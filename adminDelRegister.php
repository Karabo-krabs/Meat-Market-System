<?php
// Database connection
$conn = new mysqli('localhost', 'root', 'OneTwoThree', 'meatmarket');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Registration form handling
if (isset($_POST['register'])) {
    $role = $_POST['role']; // 'admin' or 'delivery_guy'
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $password_hint = $_POST['password_hint'];

    if ($role == 'admin') {
        $sql = "INSERT INTO Admin (name, surname, adminusername, password, password_hint) 
                VALUES ('$name', '$surname', '$username', '$password', '$password_hint')";
    } else if ($role == 'delivery_guy') {
        $sql = "INSERT INTO DeliveryGuy (name, surname, deliveryusername, password, password_hint) 
                VALUES ('$name', '$surname', '$username', '$password', '$password_hint')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration successful! Redirecting to login page...'); window.location.href = 'adminDelLogin.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            margin: auto; /* Center the registration box */
            margin-top: 100px; /* Space from the top */
        }

        .textbox {
            position: relative;
            margin-bottom: 30px;
        }

        .textbox input[type="text"],
        .textbox input[type="password"] {
            width: 90%;
            padding: 10px;
            background: #f1f1f1;
            border: none;
            outline: none;
            color: #333;
            font-size: 18px;
            border-radius: 5px;
        }

        .radio-label {
            margin-right: 20px;
            color: black; /* Set the text color for radio labels */
        }

        .radio-input {
            display: none; /* Hide default radio buttons */
        }

        .radio-custom {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid black; /* Border color */
            border-radius: 50%;
            position: relative;
            margin-right: 10px;
            cursor: pointer;
        }

        .radio-input:checked + .radio-custom {
            background: black; /* Background color when checked */
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

        a {
            display: block;
            margin-top: 10px;
            color: #333;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
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
    <div class="register-box">
        <h2 style="color: black;">Register</h2>
        
        <form method="POST" action="">
            <div class="textbox">
                <label class="radio-label">
                    <input type="radio" name="role" value="admin" class="radio-input" checked>
                    <span class="radio-custom"></span> Admin
                </label>
                <label class="radio-label">
                    <input type="radio" name="role" value="delivery_guy" class="radio-input">
                    <span class="radio-custom"></span> Delivery Guy
                </label>
            </div>

            <div class="textbox">
                <input type="text" name="name" placeholder="Name" required>
            </div>

            <div class="textbox">
                <input type="text" name="surname" placeholder="Surname" required>
            </div>

            <div class="textbox">
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="textbox">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="textbox">
                <input type="text" name="password_hint" placeholder="Password Hint" required>
            </div>

            <button type="submit" name="register" class="btn">Register</button>
            <a href="adminDelLogin.php">Already have an account? Login</a>
        </form>

    </div>
</body>
</html>
