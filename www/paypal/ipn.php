<?php

require 'PaypalIPN.php';
require_once '../../vendor/autoload.php';
require_once '../../generated-conf/config.php';
require_once '../common/reg.inc.php';

use \crwdogs\events\EventQuery;
use \crwdogs\events\UserQuery;
use \crwdogs\events\User;
use \crwdogs\events\RegistrationQuery;
use \crwdogs\events\Registration;
use \crwdogs\events\Response;
use \crwdogs\events\QuestionQuery;
use \crwdogs\events\Payment;

$ipn = new PaypalIPN();
$ipn->usePHPCerts();

$verified = $ipn->verifyIPN();
if ($verified) {
    $registration = RegistrationQuery::create()->findPK($_POST['invoice']);
    if (!isset($registration)) {
        error_log('Unable to handle IPN for reg_id: ' . $_POST['invoice']);
    } else {
        $payment = new Payment();
        try {
            $payment->setRegistrationId($registration->getRegistrationId());
            $payment->setStatus($_POST['payment_status']);
            $payment->setTxnId($_POST['txn_id']);
            $payment->setTxnType($_POST['txn_type']);
            $payment->setRecipient($_POST['receiver_email']);
            if (isset($_POST['parent_txn'])) {
                $payment->setParentTxn($_POST['parent_txn']);
            } else {
                $payment->setParentTxn('');
            }
            $payment->setEmail($_POST['payer_email']);
            $payment->setReceived($_POST['payment_date']);
        } catch (Exception $e) { 
            error_log("Payment processing error: " . $e->getMessage());
            error_log($ipn->getFull());
        }

        $payment->setFull($ipn->getFull());
        $payment->save();

        if ($registration->getStatus() == 'In Progress') {
            $mail = createRegMail($registration);
            $mailResult = $mail->send();
        }

        $registration->setStatus('Paid');
        $registration->save();
    }
} else {
    $ipn->useSandbox();
    $verified = $ipn->verifyIPN();
    if ($verified) {
        $registration = RegistrationQuery::create()->findPK(intval($_POST['invoice']));
        if (isset($registration)) {
            if ($registration->getEvent()->getSandbox() == 'Y') {
                $payment = new Payment();
                $payment->setRegistrationId($registration->getRegistrationId());
                $payment->setStatus($_POST['payment_status'] . ' SANDBOX');
                $payment->setTxnId($_POST['txn_id']);
                $payment->setTxnType($_POST['txn_type']);
                $payment->setRecipient($_POST['receiver_email']);
                $payment->setParentTxn($_POST['parent_txn']);
                $payment->setEmail($_POST['payer_email']);
                $payment->setFull($ipn->getFull());
                $payment->setReceived($_POST['payment_date']);
                $payment->save();

                if ($registration->getStatus() == 'In Progress') {
                    $mail = createRegMail($registration);
                    $mailResult = $mail->send();
                }

                $registration->setStatus('Paid SANDBOX');
                $registration->save();
            }
        } else {
            error_log('Unknown registration id: ' . $_POST['invoice']);
        }
    }
}

header("HTTP/1.1 200 OK");