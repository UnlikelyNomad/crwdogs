<?php
require_once(dirname(__DIR__).'/common/crwdogs.inc.php');

use \crwdogs\events\User;
use \crwdogs\events\UserQuery;
use \crwdogs\events\EventQuery;
use \crwdogs\events\RegistrationQuery;
use \crwdogs\events\ResponseQuery;
use \crwdogs\events\PaymentQuery;
use \crwdogs\events\ResponseQuery;

use Propel\Runtime\Collection\Collection;
use Propel\Runtime\ActiveQuery\Criteria;

$auth = false;

//should be set from session in crwdogs.inc.php if user is logged in
if (isset($user)) {
    $event_id = 2;
    $event = EventQuery::create()->findPK($event_id);

    if (canManageEvent($user, $event)) {
        $auth = true;

        $tab = 'summary';

        if (isset($_GET['tab'])) {
            $tab = $_GET['tab'];
        }
    }
}

if (!$auth) {
    echo 'You must be logged in and have access to this event.';
    exit();
}

header('Content-type: text\csv');
header('Content-Disposition: attachment; filename="dd8_questions.csv"');

$registrations = RegistrationQuery::create()->filterByEventId($event->getEventId())->where('Registration.Status != ?', 'Cancelled')->find();
$questions = $event->getQuestions();

$out = "Name";
foreach ($questions as $question) {
    $out .= "," . $question->getLabel();
}

$out .= "\r\n";

foreach ($registrations as $registration) {
    $regUser = $registration->getUser();
    $payments = $registration->getPayments();
    $payment = $payments->getLast();

    //$status = $registration->getStatus();
    $gross = 0;
    $fee = 0;

    $s = "Completed";
    if (isset($payment) && substr($payment->getStatus(), 0, strlen($s)) === $s) {
        $out .= '"' . $regUser->getLastName() . ', ' . $regUser->getFirstName() . '"';
        foreach ($questions as $question) {
            $response = ResponseQuery::create()->
                filterByRegistration($registration)->
                filterByQuestion($question)->
                findOne();

            $out .= ",";
            
            if (!is_null($response)) {
                $out .= $amount;
            }
        }

        $out .= "\r\n";
    }
}

echo $out;