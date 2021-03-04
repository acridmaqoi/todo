<?php

require '../config/db.php';

if(isset($_GET['vkey'])) {
    $vkey = $_GET['vkey'];

    echo $vkey;

    if ($result_set = $con->query("SELECT activated, activation_code FROM accounts WHERE activated = 0 AND activation_code = '$vkey' LIMIT 1")) {
        if (!empty($result_set) && $result_set->num_rows == 1) {
            $update = $con->query("UPDATE ACCOUNTS SET activated = 1 WHERE activation_code = '$vkey' LIMIT 1");
    
            if($update) {
                echo "acc verified";
            } else {
                echo $con->error;
            }
        } else {
            echo "\n163";
        }
    } else {
        die("SQL Error");
    }

    
} else {
    die("Error");
}