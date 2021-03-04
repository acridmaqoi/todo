<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../config/db.php';
require '../lib/PHPMailer/vendor/autoload.php';


// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	// Could not get the data that should have been sent.
	exit('Please complete the registration form!');
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	// One or more values are empty.
	exit('Please complete the registration form');
}

// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.
	if ($stmt->num_rows > 0) {
		// Username already exists
		echo 'Username exists, please choose another!';
	} else {
		// Username doesnt exists, create new account

		// email verification
		$vkey = md5(time().$_POST['username']);

		//insert new account into db
		if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, activation_code, activated) VALUES (?, ?, ?, ?, ?)')) {
			// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$zero = 0;
			$stmt->bind_param('ssssi', $_POST['username'], $password, $_POST['email'], $vkey, $zero);
			$stmt->execute();
		} else {
			// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
			echo 'Could not prepare statement!';
			die();
		}

		// send email
		
		//Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
			//Server settings                     
			$mail->isSMTP();                                        
			$mail->Host       = 'smtp.gmail.com';
			$mail->SMTPAuth   = true;                                  
			$mail->Username   = 'samquinn120@gmail.com';                    
			$mail->Password   = '4VunAiQZekAKLAzc7WqMCszp';                            
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         
			$mail->Port       = 465;                                    

			//Recipients
			$mail->setFrom('samquinn120@gmail.com', 'Mailer');
			$mail->addAddress('samquinn20@gmail.com', 'User');     //Add a recipient

			//Content
			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = 'Email verification';
			$mail->Body    = "http://localhost/project-1/registration/verify.php?vkey=$vkey";

			$mail->send();
			echo 'Message has been sent';
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}


		echo 'check your email for a verification link';

		// echo 'You have successfully registered, you can now login!';	
		// 	echo '<script type="text/javascript">
		// 			setTimeout(function() {
		// 						window.location.href = "index.html"
		// 					}, 3000); 
		// 			</script>';
	}
	
} else {
	// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
	echo 'Could not prepare statement!';
}
$con->close();
