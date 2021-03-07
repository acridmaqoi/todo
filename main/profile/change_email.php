<?php

require '../../controllers/auth.php';
require '../../config/db.php';
require '../../email/set_email.php';

$ok = true;
$messages = array();

// make sure the submitted registration values are not empty
if (empty($_POST['email'])) {
    $ok = false;
    $messages[] = 'Email cannot be empty!';
}
if (empty($_POST['email_confirm']) && $ok) {
    $ok = false;
    $messages[] = 'Confirm email cannot be empty!';
}

// check if emails match
if ($_POST['email'] !== $_POST['email_confirm']) {
    $ok = false;
    $messages[] = 'Emails do not match';
}

// validate email 
if (!preg_match('/^\S+@\S+\.\S+$/', $_POST['email']) && $ok) {
    $ok = false;
    $messages[] = 'Please enter a valid email address';
}

// update email
if ($ok) {
    $set_email = new SetEmail($_POST['email'], $_SESSION['id']);
}

echo json_encode(
    array(
        'ok' => $ok,
        'messages' => $messages
    )
);
