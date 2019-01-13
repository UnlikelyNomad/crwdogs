<?php

require_once '../../vendor/autoload.php';
require_once '../../generated-conf/config.php';
require_once '../../crwdogs/mail.php';

use \crwdogs\events\EventQuery;
use \crwdogs\events\UserQuery;
use \crwdogs\events\User;
use \crwdogs\events\RegistrationQuery;
use \crwdogs\events\Registration;
use \crwdogs\events\Response;
use \crwdogs\events\QuestionQuery;

$reg = json_decode($_POST['reg'], true);

//retrieve event
$event = EventQuery::create()->findPK($reg['eventid']);

//get user

//TODO: userid from session / cookie

//Check for anonymous user
$user = UserQuery::create()->findOneByEmail($reg['email']);

if(isset($user)) {
    //check if anonymous user (no password set)
    if ($user->getPassword() != '') {
        echo '{"result":"Error","msg":"Cannot register anonymously using an email registered to an account."}';
        return;
    }
} else {
    //need to create anonymous user info (no password)
    $user = new User();
    $user->setFirstName($reg['first_name']);
    $user->setLastName($reg['last_name']);
    $user->setEmail($reg['email']);
    $user->setPhone($reg['phone']);
    $user->save();
    //echo 'Anonymous user created';
}

//check if registration already exists for user/event
$registration = RegistrationQuery::create()
    ->filterByUserId($user->getUserId())
    ->filterByEventId($event->getEventId())
    ->findOne();

if (isset($registration)) {
    echo '{"result":"Error","msg":"User is already registered for this event."}';
    return;
}

$registration = new Registration();
$registration->setUserId($user->getUserId());
$registration->setEventId($event->getEventId());
$registration->setStatus('In Progress');
$registration->save();

$mail = createMail();

$mail->setFrom('admin@crwdogs.com', 'CRW Dogs Admin');
$mail->addAddress($reg['email'], $reg['first_name'] . ' ' . $reg['last_name']);

if ($event->getNotifyEmail() != '') {
    $mail->addBCC($event->getNotifyEmail());
}

$mail->Subject = 'crwdogs.com ' . $event->getName() . ' Event Registration';

$r = $registration->getRegistrationId();

$msg = 'Thank you for your registration!<br/>';
$msg .= 'Here is the information you registered with:<br/><br/>';
$msg .= 'Name: ' . $reg['first_name'] . ' ' . $reg['last_name'] . '<br/>';
$msg .= 'Email: ' . $reg['email'] . '<br/>';
$msg .= 'Phone: ' . $reg['phone'] . '<br/><br/>';

//fill out responses

//number of questions
$questions = QuestionQuery::create()->findByEventId($event->getEventId());
$q = $reg['questions'];

foreach($questions as $question) {
    $response = new Response();
    $qid = $question->getQuestionId();

    if (isset($q[$qid])) {
        if (gettype($q[$qid]) == 'boolean') {
            $q[$qid] = $q[$qid] ? 'Y' : 'N';
        }

        $response->setValue($q[$qid]);
        $msg .= $question->getLabel() . ': ' . $q[$qid] . '<br/>';
    }

    $response->setQuestionId($qid);
    $response->setRegistrationId($r);
    $response->save();
}

$mail->msgHTML($msg);

if (!$mail->send()) {
    echo '{"result":"Mail error","msg":"' . $mail->ErrorInfo . '"}';
} else {
    echo '{"result":"success","reg_id":' . $registration->getRegistrationId() . '}';
}