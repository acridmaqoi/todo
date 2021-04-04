<?php

function register_user($user, $password, $email, $activated) {

    require '../../../config/db.php';
    require '../change_email_inc/set_email.php';

    //insert new account into db
	if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, pending_email, activation_code, activated) VALUES (?, ?, ?, ?, ?, ?)')) {
		// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
		
		if ($password != null) {
			$password = password_hash($password, PASSWORD_DEFAULT);
		}

		$null = NULL;
		if ($activated) {
			$stmt->bind_param('sssssi', $user, $password, $email, $null, $vkey, $activated);
		} else {
			$stmt->bind_param('sssssi', $user, $password, $null, $email, $vkey, $activated);
		}
		
		$stmt->execute();
	} else {
		// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
		// echo 'Could not prepare statement!';
		die();
	}


	if (!$activated) {
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

		return new SetEmail($_POST['email'], $id);
	}
	

}