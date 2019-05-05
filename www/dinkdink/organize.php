<?php

require_once(dirname(__DIR__).'/common/crwdogs.inc.php');

use \crwdogs\events\User;
use \crwdogs\events\UserQuery;
use \crwdogs\events\EventQuery;
use \crwdogs\events\RegistrationQuery;
use \crwdogs\events\ResponseQuery;
use \crwdogs\events\PaymentQuery;

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
    $error = 'You must be logged in and have access to this event.';
}

function summaryTable($event) {
    $registrations = RegistrationQuery::create()->filterByEventId($event->getEventId())->where('Registration.Status != ?', 'Cancelled')->find();
    ?>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Payment</th>
            <th>Gross</th>
            <th>Fee</th>
            <th>Net</th>
        </tr>
        <?php

        foreach ($registrations as $registration) {
            $regUser = $registration->getUser();
            $payments = $registration->getPayments();
            $payment = $payments->getLast();

            $status = $registration->getStatus();
            $gross = 0;
            $fee = 0;

            $color = "#B88";

            if (isset($payment)) {

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
            </tr>

            <?php

            $responses = ResponseQuery::create()->filterByRegistrationId($registration->getRegistrationId())->find();
        } ?>
    </table> <?php
}

function itemTable($event) {
    $registrations = RegistrationQuery::create()->filterByEventId($event->getEventId())->where('Registration.Status != ?', 'Cancelled')->find();
    $items = $event->getItems();
    ?>
    <table>
        <tr>
            <th>Name</th>
            <?php
                foreach ($items as $item) {
                    ?>
                    <th><?= $item->getLabel(); ?></th>
                    <?php
                }
            ?>
        </tr>
        <?php

        foreach ($registrations as $registration) {
            $regUser = $registration->getUser();
            $payments = $registration->getPayments();
            $payment = $payments->getLast();

            $status = $registration->getStatus();
            $gross = 0;
            $fee = 0;

            $color = "#B88";

            $s = "Completed";
            if (isset($payment) && substr($status, 0, strlen($s)) === $s) {
                ?>
                <tr>
                    <td><?= $regUser->getLastName() . ', ' . $regUser->getFirstName() ?></td>
                </tr>

                <?php
            }
        } ?>
    </table> <?php
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

        <title>CRW DOGS - Dink Dink 8</title>
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
                        <?php echo $event->getName(); ?>
                    </div>
                </div>

                <div class="inner-content p-3">

                    <div class="row">
                        <div class="col-12 col-md-4">
                            <a href="?tab=summary"><button class="btn btn-primary">Summary</button></a>
                        </div>
                        <div class="col-12 col-md-4">
                            <a href="?tab=items"><button class="btn btn-primary">Purchases</button></a>
                        </div>
                        <div class="col-12 col-md-4">
                            <a href="?tab=questions"><button class="btn btn-primary">Questionnaire</button></a>
                        </div>
                    </div>

                    <?php 
                    switch ($tab) {
                        case 'summary':
                            summaryTable($event);
                            break;

                        case 'items':
                            itemTable($event);
                            break;

                        case 'questions':

                            break;
                    } ?>
                </div>
            <?php } ?>
        </div>
    </body>
</html>