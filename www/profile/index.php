<?php

require_once(dirname(__DIR__).'/common/crwdogs.inc.php');
require_once '../../crwdogs/mail.php';

if (!isset($user)) {
    header('Location: /');
    exit();
}

use \crwdogs\events\User;
use \crwdogs\events\UserQuery;

if (isset($_POST['password-submit'])) {
    if (isset($_POST['cur_password']) && $user->verifyPassword($_POST['cur_password'])) {
        if (isset($_POST['password1']) && isset($_POST['password2'])) {
            if ($_POST['password1'] == $_POST['password2']) {
                $user->setPassword(password_hash($_POST['password1'], PASSWORD_DEFAULT));
                $user->save();
                $success = 'Password updated successfully.';
            } else {
                $error = 'New passwords do not match.';
            }
        } else {
            $error = 'Please fill out all password fields to change password.';
        }
    } else {
        $error = 'Incorrect or missing credentials, please try again.';
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
                    User Profile
                </div>
            </div>

            <?php if (isset($success)) { ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div> <?php
            } ?>

            <?php if (isset($error)) { ?>
                <div class="alert alert-warning">
                    <?php echo $error; ?>
                </div> <?php
            } ?>

            <div class="inner-content p-3">
                <table>
                    <tr><td>First Name</td><td><?php echo $user->getFirstName(); ?></td></tr>
                    <tr><td>Last Name</td><td><?php echo $user->getLastName(); ?></td></tr>
                    <tr><td>Email</td><td><?php echo $user->getEmail(); ?></td></tr>
                    <tr><td>Phone</td><td><?php echo $user->getPhone(); ?></td></tr>
                    <tr><td>Location</td><td><?php echo $user->getLocation(); ?></td></tr>
                </table>
                <form method="post">
                    <div class="container">
                        <h3>Change Password</h3>
                        <div class="row">
                            <div class="col-12 col-md-3"><label for="cur_password" class="col-form-label">Current Password</label></div>
                            <div class="col-12 col-md-9"><input type="password" name="cur_password" id="cur_password" class="form-control"></div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3"><label for="password1" class="col-form-label">New Password</label></div>
                            <div class="col-12 col-md-9"><input type="password" name="password1" id="password1" class="form-control"></div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3"><label for="password2" class="col-form-label">Confirm Password</label></div>
                            <div class="col-12 col-md-9"><input type="password" name="password2" id="password2" class="form-control"></div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="submit" name="password-submit" id="submit" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>