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

$account = array('TexasCRWd', 'crw@texascrwd.com');

if (!empty($event->getPaypalEmail())) {
    $account = explode(';', $event->getPaypalEmail());
}

$paypalSandbox = $event->getSandbox() == 'Y';

$eventSuccess = $event->getPaypalSuccessUrl();
$eventCancel = $event->getPaypalCancelUrl();

$domain = 'http://';

if (isset($_SERVER['HTTPS'])) {
    $domain = 'https://';
}

$domain .= $_SERVER['HTTP_HOST'];

if (!empty($eventSuccess)) {
    $successUrl = $domain . $eventSuccess;
} else {
    $successUrl = $domain . '/registration/success.php';
}

if (!empty($eventCancel)) {
    $cancelUrl= $domain . $eventCancel;
} else {
    $cancelUrl = $domain . '/registration/cancel.php';
}

$cart = new PayPalCart(
    $account[0],
    $account[1],
    'https://crwdogs.com/paypal/ipn.php',
    $successUrl . '?id=' . $registration->getRegistrationId(),
    $cancelUrl . '?id=' . $registration->getRegistrationId(),
    $paypalSandbox
);

$cart->setBuyer($u->getFirstName(), $u->getLastName(), $u->getEmail());

$purchases = $registration->getPurchasedItems();

if (!$purchases->isEmpty()) {
    $discount = 0;

    foreach($purchases as $purchase) {
        $item = $purchase->getItem();

        echo $item->getLabel() . ' x' . $purchase->getQty() . ' $' . number_format($purchase->getUnitCost(), 2) . ' ea<br/>';

        if ($purchase->getUnitCost() < 0) {
            $discount -= $purchase->getUnitCost();
        } else {
            $item_num = $cart->addItem($purchase->getItemId(), $item->getLabel(), $purchase->getUnitCost(), $purchase->getQty());

            $options = $purchase->getRegistrationOptions();

            foreach($options as $option) {
                $value = $option->getOptionValue();
                $label = $value->getItemOption()->getLabel();

                $cart->setItemOption($item_num, $label, $value->getValue());
                echo ' - ' . $label . ': ' . $value->getValue() . '<br/>';
            }
        }
    }

    if ($discount > 0) {
        $cart->setCartDiscount($discount);
    }
}

$url = $successUrl . '?id=' . $registration->getRegistrationId();

if ($registration->getTotal() > 0) {
    $url = $cart->getPayPalCartURL($registration->getRegistrationId());
}

$_SESSION['reg_id'] = $registration->getRegistrationId();


echo htmlspecialchars($url);
//header('Location: ' . $url);