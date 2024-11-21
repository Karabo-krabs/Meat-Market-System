<?php
// Start session to access user data
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Connect to the database
$host = 'localhost';
$user = 'root'; // Update with your DB username
$pass = 'OneTwoThree'; // Update with your DB password
$dbname = 'meatmarket';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user data from session
$username = $_SESSION['username'];

// Fetch the customer primary key (customerpk) from the database
$sql = "SELECT customerpk FROM customer WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$customerData = $result->fetch_assoc();
$customerpk = $customerData['customerpk'];

$stmt->close();

// Retrieve cart and form data from POST
$cart = json_decode($_POST['cart'], true);
$deliveryOption = $_POST['delivery_option'];
$address = $deliveryOption === 'delivery' ? $_POST['address'] : NULL;  // Null for collection
$totalPrice = 0;

// Calculate total price from cart items
foreach ($cart as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}

// Add delivery fee if applicable
if ($deliveryOption === 'delivery') {
    $totalPrice += 100;
}

// Insert order into the orders table
$orderSql = "INSERT INTO orders (customerpk, order_date, total_price, payment_status, delivery_option, delivery_address)
             VALUES (?, NOW(), ?, 'Pending', ?, ?)";
$orderStmt = $conn->prepare($orderSql);
$orderStmt->bind_param("idss", $customerpk, $totalPrice, $deliveryOption, $address);
$orderStmt->execute();

// Get the last inserted order ID
$orderID = $orderStmt->insert_id;
$orderStmt->close();

// Insert each cart item into the order_items table
foreach ($cart as $productName => $item) {
    $quantity = $item['quantity'];
    $price = $item['price'];
    $totalPriceItem = $price * $quantity;

    // Retrieve the productID based on productName
    $productIDSql = "SELECT productID FROM products WHERE productName = ?";
    $productIDStmt = $conn->prepare($productIDSql);
    $productIDStmt->bind_param("s", $productName);
    $productIDStmt->execute();
    $productIDResult = $productIDStmt->get_result();
    
    if ($productIDResult->num_rows > 0) {
        $productID = $productIDResult->fetch_assoc()['productID'];
        
        // Insert the item into the order_items table
        $itemSql = "INSERT INTO order_items (order_id, productID, quantity, price, total_price)
                    VALUES (?, ?, ?, ?, ?)";
        $itemStmt = $conn->prepare($itemSql);
        $itemStmt->bind_param("iiidd", $orderID, $productID, $quantity, $price, $totalPriceItem);
        $itemStmt->execute();
        $itemStmt->close();
    } else {
        echo "Product '$productName' not found in the database.";
    }

    $productIDStmt->close();
}

// Insert a notification for the admin
$notificationText = "New order #$orderID placed by $username";
$notificationSql = "INSERT INTO notifications (order_id, notification_text)
                    VALUES (?, ?)";
$notificationStmt = $conn->prepare($notificationSql);
$notificationStmt->bind_param("is", $orderID, $notificationText);
$notificationStmt->execute();
$notificationStmt->close();

// Clear the cart from localStorage (client-side)
// Redirect based on delivery option
if ($deliveryOption === 'delivery') {
    header("Location: delivery.php?address=" . urlencode($address) . "&delivery=" . urlencode($deliveryOption));
} else {
    header("Location: confirmation.php");
}

// Close the database connection
$conn->close();
exit();
?>
