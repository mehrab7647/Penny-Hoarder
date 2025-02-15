<?php
require_once("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); //encodes
    return $data;
}


// Check whether the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $errors = array();
    $dataOK = TRUE;
    
    // Get and validate the username and password fields
    $username = test_input($_POST["username"]);
    $unameRegex = "/^[a-zA-Z0-9_]+$/";
    if (!preg_match($unameRegex, $username)) {
        $errors["username"] = "Invalid Username";
        $dataOK = FALSE;
    }

    $password = test_input($_POST["password"]);
    $passwordRegex = "/^.{8}$/";
    if (!preg_match($passwordRegex, $password)) {
        $errors["password"] = "Invalid Password";
        $dataOK = FALSE;
    }

    // Check whether the fields are not empty
    if ($dataOK) {

        // Connect to the database and verify the connection
        try {
            $db = new PDO($attr, $db_user, $db_pwd, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        // TODO 10a: use PDO::query() to get the user_id, first_name, last_name, 
        //           and avatar_url of users that match the username and password
        $query = "SELECT user_id, first_name, last_name, avatar_url FROM Loggers WHERE username = :username AND password = :password";
        $stmt = $db->prepare($query);
        $stmt->execute([':username' => $username, ':password' => $password]); // Assumes the password is stored unhashed in the DB
        $result = $stmt;
        if (!$result) {
            // query has an error
            $errors["Database Error"] = "Could not retrieve user information";
        } elseif ($row = $result->fetch()) {
            // If there's a row, we have a match and login is successful!
            
            session_start();

            // TODO 10b: store the uid, first_name, last_name, and avatar_url fields
            //            from $row into the $_SESSION superglobal variable
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["first_name"] = $row["first_name"];
            $_SESSION["last_name"] = $row["last_name"];
            $_SESSION["avatar_url"] = $row["avatar_url"];

            // Learn the IP address of the logged in user.
            $ip = $_SERVER['REMOTE_ADDR'];

            // TODO 10c: use PDO::exec() to save the details of this login in the Logins table
            //           Hints in UR Courses
            $ip = $_SERVER['REMOTE_ADDR'];
            $query = "INSERT INTO Logins (user_id, login_time, ip_address) VALUES (:user_id, NOW(), :ip)";
            $db->prepare($query)->execute([':user_id' => $_SESSION["user_id"], ':ip' => $ip]);
            // TODO 10d: Close the database connection 
            //           and redirect the user to the loginHistory.php page.
            $db = null;
            header("Location: loginHistory.php");
            exit();

            exit();
        } else {
            // login unsuccessful
            $errors["Login Failed"] = "That username/password combination does not exist.";
        }

        $db = null;

    } else {

        $errors['Login Failed'] = "You entered invalid data while logging in.";
    }
    if(!empty($errors)){
        foreach($errors as $type => $message) {
            echo "$type: $message <br />\n";
        }
    }

}
?>
<!DOCTYPE html>
<html>

<head>
    <title>CS215 Homepage</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="js/eventHandlers.js"></script>
</head>

<body>
    <div id="container">
        <header id="header-auth">
            <h1>My Login History</h1>
        </header>
        <main id="main-left">

        </main>
        <main id="main-center">
            <form action="" method="post" class="auth-form" id="login-form">
                <p class="input-field">
                    <label>Username</label>
                    <input type="text" id="username" name="username" />
                <p id="error-text-username" class="error-text hidden">Username is invalid</p>
                </p>
                <p class="input-field">
                    <label>Password</label>
                    <input type="password" id="password" name="password" />
                <p id="error-text-password" class="error-text hidden">Password is invalid</p>
                </p>
                <p class="input-field">
                    <input type="submit" class="form-submit" value="Login" />
                </p><br>
            </form>
            <div class="foot-note">
                <p>Don't have an account? <a href="signup.php">Signup</a></p>
            </div>
        </main>
        <main id="main-right">

        </main>
        <footer id="footer-auth">
            <p class="footer-text">CS 215: Lab 6 Solution</p>
        </footer>
    </div>
    <script src="js/eventRegisterLogin.js"></script>
</body>

</html>