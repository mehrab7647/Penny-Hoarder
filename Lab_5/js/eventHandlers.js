function validateName(nameInput) {
	let namePattern = /^[a-zA-Z]+$/;

	if (namePattern.test(nameInput)) {
		return true;
	} else {
		return false;
	}
}


// To Do 5: Write validator functions to validate password, date of birth, avatar, and username

function validateUsername(usrInput) {
	let usernamePattern = /^[a-zA-Z0-9_]+$/;

	if (usernamePattern.test(usrInput)) {
		return true;
	} else {
		return false;
	}
}

function validatePassword(passInput) {
	if (passInput === "") {
		console.log("Please enter a password");
		formIsValid = false;
		return false;
	} else if (passInput.length < 8 || passInput.length > 8) {
		console.log("Password must be 8 characters long");
		formIsValid = false;
		return false;
	} else {
		return true;
	}
}

function validateDOB(dobInput) {
	let dobPattern = /^\d{4}[-]\d{2}[-]\d{2}$/;

	if (dobPattern.test(dobInput)) {
		return true;
	}
	else {
		return false;
	}
}

function validateAvatar(avatarInput) {
	let avatarPattern = /^[^\n]+\.[a-zA-Z]{3,4}$/;

	if (avatarPattern.test(avatarInput)) {
		return true;
	}
	else {
		return false;
	}
}


// To Do 6a: Add an event object to this validateLogin function.
function validateLogin(loginEvent) {

	// Use getElementById() to access the login form's input elements
	// and store them in easy to remember variables.
	// The first one is done for you as an example.
	let usernameInput = document.getElementById("username");

	// To Do 6b: Add your code to access and store the password input field.
	let passwordInput = document.getElementById("password");
	let formIsValid = true;

	if (!validateUsername(usernameInput.value)) {
		console.log("'" + usernameInput.value + "' is not a valid username");
		formIsValid = false;
	} else {
		console.log("Username is valid");
	}

	// To Do 6c: You have to perform the validation for the password field.
	if (!validatePassword(passwordInput.value)) {
		console.log("Password is not valid");
	} else {
		console.log("Password is valid");
	}

	if (formIsValid === false) {
		// To Do 6d: If any of the validations fail, we need to stop the form submission.
		// Use event.preventDefault() to stop the form submission.
		loginEvent.preventDefault();
	}
	else {
		console.log("Validation successful, sending data to the server");
	}
}

function firstNameHandler(fNameEvent) {
	let firstNameInput = fNameEvent.target;

	// To Do 8a Add code to validate first name field. 
	//         Use console.log() to write error messages on the console.
	//         Hint: Call the name validator function.
	if (!validateName(firstNameInput.value)) {
		console.log("'" + firstNameInput.value + "' is not a valid first name");
		formIsValid = false;
	} else {
		console.log("First name is valid");
	}
}

function userNameHandler(uNameEvent) {
	let userNameInput = uNameEvent.target;

	// To Do 8c: Add code to validate the username field. 
	//          Use console.log() to write error messages on the console.
	//          Hint: Call the username validator function.
	if (!validateUsername(userNameInput.value)) {
		console.log("'" + userNameInput.value + "' is not a valid username");
		formIsValid = false;
	} else {
		console.log("Username is valid");
	}
}

function confirmPasswordHandler(confirmPwdEvent) {
	let passwordInput = document.getElementById("password");
	let confirmPasswordInput = confirmPwdEvent.target;
	// To Do 8d: Add code to check if the password and confirm password fields match.
	//          Use console.log() to write error messages on the console.
	if (passwordInput.value.trim() !== confirmPasswordInput.value.trim()) {
		console.log("Passwords do not match");
		formIsValid = false;
	} else {
		console.log("Passwords match");
	}

}

function dobHandler(dobEvent) {
	let dobInput = dobEvent.target;

	// To Do 8b: Add code to validate date of birth field. 
	//          Use console.log() to write error messages on the console.
	//          Hint: Call the date of birth validator function.
	if (!validateDOB(dobInput.value)) {
		console.log("'" + dobInput.value + "' is not a valid date of birth");
		formIsValid = false;
	} else {
		console.log("Date of birth is valid");
	}
}


function avatarHandler(avatarEvent) {
	let avatarInput = avatarEvent.target;

	// To Do 8e: Add code to validate the avatar field. 
	//          Use console.log() to write error messages on the console.
	//          Hint: Call the avatar validator function.
	if (!validateAvatar(avatarInput.value)) {
		console.log("'" + avatarInput.value + "' is not a valid avatar");
		formIsValid = false;
	} else {
		console.log("Avatar is valid");
	}
}

// To Do 9a: Create an event handler to validate the password field.
function passwordHandler(passwordEvent) {
	let passwordInput = passwordEvent.target;
	if (passwordInput.value.trim() === "") {
		console.log("Please enter a password");
		formIsValid = false;
	} else if (passwordInput.value.trim().length < 8 || passwordInput.value.trim().length > 8) {
		console.log("Password must be 8 characters long");
		formIsValid = false;
	} else if (!validatePassword(passwordInput.value.trim())) {
		console.log("'" + passwordInput.value.trim() + "' is not a valid password");
		formIsValid = false;
	} else {
		console.log("Password is valid");
	}
}

// To Do 9b: Create an event handler to validate the last name field.
function lastNameHandler(lNameEvent) {
	let lastNameInput = lNameEvent.target;
	if (!validateName(lastNameInput.value)) {
		console.log("'" + lastNameInput.value + "' is not a valid last name");
		formIsValid = false;
	} else {
		console.log("Last name is valid");
	}
}