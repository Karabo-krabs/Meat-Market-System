<?php
// Start the sessione

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

// Fetch unread notifications
$sql = "SELECT notifications.notification_id, notifications.notification_text, notifications.is_read, 
        orders.order_id, orders.total_price, orders.order_date, orders.delivery_option
        FROM notifications
        JOIN orders ON notifications.order_id = orders.order_id
        WHERE notifications.is_read = 0
        ORDER BY notifications.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Notifications</title>
    <style>
        body {
    background-color: white; /* You can change this to black if preferred */
    color: black; /* Default text color */
    font-family: Arial, sans-serif; /* Font style */
}

h1 {
    text-align: center; /* Center the header */
    color: black; /* Header color */
}

table {
    width: 100%; /* Full width */
    border-collapse: collapse; /* Remove spacing between table cells */
    margin: 20px 0; /* Margin around the table */
}

th, td {
    border: 1px solid black; /* Black borders for table cells */
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
    color: black; /* Black color for links */
    text-decoration: none; /* Remove underline */
}

a:hover {
    text-decoration: underline; /* Underline on hover */
}

    </style>
</head>
<body style="background-color: white;">
    
    <button>
        <a href="adminHome.php">Home</a>
    </button>
    <h1>Admin Notifications</h1>

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
                            <a href="view_order.php?order_id=<?php echo $row['order_id']; ?>">View Order</a> |
                            <a href="mark_as_read.php?notification_id=<?php echo $row['notification_id']; ?>">Mark as Read</a> |
                        </td>
                    </tr>
                    
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No new notifications</p>
    <?php } ?>

    <?php $conn->close(); ?>
</body>
</html>
