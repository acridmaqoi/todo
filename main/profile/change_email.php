<?php

require '../../controllers/auth.php';
require '../../config/db.php';

$ok = true;
$messages = array();

// Make sure the submitted registration values are not empty.
if (empty($_POST['email'])) {
    $ok = false;
    $messages[] = 'Email cannot be empty!';
}
if (empty($_POST['email_confirm']) && $ok) {
    $ok = false;
    $messages[] = 'Confirm email cannot be empty!';
}

// TODO: Check if emails match

// validate email 
if (!preg_match('/^\S+@\S+\.\S+$/', $_POST['email']) && $ok) {
    $ok = false;
    $messages[] = 'Please enter a valid email address';
}

// update email
if ($stmt = $con->prepare('UPDATE accounts SET email = (?) WHERE id = (?)')) {
    $stmt->bind_param('si', $_POST['email'], $_SESSION['id']);
    $stmt->execute();

} else {
    $ok = false;
    $messages[] = 'Fatal error';
}

echo json_encode(
    array(
        'ok' => $ok,
        'messages' => $messages
    )
);
