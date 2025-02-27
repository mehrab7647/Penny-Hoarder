<?php
$firstName = "Fix";
$lastName = "Me";
//TODO 7.2: add code that starts a session and 
//          if $_SESSION["username"] has length of 0
//          redirects back to login.php
//          OPTIONAL: retrieve your first name and last name from the session
session_start();
if (strlen($_SESSION["username"]) === 0) { 
    header("Location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>CS215 Homepage</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />

</head>

<body>
    <div id="container-login-history">
        <header id="header-login-history">
            <h1>My Login History <a class="logout" href="logout.php">Logout</a></h1>
        </header>
        <main id="main-left-login-history">

        </main>
        <section>
            <h2>About me</h2>
            <img src="images/ada2.jpg" alt="Image of Ada Lovelace" />

            <div id="user-data">
                <h3 class="user-info-name"><?= $firstName ?> <?= $lastName ?></h3>
                <p class="user-info-dob">
                    January 1, 2000
                </p>
                <a class="update-info" href="signup.php">Edit</a></h1>
            </div>
        </section>
        <aside id="login-sessions">
            <h2>Login Sessions</h2>
            <div class="session">
                <p>March 2, 2022 <span>6:00 PM</span></p>
                <p>101.111.111.111</p>
            </div>
            <div class="session">
                <p>March 2, 2022 <span>6:00 PM</span></p>
                <p>101.111.111.111</p>
            </div>
            <div class="session">
                <p>March 2, 2022 <span>6:00 PM</span></p>
                <p>101.111.111.111</p>
            </div>
            <div class="session">
                <p>March 2, 2022 <span>6:00 PM</span></p>
                <p>101.111.111.111</p>
            </div>
            <div class="session">
                <p>March 2, 2022 <span>6:00 PM</span></p>
                <p>101.111.111.111</p>
            </div>
            <div class="session">
                <p>March 2, 2022 <span>6:00 PM</span></p>
                <p>101.111.111.111</p>
            </div>
            <div class="session">
                <p>March 2, 2022 <span>6:00 PM</span></p>
                <p>101.111.111.111</p>
            </div>
        </aside>
        <main id="main-right-login-history">

        </main>
        <footer id="footer-login-history">
            <p class="footer-text">CS 215: Lab 3 Solution</p>
        </footer>
    </div>
</body>

</html>