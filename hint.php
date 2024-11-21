<?php

// Step 1: Establish Connection
$servername = "localhost";
$username = "root";
$password = "OneTwoThree";
$database = "MeatMarket";

$conn = new mysqli($servername, $username, $password, $database, 3306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Initialize variables for feedback message
$feedback_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    // Step 3: Query the database for the user's password hint
    $sql = "SELECT password_hint FROM Customer WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Fetch the password hint
        $row = $result->fetch_assoc();
        $feedback_message = "Your Password Hint: " . $row['password_hint'];
    } else {
        $feedback_message = "No user found with that username.";
    }
}

// Close Connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retrieve Password Hint</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .hint-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .hint-box {
            width: 300px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .hint-box h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }
        .textbox input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #555;
        }
        .feedback-message {
            margin-top: 20px;
            font-size: 16px;
            color: red;
        }
    </style>
</head>
<body>
    <div class="hint-container">
        <div class="hint-box">
            <h1>Retrieve Password Hint</h1>
            <form action="" method="POST">
                <div class="textbox">
                    <input type="text" name="username" placeholder="Enter your username" required>
                </div>
                <input type="submit" class="btn" value="Get Password Hint">
            </form>

            <!-- Display feedback message if any -->
            <?php if (!empty($feedback_message)): ?>
                <div class="feedback-message">
                    <?php echo $feedback_message; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
