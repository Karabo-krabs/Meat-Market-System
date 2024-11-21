<?php
session_start();

// Check if the delivery guy is logged in
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

// Accept the order
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    

    // Update the order to set the driver
    $update_sql = "UPDATE orders SET driver_id = (SELECT id FROM drivers WHERE username = ?)
                   WHERE order_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $driver_username, $order_id);
    $stmt->execute();

    // Redirect to the map page
    header("Location: map.php?order_id=$order_id");
    exit();
} else {
    echo "Invalid order ID.";
}

$stmt->close();
$conn->close();
?>
