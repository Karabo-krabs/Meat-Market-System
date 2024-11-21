<?php
// Start the session
session_start();

// Check if the user is logged in
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

// Fetch the first order ID where delivery option is 'delivery' and payment status is 'pending'
$sql = "SELECT order_id, delivery_address FROM orders 
        WHERE delivery_option = 'delivery' AND payment_status = 'pending' 
        LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Get the first order's details
    $row = $result->fetch_assoc();
    $order_id = $row['order_id'];
    $deliveryAddress = $row['delivery_address'];
} else {
    echo "No pending delivery orders found.";
    exit();
}

// Close the database connection
$conn->close();

// Store address
$storeAddress = '240 Cwaile Road, Valspan, Jan Kempdorp, 8550';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Information</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        p {
            font-size: 16px;
            color: #555;
        }
        iframe {
            width: 100%;
            height: 450px;
            border: none;
            border-radius: 8px;
            margin-top: 20px;
        }
        .done-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .done-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Delivery Information</h1>
        <p><strong>Store Address:</strong> <?php echo $storeAddress; ?></p>
        <p><strong>Customer Address:</strong> <?php echo htmlspecialchars($deliveryAddress); ?></p>

        <!-- Google Maps iframe to show the route from store to customer -->
        <iframe
            loading='lazy'
            allowfullscreen
            src='https://www.google.com/maps/embed/v1/directions?key=AIzaSyA60rhu6tmHhbtd12zdC3X1asp63R_RwMk&origin=<?php echo urlencode($storeAddress); ?>&destination=<?php echo urlencode($deliveryAddress); ?>'>
        </iframe>

        <!-- Form to update payment status to paid -->
        <form action="update_payment_status.php" method="POST">
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
            <button type="submit" class="done-button">Done</button>
        </form>
    </div>
</body>
</html>
