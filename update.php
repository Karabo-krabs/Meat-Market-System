<?php
session_start();
if (!isset($_SESSION['username'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Fetch the logged-in username
$username = $_SESSION['username'];

// Step 1: Establish connection to the database
$servername = "localhost";
$db_username = "root";
$db_password = "OneTwoThree";
$database = "meatmarket";

$conn = new mysqli($servername, $db_username, $db_password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user information from the database securely
$stmt = $conn->prepare("SELECT * FROM Customer WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $customer = $result->fetch_assoc(); // Fetch customer details into an array
} else {
    echo "Error fetching customer details.";
    exit();
}

// Step 2: Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $new_username = mysqli_real_escape_string($conn, $_POST['username']); // Fetch new username

    // Update other user details, including username if it is being changed
    $update_sql = "UPDATE Customer SET name='$name', surname='$surname', phone='$phone', address='$address', username='$new_username' WHERE username='$username'";
    
    if ($conn->query($update_sql) === TRUE) {
        echo "Information updated successfully!";
        // Update session username if it was changed
        if ($username !== $new_username) {
            $_SESSION['username'] = $new_username;
        }
    } else {
        echo "Error updating information: " . $conn->error;
    }

    // Only hash and update the password if both password fields are filled and match
    if (!empty($new_password) && $new_password === $confirm_password) {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_password_sql = "UPDATE Customer SET password='$hashed_password' WHERE username='$new_username'";
        
        if ($conn->query($update_password_sql) !== TRUE) {
            echo "Error updating password: " . $conn->error;
        } else {
            echo "Password updated successfully!";
        }
    } elseif (!empty($new_password) && $new_password !== $confirm_password) {
        echo "Passwords do not match.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer Info</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Styles for the page */
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-image: url("Background.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
        }

        .register-box {
            width: 300px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.6);
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .textbox {
            position: relative;
            margin-bottom: 30px;
        }

        .textbox input,
        .textbox textarea {
            width: 90%;
            padding: 10px;
            background: #f1f1f1;
            border: none;
            outline: none;
            color: #333;
            font-size: 18px;
            border-radius: 5px;
        }

        .eye-icon {
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
        }

        .btn {
            width: 100%;
            background: #333;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-size: 18px;
            color: white;
            border-radius: 5px;
        }

        .btn:hover {
            background: #555;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
            </ul>
        </nav>
        <h1>JAN KEMPDORP HARVEST BUTCHERY</h1>
    </header>

    <center>
        <div class="register-box">
            <h1>Update Customer Info</h1>
            <form action="update.php" method="POST">
                <div class="textbox">
                    <input type="text" name="name" id="name" placeholder="Name" value="<?= htmlspecialchars($customer['name']); ?>" required>
                </div>
                <div class="textbox">
                    <input type="text" name="surname" id="surname" placeholder="Surname" value="<?= htmlspecialchars($customer['surname']); ?>" required>
                </div>
                <div class="textbox">
                    <input type="text" name="username" id="username" placeholder="Username" value="<?= htmlspecialchars($customer['username']); ?>" >
                </div>
                <div class="textbox">
                    <input type="password" name="new_password" id="new_password" placeholder="New Password (leave blank to keep current)">
                </div>
                <div class="textbox">
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm New Password">
                </div>
                
                <div class="textbox">
                    <input type="tel" name="phone" id="phone" placeholder="Phone Number" value="<?= htmlspecialchars($customer['phone']); ?>" required>
                </div>
                <div class="textbox">
                    <input type="text" name="address" id="address" placeholder="Address" value="<?= htmlspecialchars($customer['address']); ?>" required>
                </div>
                <input type="submit" class="btn" value="Update">
            </form>
        </div>
    </center>

    <footer>
        <p>&copy; 2024 JAN KEMPDORP HARVEST BUTCHERY. All rights reserved.</p>
    </footer>
</body>
</html>
