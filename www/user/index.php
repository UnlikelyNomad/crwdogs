<?php

require_once(dirname(__DIR__).'/common/crwdogs.inc.php');
require_once '../../crwdogs/mail.php';

//should be set from session in crwdogs.inc.php if user is logged in
if (!isset($user) || !$user->isAdmin()) {
    http_response_code(404);
    exit();
}

use \crwdogs\events\User;
use \crwdogs\events\UserQuery;

$list = true;

$title = 'Userlist';

if (!isset($_GET['id'])) {
    $profiles = UserQuery::create()->orderByLastName()->orderByFirstName()->find();
} else {
    $profile = UserQuery::create()->findPK($_GET['id']);

    if (isset($profile)) {
        $list = false;
        $title = $profile->getFirstName() . ' ' . $profile->getLastName();
    } else {
        $error = 'Error accessing user.';
    }

    if (isset($_POST['reset-password'])) {
        $password = random_str(12);
        $profile->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $profile->save();

        $mail = createMail();
        $mail->setFrom('admin@crwdogs.com', 'CRW Dogs Admin');
        $mail->addAddress($profile->getEmail(), $profile->getFirstName() . ' ' . $profile->getLastName());
        $mail->Subject = 'crwdogs.com Password Reset';

        $msg = 'Your password for <a href="https://crwdogs.com">crwdogs.com</a> has been reset.<br/>';
        $msg .= '<br/>';
        $msg .= 'Your new password is: ' . $password . '</br>';
        $msg .= '<br/>';
        $msg .= 'You can login at <a href="https://crwdogs.com/login">crwdogs.com/login</a> and then click on the profile button to change your password.';

        $mail->msgHTML($msg);
        if (!$mail->send()) {
            $error = 'There was an error sending the email: ' . $mail->ErrorInfo . '<br>';
        } else {
            $success = 'Password has been reset to ' . $password . ' and emailed to ' . $profile->getEmail();
        }
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

                <?php if (isset($success)) { ?>
                    <div class="alert alert-success">
                        <?php echo $success; ?>
                    </div>
                <?php } ?>

                <div class="inner-content p-3">
                    <div class="container">
                    <?php
                        if ($list) {
                            foreach ($profiles as $profile) { ?>
                            <div class="row"><div class="col">
                                <a href="/user?id=<?php echo $profile->getUserId(); ?>">
                                    <?php echo $profile->getLastName() . ', ' . $profile->getFirstName(); ?>
                                </a>
                            </div></div>
                        <?php }
                        } else {
                            ?>

                            <div class="row">
                                <div class="col">
                                    <form method="post"><button type="submit" name="reset-password" class="btn btn-primary">Reset Password</button></form>
                                </div>
                            </div>

                            <?php
                        }
                    ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </body>
</html>