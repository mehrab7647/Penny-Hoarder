function validateName(name) {
	let nameRegEx = /^[a-zA-Z]+$/;

	if (nameRegEx.test(name))
		return true;
	else
		return false;
}

function validatePWD(pwd) {
	if (pwd.length === 8)
		return true;
	else
		return false;
}

function validateUsername(uname) {
	let unameRegEx = /^[a-zA-Z0-9]+$/;

	if (unameRegEx.test(uname))
		return true;
	else
		return false;
}

function validateDOB(dob) {
	// yyyy-mm-dd
	let dobRegEx = /^\d{4}[-]\d{2}[-]\d{2}$/;

	if (dobRegEx.test(dob))
		return true;
	else
		return false;
}

function validateAvatar(avatar) {
	let avatarRegEx = /^[^\n]+\.[a-zA-Z]{3,4}$/;

	if (avatarRegEx.test(avatar))
		return true;
	else
		return false;
}

function validateLogin(event) {

	let uname = document.getElementById("username");
	let unameError = document.getElementById("error-text-username");

	let password = document.getElementById("password");
	let passwordError = document.getElementById("error-text-password");

	let formIsValid = true;

	if (!validateUsername(uname.value)) {
		// Comment the line below
		// console.log("'" + uname.value + "' is not a valid username");
		//	To Do 7a: ADD your code to dynamically add a class name to <input> tag to highlight the input box.	
		uname.classList.add("invalid");
		//	To Do 7c: ADD your code to dynamically remove a class name to <p> tag to show the error message.	
		unameError.classList.remove("hidden");
		unameError.classList.add("error-text");

		formIsValid = false;
	}
	//	An else block to remove the error messages and the styles when the input field passes the validation 
	else {

		//	To Do 7b: ADD your code to dynamically remove a class name from the <input> tag to remove the highlights from the input box. 
		uname.classList.remove("invalid");
		//	To Do 7d: ADD your code to dynamically add a class name from the <p> tag to hide the error message.	
		unameError.classList.add("hidden");
	}

	if (!validatePWD(password.value)) {
		// Comment the line below
		// console.log("'" + password.value + "' is not a valid password");
		//	To Do 7a: ADD your code to dynamically add a class name to <input> tag to highlight the input box.	
		password.classList.add("invalid");
		//	To Do 7c: ADD your code to dynamically remove a class name to <p> tag to show the error message.	
		passwordError.classList.remove("hidden");
		passwordError.classList.add("error-text");

		formIsValid = false;
	}
	//	An else block to remove the error messages and the styles when the input field passes the validation 
	else {

		//	To Do 7b: ADD your code to dynamically remove a class name from the <input> tag to remove the highlights from the input box. 
		password.classList.remove("invalid");
		//	To Do 7d: ADD your code to dynamically add a class name from the <p> tag to hide the error message.	
		passwordError.classList.add("hidden");
	}


	if (formIsValid === false) {
		event.preventDefault();

	}
	else {
		console.log("Validation successful, sending data to the server");
	}
}

function fNameHandler(event) {
	let fname = event.target;
	if (!validateName(fname.value)) {
		console.log("First name '" + fname.value + "' is not valid.");
	}
	else {
		console.log("First name is valid.");
	}

}

function unameHandler(event) {
	let uname = event.target;
	let unameError = document.getElementById("error-text-username");

	if (!validateUsername(uname.value)) {
		// Comment the line below
		// console.log("Username '" + uname.value + "' is not valid.");
		//	To Do 8a: ADD your code to dynamically add a class name to <input> tag to highlight the input box.	
		uname.classList.add("invalid");
		//	To Do 8c: ADD your code to dynamically remove a class name to <p> tag to show the error message.	
		unameError.classList.remove("hidden");
		unameError.classList.add("error-text");
	}
	else {
		// Comment the line below
		// console.log("Username is valid.");
		//	To Do 8b: ADD your code to dynamically remove a class name from the <input> tag to remove the highlights from the input box. 
		uname.classList.remove("invalid");
		//	To Do 8d: ADD your code to dynamically add a class name from the <p> tag to hide the error message.	
		unameError.classList.add("hidden");
	}
}

function cpwdHandler(event) {
	let pwd = document.getElementById("password");
	let cpwd = event.target;
	if (pwd.value !== cpwd.value) {
		console.log("Your passwords: " + pwd.value + " and " + cpwd.value + " do not match");
	}
	else {
		console.log("Passwords match.");
	}
}

function dobHandler(event) {
	let dob = event.target;
	let dobError = document.getElementById("error-text-dob");

	if (!validateDOB(dob.value)) {
		// Comment the line below
		// console.log("Date of birth '" + dob.value + "' is not valid.");
		//	To Do 8a: ADD your code to dynamically add a class name to <input> tag to highlight the input box.	
		dob.classList.add("invalid");
		//	To Do 8c: ADD your code to dynamically remove a class name to <p> tag to show the error message.	
		dobError.classList.remove("hidden");
		dobError.classList.add("error-text");
	}
	else {
		// Comment the line below
		// console.log("Date of birth is valid.");
		//	To Do 8b: ADD your code to dynamically remove a class name from the <input> tag to remove the highlights from the input box. 
		dob.classList.remove("invalid");
		//	To Do 8d: ADD your code to dynamically add a class name from the <p> tag to hide the error message.	
		dobError.classList.add("hidden");
	}
}


function avatarHandler(event) {
	let avatar = event.target;

	if (!validateAvatar(avatar.value)) {
		console.log("Avatar '" + avatar.value + "' is not valid.");
	}
	else {
		console.log("Avatar is valid.");
	}
}

function passwordHandler(event) {
	let password = event.target;

	if (!validatePWD(password.value)) {
		console.log("Password '" + password.value + "' is not valid.");
	}
	else {
		console.log("Password is valid.");
	}
}

function lnameHandler(event) {
	let lname = event.target;

	if (!validateName(lname.value)) {
		console.log("Last name '" + lname.value + "' is not valid.");
	}
	else {
		console.log("Last name is valid.");
	}
}