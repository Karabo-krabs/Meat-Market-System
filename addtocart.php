<?php
session_start();

// Get the incoming data from the POST request
$data = json_decode(file_get_contents("php://input"));

// Assuming you have a cart array in the session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Add the product to the cart
$product = array(
    'name' => $data->name,
    'price' => $data->price
);

array_push($_SESSION['cart'], $product);

// Return success response
echo json_encode(array('success' => true));
?>
