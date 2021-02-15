<?php

session_start();
include 'common/functions_file.php';

$hour = time() - 3600 * 24 * 7;

setcookie('winlott-user', "", $hour);
setcookie('remember-me', "", $hour);

unset($_SESSION['user-name']);
unset($_SESSION['logged']);

session_unset();
session_destroy();

redirectTo(0.1, '/index.php');
