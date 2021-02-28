<?php

require '../../controllers/auth.php';
require '../../config/db.php';

// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['email'], $_POST['email_confirm'])) {
	// Could not get the data that should have been sent.
	exit('Please complete the registration form!');
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['email']) || empty($_POST['email_confirm']) || empty($_POST['email'])) {
	// One or more values are empty.
	exit('Please complete the registration form');
}

if ($stmt = $con->prepare('UPDATE accounts SET email = (?) WHERE id = (?)')) {
    $stmt->bind_param('si', $_POST['email'], $_SESSION['id']);
    $stmt->execute();

    echo "done";
} else {
    echo "error";
}