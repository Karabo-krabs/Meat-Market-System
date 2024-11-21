<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meat Market</title>
    
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

        section {
            padding: 20px;
            margin: 20px;
            background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent background */
            border-radius: 10px;
        }

        #home {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        form label {
            margin: 10px 0 5px;
        }

        form input, form textarea {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            padding: 10px;
            background-color: #b22222;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #a11b1b;
        }

        footer {
            background-color: rgba(51, 51, 51, 0.8); /* Semi-transparent background */
            color: white;
            text-align: center;
            padding: 10px 0;
        }

        .login-container {
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
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

        .textbox {
            position: relative;
            margin-bottom: 30px;
        }

        .textbox input {
            width: 100%;
            padding: 10px;
            background: #f1f1f1;
            border: none;
            outline: none;
            color: #333;
            font-size: 18px;
            border-radius: 5px;
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

    <div class="login-container">
        <div class="login-box">
            <h1>Login</h1>
            
            <?php
                // Start the session
                session_start();

                // Step 1: Establish Connection
                $servername = "localhost";
                $username = "root";
                $password = "OneTwoThree";
                $database = "meatmarket";

                $conn = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Step 2: Process Login Form Submission
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $username = mysqli_real_escape_string($conn, $_POST['username']);
                    $password = mysqli_real_escape_string($conn, $_POST['password']);

                    // Step 3: Prepare SQL Statement to fetch the user
                    $sql = "SELECT * FROM customer WHERE username='$username'";
                    $result = $conn->query($sql);

                    if ($result->num_rows == 1) {
                        // Fetch the user details
                        $row = $result->fetch_assoc();
                        $hashed_password = $row['password']; // Get the hashed password from the database

                        // Step 4: Verify the entered password against the hashed password
                        if (password_verify($password, $hashed_password)) {
                            // Login successful, set the session variable
                            $_SESSION['username'] = $username;

                            // Redirect to homepage or other logged-in page
                            header("Location: Home.php");
                            exit();
                        } else {
                            // Invalid password
                            echo "<p style='color:red;'>Invalid username or password</p>";
                        }
                    } else {
                        // User not found
                        echo "<p style='color:red;'>Invalid username or password</p>";
                    }
                }

                // Close Connection
                $conn->close();
?>

            
            <form action="" method="POST" id="loginForm">
                <div class="textbox">
                    <input type="text" id="username" placeholder="Username" name="username" value="" required>
                </div>
                <div class="textbox">
                    <input type="password" id="password" placeholder="Password" name="password" required>
                </div>
                <input type="submit" class="btn" value="Login">
            </form>

            <a href="register.php">Don't have an account? Sign up</a><br>
            <!-- Forgot Password Link -->
            <a href="hint.html" > Forgot Password? Get your Hint </a>
        </div>
    </div>

    <main>
        <section id="home">
            <h2>Fresh, Quality Meat Delivered to Your Doorstep</h2>
            <p>We offer a wide range of premium meats, sourced from the best farms and delivered fresh to you.</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 JAN KEMPDORP HARVEST BUTCHERY. All rights reserved.</p>
    </footer>

    <script>
        function login() {
            document.getElementById('loginForm').onsubmit = function(event) {
                event.preventDefault(); // Prevent form submission
            
                let username = document.getElementById('username').value;
                let password = document.getElementById('password').value;
            
                if (username === "user" && password === "password") {
                    window.location.href = "HomeLoggedIn.php"; // Redirect to homepage
                } else {
                    alert("Invalid credentials, please try again.");
                }
            };
        }
    </script>

</body>
</html>
