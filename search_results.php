<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "OneTwoThree";
$database = "meatmarket";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search query from the URL (sent via GET)
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Prepare the SQL query to search across all categories
$sql = "SELECT * FROM products WHERE productName LIKE '%$search%' OR category LIKE '%$search%'";

// Execute the query
$result = $conn->query($sql);

// Start outputting results
if ($result->num_rows > 0) {
    echo "<div class='back-button-container'><a href='Home.php' class='back-button'>Back to Home</a></div>";
    
    echo "<h1>Search Results for '" . htmlspecialchars($search) . "'</h1>";
    echo "<div class='product-grid'>";

    while ($product = $result->fetch_assoc()) {
        // Display each product found
        echo "<div class='product'>";
        echo "<img src='" . htmlspecialchars($product['Image']) . "' alt='" . htmlspecialchars($product['productName']) . "'>";
        echo "<h3>" . htmlspecialchars($product['productName']) . "</h3>";
        echo "<p>Category: " . htmlspecialchars($product['category']) . "</p>";
        echo "<p>Price: R" . htmlspecialchars($product['Price']) . "</p>";
        echo "<button onclick=\"addToCart('" . $product['productName'] . "', " . $product['Price'] . ")\">Add to Cart</button>";
        echo "</div>"; // Closing the product div
    }
    
    echo "</div>"; // Closing the product grid div
} else {
    echo "<h1>No results found for '" . htmlspecialchars($search) . "'</h1>";
}


// Close the database connection
$conn->close();
?>

<html lang="en">
<head>

    <style>
        
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-image: url("Background.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white; /* Ensure text is readable */
        }

        /* Styling for the product grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Responsive grid */
            gap: 20px;
            padding: 20px;
            justify-items: center; /* Center align the products */
        }

        /* Styling for each product */
        .product {
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            width: 200px; /* Set a fixed width for each product */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Styling for the product images */
        .product img {
            width: 100px; /* Make images smaller */
            height: 100px;
            object-fit: cover; /* Ensure images maintain aspect ratio */
            border-radius: 5px;
            margin-bottom: 10px;
        }

        /* Styling for the product text */
        .product h3 {
            font-size: 18px;
            margin: 10px 0 5px;
        }

        .product p {
            font-size: 14px;
            margin: 5px 0;
        }

        /* Styling for the buttons */
        .product button {
            background-color: #b22222;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
        }

        .product button:hover {
            background-color: #a11c1c;
        }

         /* Back button styling */
         .back-button-container {
            text-align: center;
            margin: 20px 0;
        }

        .back-button {
            background-color: #b22222;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #a11c1c; /* Darken on hover */
        }
    </style>

            
    <script src="home.js"></script>
    <script>
         function addToCart(product, price) {
            const cart = JSON.parse(localStorage.getItem('cart')) || {};
            if (cart[product]) {
                cart[product].quantity += 1;
            } else {
                cart[product] = { price: price, quantity: 1 };
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            alert(`${product} added to cart.`);
        }
    </script>
</head>
</html>
