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
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="checkout.css">
    <style>
        /* Reset some default styles */
        body, h1, h2, p, table, th, td, a {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: gray;
            color: #333;
        }

        header {
            background-color: #d32f2f;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-bottom: 20px;
        }

        .confirmation-container {
            width: 80%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        #map-container {
            width: 100%;
            height: 450px;
            margin-bottom: 20px;
        }

        iframe {
            width: 100%; /* Changed to 100% for responsive design */
            height: 450px; /* Height remains fixed */
            border: 0;
        }

        a {
            display: inline-block;
            background-color: #d32f2f;
            color: white;
            padding: 10px 20px;
            margin: 20px 0;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        a:hover {
            background-color: #b71c1c;
        }

        /* Button styles */
        button {
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        button a {
            font-size: 18px; /* Adjust the font size for the link */
        }
    </style>
</head>
<body>
    <header>
        <h1>Order Successful!</h1>
    </header>
    
    <div class="confirmation-container">
        <h2>Your order has been placed.</h2>
        <p>Please fetch your order at Jan Kempdorp Harvest Butchery with the amount due.</p>

        <button>
            <a href="home.php">Back to Products</a>
        </button>
    </div>
</body>
</html>
