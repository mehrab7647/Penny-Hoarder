//Login Event Listener and Validators
document.addEventListener("DOMContentLoaded", function () {
	const form1 = document.getElementById("auth-form");

	form1.addEventListener("submit", validateLogin);

	function validateEmail(email) {
		const emailRegEx = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple regex for valid email format
		return emailRegEx.test(email);
	}

	function validatePWD(pwd) {
		return pwd.length >= 6; // Minimum password length
	}

	function validateLogin(event) {
		event.preventDefault(); // Prevent form submission for validation

		const mail = document.getElementById("mail");
		const password = document.getElementById("pass");
		let formIsValid = true;

		// Validate Username
		if (!validateEmail(mail.value)) {
			mail.classList.add("border1");
			document.getElementById("error-text-mail").classList.remove("hidden");
			formIsValid = false;
		} else {
			mail.classList.remove("border1");
			document.getElementById("error-text-mail").classList.add("hidden");
		}

		// Validate Password
		if (!validatePWD(password.value)) {
			password.classList.add("border1");
			document.getElementById("error-text-pass").classList.remove("hidden");
			formIsValid = false;
		} else {
			password.classList.remove("border1");
			document.getElementById("error-text-pass").classList.add("hidden");
		}

		if (formIsValid) {
			console.log("Validation successful, sending data to the server");
			form1.submit(); // Uncomment this line if you want to proceed with form submission
		}
	}
});