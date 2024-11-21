<?php
// Start the session
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['username'])) {
    header("Location: adminDelLogin.php");
    exit();
}

// Connect to the database
$host = 'localhost';
$user = 'root'; // Update with your username
$pass = 'OneTwoThree'; // Update with your password
$dbname = 'meatmarket';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the notification ID from the URL
$notification_id = $_GET['notification_id'];

// Update the notification status to 'read'
$sql = "UPDATE notifications SET is_read = 1 WHERE notification_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $notification_id);
$stmt->execute();

header("Location: admin_notifications.php"); // Redirect back to notifications page
exit();
