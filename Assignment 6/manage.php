<?php
// Include database connection
include 'db_connection.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
// Fetch user's blog posts
$query = "SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$posts = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/asgstyle.css">
    <title>Blog Management</title>
    <style>
        #footer-manage {
            grid-column: 1/4;
        }
        #details-1 {
            display: flex;
            justify-content: space-evenly;
            padding: 26px;
        }
    </style>
</head>
<body>
    <div id="container-manage">
        <!-- Header -->
        <header class="header-main">
            <img src="images/logo.png" alt="Penny Hoarder Logo" height="150" width="150">
            <h1>Penny Hoarder</h1>
            <div class="user-auth-container">
                <img src="<?= htmlspecialchars($_FILES['avatar'] ?? "images/avatar.jpg") ?>" height="50px" width="50px" alt="User Avatar">
                <div>
                    <p><?= htmlspecialchars($_SESSION["username"]) ?></p>
                </div>
                <form action="logout.php">
                    <input type="image" src="images/logout.png" alt="Logout" height="50px" width="50px">
                </form>
            </div>
        </header>

        <!-- Sidebar Menu -->
        <nav class="navbar">
                <ul>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        li><a href="home.php">Home</a><li>
                        <li><a href="logout.php">Logout</a></li>
                        <li><a href="blogcreate.php">Create a Blog</a><li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>

        <!-- Main Content -->
        <main id="manage-main">
            <div id="manage-header">
                <h2>Your Blog Posts</h2>
            </div>
            <?php if ($posts->num_rows > 0): ?>
                <?php while ($post = $posts->fetch_assoc()): ?>
                    <div id="manage-post">
                        <!-- Post Header -->
                        <div id="post-1">
                            <div id="image-1">
                                <?php if (!empty($post["image_path"])): ?>
                                    <img src="<?= htmlspecialchars($post["image_path"]) ?>" alt="Featured Image" style="width: 270px; height: 230px;">
                                <?php else: ?>
                                    <p>No Featured Image</p>
                                <?php endif; ?>
                            </div>
                            <div id="content-1">
                                <p><strong><?= htmlspecialchars(substr($post["content"], 0, 50)) ?>...</strong></p>
                                <p>Posted on: <?= date('F d, Y', strtotime($post["created_at"])) ?></p>
                            </div>
                            <div id="details-1">
                                <a href="blogdetails.php?id=<?= $post['id'] ?>">View Details</a>
                                <a href="deletepost.php?id=<?= $post['id'] ?>">Delete</a>
                            </div>
                        </div>

                        <!-- Comments Section -->
                        <div id="comments-section">
                            <h4>Comments</h4>
                            <?php
                            // Fetch comments for the post
                            $comments_query = "SELECT comments.*, users.screenname, users.avatar 
                                               FROM comments 
                                               JOIN users ON comments.user_id = users.id 
                                               WHERE comments.post_id = ? 
                                               ORDER BY comments.created_at DESC";
                            $comments_stmt = $db->prepare($comments_query);
                            $comments_stmt->bind_param("i", $post["id"]);
                            $comments_stmt->execute();
                            $comments = $comments_stmt->get_result();

                            if ($comments->num_rows > 0):
                                while ($comment = $comments->fetch_assoc()): ?>
                                    <div class="comment-section">
                                        <div class="comment">
                                            <div class="comment-avatar">
                                                <img src="<?= htmlspecialchars($comment["avatar"]) ?>" alt="User Avatar" style="width: 50px; height: 50px; border-radius: 50%;">
                                            </div>
                                            <div class="comment-content">
                                                <p><strong><?= htmlspecialchars($comment["screenname"]) ?></strong></p>
                                                <p><?= htmlspecialchars($comment["content"]) ?></p>
                                                <p>Posted on: <?= date('F d, Y', strtotime($comment["created_at"])) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p>No comments yet.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>You have not created any blog posts yet. <a href="blogcreate.php">Create one now!</a></p>
            <?php endif; ?>
        </main>

        <!-- Footer -->
        <footer id="footer-manage">
            <p>© 2024 Blog Application</p>
        </footer>
    </div>
</body>
</html>
