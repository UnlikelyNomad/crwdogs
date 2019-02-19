<?php

require_once '../../vendor/autoload.php';
require_once '../../generated-conf/config.php';
require_once '../../crwdogs/mail.php';
require_once '../common/reg.inc.php';
require_once '../common/paypal.inc.php';

use \crwdogs\events\EventQuery;
use \crwdogs\events\UserQuery;
use \crwdogs\events\User;
use \crwdogs\events\RegistrationQuery;
use \crwdogs\events\Registration;
use \crwdogs\events\Response;
use \crwdogs\events\QuestionQuery;

if (!isset($_POST['event_id'])) {
    http_response_code(404);
    exit();
}

$registration = createRegistration($_POST);

$u = $registration->getUser();
$event = $registration->getEvent();

$mail = createMail();
$cart = new PayPalCart(
    'TexasCRWd',
    'crw@texascrwd.com',
    'https://crwdogs.com/paypal/ipn.php',
    'https://crwdogs.com/registration/success.php?id=' . $registration->getRegistrationId(),
    'https://crwdogs.com/registration/cancel.php?id=' . $registration->getRegistrationId()
);

$mail->setFrom('admin@crwdogs.com', 'CRW Dogs Admin');
$mail->addAddress($u->getEmail(), $u->getFirstName() . ' ' . $u->getLastName());

if ($event->getNotifyEmail() != '') {
    $mail->addBCC($event->getNotifyEmail());
}

$mail->Subject = $event->getName() . ' Registration';

$msg = 'Thank you for your registration!<br/>';
$msg .= 'Your registration number is: ' . $registration->getRegistrationId() . '</br>';
$msg .= '<br/>';
$msg .= 'Here is the information you registered with:<br/><br/>';
$msg .= '<b>Name:</b> ' . $u->getFirstName() . ' ' . $u->getLastName() . '<br/>';
$msg .= '<b>Email:</b> ' . $u->getEmail() . '<br/>';
$msg .= '<b>Phone:</b> ' . $u->getPhone() . '<br/>';
$msg .= '<br/>';

$cart->setBuyer($u->getFirstName(), $u->getLastName(), $u->getEmail());

$purchases = $registration->getPurchasedItems();

if (!$purchases->isEmpty()) {
    $msg .= '<b>Purchases:</b><br/>';
}

foreach($purchases as $purchase) {
    $item = $purchase->getItem();
    $msg .= $item->getLabel() . ' $' . number_format($purchase->getUnitCost(), 2) . ' x' . $purchase->getQty() . '<br/>';

    $cart->addItem($purchase->getItemId(), $item->getLabel(), $purchase->getUnitCost(), $purchase->getQty());

    $options = $purchase->getRegistrationOptions();

    foreach($options as $option) {
        $value = $option->getOptionValue();
        $label - $value->getItemOption()->getLabel();
        $msg .= ' - ' . $label . ': ' . $value->getValue() . '<br/>';

        $cart->setItemOption($purchase->getItemId(), $label, $value->getValue());
    }

    $msg .= '<br/>';
}

//fill out responses
$responses = $registration->getResponses();

if (!$responses->isempty()) {
    $msg .='<b>Questionaire:</b><br/>';
}

foreach($responses as $response) {
    $v = $response->getValue();

    if ($v == 'true') {
        $v = 'Y';
    } else if ($v == 'false') {
        $v = 'N';
    }

    $msg .= $response->getQuestion()->getLabel() . ': ' . $v . '<br/>';
}

$url = '/registration/success?id=' . $registration->getRegistrationId();

if ($registration->getTotal() > 0) {
    $url = $cart->getPayPalCartURL($registration->getRegistrationId());
    $msg .= '<br/>';
    $msg .= '<b>Note:</b> You should be receiving a separate email from paypal confirming payment for this event.<br/>';
    $msg .= 'If there was an issue accessing paypal you can try again with this link: ';
    $msg .= '<a href="https://crwdogs.com/registration/pay.php?id=' . $registration->getRegistrationId() . '">Pay for registration</a><br/>';
}

$msg .= '<br/>';
$msg .= 'Please reply to this email if you have any issues or questions!<br/>';

$msg .= '<br/>';
$msg .= 'Incoming!<br/>';
$msg .= '<a href="https://crwdogs.com">crwdogs.com</a>';

$mail->msgHTML($msg);

$mailResult = $mail->send();
header('Location: ' . $url);