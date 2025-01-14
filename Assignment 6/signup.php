<?php
// Database connection
include 'db_connection.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $screenname = trim($_POST["uname"]);
    $password = $_POST["password"];
    $avatar = $_FILES["avatar"];
    $fname = trim($_POST["fname"]);
    $lname = trim($_POST["lname"]);
    $dob = $_POST["dob"];

    // Validation
    $errors = [];
    if (empty($fname)) {
        $errors[] = "First name is required.";
    }
    if (empty($lname)) {
        $errors[] = "Last name is required.";
    }
    if (empty($dob)) {
        $errors[] = "Date of birth is required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (!preg_match("/^\w+$/", $screenname)) {
        $errors[] = "Screen name must only contain letters, numbers, and underscores.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }
    if ($avatar["error"] != UPLOAD_ERR_OK) {
        $errors[] = "Avatar upload failed.";
    }

    if (empty($errors)) {
        // Save avatar
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $avatar_path = "images/" . basename($_FILES["avatar"]["name"]);
            if (!move_uploaded_file($_FILES["avatar"]["tmp_name"], $avatar_path)) {
                $errors[] = "Failed to save avatar.";
            }
        } else {
            $errors[] = "Avatar upload failed.";
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Save user to database
        $query = "INSERT INTO users (fname, lname, dob, email, screenname, password, avatar) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sssssss", $fname, $lname, $dob, $email, $screenname, $hashed_password, $avatar_path);
        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            die("Database error: " . $stmt->error);
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Penny Hoarder - Sign Up</title>
    <link rel="stylesheet" href="css/asgstyle.css" />
    <style>
        #main-center
        {
            grid-row:2/3;
            grid-column:2/4;
            margin: auto;
        }
    </style>
    <script src="js/signupHandlers.js"></script>
</head>

<body>
    <div id="container">
        <header id="header-auth">
            <img src="images/logo.png" alt="Penny Hoarder logo" height="140" width="150" />
            <h1>Penny Hoarder</h1>
        </header>
        <main id="main-center">
            <form id="signup-form" class="signup-form-border" method="POST" enctype="multipart/form-data" >
                <h2 id="signup-header">Sign Up</h2>
                <div id="form-input-grid">
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="fname" />

                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lname" />

                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" />

                    <label for="uname">Username</label>
                    <input type="text" id="uname" name="uname" />
                    <div></div>
                    <div id="error-text-screenname" class="error-text hidden">
                        No spaces or special characters
                    </div>

                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" />
                    <div></div>
                    <div id="error-text-email" class="error-text hidden">
                        Invalid email format
                    </div>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" />
                    <div></div>
                    <div id="error-text-password" class="error-text hidden">
                        At least 6 characters and one non-letter character
                    </div>

                    <label for="retypepass">Retype Password</label>
                    <input type="password" id="retypepass" name="retypepass" />
                    <div></div>
                    <div id="error-text-verify-password" class="error-text hidden">
                        Passwords do not match
                    </div>

                    <label for="avatar">Select an Avatar</label>
                    <input type="file" id="avatar" name="avatar" accept="image/jpg, image/jpeg, image/gif, image/png">
                    <div></div>
                    <div id="error-text-avatar" class="error-text hidden">No Avatar image</div>
                </div>
                <div id="align-right">
                    <input type="submit" value="Create an Account" />
                </div>
            </form>
            <div id="form-note">
                <p>Already a user? <a href="login.php">Login</a></p>
            </div>
        </main>
        <footer id="footer-auth">
            <p id="footer-text">&copy; Penny Hoarder 2024</p>
        </footer>
    </div>
</body>

</html>
