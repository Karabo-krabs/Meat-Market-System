let cart = JSON.parse(localStorage.getItem('cart')) || [];
const cartCount = document.getElementById('cart-count');

function updateCartCount() {
    cartCount.innerText = `(${cart.length})`;
}

function loadProducts() {
    fetch('load_products.php')
        .then(response => response.json())
        .then(products => {
            const container = document.getElementById('products-container');
            products.forEach(product => {
                const productDiv = document.createElement('div');
                productDiv.classList.add('product');
                productDiv.innerHTML = `
                    <img src="${product.image}" alt="${product.name}">
                    <h2>${product.name}</h2>
                    <p>Price: $${product.price.toFixed(2)}</p>
                    <button onclick="addToCart(${product.id})">Add to Cart</button>
                `;
                container.appendChild(productDiv);
            });
        });
}

function addToCart(productId) {
    const product = cart.find(p => p.id === productId);
    if (product) {
        product.quantity++;
    } else {
        cart.push({ id: productId, quantity: 1 });
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
}

document.addEventListener('DOMContentLoaded', () => {
    loadProducts();
    updateCartCount();
});
