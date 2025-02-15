var form = document.getElementById("login-form");
form.addEventListener("submit", validateLogin);

// Code for Lab 11 starts here

// TODO 4a: Register a 'blur' event with the login form's username field and
// the handler function defined on the 'eventHandlers.js' file. 
var usernameField = document.getElementById("username");
usernameField.addEventListener("blur", usernameHandler);
