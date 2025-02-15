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

	let password = document.getElementById("password");

	let formIsValid = true;

	if (!validateUsername(uname.value)) {
		uname.classList.add("highlight");
		document.getElementById("error-text-username").classList.remove("hidden");
		formIsValid = false;
	}
	else {
		uname.classList.remove("highlight");
		document.getElementById("error-text-username").classList.add("hidden");

	}

	if (!validatePWD(password.value)) {
		password.classList.add("highlight");
		document.getElementById("error-text-password").classList.remove("hidden");
		formIsValid = false;
	}
	else {

		password.classList.remove("highlight");
		document.getElementById("error-text-password").classList.add("hidden");
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

	if (!validateUsername(uname.value)) {
		uname.classList.add("highlight");
		document.getElementById("error-text-uname").classList.remove("hidden");
	}
	else {
		uname.classList.remove("highlight");
		document.getElementById("error-text-uname").classList.add("hidden");
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
	if (!validateDOB(dob.value)) {
		console.log("Date of birth '" + dob.value + "' is not valid.");
		dob.classList.add("highlight");
		document.getElementById("error-text-dob").classList.remove("hidden");

	}
	else {
		console.log("Date of birth is valid.");
		dob.classList.remove("highlight");
		document.getElementById("error-text-dob").classList.add("hidden");

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