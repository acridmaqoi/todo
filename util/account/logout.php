<?php

require_once '../../config/db.php';

// destory remember-acc cookie
if ($stmt = $con->prepare('UPDATE accounts SET login_token = NULL WHERE id = (?)')) {
    $stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();
}

unset($_COOKIE['login_token']);
setcookie('login_token', null, -1, '/');

session_start();
session_destroy();
// Redirect to the login page:
header('Location: ../../index.php');
