<?php
// Database connection settings
$host = "localhost";
$user = "root";
$password = "";
$db = "travels";

// Create connection
$conn = mysqli_connect($host, $user, $password, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}