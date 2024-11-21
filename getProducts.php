<?php
// getProduct.php

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'butchery');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$productId = intval($_GET['id']); // Sanitize input to prevent SQL injection

$result = $conn->query("SELECT name, price FROM products WHERE id = $productId");

if ($result && $result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode([]);
}

$conn->close();
?>
