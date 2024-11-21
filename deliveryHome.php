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

// Fetch unread notifications for the delivery guy
$driver_username = $_SESSION['username'];

// Update the SQL query to reflect the correct column name
$sql = "SELECT notifications.notification_id, notifications.notification_text, 
               orders.order_id, orders.total_price, orders.order_date, 
               orders.delivery_option, orders.customerpk, orders.delivery_address
        FROM notifications
        JOIN orders ON notifications.order_id = orders.order_id
        WHERE orders.driver_id = (SELECT deliverypk FROM deliveryGuy WHERE deliveryusername = ?) AND notifications.is_read = 0
        ORDER BY notifications.created_at DESC";

$stmt = $conn->prepare($sql);

// Bind the username from the session to fetch the correct delivery guy ID
$stmt->bind_param("s", $driver_username);

// Execute and check for errors
if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Guy Notifications</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Delivery Guy Notifications</h1>

    <?php if ($result->num_rows > 0) { ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Notification</th>
                    <th>Order ID</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                    <th>Delivery Option</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['notification_text']); ?></td>
                        <td><?php echo $row['order_id']; ?></td>
                        <td>R<?php echo number_format($row['total_price'], 2); ?></td>
                        <td><?php echo date("F j, Y, g:i a", strtotime($row['order_date'])); ?></td>
                        <td><?php echo ucfirst($row['delivery_option']); ?></td>
                        <td>
                            <a href="accept_order.php?order_id=<?php echo $row['order_id']; ?>">Accept Order</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No new notifications</p>
    <?php } ?>

    <?php 
    $stmt->close();
    $conn->close(); 
    ?>
</body>
</html>
