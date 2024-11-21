<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "OneTwoThree";
$dbname = "meatmarket";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch product data
$sql = "SELECT id, name, price, description, image, (current_qty - sales_qty) AS current_qty, sales_qty FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meat Market</title>
    <link rel="stylesheet" href="original.css">
</head>
<body>
    <main>
        <div class="container">
            <table class="inventory-table" id="inventoryTable">
                <thead>
                    <tr>
                        <th>Item Code</th>
                        <th>Description</th>
                        <th>Unit Cost (R)</th>
                        
                        <th>Current Qty</th>
                        <th>Sales Order Qty</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['price']; ?></td>
                                
                                <td><?php echo $row['current_qty']; ?></td>
                                <td><?php echo $row['sales_qty']; ?></td>
                                <td>
                                    <button class="btn" onclick="editItem(this)">Edit</button>
                                    <button class="btn" onclick="updateItem(<?php echo $row['id']; ?>)">Sell</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="7">No products available</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div> 
    </main>

    <script src="home.js"></script>
    <script>
        function updateItem(productId) {
            // Make an AJAX call to update sales quantity in the database
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "update_inventory.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (this.status == 200) {
                    alert("Sales updated successfully!");
                    window.location.reload(); // Reload the page to see updated data
                }
            };
            xhr.send("product_id=" + productId);
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
