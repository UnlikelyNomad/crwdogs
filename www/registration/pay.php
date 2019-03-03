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

if (!isset($_GET['id'])) {
    http_response_code(404);
    exit();
}

$registration = RegistrationQuery::create()->findPK($_GET['id']);

$u = $registration->getUser();
$event = $registration->getEvent();

$cart = new PayPalCart(
    'TexasCRWd',
    'crw@texascrwd.com',
    'https://crwdogs.com/paypal/ipn.php',
    'https://crwdogs.com/registration/success.php?id=' . $registration->getRegistrationId(),
    'https://crwdogs.com/registration/cancel.php?id=' . $registration->getRegistrationId(),
    false
);

$cart->setBuyer($u->getFirstName(), $u->getLastName(), $u->getEmail());

$purchases = $registration->getPurchasedItems();

foreach($purchases as $purchase) {
    $item = $purchase->getItem();

    $cart->addItem($purchase->getItemId(), $item->getLabel(), $purchase->getUnitCost(), $purchase->getQty());

    $options = $purchase->getRegistrationOptions();

    foreach($options as $option) {
        $value = $option->getOptionValue();
        $label - $value->getItemOption()->getLabel();

        $cart->setItemOption($purchase->getItemId(), $label, $value->getValue());
    }
}

$url = $cart->getPayPalCartURL($registration->getRegistrationId());

header('Location: ' . $url);