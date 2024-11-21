<?php
// Start the session
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['username'])) {
    header("Location: adminDelLogin.php");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', 'OneTwoThree', 'meatmarket');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission to add a new product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['productName'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $current_qty = $_POST['current_qty'];
    $sales_qty = $_POST['sales_qty'];
    
    // Handle the image upload
    $image = $_FILES['image']['name'];
    $imageTmpName = $_FILES['image']['tmp_name'];
    $imageFolder = 'C:/Users/202215553/Desktop/i updated/i (3)/i/' . $image; // Ensure this path is correct

    // Move the uploaded image to the 'uploads' folder
    if (move_uploaded_file($imageTmpName, $imageFolder)) {
        // Insert product into database
        $sql = "INSERT INTO products (productName, Category, price, current_qty, sales_qty, image) 
                VALUES ('$productName', '$category', '$price', '$current_qty', '$sales_qty', '$image')";

        if ($conn->query($sql) === TRUE) {
            echo "New product added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Failed to upload image.";
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JAN KEMPDORP HARVEST BUTCHERY</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('HomeBack.jpg'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
        }
        .navbar {
            background-color: rgba(223, 11, 15, 0.866);
            padding: 20px;
            color: white;
            display: flex;
            align-items: center;
        }
        .navbar h1 {
            flex: 1;
            font-size: 30px;
            text-align: center;
            margin: 0;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            border-radius: 10px;
            padding: 20px;
        }
        .form-container {
            display: flex;
            justify-content: center; /* Center the form horizontally */
            margin-bottom: 20px;
        }
        form {
            text-align: left; /* Align text to the left within the form */
        }
        .inventory-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: maroon;
        }
        .inventory-table th, .inventory-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #f4efef;
        }
        .inventory-table th {
            background-color: #90411369;
            color: black;
        }
        .inventory-table td {
            color: white;
        }
        .add-item {
            margin: 20px 0;
            text-align: right;
        }
        .btn {
            padding: 8px 16px;
            background-color: white;
            color: black;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #ddd;
        }
        .edit-btn {
            padding: 5px 10px;
            background-color: #ff9800; /* Color for edit button */
            color: white;
            border: none;
            cursor: pointer;
        }
        .edit-btn:hover {
            background-color: #e68a00; /* Darker shade on hover */
        }
        .side-panel {
            position: fixed;
            top: 0;
            left: 0;
            width: 200px;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.5);
        }
        .side-panel h2 {
            margin-top: 0;
        }
        .side-panel ul {
            list-style-type: none;
            padding: 0;
        }
        .side-panel ul li {
            margin: 15px 0;
        }
        .side-panel ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }
        .side-panel ul li a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Side Panel -->
    <div class="side-panel">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="adminHome.php">Dashboard</a></li>
            <li><a href="admin_notifications.php">View order Notifications</a></li>
            <li><a href="logoutAd.php">Logout</a></li>
        </ul>
    </div>

    <!-- Navigation Bar -->
    <div class="navbar">
        <h1>JAN KEMPDORP HARVEST BUTCHERY</h1>
    </div>

    <div class="container" style="margin-left: 220px;"> <!-- Adjusted for side-panel -->
        <!-- Form to add a new item -->
        <div class="form-container">
            <form action="adminHome.php" method="POST" enctype="multipart/form-data">
                <label for="productName">Product Name:</label><br>
                <input type="text" id="productName" name="productName" required><br><br>

                <label for="category">Category:</label><br>
                <input type="text" id="category" name="category" required><br><br>

                <label for="price">Price:</label><br>
                <input type="number" step="0.01" id="price" name="price" required><br><br>

                <label for="current_qty">Current Quantity:</label><br>
                <input type="number" id="current_qty" name="current_qty" required><br><br>

                <label for="sales_qty">Sales Quantity:</label><br>
                <input type="number" id="sales_qty" name="sales_qty" required><br><br>

                <label for="image">Image:</label><br>
                <input type="file" id="image" name="image" accept="image/*" required><br><br>

                <button type="submit" class="btn">Add Item</button>
            </form>
        </div>

        <!-- Table displaying the products -->
        <table class="inventory-table">
            <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Current Qty</th>
                    <th>Sales Order Qty</th>
                    <th>Image</th>
                    <th>Actions</th> <!-- New column for actions -->
                </tr>
            </thead>
            <tbody>
                <?php
                    // Fetch and display products from the database
                    $conn = new mysqli('localhost', 'root', 'OneTwoThree', 'meatmarket');

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT productID, productName, Category, price, current_qty, sales_qty, image FROM products";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['productID'] . "</td>";
                            echo "<td>" . $row['productName'] . "</td>";
                            echo "<td>" . $row['Category'] . "</td>";
                            echo "<td>" . number_format($row['price'], 2) . "</td>";
                            echo "<td>" . $row['current_qty'] . "</td>";
                            echo "<td>" . $row['sales_qty'] . "</td>";
                            echo "<td><img src='uploads/" . $row['image'] . "' alt='" . $row['productName'] . "' style='width: 50px; height: auto;' /></td>";
                            echo "<td><a href='edit_product.php?id=" . $row['productID'] . "' class='edit-btn'>Edit</a></td>"; // Edit button
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No products found</td></tr>";
                    }

                    $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
