<?php

require __DIR__ . '../../../autoloader.php';
require __DIR__ . '../../db.php';

if (!isset($_POST['email'])) {
    die('error');
}

$ok = true;
$messages = array();

$email = $_POST['email'];
$vkey = md5(time().$email);

if (empty($email)) {
    $ok = false;
    $messages[] = "Please enter a email";
}

if ($ok) {
    if ($stmt = $con->prepare('UPDATE accounts SET password_code = (?) WHERE email = (?)')) {
        $stmt->bind_param('ss', $vkey, $email);
        $stmt->execute();
    
        if ($stmt->affected_rows == 0) {
            $ok = false;
            $messages[] = "No account with this email exists";
        }
    } else {
        die('db error');
    }
}

if ($ok) {
    // send vkey via email
    $mail->addAddress($email, 'User');
    $mail->isHTML(true);
    $mail->Subject = 'Change password';
    $mail->Body    = "http://localhost/project-1/util/account/change_password_inc/verify.php?vkey=$vkey";

    $mail->send();

    $messages[] = 'Check your email for a verification link';
}


echo json_encode(
    array(
        'ok' => $ok,
        'messages' => $messages
    )
);




