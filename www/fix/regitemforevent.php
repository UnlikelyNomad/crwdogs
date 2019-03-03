<?php

require_once '../../vendor/autoload.php';
require_once '../../generated-conf/config.php';
require_once '../common/crwdogs.inc.php';

use \crwdogs\events\RegistrationQuery;
use \crwdogs\events\PurchasedItem;
use \crwdogs\events\PurchasedItemQuery;

requireAdmin();

$event_id = $_GET['eid'];
$item_id = $_GET['iid'];
$qty = $_GET['qty'];
$uc = $_GET['uc'];

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
        $purchase->setQty($qty);
        $purchase->setUnitCost($uc);
        $purchase->save();
        $count++;
    }
}

echo 'Added purchase to ' . $count . ' registrations.';