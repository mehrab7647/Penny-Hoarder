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
        // Reset previous error states
        const mail = document.getElementById("mail");
        const password = document.getElementById("pass");
        
        // Remove any previous error classes
        mail.classList.remove("border1");
        password.classList.remove("border1");
        document.getElementById("error-text-mail").classList.add("hidden");
        document.getElementById("error-text-pass").classList.add("hidden");

        let formIsValid = true;

        // Validate Username
        if (!validateEmail(mail.value)) {
            mail.classList.add("border1");
            document.getElementById("error-text-mail").classList.remove("hidden");
            document.getElementById("error-text-mail").textContent = "Email format is invalid";
            formIsValid = false;
        }

        // Validate Password
        if (!validatePWD(password.value)) {
            password.classList.add("border1");
            document.getElementById("error-text-pass").classList.remove("hidden");
            document.getElementById("error-text-pass").textContent = "Password must be at least 6 characters";
            formIsValid = false;
        }

        // If form is not valid, prevent submission
        if (!formIsValid) {
            event.preventDefault();
        }
    }
});