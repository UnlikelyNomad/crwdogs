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
use \crwdogs\events\RegistrationQuery;
use \crwdogs\events\ResponseQuery;
use \crwdogs\events\PaymentQuery;

use Propel\Runtime\Collection\Collection;
use Propel\Runtime\ActiveQuery\Criteria;

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
                                    <?php
                                        $eventUrl = $event->getOrganizeUrl();
                                        if (empty($eventUrl)) {
                                            $eventUrl = '/event?id=' . $event->getEventId();
                                        }
                                    ?>
                                    <a href="<?= $eventUrl ?>">
                                        <?php echo $event->getName(); ?>
                                    </a>
                                </div></div>
                            <?php }
                            }
                        } else {
                            //list registrations
                            $registrations = RegistrationQuery::create()->filterByEventId($event->getEventId())->where('Registration.Status != ?', 'Cancelled')->find();

                            $regs = array();

                            ?>
                            <table>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Payment</th>
                                    <th>Gross</th>
                                    <th>Fee</th>
                                    <th>Net</th>
                                    <th>Send Payment Email</th>
                                </tr>
                                <?php

                                foreach ($registrations as $registration) {
                                    $regUser = $registration->getUser();
                                    $payments = $registration->getPayments();
                                    $payment = $payments->getLast();

                                    $color = "#B88";

                                    if (isset($payment)) {
                                        $status = $payment->getStatus();

                                        $s = 'Completed';
                                        if (substr($status, 0, strlen($s)) === $s) {
                                            $color = "#6D6";
                                        }

                                        $s = 'Pending';
                                        if (substr($status, 0, strlen($s)) === $s) {
                                            $color = "#AB2";
                                        }

                                        preg_match("/mc_gross=([^&]+)/", $payment->getFull(), $gross_match);
                                        $gross = floatval($gross_match[1]);

                                        preg_match("/mc_fee=([^&]+)/", $payment->getFull(), $fee_match);
                                        if (isset($fee_match[1])) {
                                            $fee = floatval($fee_match[1]);
                                        } else {
                                            $fee = 0;
                                        }
                                    } else {
                                        $status = "No Payment";
                                        $gross = 0;
                                        $fee = 0;
                                    }

                                    $net = $gross - $fee;

                                    ?>
                                    <tr>
                                        <td><?= $regUser->getLastName() . ', ' . $regUser->getFirstName() ?></td>
                                        <td><a href="mailto:<?= $regUser->getEmail() ?>"><?= $regUser->getEmail() ?></a></td>
                                        <td style="background-color: <?= $color ?>;"><?= $status ?></td>
                                        <td><?= $gross ?></td>
                                        <td><?= $fee ?></td>
                                        <td><?= $net ?></td>
                                        <td><?php /*if ($status == "No Payment") { ?>
                                            <form action="/paypal/resend.php" method="post">
                                                <input type="hidden" name="event_id" value="<?= $event->getEventId() ?>">
                                                <input type="hidden" name="reg_id" value="<?= $registration->getRegistrationId() ?>">
                                                <button type="submit" name="email_paypal_link" class="btn btn-sm btn-primary">Send Payment Email</button>
                                            </form><?php } */?>
                                        </td>
                                    </tr>

                                    <?php

                                    $responses = ResponseQuery::create()->filterByRegistrationId($registration->getRegistrationId())->find();
                                } ?>
                            </table>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </body>
</html>