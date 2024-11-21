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
$order_id = $_GET['order_id'];

// Fetch order details
$sql = "SELECT orders.*, customer.username, customer.address
        FROM orders
        JOIN customer ON orders.customerpk = customer.customerpk
        WHERE orders.order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$orderResult = $stmt->get_result();

if ($orderResult->num_rows > 0) {
    $order = $orderResult->fetch_assoc();
} else {
    echo "Order not found.";
    exit();
}

// Fetch ordered items
$sql_items = "SELECT order_items.*, products.productName AS product_name
              FROM order_items
              JOIN products ON order_items.productID = products.productID
              WHERE order_items.order_id = ?";
$stmt_items = $conn->prepare($sql_items);
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$itemsResult = $stmt_items->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <style>
        body {
    background-color: white; /* Page background */
    color: black; /* Text color */
    font-family: Arial, sans-serif; /* Font family */
}

h1 {
    text-align: center; /* Center header */
    color: black; /* Header color */
}

h3 {
    color: black; /* Color for subheadings */
}

table {
    width: 100%; /* Full width */
    border-collapse: collapse; /* Collapse borders */
    margin: 20px 0; /* Margin around the table */
}

th, td {
    border: 1px solid black; /* Black borders for cells */
    padding: 10px; /* Padding inside cells */
    text-align: left; /* Align text to the left */
}

th {
    background-color: black; /* Black background for header */
    color: white; /* White text for header */
}

tr:nth-child(even) {
    background-color: #f2f2f2; /* Light gray for even rows */
}

a {
    color: black; /* Black links */
    text-decoration: none; /* Remove underline */
}

a:hover {
    text-decoration: underline; /* Underline on hover */
}

strong {
    color: black; /* Strong text color */
}

    </style>
</head>
<body style="background-color: white;">
    <h1>Order Details - ID <?php echo $order['order_id']; ?></h1>

    <p><strong>Customer:</strong> <?php echo htmlspecialchars($order['username']); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
    <p><strong>Order Date:</strong> <?php echo date("F j, Y, g:i a", strtotime($order['order_date'])); ?></p>
    <p><strong>Total Price:</strong> R<?php echo number_format($order['total_price'], 2); ?></p>
    <p><strong>Delivery Option:</strong> <?php echo ucfirst($order['delivery_option']); ?></p>

    <h3>Ordered Items</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($item = $itemsResult->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>R<?php echo number_format($item['price'], 2); ?></td>
                    <td>R<?php echo number_format($item['total_price'], 2); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <button>
        <a href="admin_notifications.php">Back to Notifications</a></p>
    </button>
    <?php
    $conn->close();
    ?>
</body>
</html>
