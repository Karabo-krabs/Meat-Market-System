<?php
// Step 1: Establish Connection
$servername = "localhost";
$username = "root";
$password = "OneTwoThree";
$database = "meatmarket";

$conn = new mysqli($servername, $username, $password, $database, 3306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Process Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $phonenumber = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password1 = mysqli_real_escape_string($conn, $_POST['password1']);
    $password_hint = mysqli_real_escape_string($conn, $_POST['password_hint']);

    // Step 3: Validate that passwords match
    if ($password === $password1) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Step 4: Prepare SQL Statement
        $sql = "INSERT INTO Customer (name, surname, username, phone, address, password, password_hint) 
        VALUES ('$name', '$surname', '$username', '$phonenumber', '$address', '$hashed_password', '$password_hint')";

        // Step 5: Execute SQL Statement
        if ($conn->query($sql) === TRUE) {
            echo "<script>
            alert('Registration successful! Redirecting to login page...');
            window.location.href = 'login.php';
        </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
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
    <title>Meat Market</title>
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
    <!-- Google Places API for Address Autocomplete -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA60rhu6tmHhbtd12zdC3X1asp63R_RwMk&libraries=places"></script>

    <script>
        // Initialize Google Places Autocomplete
        function initializeAutocomplete() {
            var input = document.getElementById('autocomplete');
            var autocomplete = new google.maps.places.Autocomplete(input);
        }

        // Password Visibility Toggle
        function togglePasswordVisibility(id) {
            var field = document.getElementById(id);
            var icon = document.getElementById(id + "-icon");
            if (field.type === "password") {
                field.type = "text";
                icon.textContent = "🙈";  // Icon for showing
            } else {
                field.type = "password";
                icon.textContent = "👁";  // Icon for hiding
            }
        }

        window.onload = initializeAutocomplete;
    </script>
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
            <h1>Register</h1>
            <form id="registerForm" action="" method="POST" onsubmit="return validatePasswords()">
                <div class="textbox">
                    <input type="text" name="name" placeholder="First Name" required>
                </div>
                <div class="textbox">
                    <input type="text" name="surname" placeholder="Last Name" required>
                </div>
                <div class="textbox">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="textbox">
                    <input type="text" name="phone_number" placeholder="Phone Number" required>
                </div>
                <div class="textbox">
                    <textarea name="address" id="autocomplete" placeholder="Address" maxlength="140" required></textarea>
                </div>
                <div class="textbox">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <span class="eye-icon" id="password-icon" onclick="togglePasswordVisibility('password')">👁</span>
                </div>
                <div class="textbox">
                    <input type="password" id="password1" name="password1" placeholder="Confirm Password" required>
                    <span class="eye-icon" id="password1-icon" onclick="togglePasswordVisibility('password1')">👁</span>
                </div>
                <div class="textbox">
                    <input type="text" name="password_hint" placeholder="Password Hint" required>
                </div>
                <input type="submit" class="btn" value="Register">
                <p><a href="login.html" style="color: white;">Already have an account? Log in</a></p>
            </form>
        </div>
    </center>

    <main>
        <section id="home">
            <h2>Fresh, Quality Meat Delivered to Your Doorstep</h2>
            <p>We offer a wide range of premium meats, sourced from the best farms and delivered fresh to you.</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 JAN KEMPDORP HARVEST BUTCHERY. All rights reserved.</p>
    </footer>
</body>
</html>
