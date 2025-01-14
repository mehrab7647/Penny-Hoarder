<?php
// Database connection
include 'db_connection.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["mail"]);
    $password = $_POST["pass"];

    $query = "SELECT id, password FROM users WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $stored_password);
        $stmt->fetch();
      
        if (password_verify($password, $stored_password)) {
            $_SESSION["user_id"] = $user_id;
            header("Location: home.php");
            exit;
        }
        else {
          $login_error = "Invalid email or password.";
        }
    }

    $login_error = "Invalid email or password.";
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Penny Hoarder-Login</title>
  <link rel="stylesheet" type="text/css" href="css/asgstyle.css" />
  <script src="js/loginHandlers.js"></script>
</head>

<body>
  <div id="container">
    <header id="header-auth">
      <img src="images/logo.png" alt="Penny Hoarder logo" height="140" width="150"/>
      <h1> Penny Hoarder</h1>
    </header>
    <div id="main-center">
      <form id="auth-form" action="home.php" method="post">
        <h2 id="login-header">
          Login
        </h2>
        <div id="form-input-grid">
          <label for="mail">E-mail:</label>
          <input type="text" id="mail" name="mail" />
          <div></div>
          <div id="error-text-mail" class="error-text hidden">
            Email format is invalid
          </div>
          <label for="pass">Password:</label>
          <input type="text" id="pass" name="pass" />
          <div></div>
          <div id="error-text-pass" class="error-text hidden">
            Password is invalid
          </div>
        </div>
        <div id="align-right">
          <input type="submit" value="Login" />
        </div>
      </form>
      <div id="form-note">
        <p>
          Don't have an account? <a href="signup.php">Signup</a>
        </p>
      </div>
    </div>
    <aside id="recent">
      <div id="side-header">
        <h2>
          Recent Posts
        </h2>
      </div>

      <div id="posts">
        <div id="post-info">
          <p>Username</p>
          <p>Title</p>
          <p>20 Comments</p>
          <p>Date and Time</p>
        </div>
        <div id="post-img">
          <img src="images/picture.jpg" alt="Random Picture" height="150" height="150"/>
          <form action="blogdetails.php">
            <input type="submit" value="See More..." />
          </form>
        </div>
      </div>
      <div id="posts">
        <div id="post-info">
          <p>Username</p>
          <p>Title</p>
          <p>20 Comments</p>
          <p>Date and Time</p>
        </div>
        <div id="post-img">
          <img src="images/picture.jpg" alt="Random Picture" height="150" height="150"/>
          <form action="blogdetails.php">
            <input type="submit" value="See More..." />
          </form>
        </div>
      </div>
      <div id="posts">
        <div id="post-info">
          <p>Username</p>
          <p>Title</p>
          <p>20 Comments</p>
          <p>Date and Time</p>
        </div>
        <div id="post-img">
          <img src="images/picture.jpg" alt="Random Picture" height="150" height="150"/>
          <form action="blogdetails.php">
            <input type="submit" value="See More..." />
          </form>
        </div>
      </div>
      <div id="posts">
        <div id="post-info">
          <p>Username</p>
          <p>Title</p>
          <p>20 Comments</p>
          <p>Date and Time</p>
        </div>
        <div id="post-img">
          <img src="images/picture.jpg" alt="Random Picture" height="150" height="150"/>
          <form action="blogdetails.php">
            <input type="submit" value="See More..." />
          </form>
        </div>
      </div>
      <div id="posts">
        <div id="post-info">
          <p>Username</p>
          <p>Title</p>
          <p>20 Comments</p>
          <p>Date and Time</p>
        </div>
        <div id="post-img">
          <img src="images/picture.jpg" alt="Random Picture" height="150" height="150"/>
          <form action="blogdetails.php">
            <input type="submit" value="See More..." />
          </form>
        </div>
      </div>

    </aside>
    <footer id="footer-auth">
      <p id="footer-text">&copy; Penny Hoarder 2024</p>
    </footer>
  </div>
  <script src="js/eventRegisterLogin.js"></script>
</body>

</html>