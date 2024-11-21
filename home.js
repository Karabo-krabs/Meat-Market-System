function openSidePanel() {
    document.getElementById("sidePanel").classList.add("open-side-panel");
    document.getElementById("mainContent").classList.add("open-main-content");
    document.addEventListener('click', outsideClickListener);
}

function closeSidePanel() {
    document.getElementById("sidePanel").classList.remove("open-side-panel");
    document.getElementById("mainContent").classList.remove("open-main-content");
    document.removeEventListener('click', outsideClickListener);
}
function outsideClickListener(event) {
    const sidePanel = document.getElementById("sidePanel");
    const openButton = document.querySelector(".open-btn");
    if (!sidePanel.contains(event.target) && event.target !== openButton) {
        closeSidePanel();
    }
}
function showLoginForm() {
    const sidePanelContent = document.getElementById("sidePanelContent");
    sidePanelContent.innerHTML = `
        <input type="text" placeholder="Username" class = "username"> <br>
        <input type="password" placeholder="Password"><br>
        <button onclick="login()">Login</button><br>
        <button onclick="showRegisterForm()">Register</button>
    `;
}

function filterProducts() {
    const searchInput = document.getElementById('search-bar').value.toLowerCase();
    const products = document.querySelectorAll('.product');
    let visibleProducts = 0;

    products.forEach(product => {
        const productName = product.querySelector('h2').innerText.toLowerCase();
        // Check if the product name or any other relevant information contains the search input
        if (productName.includes(searchInput)) {
            product.classList.remove('hidden'); // Show matching products
            visibleProducts++;
        } else {
            product.classList.add('hidden'); // Hide non-matching products
        }
    });

    const noProductsMessage = document.getElementById('no-products-message');
    if (visibleProducts === 0) {
        noProductsMessage.style.display = 'block'; // Show message if no products are visible
    } else {
        noProductsMessage.style.display = 'none'; // Hide message if products are found
    }
}


// home.js

function addToCart(product) {
    // Get the current cart from localStorage or initialize a new one
    let cart = JSON.parse(localStorage.getItem('cart')) || {};

    // Check if the product already exists in the cart
    if (cart[product]) {
        cart[product].quantity += 1;  // Increase quantity
    } else {
        cart[product] = { quantity: 1 };  // Add new product with quantity 1
    }

    // Update the localStorage with the new cart
    localStorage.setItem('cart', JSON.stringify(cart));

    // Confirm the addition
    alert(product + ' has been added to the cart.');
}



function loadCart() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let cartItems = document.getElementById('cart-items');
    cartItems.innerHTML = '';

    cart.forEach(item => {
        let productElement = document.createElement('div');
        productElement.innerHTML = `
            <h3>Product ID: ${item.id}</h3>
            <p>Quantity: <button onclick="increment(${item.id})">+</button> ${item.quantity} <button onclick="decrement(${item.id})">-</button></p>
            <button onclick="removeFromCart(${item.id})">Remove</button>
        `;
        cartItems.appendChild(productElement);
    });
}

function increment(productId) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let index = cart.findIndex(item => item.id === productId);
    if (index !== -1) {
        cart[index].quantity += 1;
        localStorage.setItem('cart', JSON.stringify(cart));
        loadCart(); // Reload cart items
    }
}

function decrement(productId) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let index = cart.findIndex(item => item.id === productId);
    if (index !== -1 && cart[index].quantity > 1) {
        cart[index].quantity -= 1;
        localStorage.setItem('cart', JSON.stringify(cart));
        loadCart(); // Reload cart items
    }
}

function removeFromCart(productId) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = cart.filter(item => item.id !== productId);
    localStorage.setItem('cart', JSON.stringify(cart));
    loadCart(); // Reload cart items
}

function clearCart() {
    localStorage.removeItem('cart');
    loadCart(); // Reload cart items
}

function checkout() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (cart.length === 0) {
        alert('Your cart is empty.');
        return;
    }
    // Proceed to checkout (you can implement your own logic here)
    alert('Checkout functionality not yet implemented.');
}

// Load cart items when the cart page is opened
window.onload = loadCart;




// catalogue.js
/*
// Initialize the cart
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Function to add a product to the cart
function addToCart(productName, productPrice) {
    const product = { name: productName, price: productPrice };
    
    // Check if the product is already in the cart
    const existingProduct = cart.find(item => item.name === productName);
    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        product.quantity = 1;
        cart.push(product);
    }
    
    // Save the cart to local storage
    localStorage.setItem('cart', JSON.stringify(cart));
    alert(productName + ' has been added to your cart.');
}

// Function to load the cart
function loadCart() {
    cart = JSON.parse(localStorage.getItem('cart')) || [];
}

// Load the cart when the script is loaded
loadCart();
*/


/*const prices = {
    '1': {
        '1KG': '$5.00',
        '250g': '$9.00',
        '500g': '$20.00'
    },
    '2': {
        '1KG': '$6.00',
        '250g': '$11.00',
        '500g': '$22.00'
    }
    // Add more products and their prices here
};


let selectedWeights = {};

function showPrice(productId, weight) {
    selectedWeights[productId] = weight;
    const priceDiv = document.getElementById(`price-${productId}`);
    priceDiv.textContent = `Price: ${prices[productId][weight]}`;
    document.getElementById(`add-to-cart-${productId}`).disabled = false;
}
let cart = [];


function addToCart(productId) {
    const weight = selectedWeights[productId];
    if (!weight) return;

    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.push({
        productId,
        weight,
        price: prices[productId][weight]
    });
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();

    // Reset selection
    selectedWeights[productId] = '';
    document.getElementById(`price-${productId}`).textContent = '';
    document.getElementById(`add-to-cart-${productId}`).disabled = true;

// Show confirmation message
    const confirmationMsg = document.getElementById('confirmation-msg');
    confirmationMsg.textContent = `Product ${productId} added to cart!`;
    setTimeout(() => {
        confirmationMsg.textContent = '';
    }, 3000); // Hide message after 3 seconds
}

function updateCartDisplay() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItems = document.getElementById('cart-items');
    cartItems.innerHTML = '';

    cart.forEach(item => {
        const listItem = document.createElement('li');
        const productImg = document.createElement('img');
        productImg.src = `product${item.productId}.jpg`;
        listItem.appendChild(productImg);

        const text = document.createTextNode(`Product ${item.productId} - ${item.weight}: ${item.price}`);
        listItem.appendChild(text);

        cartItems.appendChild(listItem);
    });
}

function clearCart() {
    localStorage.removeItem('cart');
    updateCartDisplay();
}

document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('cart-items')) {
        updateCartDisplay();
    }
});
*/



/*

function addToCart(productName, productId) {
    const existingItem = cart.find(item => item.productId === productId);
    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({
            productId,
            productName,
            quantity: 1,
            price: prices[productId]
        });
    }
    updateCartDisplay();
}

function clearCart() {
    cart = [];
    updateCartDisplay();
}

function updateCartDisplay() {
    const cartItems = document.getElementById('cart-items');
    cartItems.innerHTML = '';

    cart.forEach(item => {
        const listItem = document.createElement('li');
        listItem.textContent = `${item.productName} - ${item.quantity} x ${item.price}`;
        cartItems.appendChild(listItem);
    });
}

*/

