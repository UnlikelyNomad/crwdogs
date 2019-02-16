<?php

if (__FILE__ == $_SERVER["SCRIPT_FILENAME"]) {
    http_response_code(404);
    exit();
}

?>

<div class="navbar fixed-top navbar-light bg-light">
    <a class="navbar-brand" href="/">CRWDOGS.COM</a>

<?php
    if (isset($_SESSION['user_id'])) {
        //user logged in
        ?>
        <div>
            <span class="navbar-text mr-2"><?php echo $user->getFirstName(); ?>, incoming!</span>
            <a href="/profile"><button type="submit" class="btn btn-primary">PROFILE</button></a>
            <?php if ($user->isAdmin()) { ?>
                <a href="/user"><button type="submit" class="btn btn-primary">USERS</button></a>
            <?php } ?>
            <a href="/event"><button type="submit" class="btn btn-primary">ORGANIZE</button></a>
            <a href="/logout"><button type="submit" class="btn btn-outline-primary">LOGOUT</button></a>
        </div>
    <?php
    } else if (!isset($hideLogin) || !$hideLogin) {
        //user not logged in
        ?>

        <?php /*
        <form action="/login/index.php" method="post" class="form-inline">
            <input type="email" class="form-control mx-1" placeholder="E-Mail" name="email">
            <input type="password" class="form-control mx-1" placeholder="Password" name="password">
            <input type="submit" name="login-submit" value="LOGIN" class="btn btn-outline-primary mx-1">
            <?php //<a href="/signup" class="form-text ml-2">SIGN UP</a> ?>
        </form> */?>

    <?php
    }
?>
</div>