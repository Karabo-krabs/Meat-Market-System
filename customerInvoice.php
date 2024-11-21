<?php
session_start();

// Assuming customer is logged in and the username is stored in the session
$username = $_SESSION['username'];

// Connect to the database
$mysqli = new mysqli("localhost", "root", "OneTwoThree", "meatmarket");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Step 1: Retrieve customerpk based on the logged-in username
$customerQuery = $mysqli->prepare("SELECT customerpk, name FROM customer WHERE username = ?");
$customerQuery->bind_param("s", $username);
$customerQuery->execute();
$customerResult = $customerQuery->get_result();

if ($customerResult->num_rows > 0) {
    $customerData = $customerResult->fetch_assoc();
    $customerpk = $customerData['customerpk'];
    $customerName = $customerData['name'];

    // Step 2: Retrieve all orders placed by this customer
    $orderQuery = $mysqli->prepare("SELECT * FROM orders WHERE customerpk = ?");
    $orderQuery->bind_param("i", $customerpk);
    $orderQuery->execute();
    $orderResult = $orderQuery->get_result();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Invoice</title>
        <style>
            /* General page styling */
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f9f9f9;
                color: #333;
            }

            /* Invoice Header */
            h1 {
                text-align: center;
                background-color: #333;
                color: white;
                padding: 20px 0;
                margin: 0;
                font-size: 24px;
            }

            /* Order Information */
            h3 {
                color: #555;
                margin-top: 20px;
                font-size: 20px;
            }

            p {
                font-size: 16px;
                margin: 5px 0;
            }

            /* Table Styling */
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            table, th, td {
                border: 1px solid #ddd;
            }

            th, td {
                padding: 10px;
                text-align: left;
            }

            th {
                background-color: #333;
                color: white;
            }

            /* Total Price */
            h2 {
                text-align: right;
                margin-top: 30px;
                color: #333;
            }

            /* Enhancing overall layout */
            .container {
                width: 80%;
                margin: 0 auto;
                background-color: white;
                padding: 20px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                margin-top: 50px;
            }
        </style>
    </head>
    <body>
    <div class="container">
    <?php
    if ($orderResult->num_rows > 0) {
        echo "<h1>Invoice for $customerName</h1>";
        
        // Loop through each order and display order details
        while ($order = $orderResult->fetch_assoc()) {
            $orderID = $order['order_id'];
            $orderDate = $order['order_date'];
            $totalPrice = $order['total_price'];
            $paymentStatus = $order['payment_status'];
            $deliveryOption = $order['delivery_option'];
            $deliveryAddress = $order['delivery_address'];

            echo "<h3>Order ID: $orderID</h3>";
            echo "<p>Order Date: $orderDate</p>";
            echo "<p>Delivery Option: $deliveryOption</p>";
            echo "<p>Delivery Address: $deliveryAddress</p>";
            echo "<p>Payment Status: $paymentStatus</p>";
            
            // Step 3: Retrieve all items for this order
            $itemsQuery = $mysqli->prepare("SELECT * FROM order_items WHERE order_id = ?");
            $itemsQuery->bind_param("i", $orderID);
            $itemsQuery->execute();
            $itemsResult = $itemsQuery->get_result();

            if ($itemsResult->num_rows > 0) {
                echo "<table>
                        <tr>
                            <th>Product ID</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                        </tr>";

                // Loop through each item and display product details
                while ($item = $itemsResult->fetch_assoc()) {
                    $productID = $item['productID'];
                    $quantity = $item['quantity'];
                    $price = $item['price'];
                    $totalItemPrice = $item['total_price'];

                    echo "<tr>
                            <td>$productID</td>
                            <td>$quantity</td>
                            <td>$price</td>
                            <td>$totalItemPrice</td>
                        </tr>";
                }
                echo "</table><br>";
            }
        }

        // Step 4: Display the total price for all orders
        echo "<h2>Total Invoice Price: $totalPrice</h2>";
    } else {
        echo "<p>No orders found for this customer.</p>";
    }
    ?>
    </div>
    </body>
    </html>
    <?php
} else {
    echo "<p>Customer not found.</p>";
}

$mysqli->close();
?>
