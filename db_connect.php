<?php
$servername = "localhost";
$username = "root";  // Your MySQL username
$password = "OneTwoThree";  // Your MySQL password
$dbname = "meatmarket";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
