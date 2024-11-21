<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: AdminDelLogin.php");
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

// Check if the order_id is set in the POST request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Update the payment status to 'paid'
    $sql = "UPDATE orders SET payment_status = 'paid' WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        // Redirect back to the delivery page or show a success message
        echo "Payment status updated to paid.";
        echo "<script>window.location.href = 'map.php';</script>";

    } else {
        echo "Error updating payment status: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "No order ID provided.";
}

// Close the database connection
$conn->close();
?>
