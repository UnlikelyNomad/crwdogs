<?php

require_once(dirname(__DIR__).'/common/crwdogs.inc.php');

use \crwdogs\events\UserQuery;

$email = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login-submit'])) {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }

    $user = UserQuery::create()->findOneByEmail($_POST['email']);

    $userValid = false;

    if (isset($user)) {
        if (password_verify($_POST['password'], $user->getPassword())) {
            $userValid = true;

            session_start();
            $_SESSION['user_id'] = $user->getUserId();
            header('Location: ../');
            exit();
        }
    }

    if (!$userValid) {
        $msg = 'Invalid credentials. Please try again.';
    }
}

$hideLogin = true;

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/crwdogs.css">

        <link rel="shortcut icon" href="/images/favicon.png">

        <title>CRW Dogs - Login</title>
    </head>
    <body>
        <?php include '../common/nav.inc.php'; ?>
        <div class="main-content text-center">
            <div class="banner">
                <div class="banner-text rounded">
                    LOGIN
                </div>
            </div>

            <?php if (isset($msg)) {
                ?>
                <div class="alert alert-warning">
                    <?php echo $msg; ?>
                </div>
            <?php } ?>

            <div class="inner-content p-3">
                <form method="post">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-3"><label for="email" class="col-form-label">Email</label></div>
                            <div class="col-12 col-md-9"><input type="email" name="email" id="email" class="form-control" value="<?php echo $email; ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3"><label for="password" class="col-form-label">Password</label></div>
                            <div class="col-12 col-md-9"><input type="password" name="password" id="password" class="form-control"></div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="submit" name="login-submit" id="submit" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>