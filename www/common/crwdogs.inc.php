<?php

if (__FILE__ == $_SERVER["SCRIPT_FILENAME"]) {
    http_response_code(404);
    exit();
}

require_once(dirname(dirname(__DIR__)).'/vendor/autoload.php');
require_once(dirname(dirname(__DIR__)).'/generated-conf/config.php');

use \crwdogs\events\UserQuery;
use \crwdogs\events\AuthGroupQuery;

session_start();

$user = NULL;

if (isset($_SESSION['user_id'])) {
    $user = UserQuery::create()->findPK($_SESSION['user_id']);
    if (isset($user)) {
        //do logged-in usery stuff?
    } else {

        //something hanky, kill session with fire.
        session_unset();
        session_destroy();
    }
}

function canManageEvent($user, $event) {

    if ($user->isAdmin()) {
        return true;
    }
    
    $eventGroup = AuthGroupQuery::create()->findPK($event->getOwningGroup());
    return $user->getGroups()->contains($eventGroup);
}

$keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_';
function random_str($length) {
    global $keyspace;

    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;

    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}

function requireAdmin() {
    global $user;

    if (!isset($user) || !$user->isAdmin()) {
        http_response_code(404);
        exit();
    }
}