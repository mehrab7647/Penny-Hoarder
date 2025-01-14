<?php
// Include database connection
include 'db_connection.php';
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$post_id = $_GET["id"] ?? null;

// Check if the post ID is provided
if (!$post_id) {
    die("Invalid post ID.");
}

// Fetch the post details
$query = "SELECT posts.*, users.screenname, users.avatar 
          FROM posts 
          JOIN users ON posts.user_id = users.id 
          WHERE posts.id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) {
    die("Post not found.");
}

// Handle comment submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $content = trim($_POST["comment"]);
    if (!empty($content)) {
        $comment_query = "INSERT INTO comments (post_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $db->prepare($comment_query);
        $stmt->bind_param("iis", $post_id, $user_id, $content);
        $stmt->execute();
        header("Location: blogdetails.php?id=$post_id");
        exit;
    }
}

// Fetch comments for the post
$comments_query = "SELECT comments.*, users.screenname, users.avatar 
                   FROM comments 
                   JOIN users ON comments.user_id = users.id 
                   WHERE comments.post_id = ? 
                   ORDER BY comments.created_at DESC";
$comments_stmt = $db->prepare($comments_query);
$comments_stmt->bind_param("i", $post_id);
$comments_stmt->execute();
$comments = $comments_stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Penny Hoarder - Blog Details</title>
    <link rel="stylesheet" type="text/css" href="css/asgstyle.css">
    <script src="js/counter.js"></script>
    <script src="js/ajaxHandlers.js"></script>
</head>

<body>
    <div class="wrapper-container">
        <!-- Header Section -->
        <header class="header-main">
            <img src="images/logo.png" alt="Penny Hoarder Logo" height="150" width="150">
            <h1>Penny Hoarder</h1>
            <div class="user-auth-container">
                <img src="<?= htmlspecialchars($post['avatar'] ?? "images/avatar.jpg") ?>" height="50px" width="50px" alt="User Avatar">
                <div>
                    <p><?= htmlspecialchars($post["screenname"]) ?></p>
                </div>
                <form action="logout.php">
                    <input type="image" src="images/logout.png" alt="Logout" height="50px" width="50px">
                </form>
            </div>
        </header>

        <!-- Navigation Section -->
        <div id="manage-menu">
        <nav class="navbar">
                <ul>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="home.php">Home</a><li>
                        <li><a href="manage.php">Manage Blogs</a></li>
                        <li><a href="logout.php">Logout</a></li>
                        <li><a href="blogcreate.php">Create a Blog</a><li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Blog Content Box -->
            <div class="content-box">
                <div class="flex-container">
                    <div class="image-wrapper">
                        <?php if (!empty($post["image_path"])): ?>
                            <img src="<?= htmlspecialchars($post["image_path"]) ?>" width=150px height=150px alt="Blog Image">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/300x200?text=No+Image" width=100px height=100px alt="No Blog Image">
                        <?php endif; ?>
                    </div>
                    <!-- Upvote and Downvote Section -->
                    <div class="vote-container">
                        <div class="vote-icon">&#8679;</div>
                        <div class="vote-count-new"><?= htmlspecialchars($post['upvotes']) ?></div>
                        <div class="downvote-icon">&#8681;</div>
                    </div>
                </div>

                <!-- Blog Title and Content Section -->
                <div class="text-box">
                    <h3><?= htmlspecialchars($post["content"]) ?></h3>
                    <p>Posted on: <?= date('F d, Y', strtotime($post["created_at"])) ?></p>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="comment-box">
                <h3>&#11166; <?= $comments->num_rows ?> Comments</h3>
                <div class="comment-wrapper">
                    <?php while ($comment = $comments->fetch_assoc()): ?>
                        <!-- Comment Block -->
                        <div class="comment-item" data-comment-id="<?= htmlspecialchars($comment['id']) ?>">
                            <div class="comment-avatar-new">
                                <img src="<?= htmlspecialchars($comment["avatar"]) ?>" width="100px" height="100px" alt="User Avatar">
                            </div>
                            <div class="comment-details">
                                <div>
                                    <div class="user-name"><?= htmlspecialchars($comment["screenname"]) ?></div>
                                    <div class="comment-text"><?= htmlspecialchars($comment["content"]) ?></div>
                                </div>
                                <div class="comment-actions">
                                    <div class="vote-icon">&#8679;</div>
                                    <div class="vote-count-new"><?= htmlspecialchars($comment['upvotes']) ?></div>
                                    <div class="downvote-icon">&#8681;</div>
                                    <div class="vote-count-new"><?= htmlspecialchars($comment['downvotes']) ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Add Comment Section -->
                <?php if (isset($_SESSION["user_id"])): ?>
                    <div class="comment-item">
                        <div class="comment-avatar-new">
                            <img src="images/avatar.jpg" alt="User Avatar" width="50" height="50">
                        </div>
                        <div class="comment-details">
                            <form method="POST">
                                <textarea id="comment" name="comment" class="textarea-custom" rows="2" placeholder="Type your comment here..." required></textarea>
                                <div id="character-count-comment" class="char-count">1000 characters left</div>
                                <button class="button-custom">Submit</button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <p><a href="login.php">Login</a> to add a comment.</p>
                <?php endif; ?>
            </div>
        </main>


        <!-- Footer Section -->
        <footer class="footer-bar">
            <p>&copy; Penny Hoarder 2024. All rights reserved.</p>
        </footer>
    </div>
</body>

</html>