<?php

require_once '../../vendor/autoload.php';
require_once '../../generated-conf/config.php';

use \crwdogs\events\EventQuery;
use \crwdogs\events\UserQuery;
use \crwdogs\events\User;

$reg = json_decode($_POST['reg']);

//retrieve event
$event = EventQuery::create()->findPK($reg->eventid);

//get user

//TODO: userid from session / cookie

//Check for anonymous user
$user = UserQuery::create()->findOneByEmail($reg->email);

if(isset($user)) {
    echo $user->getFirstName() . ' ' . $user->getLastName();
} else {
    //need to create anonymous user info (no password)

}

?>