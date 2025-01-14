<?php
include 'db_connection.php';
session_start();
if(strlen($_SESSION['username']) == 0) {
    header("Location: login.php");
    exit();
}

// Fetch recent posts
$query = "SELECT posts.*, users.screenname, users.avatar 
          FROM posts 
          JOIN users ON posts.user_id = users.id 
          ORDER BY posts.created_at DESC LIMIT 5";
$result = $db->query($query);
?>

<!DOCTYPE html>
<html>

<head>
    <title> Sign Up</title>
    <link rel="stylesheet" href="css/asgstyle.css" />
</head>

<body>
    <header id="header-auth">
        <img src="images/logo.png" alt="Penny Hoarder logo" height="140" width="150"/>
        <h1> Penny Hoarder</h1>
      </header>
    <main id="main-page">
        <div id="main-page-grid">
            <nav class="navbar">
                <ul>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="manage.php">Manage Blogs</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <div id="main-page-content-grid">
            <div id="left-column">
                <div class="blog-post-container">
                    <h2>Create a Blog Post</h2>
                    <textarea class="blog-textarea" placeholder="What's on your mind?" rows="5"></textarea>
                    <button class="post-button">Post</button>
                </div>
                <div id="element-1">
                    Welcome Parthib!
                </div>
                <div id="element-2">
                    <div id="element-2-col1">
                        <img src="path_to_user_picture.jpg" alt="User Picture" id="user-picture">
                    </div>
                    <div id="element-2-col2">
                        <h2>Manage Your Account</h2>
                        <ul class="links">
                            <li><a href="manage.php">Manage Posts</a></li>
                            <li><a href="#account-security">Account & Security</a></li>
                            <li><a href="#settings">Settings</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="recent-1">
                <div id="side-header"><h2>Recent Posts</h2></div>
                <?php while ($post = $result->fetch_assoc()): ?>
                    <div id="posts">
                        <img src="<?= htmlspecialchars($post['avatar']) ?>" alt="User Avatar" class="post-avatar" style="width: 50px; height: 50px; border-radius: 50%;">
                        <h3><?= htmlspecialchars($post['screenname']) ?></h3>
                        <p><?= htmlspecialchars(substr($post['content'], 0, 100)) ?>...</p>
                        <a href="blogdetails.php?id=<?= $post['id'] ?>">Read More</a>
                        <p>Posted on: <?= date('F d, Y', strtotime($post['created_at'])) ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <footer id="footer-home">
            <p class="footer-home-text">&copy; 2024, Penny Hoarder</p>
        </footer>
    </main>
</body>

</html>