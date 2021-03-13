<?php

function get_username() {
    require 'C:\xampp\htdocs\project-1\config\db.php';
    $stmt = $con->prepare('SELECT username FROM accounts WHERE id = ?');
	$stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
	$stmt->close();
    
    return $result;
}

function get_email() {
    require 'C:\xampp\htdocs\project-1\config\db.php';
    $stmt = $con->prepare('SELECT email FROM accounts WHERE id = ?');
	$stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
	$stmt->close();
    
    return $result;
}


