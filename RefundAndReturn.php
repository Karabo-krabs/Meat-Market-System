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
            <div class="search-container">
                <input type="text" placeholder="Search..." id="search-bar">
                <button onclick="window.location.href='search.html'"><b>Search</b></button>
                
            </div>
        </nav>
    </header>

    <div class="tees">
        <p>At Jan Kempdorp Harvest Butchery, we take pride in our commitment to providing you with the highest quality products. We stand by our promise to deliver excellence in both our products and service. If, for any reason, you are not satisfied with your purchase, we have established a transparent and customer-friendly return and refund policy to ensure your complete satisfaction. </p>

        <p>1. Refund Eligibility:
        </p>

        <p>We offer refunds on products that meet the following criteria:
        </p>
        <p>• The product is returned within the specified time frame of its expiration date.
        </p>
        <p>• The product is accompanied by a valid proof of purchase (invoice).
        </p>
        <p>• The product’s weight has not been reduced by more than 30% of its original weight.
        </p>
        <p>2. Return Process:
        </p>
        <p>Should you wish to initiate a return and request a refund, please adhere to the following steps:
        </p>
        <p>• Visit any of our physical store locations within 7  days from the date of purchase.
        </p>
        <p>• Present your proof of purchase (invoice) along with the product you intend to return.
        </p>
        <p>• Our store staff will inspect the product to ensure it meets the eligibility criteria.
        </p>
        <p>
            • Upon approval, the return will be processed, and you will receive a refund equivalent to the actual weight of the returned product.
        </p>

        <p>Refunds will be processed directly at the store’s till points, ensuring a hassle-free experience. The refund amount will correspond to the actual weight of the returned product, in accordance with our policy.
        </p>

        <p>4. Processing Time:
        </p>
        <p>Our team will promptly process your refund at the store’s till points upon confirming the eligibility of the returned product. The refund will be credited using the same payment method used for the original purchase.
        </p>
        <p>5. Contact Us:
        </p>
        <p>If you have any inquiries or require assistance regarding our return and refund policy, our courteous staff are ready to assist you. Please feel free to reach out to us at 202213141@spu.ac.za or 067 993 3997
        </p>
        <p>Jan Kempdorp Harvest Butchery values your trust in us and your satisfaction is of utmost importance. Thank you for allowing us to serve you and meet your culinary needs.
        </p>Please note that this return and refund policy is subject to change. For the most current information, kindly visit our website or contact our customer service.
        <p>Jan Kempdorp Harvest Butchery tel number 0679933997
        </p>
        <button>
            <a href="Home.php">Home</a>
        </button>
    </div>  

</body>   
</html> 