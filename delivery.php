<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: home.php");
    exit();
}

// Ensure the delivery address was passed
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET['address']) || empty($_GET['address'])) {
        echo "Delivery address is required!";
        exit();
    }

    // Get the delivery address from the query parameter
    $deliveryAddress = htmlspecialchars($_GET['address']);
    
    // Proceed with delivery logic
    $storeAddress = '240 Cwaile Road, Valspan, Jan Kempdorp, 8550';

    // Display delivery information
    echo "<h1>Delivery Information</h1>";
    echo "<p>Store Address: $storeAddress</p>";
    echo "<p>Customer Address: $deliveryAddress</p>";

    // Here, you can integrate Google Maps to show the delivery route from the store to the customer address.
    // Below is an example Google Maps iframe to show the route from store to customer
    echo "<iframe
            width='600'
            height='450'
            style='border:0'
            loading='lazy'
            allowfullscreen
            src='https://www.google.com/maps/embed/v1/directions?key=AIzaSyA60rhu6tmHhbtd12zdC3X1asp63R_RwMk&origin=" . urlencode($storeAddress) . "&destination=" . urlencode($deliveryAddress) . "'>
          </iframe>";
    echo "<div class='back-button-container'><a href='Home.php' class='back-button'>Back to Home</a></div>";
} else {
    echo "No delivery address provided.";
    exit();
}
?>
