<?php

if (__FILE__ == $_SERVER["SCRIPT_FILENAME"]) {
    http_response_code(404);
    exit();
}

require_once '../../vendor/autoload.php';
require_once '../../generated-conf/config.php';
require_once '../../crwdogs/mail.php';
require_once '../common/crwdogs.inc.php';

use \crwdogs\events\User;
use \crwdogs\events\UserQuery;
use \crwdogs\events\Registration;
use \crwdogs\events\RegistrationQuery;
use \crwdogs\events\Response;
use \crwdogs\events\PurchasedItem;
use \crwdogs\events\RegistrationOption;
use \crwdogs\events\EventQuery;
use \crwdogs\events\OptionValueQuery;

$paypalConfig = [
    'business' => 'crw@texascrwd.com',
    'return' => 'https://crwdogs.com/register/success.php?reg_id=',
    'cancel_return' => 'https://crwdogs.com/register/cancel.php?reg_id=',
    'notify_url' => 'https://crwdogs.com/paypal/ipn.php'
];

function createUser($data) {
    $user = new User();
    $user->setFirstName($data['first_name']);
    $user->setLastName($data['last_name']);
    $user->setEmail($data['email']);

    if (isset($data['phone'])) {
        $user->setPhone($data['phone']);
    }

    if (isset($data['location'])) {
        $user->setLocation($data['location']);
    }

    $user->save();

    return $user;
}

function createRegistration($data) {
    $registration = new Registration();

    if (!isset($user)) {
        $registrant = createUser($data);
    } else {
        $registrant = $user;
    }

    $event = EventQuery::create()->findPK($data['event_id']);

    $registration->setUser($registrant);
    $registration->setEvent($event);
    $registration->setStatus('In Progress');
    $registration->save();

    $total = $event->getRegCost();

    $discounts = $event->getEarlyDiscounts();

    $now = date('Y-m-d');

    foreach($discounts as $discount) {
        if ($discount->getEndDate() >= $now) {
            $total += $discount->getDiscount();
            break;
        }
    }

    $questions = $event->getQuestions();

    foreach ($questions as $question) {
        $key = 'qid' . $question->getQuestionId();

        if (isset($data[$key]) && !empty($data[$key])) {
            $response = new Response();
            $response->setRegistration($registration);
            $response->setQuestion($question);
            $response->setValue($data[$key]);

            $response->save();
        }
    }

    $items = $event->getItems();

    foreach($items as $item) {
        $key = 'iid' . $item->getItemId();

        $qty = 0;

        if (isset($data[$key . '-qty'])) {
            $qty= $data[$key . '-qty'];
        }

        if ($qty > 0) {
            $purchase = new PurchasedItem();
            $purchase->setItem($item);
            $purchase->setRegistration($registration);
            $purchase->setQty($qty);

            $cost = $item->getBaseCost();

            $options = $item->getItemOptions();

            foreach($options as $option) {
                $opt = 'oid' . $option->getItemOptionId();

                $vid = $data[$opt];
                $value = OptionValueQuery::create()->findPK($vid);

                $cost += $value->getCostAdj();

                $regOpt = new RegistrationOption();
                $regOpt->setPurchasedItem($purchase);
                $regOpt->setOptionValue($value);
                $regOpt->save();
            }

            $purchase->setUnitCost($cost);
            $purchase->save();
        }
    }

    $registration->setTotal($total);
    $registration->save();

    return $registration;
}