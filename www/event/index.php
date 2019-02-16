<?php

require_once(dirname(__DIR__).'/common/crwdogs.inc.php');
require_once '../../crwdogs/mail.php';

//should be set from session in crwdogs.inc.php if user is logged in
if (!isset($user)) {
    http_response_code(404);
    exit();
}

use \crwdogs\events\User;
use \crwdogs\events\UserQuery;
use \crwdogs\events\EventQuery;
use Propel\Runtime\Collection\Collection;

$list = true;

$title = 'Organized Events';

if (!isset($_GET['id'])) {
    //event list
    $events = new Collection();

    if ($user->isAdmin()) {
        $events = EventQuery::create()->find();
    } else {
        $groups = $user->getGroups();
        
        $events_arr = array();

        foreach ($groups as $group) {
            $e = $group->getEvents();
            foreach($e as $ev) {
                array_push($events_arr, $ev);
            }
        }

        $events->setData($events_arr);
    }
} else {
    $event = EventQuery::create()->findPK($_GET['id']);

    if (isset($event) && canManageEvent($user, $event)) {
        $list = false;
        $title = $event->getName();
    } else {
        $error = 'Error accessing event.';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/crwdogs.css">

        <link rel="shortcut icon" href="/images/favicon.png">

        <title>CRW DOGS - <?php echo $title; ?></title>
    </head>
    <body>
        <?php include '../common/nav.inc.php'; ?>
        <div class="main-content text-center">

            <?php if (isset($error)) { ?>
                <div class="alert alert-warning">
                    <?php echo $error; ?>
                </div> <?php
            }  else { ?>
                <div class="banner">
                    <div class="banner-text rounded">
                        <?php echo $title; ?>
                    </div>
                </div>

                <div class="inner-content p-3">
                    <div class="container">
                    <?php
                        if ($list) {
                            if ($events->isEmpty()) {
                                echo 'You are not organizing any events.';
                            } else {
                                foreach ($events as $event) { ?>
                                <div class="row"><div class="col">
                                    <a href="/event?id=<?php echo $event->getEventId(); ?>">
                                        <?php echo $event->getName(); ?>
                                    </a>
                                </div></div>
                            <?php }
                            }
                        } else {
                            //list registrations
                        }
                    ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </body>
</html>