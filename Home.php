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
    <link rel="stylesheet" href="Home.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="#home"><b>Home</b></a></li>
            </ul> 
            <h1 class="Jan">JAN KEMPDORP HARVEST BUTCHERY</h1>
            <form action="search_results.php" method="GET" class="search-container">
                <input type="text" name="search" id="search-bar" placeholder="Search for products..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" required>
                <button type="submit">Search</button>
            </form>


        </nav>
        
        <button class="open-btn" onclick="openSidePanel()">☰ </button>

        <div id="sidePanel" class="side-panel">
            <a href="javascript:void(0)" class="close-btn" onclick="closeSidePanel()">×</a>
            <a href="cart.php">View Cart</a>
            <a href="customerInvoice.php">Customer Invoice</a>
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
        <h1>Product Catalogue</h1>
   
    <div class="catalogue-container">
        <div class="product">
            <img src="putsana.jpg" alt="Product 2">
            <i><h3 style="color: white;">Livestock</h3></i>
            <button id="view_livestock" >
                <b><a href="livestock.php" style="color: white;">View </a></b>
            </button>

        </div>

        <div class="product">
            <img src="beef.jpeg" alt="Product 2">
            <i><h3 style="color: white;">Beef </h3></i>
            <button id="view_Beef">
                <b><a href="Beef.php" style="color: white;">View</a></b>
            </button>

        </div>
        <div class="product">
            <img src="lamb.jpg" alt="Lamb">
            <i><h3 style="color: white;">Lamb </h3></i>
            <button id="view_lamb">
                <b><a href="lamb.php" style="color: white;">View </a></b>
            </button>

        </div>
        <div class="product">
            <img src="pork.jpeg" alt="Product 2">
            <i><h3 style="color: white;">Pork </h3></i>
            <button id="view_stew">
                <b><a href="pork.php" style="color: white;">View </a></b>
            </button>

        </div>

        <div class="product">
            <img src="goat1.jpeg" alt="Product 2">
            <i><h3 style="color: white;">Goat </h3></i>
            <button id="view_stew">
                <b><a href="goat.php" style="color: white;">View </a></b>
            </button>

        </div>
        <div class="product">
            <img src="Whole-Chicken.jpg" alt="Product 2">
            <i><h3 style="color: white;">Chicken</h3></i>
            <button id="view_stew">
                <b><a href="Chicken.php" style="color: white;">View </a></b>
            </button>

        </div>
        
        <!-- Add more products as needed -->
    </div>


    

    <footer class="footer" >
        <div>
            <b><p>240 Cwaile Road</p></b>
            <b><p>Valspan</p></b>
            <p><b>Jan Kempdorp</b></p>
            <p><b>8550</b></p>
        </div>
        <div>

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
    <script src="home.js"></script>
</body>
</html>
