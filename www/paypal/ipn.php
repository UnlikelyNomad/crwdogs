<?php

require 'PaypalIPN.php';
require_once '../../vendor/autoload.php';
require_once '../../generated-conf/config.php';

use \crwdogs\events\EventQuery;
use \crwdogs\events\UserQuery;
use \crwdogs\events\User;
use \crwdogs\events\RegistrationQuery;
use \crwdogs\events\Registration;
use \crwdogs\events\Response;
use \crwdogs\events\QuestionQuery;
use \crwdogs\events\Payment;

$ipn = new PaypalIPN();

//$ipn->useSandbox();
$ipn->usePHPCerts();

$verified = $ipn->verifyIPN();
if ($verified) {
    $registration = RegistrationQuery::create()->findPK($_POST['invoice']);
    if (!isset($registration)) {
        error_log('Unable to handle IPN for reg_id: ' . $_POST['invoice']);
    } else {
        $payment = new Payment();
        $payment->setRegistrationId($registration->getRegistrationId());
        $payment->setStatus($_POST['payment_status']);
        $payment->setTxnId($_POST['txn_id']);
        $payment->setTxnType($_POST['txn_type']);
        $payment->setRecipient($_POST['receiver_email']);
        $payment->setParentTxn($_POST['parent_txn']);
        $payment->setEmail($_POST['payer_email']);
        $payment->setFull($ipn->getFull());
        $payment->setReceived($_POST['payment_date']);
        $payment->save();
    }
}

header("HTTP/1.1 200 OK");