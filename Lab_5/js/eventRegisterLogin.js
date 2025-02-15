// To Do 4: Add code to register a "submit" event on the login form,
//         and assign an event handler.
//         Hint: use addEventListener() to register events.
document.getElementById('login-form').addEventListener('submit', validateLoginForm);

function validateLoginForm(loginEvent) {
  // Prevent default form submission
  loginEvent.preventDefault();

  // Get input values from the form
  let loginUsernameInput = document.getElementById('username').value.trim();
  let loginPasswordInput = document.getElementById('password').value.trim();

  // Check if both fields are filled
  if (loginUsernameInput === "" || loginPasswordInput === "") {
    console.log("Please fill in both the username and password fields.");
  } else {
    // If both fields are filled, submit the form
    loginEvent.target.submit();
  }
}
