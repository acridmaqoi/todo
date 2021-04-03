<?php

require_once '../../config/db.php';
require_once './login_inc/login_inc.php';

$ok = true; // tracks if tests have passed
$messages = array(); // error messages

// check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['username'], $_POST['password'])) {
	// Could not get the data that should have been sent.
	$ok = false;
	$messages[] = 'Please fill both the username and password fields!';
}

// fetch user details from db
$stmt;
if ($ok && ($stmt = $con->prepare('SELECT id, password, email, pending_email, activated FROM accounts WHERE username = ?'))) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();
} else {
	$ok = false;
	$messages[] = 'The login system is currently offline, please try again later';
}


$id;
$password;
$activated = false;

// check username
if ($ok && $stmt->num_rows > 0) {
	$stmt->bind_result($id, $password, $email, $pending_email, $activated);
	$stmt->fetch();
} else {
	$ok = false;
	$messages[] = 'Incorrect username and/or password!';
}

// check password
if ($ok && !password_verify($_POST['password'], $password)) {
	$ok = false;
	$messages[] = 'Incorrect username and/or password!';
}

// check acc is activated
if ($ok && !$activated ) {
	$ok = false;
	$messages[] = 'Please check '.$pending_email.' for a verification email';
}

// all checks are passed, so can login
if ($ok) {

	// echo $id;
	login_user($id, $_POST['remember']);
} 

echo json_encode(
	array(
		'ok' => $ok,
		'messages' => $messages
	)
);
