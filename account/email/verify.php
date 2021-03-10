<?php

require '../../config/db.php';

if(!isset($_GET['vkey'])) {
    die("no vkey provided");
}

$vkey = $_GET['vkey'];

if (!($result_set = $con->query("SELECT activated, activation_code, pending_email FROM accounts WHERE activated = 0 AND activation_code = '$vkey' LIMIT 1"))) {
    die("SQL Error: ".$con->error);
} 

// check acc matches vkey
if (!empty($result_set) && $result_set->num_rows == 1) {
    $email = $result_set->fetch_assoc()["pending_email"];

    if ($update = $con->prepare("UPDATE accounts SET activated = 1, email = (?) WHERE activation_code = '$vkey' LIMIT 1")) {
        $update->bind_param('s', $email);
        $update->execute();
        echo "email verified";
    } else {
        die("SQL Error: ".$con->error);
    }
} else {
    echo "invalid vkey";
}