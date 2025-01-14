document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("signup-form");

    form.addEventListener("submit", validateSignup);

    function validateEmail(email) {
        const emailRegEx = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple regex for valid email format
        return emailRegEx.test(email);
    }

    function validateScreenname(screenname) {
        const screennameRegEx = /^\w+$/; // Only word characters (letters, digits, underscores)
        return screennameRegEx.test(screenname);
    }

    function validatePassword(password) {
        const passwordRegEx = /^(?=.*[^\w])(?=.{6,})/; // At least 6 characters and one non-letter
        return passwordRegEx.test(password);
    }

    function validateSignup(event) {
        event.preventDefault(); // Prevent form submission for validation

        const email = document.getElementById("email");
        const screenname = document.getElementById("uname");
        const avatar = document.getElementById("avatar");
        const password = document.getElementById("password");
        const verifyPassword = document.getElementById("retypepass");

        let formIsValid = true;

        // Clear previous error messages
        clearErrorMessages();

        // Validate Email
        if (!validateEmail(email.value)) {
            showError(email, "error-text-email", "Email format is invalid");
            formIsValid = false;
        }

        // Validate Screen Name
        if (!validateScreenname(screenname.value)) {
            showError(screenname, "error-text-screenname", "Screen name must contain no spaces or special characters");
            formIsValid = false;
        }

        // Validate Avatar
        if (!avatar.files.length) {
            showError(avatar, "error-text-avatar", "Avatar image is required");
            formIsValid = false;
        }

        // Validate Password
        if (!validatePassword(password.value)) {
            showError(password, "error-text-password", "Password must be at least 6 characters long and contain at least one non-letter character.");
            formIsValid = false;
        }

        // Validate Verify Password
        if (password.value !== verifyPassword.value) {
            showError(verifyPassword, "error-text-verify-password", "Passwords do not match.");
            formIsValid = false;
        }

        if (formIsValid) {
            console.log("Validation successful, sending data to the server");
            form.submit(); // Uncomment this line if you want to proceed with form submission
        }
    }

    function showError(input, errorId, errorMessage) {
        input.classList.add("border1");
        document.getElementById(errorId).textContent = errorMessage;
        document.getElementById(errorId).classList.remove("hidden");
    }

    function clearErrorMessages() {
        const errorTexts = document.querySelectorAll(".error-text");
        errorTexts.forEach(errorText => {
            errorText.classList.add("hidden");
        });
        const inputs = form.querySelectorAll("input");
        inputs.forEach(input => {
            input.classList.remove("border1");
        });
    }
});
