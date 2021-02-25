<?php
session_start();
include 'common/functions_file.php';
$result_returned = remember_user();

if (!isset($result_returned)) {
    display_login_page('');
} else {
    setcookie('winlott-user', "", 1, '/');
    setcookie('remember-me', "", 1, '/');
    $_SESSION['winlott-valid-name'] = "";

    session_unset();
    session_destroy();

    redirectTo(0.1, '/index.php');
}