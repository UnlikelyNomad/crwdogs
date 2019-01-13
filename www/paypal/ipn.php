<?php

require 'PaypalIPN.php';

use PaypalIPN;

$ipn = new PaypalIPN();

$ipn->useSandbox();
$verified = $ipn->verifyIPN();
if ($verified) {
    error_log(print_r($_POST, true));
}

header("HTTP/1.1 200 OK");