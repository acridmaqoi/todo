<?php

function auth($redirect) {

	require(__DIR__ . '/../../config/db.php');
	require('login_inc/login_inc.php');

	

	if (!isset($_SESSION['logged_in'])) {


		if (isset($_COOKIE['login_token']) && $stmt = $con->prepare('SELECT id FROM accounts WHERE login_token = (?)')) {	
			$stmt->bind_param('s', $_COOKIE['login_token']);
			$stmt->bind_result($id);
			$stmt->execute();
			$stmt->store_result();
			
			if ($stmt->num_rows() == 1) {

				$stmt->fetch();
				
				if (login_user($id, true)) {
					header('Location: http://localhost/project-1/main/list.php?id='.$_COOKIE['login_token']);
					
				}
			}
		} else {
			// If the user is not logged in redirect to the login page...
			if ($redirect) {

				header('Location: http://localhost/project-1');
				exit;
			}
		}
	}

	
}


