<?php
// Start the session
session_start();

// Check if the user is logged in by verifying if the session contains the username
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meat Market</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="#home"><b>Home</b></a></li>
            </ul> 
            <h1 class="Jan">JAN KEMPDORP HARVEST BUTCHERY</h1>
            <div class="search-container">
                <button>
                    <b><a href="Home.php" style="color:white">Back </a></b>
                </button>
                
            </div>
        </nav>
        <button class="open-btn" onclick="openSidePanel()">☰ </button>

        <div id="sidePanel" class="side-panel">
            <a href="javascript:void(0)" class="close-btn" onclick="closeSidePanel()">×</a>
            <a href="cart.php">View Cart</a>
            <a href="https://wa.me/+27604469370" target="_blank">WhatsApp</a>
            <a href="update.php">Update Information</a>
            <a href="logout.php">Logout</a>
            
        </div>
    </header>

    <main>
        <section id="home">
            <h2>Fresh, Quality Meat and Livestock Delivered to Your Doorstep</h2>
            <p>We offer a wide range of premium meats, sourced from the best farms and delivered fresh to you.</p>
        </section>
    </main>

    <header>
        <h1>Lamb</h1>
        <div class="catalogue-container">
            <?php
            // Database connection details
            $servername = "localhost";
            $username = "root";  // Replace with your MySQL username
            $password = "OneTwoThree";      // Replace with your MySQL password
            $dbname = "meatmarket";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // SQL query to get products from the 'Pig' category
            $sql = "SELECT productID, productName, category, Price, current_qty, image FROM products WHERE category = 'Lamb'";
            $result = $conn->query($sql);

            // Display products dynamically
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                    // Display image using file path
                    echo "<img src='" . $row['image'] . "' alt='" . $row['productName'] . "' />";
                    echo "<h2>" . $row["productName"] . "</h2>";
                    echo "<p>" . $row["productName"] . "</p>";
                    echo "<p>R" . $row["Price"] . "</p>";
                    echo "<button onclick=\"addToCart('" . $row['productName'] . "', " . $row['Price'] . ")\">Add to Cart</button>";
                    echo "</div>";
                }
            } else {
                echo "No products found in the Pig category.";
            }

            $conn->close();
            ?>
        </div>
    </header>

    <script src="home.js"></script>

    <footer class="footer">
        <div>
            <b><p>240 Cwaile Road</p></b>
            <b><p>Valspan</p></b>
            <p><b>Jan Kempdorp</b></p>
            <p><b>8550</b></p>
        </div>
        <div>
            <button style="background-color: #b22222;">
                <b><a href="TermsAndConditions.php" style="color: white;">Terms And Conditions</a></b>
            </button><br><br>
            <button style="background-color: #b22222;">
                <b><a href="RefundAndReturn.php" style="color: white;">Refund and Return Policy</a></b>
            </button>
        </div>
        <div>
            <b><p>Customer Service: 0679933997</p></b>
            <b><p>Email: 202213141@spu.ac.za</p></b>
            <b><p>Mon-Fri, 9 AM - 5 PM</p></b>
            <b><p>Sat-Sun, 9 AM - 2 PM</p></b>
        </div>
    </footer>
    <footer style="background-color: #333;">
        <div>
            <b><p>&copy; 2024 JAN KEMPDORP HARVEST BUTCHERY. All rights reserved.</p></b>
        </div>
    </footer>
    <script>
        function openSidePanel() {
            document.getElementById("sidePanel").style.width = "250px";
        }

        function closeSidePanel() {
            document.getElementById("sidePanel").style.width = "0";
        }

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
</body>
</html>
