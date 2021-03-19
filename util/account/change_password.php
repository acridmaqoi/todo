<?php

require_once (__DIR__ . '/../../controllers/auth.php');
require_once (__DIR__ . '/../../config/db.php');
require_once (__DIR__ . '/../../config/email.php');

$ok = true;
$messages = array();

$password             = $_POST['password'];
$new_password         = $_POST['new_password'];
$new_password_confirm = $_POST['new_password_confirm'];

// make sure the submitted registration values are not empty
if (empty($password)) {
    $ok = false;
    $messages[] = 'Password cannot be empty!';
}
if ($ok && empty($new_password)) {
    $ok = false;
    $messages[] = 'New password cannot be empty!';
} else if ($ok && empty($new_password_confirm)) {
    $ok = false;
    $messages[] = 'Confirm new password cannot be empty!';
}

// verify password
if ($ok) {
    if ($stmt = $con->prepare('SELECT password FROM accounts WHERE id = (?)')) {
        $stmt->bind_param('i', $_SESSION['id']);
        $stmt->bind_result($current_password);
        $stmt->execute();
        $stmt->store_result();
    
        if (strcmp($password, $current_password) !== 0) {
            $ok = false;
            $messages[] = 'Password incorrect';
        }
    } else {
        $ok = false;
        $messages[] = 'db error';
    }
}

// check new passwords match
if ($ok) {
    if (strcmp($new_password, $new_password_confirm) != 0) {
        $ok = false;
        $messages[] = "New passwords don't match ".$new_password." ".$new_password_confirm;
    } else {
        // new password validation
        if (!preg_match('/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,}$/', $new_password)) {
            $ok = false;
            $messages[] = 'New password must be at least 8 characters long and have 1 uppercase letter, 1 lowercase letter, 1 digit and one special character';
        }
    }
}

// update password
if ($ok) {
    if ($stmt = $con->prepare('UPDATE accounts SET password = (?) WHERE id = (?)')) {
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt->bind_param('si', $new_password, $_SESSION['id']);
        $stmt->execute();
    } else {
        $ok = false;
        $messages[] = 'db error';
    }

    // // alert user of change via email
    // $mail->addAddress($_SESSION['email'], 'User');
    // $mail->isHTML(true);
    // $mail->Subject = 'Your password has been changed';
    // $mail->Body    = "Your password was changed today at ".date('Y-m-d H:i:s')."\nIf this was not you please reset your password immediately";

    // $mail->send();

    $messages[] = "Password sucsessfully changed";
}

echo json_encode(
    array(
        'ok' => $ok,
        'messages' => $messages
    )
);
