<?php

require '../config/db.php';
require 'email/set_email.php';

$ok = true; // tracks if tests have passed
$messages = array(); // error messages

// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	// Could not get the data that should have been sent.
	die('Error');
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	// One or more values are empty.
	$ok = false;
	$messages[] = 'Please complete the registration form';
} else {
	// email validation
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$ok = false;
		$messages[] = 'Invalid email';
	}

	// password validation
	if (!preg_match('@^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,}$@', $_POST['email'])) {
		$ok = false;
		$messages[] = 'Password must be at least 8 characters long and have 1 uppercase letter, 1 lowercase letter, 1 digit and one special character.';
	}
}

// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT id FROM accounts WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.
	if ($stmt->num_rows > 0) {
		// Username already exists
		$ok = false;
		$messages[] = 'Username exists, please choose another!';
	}
}

// Check if acc with email alrady exists
if ($stmt = $con->prepare('SELECT id FROM accounts WHERE email = ?')) {
	$stmt->bind_param('s', $_POST['email']);
	$stmt->execute();
	$stmt->store_result();

	if ($stmt->num_rows > 0) {
		// email already exists
		$ok = false;
		$messages[] = 'Email exists, please choose another!';
	}
}

if ($ok) {
	//insert new account into db
	if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, activation_code, activated) VALUES (?, ?, ?, ?, ?)')) {
		// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$zero = 0;
		$stmt->bind_param('ssssi', $_POST['username'], $password, $_POST['email'], $vkey, $zero);
		$stmt->execute();
	} else {
		// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
		// echo 'Could not prepare statement!';
		die();
	}


	// get session id
	if ($stmt = $con->prepare('SELECT id FROM accounts WHERE username = (?)')) {
		$stmt->bind_param('s', $_POST['username']);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows() > 0) {
			$stmt->bind_result($id);
			$stmt->fetch();
		} else {
			die('db error');
		}
	}

	$set_email = new SetEmail($_POST['email'], $id);
	//echo "Check your email for a verification link";
}
	
$con->close();

echo json_encode(
	array(
		'ok' => $ok,
		'messages' => $messages
	)
);