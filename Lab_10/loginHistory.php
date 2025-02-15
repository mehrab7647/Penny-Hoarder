<?php
    session_start();
    require_once("db.php");

    // Check whether the user has logged in or not.
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    } else {
        $firstName = $_SESSION["first_name"];
        $lastName = $_SESSION["last_name"];
        $user_id = $_SESSION["user_id"];
        $avatar_url = $_SESSION["avatar_url"];
    }

    // Connect to the database and verify the connection
    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }

    // TODO 12a: use PDO::query() with a SELECT statement to fetch details for all the Logins for the current user
    //           Optional DATETIME formatting hints in UR Courses
    $query = "SELECT login_time FROM Logins WHERE user_id = :user_id ORDER BY login_time DESC";
    $stmt = $db->prepare($query);
    $stmt->execute([':user_id' => $_SESSION["user_id"]]);
    $logins = $stmt->fetchAll();

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
            <img src="<?=$avatar_url?>" alt="Image of Ada Lovelace" />

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

<?php
    // TODO 12b: Iterate over the result set and dynamically generate <div class="session"> blocks 
    //           for login details based on samples shown in previous labs.
    //           Optional date and time formatting hints in UR Courses
    foreach ($logins as $login) {
        // Format the date and time for better readability
        $formattedDate = date("F j, Y, g:i a", strtotime($login['login_time']));
        echo "<div class='session'>$formattedDate</div>";
    }
?>
        </aside>
        <main id="main-right-login-history">

        </main>
        <footer id="footer-login-history">
            <p class="footer-text">CS 215: Lab 3 Solution</p>
        </footer>
    </div>
</body>

</html>