// Register a change validator on first name field
let firstNameField = document.getElementById("fname");
firstNameField.addEventListener("blur", firstNameHandler);

// Register a change validator on username field
let userNameField = document.getElementById("username");
userNameField.addEventListener("blur", userNameHandler);

// Register a change validator on confirm password field
let confirmPasswordField = document.getElementById("cpassword");
confirmPasswordField.addEventListener("blur", confirmPasswordHandler);

// Register a change validator on date of birth field
let dobField = document.getElementById("dob");
dobField.addEventListener("blur", dobHandler);

// Register a change validator on avatar image field
let avatarField = document.getElementById("profilephoto");
avatarField.addEventListener("blur", avatarHandler);

// To Do 7: Add code to register "blur" event validators on these input fields.
//          - Last Name (lname)
//          - Password (password)
//         Hint: use addEventListener() to register events.

// Register a change validator on password field
let passwordField = document.getElementById("password");
passwordField.addEventListener("blur", passwordHandler);

// Register a change validator on last name field
let lastNameField = document.getElementById("lname");
lastNameField.addEventListener("blur", lastNameHandler);

// Register a "submit" event handler for the sign-up form
document.getElementById("signup-form").addEventListener("submit", function(signupEvent) {
    signupEvent.preventDefault();  // Prevent the default form submission

    // Retrieve input values and trim any extra whitespace
    let firstNameInput = document.getElementById("fname").value.trim();
    let lastNameInput = document.getElementById("lname").value.trim();
    let usernameInput = document.getElementById("username").value.trim();
    let passwordInput = document.getElementById("password").value.trim();
    let confirmPasswordInput = document.getElementById("cpassword").value.trim();
    let dobInput = document.getElementById("dob").value.trim();
    let profilePhotoFiles = document.getElementById("profilephoto").files.length;

    // Check if all required fields are filled
    if (firstNameInput === "" || lastNameInput === "" || usernameInput === "" || passwordInput === "" || confirmPasswordInput === "" || dobInput === "" || profilePhotoFiles === 0) {
        console.log("Please fill up the entire form.");
    } else {
        console.log("Sign up successful");
    }
});