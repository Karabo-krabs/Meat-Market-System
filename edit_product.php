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

// Initialize variables
$productID = $_GET['id'] ?? '';
$productName = '';
$category = '';
$price = '';
$current_qty = '';
$sales_qty = '';
$image = '';

// Fetch product details
if ($productID) {
    $sql = "SELECT productName, Category, price, current_qty, sales_qty, image FROM products WHERE productID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $productName = $row['productName'];
        $category = $row['Category'];
        $price = $row['price'];
        $current_qty = $row['current_qty'];
        $sales_qty = $row['sales_qty'];
        $image = $row['image'];
    } else {
        echo "Product not found!";
    }
}

// Handle form submission to update the product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['productName'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $current_qty = $_POST['current_qty'];
    $sales_qty = $_POST['sales_qty'];
    
    // Handle the image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageFolder = 'uploads/' . $image; // Ensure this path is correct

        // Move the uploaded image to the 'uploads' folder
        if (move_uploaded_file($imageTmpName, $imageFolder)) {
            // Update product in database with new image
            $sql = "UPDATE products SET productName=?, Category=?, price=?, current_qty=?, sales_qty=?, image=? WHERE productID=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdiisi", $productName, $category, $price, $current_qty, $sales_qty, $image, $productID);
        } else {
            echo "Failed to upload image.";
        }
    } else {
        // Update product in database without changing the image
        $sql = "UPDATE products SET productName=?, Category=?, price=?, current_qty=?, sales_qty=? WHERE productID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdiis", $productName, $category, $price, $current_qty, $sales_qty, $productID);
    }

    if ($stmt->execute()) {
        echo "Product updated successfully!";
        header("Location: adminHome.php"); // Redirect back to the admin home after update
        exit();
    } else {
        echo "Error updating product: " . $stmt->error;
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
    <title>Edit Product - JAN KEMPDORP HARVEST BUTCHERY</title>
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
            background-color: maroon;
        }
        form {
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="number"], input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            padding: 10px 20px;
            background-color: white;
            color: black;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>Edit Product</h1>
    </div>

    <div class="container">
        <form action="edit_product.php?id=<?php echo $productID; ?>" method="POST" enctype="multipart/form-data">
            <label for="productName">Product Name:</label>
            <input type="text" id="productName" name="productName" value="<?php echo htmlspecialchars($productName); ?>" required>

            <label for="category">Category:</label>
            <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($category); ?>" required>

            <label for="price">Price:</label>
            <input type="number" step="0.01" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" required>

            <label for="current_qty">Current Quantity:</label>
            <input type="number" id="current_qty" name="current_qty" value="<?php echo htmlspecialchars($current_qty); ?>" required>

            <label for="sales_qty">Sales Quantity:</label>
            <input type="number" id="sales_qty" name="sales_qty" value="<?php echo htmlspecialchars($sales_qty); ?>" required>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*">

            <button type="submit" class="btn">Update Product</button>
        </form>
    </div>
</body>
</html>
