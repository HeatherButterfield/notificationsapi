<?php
$servername = "localhost";
    $username = "Heather";
    $password = "qEzZ6)q#NAbu@a)";
    $database = "lms3660";
    $dbport = 3306;
// Create connection
    $mysqli = new mysqli($servername, $username, $password, $database, $dbport);
    if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: ($mysqli->connect_errno) $mysqli->connect_error");
 }  
?>

