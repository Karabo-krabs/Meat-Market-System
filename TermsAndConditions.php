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
        <p>Updated – 14 June 2024</p>

        <p>Please read these Terms and Conditions (“Terms”, “Terms and Conditions”) carefully before using our website (the “Service”) operated by Jan Kempdop Harvest Butchery (PTY) ltd (“us”, “we”, or “our”).</p>

        <p>Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms. These Terms apply to all visitors, users, and others who access or use the Service.</p>

        <p>By accessing or using the Service, you agree to be bound by these Terms. If you disagree with any part of the terms, then you may not access the Service.</p>

        <p>Purchases</p>

        <p>If you wish to purchase any product or service made available through the Service (“Purchase”), you may be asked to supply certain information relevant to your Purchase including, without limitation, your name, address, and payment information.</p>
        
        <p> Governing Law </p>

            <p>These Terms shall be governed and construed in accordance with the laws of South Africa, without regard to its conflict of law provisions.</p>
            
            <p>Changes </p>
            
            <p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. 
            If a revision is a material, we will try to provide at least 30 days’ notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.</p>
            
            <p>By continuing to access or use our Service after those revisions become effective, 
            you agree to be bound by the revised terms. If you do not agree to the new terms, please stop using the Service.</p>
            
            <p>Pricing Disclaimer: At Jan Kempdorp Harvest Butchery, we strive to maintain consistency in pricing 
            across both our online and in-store platforms. However, please note that inventory levels and pricing may vary between these channels. While we make every reasonable effort to ensure accuracy in the information provided, factors such as promotions, supplier costs, and regional variations may result in differences in pricing. We appreciate your understanding and assure you that we continuously work towards providing the best value to our customers. For the most up-to-date pricing information, we encourage you to reach out to our customer service team or visit one of our convenient store locations. Thank you for choosing Jan Kempdorp Harvest Butchery.</p>
            
            <p>Contact Us</p>
            
            <p>If you have any questions about these Terms, please contact us at:</p>
            
            <p>0679933997</p>
            
            <button>
            <a href="Home.php">Home</a>
        </button>
    </div>  

</body>   
</html> 