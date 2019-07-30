<?php

require_once(dirname(__DIR__).'/common/crwdogs.inc.php');
require_once '../../crwdogs/mail.php';

if (isset($user)) {
    header('Location: /');
    exit();
}

use \crwdogs\events\User;
use \crwdogs\events\UserQuery;

$hideLogin = true;

function echoIfPost($key) {
    if (isset($_POST[$key])) {
        echo $_POST[$key];
    }
}

$error = NULL;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup-submit'])) {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }

    $user = UserQuery::create()->findOneByEmail($_POST['email']);

    if (!isset($user)) {
        //create new user
        $user = new User();
        $user->setFirstName($_POST['first_name']);
        $user->setLastName($_POST['last_name']);
        $user->setEmail($email);
        $user->setPhone($_POST['phone']);
        $user->setLocation($_POST['location']);

        $password = random_str(12);
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));

        $user->save();
        $success = true;

        //create email
        $mail = createMail();
        $mail->addAddress($email, $user->getFirstName() . ' ' . $user->getLastName());
        $mail->Subject = 'crwdogs.com User Registration';

        $msg = 'Thank you for your registration, ' . $user->getFirstName() . ' ' . $user->getLastName() . '!<br/>';
        $msg .= '<br/>';
        $msg .= 'Here is the information you provided:<br/>';
        $msg .= 'Phone: ';

        if (empty($user->getPhone())) {
            $msg .= 'Not provided.<br/>';
        } else {
            $msg .= $user->getPhone() . '<br/>';
        }

        $msg .= 'Location: ';

        if (empty($user->getLocation())) {
            $msg .= 'Not provided.<br/>';
        } else {
            $msg .= $user->getLocation() . '<br/>';
        }

        $msg .= '<br/>';
        $msg .= 'To login, please visit <a href="https://crwdogs.com/login">https://crwdogs.com/login</a> and login with this email and your password:<br/>';
        $msg .= '<br/>';
        $msg .= $password . '<br/>';
        $msg .= '<br/>';
        $msg .= 'Blue Skies!';

        $mail->msgHTML($msg);

        $mail->setFrom('admin@crwdogs.com', 'CRW Dogs Admin');
        
        if (!$mail->send()) {
            $error = 'There was an error sending your user registration email: ' . $mail->ErrorInfo . '<br>';
            $error .= 'Email us at <a href="mailto:admin@crwdogs.com">admin@crwdogs.com</a> if you need assistance.';
        }

    } else {
        $error = 'That email address is already claimed. Please use a different email or contact <a href="mailto:admin@crwdogs.com">admin@crwdogs.com</a> for help.';
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

        <title>CRW Dogs - Sign Up</title>
    </head>
    <body>
        <?php include '../common/nav.inc.php'; ?>
        <div class="main-content text-center">
            <div class="banner">
                <div class="banner-text rounded">
                    SIGNUP
                </div>
            </div>

            <?php if (isset($success) && $success) {

                if (isset($error)) { ?>
                    <div class="alert alert-warning">
                        <?php echo $error; ?>
                    </div>

                <?php
                } else { ?>

                <div class="alert alert-success">
                    Success! Please check your email account <?php echo $email; ?> for login information.
                </div> <?php
                }
            } else {

                if (isset($error)) { ?>
                <div class="alert alert-warning">
                    <?php echo $error; ?>
                </div>
            <?php } ?>

            <div class="inner-content p-3">
                <form method="post">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-3"><label for="first_name" class="col-form-label">First Name</label></div>
                            <div class="col-12 col-md-9"><input type="text" name="first_name" id="first_name" class="form-control" value="<?php echoIfPost('first_name'); ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3"><label for="last_name" class="col-form-label">Last Name</label></div>
                            <div class="col-12 col-md-9"><input type="text" name="last_name" id="last_name" class="form-control" value="<?php echoIfPost('last_name'); ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3"><label for="email" class="col-form-label">Email</label></div>
                            <div class="col-12 col-md-9"><input type="email" name="email" id="email" class="form-control" value="<?php echoIfPost('email'); ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3"><label for="phone" class="col-form-label">Phone</label></div>
                            <div class="col-12 col-md-9"><input type="text" name="phone" id="phone" class="form-control" value="<?php echoIfPost('phone'); ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3"><label for="location" class="col-form-label">Location</label></div>
                            <div class="col-12 col-md-9"><input type="text" name="location" id="location" class="form-control" value="<?php echoIfPost('location'); ?>"></div>
                        </div>
                        <div class="row text-center">
                            <div class="col">
                                <span class="font-italic">You will be emailed a random password for your first login when you signup so please ensure your email is correct.</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="submit" name="signup-submit" id="submit" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <?php } ?>
        </div>
    </body>
</html>