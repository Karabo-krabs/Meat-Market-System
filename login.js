let users = [
    {username: 'farmer1', password: 'password1'},
    {username: 'farmer2', password: 'password2'}
];

function login() {
    document.getElementById('loginForm').onsubmit = function(event) {
        event.preventDefault(); // Prevent form submission
    
        let username = document.getElementById('username').value;
        let password = document.getElementById('password').value;
    
        if (username === "user" && password === "password") {
            window.location.href = "HomeLoggedIn.html"; // Redirect to homepage
        } else {
            alert("Invalid credentials, please try again.");
        }
    };
    
}


function register() {
    let username = document.getElementById('username').value;
    let password = document.getElementById('password').value;

    let userExists = users.some(user => user.username === username);

    if (userExists) {
        alert('User already exists');
    } else {
        users.push({username: username, password: password});
        alert('Registration successful');
    }

}
function search() {
    let query = document.getElementById('search-bar').value;
    alert('Searching for: ' + query);
}

let cart = [];

function addToCart(productName) {
    cart.push(productName);
    alert(productName + ' has been added to your cart.');
}