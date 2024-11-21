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

// Get the order ID from the URL
$order_id = intval($_GET['order_id']);

// Prepare and execute the insert statement to notify the driver
$sql = "INSERT INTO driver_notifications (order_id, notification_text, created_at) VALUES (?, ?, NOW())";
$stmt = $conn->prepare($sql);
$notification_text = "New delivery request for Order ID: " . $order_id;
$stmt->bind_param("is", $order_id, $notification_text);
$stmt->execute();

// Check if the notification was sent successfully
if ($stmt->affected_rows > 0) {
    echo "Driver notified successfully!";
} else {
    echo "Error notifying the driver.";
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Redirect back to the notifications page
header("Location: admin_notifications.php"); // Adjust to your notifications page
exit();
?>
