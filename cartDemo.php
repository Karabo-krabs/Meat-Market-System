<?php
session_start();
header('Content-Type: application/json');
include 'db_connect.php';  // Include database connection file

// Handle POST request to add items to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if necessary data is available
    if (isset($data['productId']) && isset($data['price']) && isset($data['quantity'])) {
        $productId = $data['productId'];
        $price = $data['price'];
        $quantity = $data['quantity'];
        $customer_id = $_SESSION['customer_id'] ?? 1;  // Default customer for testing

        // Insert product into cart for the specific customer
        $query = "INSERT INTO cart (productid, price, quantity, customer_id) VALUES ('$productId', '$price', '$quantity', '$customer_id')";

        if (mysqli_query($conn, $query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid data.']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle GET request to fetch cart items for display
    $customer_id = $_SESSION['customer_id'] ?? 1;  // Default customer for testing
    $query = "SELECT p.productName, c.price, c.quantity 
              FROM cart c 
              JOIN products p ON c.productid = p.productID 
              WHERE customer_id = '$customer_id'";
    $result = mysqli_query($conn, $query);
    $cartItems = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $cartItems[] = $row;
    }
    echo json_encode($cartItems);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>
