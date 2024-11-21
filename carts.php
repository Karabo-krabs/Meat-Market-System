<?php
session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Your Cart</h1>
        <a href="indexes.html">Back to Products</a>
    </header>

    <main>
        <div id="cart-container">
            <?php if (empty($cart)): ?>
                <p>Your cart is empty.</p>
            <?php else: ?>
                <table>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $total = 0;
                    foreach ($cart as $item):
                        $productId = $item['id'];
                        $quantity = $item['quantity'];
                        // Fetch product details from the database
                        // Assuming $products is an associative array with product data
                        // ... (fetching logic goes here)
                        $totalPrice = $product['price'] * $quantity;
                        $total += $totalPrice;
                    ?>
                        <tr>
                            <td><?php echo $product['name']; ?></td>
                            <td>$<?php echo number_format($product['price'], 2); ?></td>
                            <td>
                                <button onclick="updateQuantity(<?php echo $productId; ?>, -1)">-</button>
                                <?php echo $quantity; ?>
                                <button onclick="updateQuantity(<?php echo $productId; ?>, 1)">+</button>
                            </td>
                            <td>$<?php echo number_format($totalPrice, 2); ?></td>
                            <td><button onclick="removeItem(<?php echo $productId; ?>)">Remove</button></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3">Total</td>
                        <td colspan="2">$<?php echo number_format($total, 2); ?></td>
                    </tr>
                </table>
            <?php endif; ?>
        </div>
    </main>

    <script>
        const cart = JSON.parse(localStorage.getItem('cart')) || [];

        function updateQuantity(productId, change) {
            const product = cart.find(p => p.id === productId);
            if (product) {
                product.quantity += change;
                if (product.quantity <= 0) {
                    removeItem(productId);
                } else {
                    localStorage.setItem('cart', JSON.stringify(cart));
                    location.reload();
                }
            }
        }

        function removeItem(productId) {
            const updatedCart = cart.filter(p => p.id !== productId);
            localStorage.setItem('cart', JSON.stringify(updatedCart));
            location.reload();
        }
    </script>
</body>
</html>
