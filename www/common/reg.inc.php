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
        $phone = $data['phone'];
        if (strlen($phone) > 20) {
            $phone = substr($phone, 0, 20);
        }
        $user->setPhone($phone);
    }

    if (isset($data['location'])) {
        $user->setLocation($data['location']);
    }

    $user->save();

    return $user;
}

function createRegMail($registration) {
    $event = $registration->getEvent();
    $u = $registration->getUser();

    $mail = createMail();

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


    $purchases = $registration->getPurchasedItems();


    if (!$purchases->isEmpty()) {
        $msg .= '<b>Purchases:</b><br/>';
        $discount = 0;

        foreach($purchases as $purchase) {
            $item = $purchase->getItem();
            $msg .= $item->getLabel() . ' x' . $purchase->getQty() . ' $' . number_format($purchase->getUnitCost(), 2) . ' ea<br/>';

            if ($purchase->getUnitCost() < 0) {
                $discount -= $purchase->getUnitCost();
            } else {
                $options = $purchase->getRegistrationOptions();

                foreach($options as $option) {
                    $value = $option->getOptionValue();
                    $label = $value->getItemOption()->getLabel();
                    $msg .= ' - ' . $label . ': ' . $value->getValue() . '<br/>';
                }
            }

            $msg .= '<br/>';
        }

        $msg .= '<b>Total:</b> $' . number_format($registration->getTotal(), 2) . '<br/><br/>';
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

    /*if ($registration->getTotal() > 0) {
        $msg .= '<br/>';
        $msg .= '<b>Note:</b> You should be receiving a separate email from paypal confirming payment for this event.<br/>';
        $msg .= 'If there was an issue accessing paypal you can try again with this link: ';
        $msg .= '<a href="https://crwdogs.com/registration/pay.php?id=' . $registration->getRegistrationId() . '">Pay for registration</a><br/>';
    }*/

    $msg .= '<br/>';
    $msg .= 'Please reply to this email if you have any issues or questions!<br/>';

    $emailExtra = $event->getRegEmailExtra();
    if (isset($emailExtra)) {
        $msg .= $emailExtra;
    }

    $msg .= '<br/>';
    $msg .= 'Incoming!<br/>';
    $msg .= '<a href="https://crwdogs.com">crwdogs.com</a>';

    $mail->msgHTML($msg);

    return $mail;
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

    $total = 0;

    foreach($items as $item) {
        $key = 'iid' . $item->getItemId();

        if ($item->getMultipleVariations() == 'Y') { //lookup option values 

            $options = $item->getItemOptions();
            $cost = $item->getBaseCost();

            $numVar = intval($data[$key . '-num']);

            for ($i = 0; $i < $numVar; $i++) {
                $itemNumKey = $key . '-' . $i;

                $qty = $data[$itemNumKey . '-qty'];

                $purchase = new PurchasedItem();
                $purchase->setItem($item);
                $purchase->setRegistration($registration);
                $purchase->setQty($qty);

                foreach($options as $option) {
                    $opt = $itemNumKey . '-' . $option->getOptionId();

                    $vid = $data[$opt];
                    $value = OptionValueQuery::create()->findPK($vid);

                    $cost += $value->getCostAdj();

                    $regOpt = new RegistrationOption();
                    $regOpt->setPurchasedItem($purchase);
                    $regOpt->setOptionValue($value);
                }

                $purchase->setUnitCost($cost);
                $purchase->save();
                $total += $qty * $cost;
            }

        } else { //item as-is

            $qty = 0;
            $cost = $item->getBaseCost();

            if (isset($data[$key . '-qty'])) {
                $qty= $data[$key . '-qty'];
            }

            if ($qty > 0) {
                $purchase = new PurchasedItem();
                $purchase->setItem($item);
                $purchase->setRegistration($registration);
                $purchase->setQty($qty);

                $purchase->setUnitCost($cost);
                $purchase->save();
                $total += $qty * $cost;
            }
        }
    }

    $registration->setTotal($total);
    $registration->save();

    return $registration;
}