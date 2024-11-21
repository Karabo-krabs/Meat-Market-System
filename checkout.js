let cart = JSON.parse(localStorage.getItem('cart')) || [];

function displayCart() {
    const cartTableBody = document.querySelector('#cart-table tbody');
    cartTableBody.innerHTML = ''; // Clear the current cart items

    let total = 0;
    cart.forEach(product => {
        const productTotal = product.price * product.quantity;
        total += productTotal;

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${product.name}</td>
            <td>$${product.price.toFixed(2)}</td>
            <td>${product.quantity}</td>
            <td>$${productTotal.toFixed(2)}</td>
        `;
        cartTableBody.appendChild(row);
    });

    document.getElementById('cart-total').textContent = total.toFixed(2);
}

document.getElementById('checkout-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Gather form data
    const formData = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        address: document.getElementById('address').value,
        cardNumber: document.getElementById('card-number').value,
        expiryDate: document.getElementById('expiry-date').value,
        cvv: document.getElementById('cvv').value,
    };

    // For this example, we'll just log the form data and cart to the console
    console.log('Form Data:', formData);
    console.log('Cart:', cart);

    // Here you would integrate with a real payment gateway API

    // Clear the cart and local storage after successful checkout
    localStorage.removeItem('cart');
    alert('Order placed successfully!');

    // Optionally redirect to a confirmation page
    window.location.href = 'confirmation.php';
});

// Display the cart on page load
displayCart();
