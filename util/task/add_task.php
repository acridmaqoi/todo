<?php

require_once "../../config/db.php";

$ok = true;
$messages = array();

// check data was submitted
if (!isset($_POST['title'])) {
    die('Error');
}

$title = $_POST['title'];

// check values are not empty
if (empty($title)) {
    $ok = false;
    $messages[] = 'Enter a task';
}


if ($ok) {
    // insert task into db
    if ($stmt = $con->prepare('INSERT INTO TASKS (title, user_id) VALUES (?, ?)')) {
        $stmt->bind_param('si', $title, $_SESSION["id"]);
        $stmt->execute();
    } else {
        $ok = false;
        $messages[] = 'An unexpected error occoured please try again later';
    }
}


echo json_encode(
    array(
        'ok' => $ok,
		'messages' => $messages
    )
);
