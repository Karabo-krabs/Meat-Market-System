<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $conn = new mysqli('localhost', 'root', 'OneTwoThree', 'meatmarket');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO products (productName, price, current_qty, sales_qty, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdiib", $productName, $price, $current_qty, $sales_qty, $imageData);

    // Retrieve data from the form
    $productName = $_POST['productName'];
    $price = $_POST['price'];
    $current_qty = $_POST['current_qty'];
    $sales_qty = $_POST['sales_qty'];

    // Handling image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
    } else {
        $imageData = null; // Set to null or handle error
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>
