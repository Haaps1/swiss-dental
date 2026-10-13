<?php

$host = "localhost";
$dbname = "u595349695_SwissDental";
$username = "u595349695_swissdental";
$password = "3Fj@Ml*Kb82z";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>