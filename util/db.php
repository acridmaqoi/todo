<?php 

$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "project-1";

$con = mysqli_connect($hostname, $username, $password, $dbname) or die("Database connection not established.");