<?php
// Start the session
session_start();

// Check if the user is logged in by verifying if the session contains the username
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="cart.css">

    <style>
        /* General body styling */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    background-color: grey;
    color: #333;
}

header {
    background-color: #b22222;
    padding: 20px;
    text-align: center;
    color: white;
}

header h1 {
    margin: 0;
}

.back-button {
    background-color: #a11c1c;
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 16px;
    display: inline-block;
    margin-top: 10px;
}

.back-button:hover {
    background-color: #8e1b1b;
}

/* Main container */
main {
    margin: 20px auto;
    padding: 20px;
    width: 80%;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

#cart-items {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

#cart-items th, #cart-items td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

#cart-items th {
    background-color: #b22222;
    color: white;
}

#cart-items td {
    color: #333;
}

/* Cart buttons styling */
.cart-actions {
    margin-top: 20px;
    text-align: center;
}

.cart-button {
    background-color: #b22222;
    color: white;
    border: none;
    padding: 10px 15px;
    margin: 5px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.cart-button:hover {
    background-color: #a11c1c;
}

#total-price {
    text-align: right;
    font-size: 18px;
    font-weight: bold;
    color: #b22222;
    margin-top: 20px;
}

    </style>
</head>
<body>
    <header>
        <h1>Your Cart</h1>
    </header>

    <main>
        <table id="cart-items" >
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Cart items will be inserted here -->
            </tbody>
        </table>
        <h3 id="total-price">Total: R0.00</h3>
        <button onclick = "home()">Home</button>
        <button id="clear-cart">Clear Cart</button>
        <button id="checkout">Checkout</button>
        
    </main>

    <script src="cart.js"></script>
    <script>
        document.getElementById("clear-cart").addEventListener("click", clearCart);
        document.getElementById("checkout").addEventListener("click", checkout);
    </script>
    
</body>
</html>
