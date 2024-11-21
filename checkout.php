<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Connect to the database
$host = 'localhost';
$user = 'root'; // Update with your username
$pass = 'OneTwoThree'; // Update with your password
$dbname = 'meatmarket';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the logged-in user's address from the database
$username = $_SESSION['username'];
$sql = "SELECT address FROM customer WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$userAddress = '';
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userAddress = $row['address'];
}

$conn->close();

// Initialize error variable
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submittedAddress = $_POST['address'];
    $deliveryOption = $_POST['delivery_option'];
    
    // Cart data from hidden input (stored as JSON)
    $cart = json_decode($_POST['cart'], true);

    // Use stripos for case-insensitive address validation only for delivery
    if ($deliveryOption === 'delivery' && stripos($submittedAddress, 'Jan Kempdorp') === false) {
        $error = "Please enter a valid address in Jan Kempdorp.";
    } else {
        // Connect to the database again to update products and insert orders
        $conn = new mysqli($host, $user, $pass, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Update each product in the database
        foreach ($cart as $productName => $details) {
            $quantity = (int) $details['quantity']; // Ordered quantity

            // Assuming you have a way to get the product ID by product name
            $sql = "SELECT productID FROM products WHERE productName = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $productName);
            $stmt->execute();
            $result = $stmt->get_result();
            $productID = $result->fetch_assoc()['productID'];

            // Update the product's current_qty and sales_qty
            $sql = "UPDATE products 
                    SET current_qty = current_qty - ?, sales_qty = sales_qty + ?
                    WHERE productID = ? AND current_qty >= ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiii", $quantity, $quantity, $productID, $quantity);

            if ($stmt->execute()) {
                echo "Product $productName updated successfully.<br>";
            } else {
                echo "Error updating product $productName: " . $conn->error . "<br>";
            }
        }

        // Clear the cart in localStorage
        echo "<script>localStorage.removeItem('cart');</script>"; // Keep this line if you're using localStorage

        // Redirect based on delivery option
        if ($deliveryOption === 'delivery') {
            echo "<script>
                    window.location.href = 'delivery.php?address=" . urlencode($submittedAddress) . "&delivery=" . urlencode($deliveryOption) . "';
                </script>";
        } else {
            echo "<script>
                    window.location.href = 'confirmation.php';
                </script>";
        }
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles.css">

    <!-- Include Google Places API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA60rhu6tmHhbtd12zdC3X1asp63R_RwMk&libraries=places"></script>
</head>
<body style="background-color: gray;">

    <header>
        <h1>Order Summary</h1>
    </header>
    <button onclick="history.back()" style="background-color: #b22222; color: white; border: none; padding: 10px 15px; font-size: 16px; cursor: pointer; border-radius: 5px; margin-bottom: 20px;">&larr; Back</button>

    <ul id="order-summary"></ul> <!-- For the list of ordered products -->

    <h3 id="total-price">Total: R0.00</h3>
    <h3 id="delivery-price" style="display: none;">Delivery Fee: R100.00</h3>
    
    <form id="orderForm" method="POST" action="">
        <input type="hidden" name="cart" id="cart-hidden-input">

        <!-- Textbox for Delivery Address -->
        <div>
            <label for="address">Delivery Address:</label>
            <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($userAddress); ?>" placeholder="Enter your delivery address"> 
            <?php if (!empty($error)) { ?>
                <span style="color: red;"><?php echo $error; ?></span>
            <?php } else { ?>
                <span id="addressError" style="color: red; display: none;">Please enter a valid address in Jan Kempdorp.</span> <!-- Error message -->
            <?php } ?>
        </div>

        <div>
            <label>
                <input type="radio" name="delivery_option" value="delivery" checked> Delivery (R100.00)
            </label>
            <label>
                <input type="radio" name="delivery_option" value="collection"> Collection (No extra fee)
            </label>
        </div>

        <button type="submit">Proceed with Order</button>
    </form>
    
    <button>
        <b><a href="cart.php" style="color:#b22222">Back </a></b>
    </button>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const totalPriceDiv = document.getElementById('total-price');
            const deliveryPriceDiv = document.getElementById('delivery-price');
            const addressInput = document.getElementById('address');
            const cartEmptyError = document.createElement('p');
            cartEmptyError.style.color = 'red';
            cartEmptyError.style.display = 'none';
            cartEmptyError.textContent = 'Your cart is empty. Please add items to your cart before proceeding.';
            document.body.insertBefore(cartEmptyError, document.querySelector('form'));

            let total = 0; // This will be updated with cart total

            // Load the cart from localStorage and calculate the total
            const cart = JSON.parse(localStorage.getItem('cart')) || {};
            if (Object.keys(cart).length === 0) {
                cartEmptyError.style.display = 'block'; // If cart is empty, show error message
                return; // Stop if cart is empty
            }

            // Display the cart items and calculate the total
            for (const [productName, details] of Object.entries(cart)) {
                const itemTotal = details.price * details.quantity;
                total += itemTotal;

                // Create list item for each product in the cart
                const listItem = document.createElement('li');
                listItem.innerHTML = `${details.quantity} x ${productName} - R${itemTotal.toFixed(2)}`;
                document.getElementById("order-summary").appendChild(listItem);
            }

            // Function to calculate the total including delivery
            function calculateTotalWithDelivery() {
                const deliveryOption = document.querySelector('input[name="delivery_option"]:checked').value;
                let finalTotal = total;

                if (deliveryOption === 'delivery') {
                    finalTotal += 100; // Add delivery charge
                    deliveryPriceDiv.style.display = 'block'; // Show delivery fee
                } else {
                    deliveryPriceDiv.style.display = 'none'; // Hide delivery fee for collection
                }

                totalPriceDiv.innerText = `Total: R${finalTotal.toFixed(2)}`;
            }

            // Display total price and apply delivery fee if applicable
            calculateTotalWithDelivery();

            // Update total when delivery option is changed
            const deliveryOptions = document.querySelectorAll('input[name="delivery_option"]');
            deliveryOptions.forEach(option => {
                option.addEventListener('change', calculateTotalWithDelivery);
            });

            // Initialize Google Places Autocomplete for address input
            let autocomplete = new google.maps.places.Autocomplete(addressInput);
            autocomplete.setFields(['address_components', 'formatted_address']);

            // Listen for the place changed event
            autocomplete.addListener('place_changed', function() {
                let place = autocomplete.getPlace();
                addressInput.value = place.formatted_address; // Set the input value to the formatted address
                document.getElementById('addressError').style.display = 'none'; // Hide error message
            });

            // Store the cart data in a hidden input to send it to the server
            document.getElementById('cart-hidden-input').value = JSON.stringify(cart);
        });
    </script>
</body>
</html>
