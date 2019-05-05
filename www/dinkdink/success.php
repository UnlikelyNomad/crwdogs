<?php

require_once '../../vendor/autoload.php';
require_once '../../generated-conf/config.php';
require_once '../../crwdogs/mail.php';
require_once '../common/reg.inc.php';

use \crwdogs\events\EventQuery;
use \crwdogs\events\UserQuery;
use \crwdogs\events\RegistrationQuery;

if (!isset($_SESSION['reg_id'])) {
    error_log('Missing reg_id');
    header('Location: /');
    return;
}

$registration = RegistrationQuery::create()->findPK($_SESSION['reg_id']);
$u = $registration->getUser();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/jquery-ui.min.css">
        <link rel="stylesheet" href="/css/crwdogs.css">

        <link rel="shortcut icon" href="/images/favicon.png">

        <title>CRW Dogs - Registration Completed</title>
    </head>
    <body style="background-image:url(/images/yellowbrick.png);">

    <?php include '../common/nav.inc.php'; ?>

        <div class="main-content">
            <div class="banner">
                <div class="banner-text rounded">
                    <img src="/images/noplacelikedink.png" style="max-height: 600px;">
                </div>
            </div>

            <div class="container-fluid inner-content rounded">
                <div class="row justify-content-center">
                    <div class="col text-center">
                        <h2>Registration Complete</h2>
                        <br>
                        Thank you for your registration, <?= $u->getFirstName() . ' ' . $u->getLastName() ?>!<br>
                        You should receive a confirmation email to <?= $u->getEmail() ?> with your registration details.<br>
                        <br>
                        <h3><a href="https://dinkdinkboogie.com">Back to Dink Dink site!</a></h3>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="../js/jquery-3.3.1.min.js"></script>
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/jquery.ui.touch-punch.min.js"></script>
        <script src="../js/popper.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/registration.js"></script>
    </body>
</html>