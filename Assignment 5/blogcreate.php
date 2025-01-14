<?php
// Include database connection
include 'db_connection.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION["user_id"];
    $content = trim($_POST["content"]);
    $featured_image = $_FILES["featured_image"];
    $errors = [];

    // Validate content
    if (empty($content)) {
        $errors[] = "Content cannot be empty.";
    }

    // Handle image upload
    $image_path = null;
    if ($featured_image["error"] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/posts/";
        $image_path = $target_dir . basename($featured_image["name"]);
        if (!move_uploaded_file($featured_image["tmp_name"], $image_path)) {
            $errors[] = "Failed to upload image.";
        }
    }

    if (empty($errors)) {
        // Insert post into the database
        $query = "INSERT INTO posts (user_id, content, image_path, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $db->prepare($query);
        $stmt->bind_param("iss", $user_id, $content, $image_path);
        if ($stmt->execute()) {
            header("Location: manage.php");
            exit;
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penny Hoarder - Create a Post</title>
    <link rel="stylesheet" type="text/css" href="css/asgstyle.css">
    <script src="js/counter.js"></script>
    <style>
        #form-input-grid {
            display: grid;
            grid-template-columns: 1fr 10fr;
            row-gap: 10px;
            column-gap: 10px;
        }
    </style>
</head>

<body>
    <div id="container-2">
        <!-- Header Section -->
        <header id="header-auth">
            <div>
                <img src="images/logo.png" alt="Penny Hoarder Logo" height="140" width="140">
            </div>
            <div>
                <h1>Penny Hoarder</h1>
            </div>
            <!-- User Profile & Logout -->
            <div id="manage-logout">
                <img src="images/avatar.jpg" height="40px" width="40px" id="avatar1" alt="User Avatar" />
                <div id="user-text">
                    <p id="user1">Username</p>
                </div>
                <form action="login.php">
                    <input type="image" src="images/logout.png" alt="Logout" height="50px" width="50px" />
                </form>
            </div>
        </header>

        <!-- Navigation Section -->
        <nav id="manage-menu">
            <h2>Menu</h2>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="manage.php">Manage Posts</a></li>
                <li><a href="blogcreate.php">Create Post</a></li>
                <li><a href="home.php">Settings</a></li>
            </ul>
        </nav>

        <!-- Main Content Section -->
        <main id="main-center-2">
            <h2>Create a Blog Post</h2>
            <?php if (!empty($errors)): ?>
                <ul class="error-list">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <form id="auth-form" method="POST" enctype="multipart/form-data">
                <div id="form-input-grid">
                    <label id="align-right" for="title">Title:</label>
                    <input type="text" id="title" name="title" placeholder="Enter the title" required>

                    <label id="align-right" for="content">Blog Content:</label>
                    <textarea id="content" name="content" rows="10" placeholder="Write your post here..."
                        required></textarea>
                    <div></div>
                    <div id="character-count-content" class="char-count">2000 characters left</div>
                    <label id="align-right" for="media">Add Media:</label>
                    <input type="file" id="media" name="media" accept="image/*,video/*">


                    <div></div> <!-- Empty div for spacing -->
                    <div id="form-note">
                        <input type="submit" value="Save Draft">
                        <input type="submit" value="Post">
                    </div>
                </div>
            </form>
        </main>

        <!-- Footer Section -->
        <footer id="footer-auth">
            <p id="footer-text">&copy; Penny Hoarder 2024. All rights reserved.</p>
        </footer>
    </div>
</body>

</html>