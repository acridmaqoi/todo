<?php

function login_user($id, $remember) {

	require __DIR__ . '../../../../autoloader.php';
	require __DIR__ . '../../../db.php';

    // set session variables
	session_regenerate_id();
	$_SESSION['logged_in'] = TRUE;
	$_SESSION['id'] = $id;

	if ($remember) {
		$token = bin2hex(random_bytes(16));

		if ($stmt = $con->prepare('UPDATE accounts SET login_token = (?) WHERE username = (?)')) {
			$stmt->bind_param('ss', $token, $_POST['username']);
			$stmt->execute();
		}

		setcookie('login_token', $token, time() + (86400 * 30), "/");
	}

	return true;
}

