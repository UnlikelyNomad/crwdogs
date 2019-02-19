<?php

require_once '../../vendor/autoload.php';
require_once '../../generated-conf/config.php';

use \crwdogs\events\RegistrationQuery;
use \crwdogs\events\PurchasedItem;
use \crwdogs\events\PurchasedItemQuery;

if (!isset($user) && !$user->isAdmin()) {
    http_response_code(404);
    exit();
}

$event_id = $_GET['eid'];
$item_id = $_GET['iid'];

$registrations = RegistrationQuery::create()->filterByEventId($event_id)->find();

$count = 0;

foreach($registrations as $registration) {
    $reg_id = $registration->getRegistrationId();

    $found = false;

    $purchases = PurchasedItemQuery::create()->filterByRegistrationId($reg_id)->find();

    foreach($purchases as $purchase) {
        if ($purchase->getItemId() == $item_id) {
            $found = true;
            break;
        }
    }

    if (!$found) {
        $purchase = new PurchasedItem();
        $purchase->setItemId($item_id);
        $purchase->setRegistrationId($reg_id);
        $purchase->setQty($_GET['qty']);
        $purchase->setUnitCost($_GET['uc']);
        $purchase->save();
        $count++;
    }
}

echo 'Added purchase to ' . $count . ' registrations.';