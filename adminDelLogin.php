<?php
session_start(); // Start the session

// Database connection
$conn = new mysqli('localhost', 'root', 'OneTwoThree', 'meatmarket');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login form handling
if (isset($_POST['login'])) {
    $role = $_POST['role']; // 'admin' or 'delivery_guy'
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($role == 'admin') {
        $sql = "SELECT * FROM Admin WHERE adminusername='$username'";
    } else if ($role == 'delivery_guy') {
        $sql = "SELECT * FROM DeliveryGuy WHERE deliveryusername='$username'";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Store session data
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            // Redirect based on role
            if ($role == 'admin') {
                header("Location: adminHome.php");
                exit(); // Stop script execution after redirect
            } else if ($role == 'delivery_guy') {
                header("Location: map.php");
                exit(); // Stop script execution after redirect
            }
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with this username!";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-image: url("Background.jpg"); /* Correct relative path */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white; /* Ensure text is readable */
        }

        header {
            background-color: rgba(178, 34, 34, 0.8); /* Semi-transparent background */
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
        }

        .login-container {
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 50px; /* Add some margin from the top */
        }

        .login-box {
            width: 300px;
            padding: 40px;
            position: relative;
            background: rgba(255, 255, 255, 0.6);
            text-align: center;
            border-radius: 10px;
        }

        .login-box h1 {
            margin-bottom: 30px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;

        }

        form label {
            margin: 10px 0 5px;
            text-align: left; /* Align labels to the left */
            color: #333;
        }

        form input[type="text"],
        form input[type="password"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%; /* Full width */
        }

        form input[type="radio"] {
            margin-right: 10px; /* Space between radio button and label */
            accent-color: black; /* Set radio button color to black */
            color: #333;
        }

        form button {
            padding: 10px;
            margin-bottom: 10px;
            background-color: black; /* Set button color to black */
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px; /* Added border radius for consistency */
        }

        form button:hover {
            background-color: #333; /* Darker shade for hover effect */
        }

        footer {
            background-color: rgba(51, 51, 51, 0.8); /* Semi-transparent background */
            color: white;
            text-align: center;
            padding: 10px 0;
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

    <div class="login-container">
        <div class="login-box">
            <h1>Login</h1>

            <form method="POST" action="">
                <label for="role">I am a:</label>
                <label>
                    <input type="radio" style="color: #333;" name="role" value="admin" checked> Admin
                </label>
                <label>
                    <input type="radio" style="color: #333;" name="role" value="delivery_guy"> Delivery Guy
                </label>
                <br>
                <input type="text" name="username" placeholder="Enter your username" required>
                <input type="password" name="password" placeholder="Enter your password" required>

                <button type="submit" name="login">Login</button>
                <a href="adminDelRegister.php" style="color: #b22222; text-decoration: none;">Don't have an account? Sign up</a><br>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 JAN KEMPDORP HARVEST BUTCHERY. All rights reserved.</p>
    </footer>
</body>
</html>
