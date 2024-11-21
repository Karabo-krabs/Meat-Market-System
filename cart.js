document.addEventListener("DOMContentLoaded", function() {
    const cartItemsDiv = document.getElementById("cart-items").querySelector("tbody");
    const totalPriceDiv = document.getElementById("total-price");
    const cart = JSON.parse(localStorage.getItem('cart')) || {};

    let total = 0;

    for (const [product, details] of Object.entries(cart)) {
        const productRow = document.createElement("tr");
        const itemTotal = details.price * details.quantity;

        productRow.innerHTML = `<td>${product}</td>
                                <td>R${details.price}</td>
                                <td>
                                    <button onclick="changeQuantity('${product}', -1)">-</button>
                                    <span id="${product}-quantity">${details.quantity}</span>
                                    <button onclick="changeQuantity('${product}', 1)">+</button>
                                </td>
                                <td>R${itemTotal.toFixed(2)}</td>
                                <td>
                                    <button onclick="removeFromCart('${product}')">Remove</button>
                                </td>`;
        cartItemsDiv.appendChild(productRow);
        total += itemTotal;
    }

    totalPriceDiv.innerText = `Total: R${total.toFixed(2)}`;
});

function changeQuantity(product, delta) {
    const cart = JSON.parse(localStorage.getItem('cart'));
    if (cart[product]) {
        cart[product].quantity += delta;
        if (cart[product].quantity <= 0) {
            delete cart[product];
        }
        localStorage.setItem('cart', JSON.stringify(cart));
        location.reload(); // Reload to refresh the cart
    }
}

function removeFromCart(product) {
    const cart = JSON.parse(localStorage.getItem('cart'));
    if (cart[product]) {
        delete cart[product];
        localStorage.setItem('cart', JSON.stringify(cart));
        location.reload(); // Reload to refresh the cart
    }
}

function clearCart() {
    localStorage.removeItem('cart');
    location.reload(); // Reload to refresh the cart
}

function checkout() {
    alert("Proceeding to checkout...");
    window.location.href = "checkout.php";

    // Implement checkout logic here
}

function home() {
    window.location.href = "home.php";
    // Implement checkout logic here
}

