<?php

require_once '../../vendor/autoload.php';
require_once '../../generated-conf/config.php';
require_once '../../crwdogs/mail.php';
require_once '../common/reg.inc.php';
require_once '../common/paypal.inc.php';

use \crwdogs\events\EventQuery;
use \crwdogs\events\UserQuery;
use \crwdogs\events\RegistrationQuery;

if (!isset($_SESSION['reg_id'])) {
    header('Location: /');
    return;
}

$registration = RegistrationQuery::create()->findPK($_SESSION['reg_id']);
$u = $registration->getUser();

if ($registration->getStatus() !== 'Cancelled') {

    $registration->setStatus('Cancelled');
    $registration->save();
}

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
    <body>

    <?php include '../common/nav.inc.php'; ?>

        <div class="main-content">
            <div class="banner">
                <div class="banner-text rounded">
                    <img src="/images/jump1.jpg" class="img-fluid rounded">
                </div>
            </div>

            <div class="container-fluid inner-content rounded">
                <div class="row justify-content-center">
                    <div class="col text-center">
                        <h2>Registration Cancelled</h2>
                        <br>
                        You've cancelled payment for your registration.<br>
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