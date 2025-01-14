<?php
include 'db_connection.php';
session_start();

// Determine number of blogs based on login status
$limit = isset($_SESSION['user_id']) ? 20 : 5;
$last_id = isset($_GET['last_id']) ? intval($_GET['last_id']) : 0;

$query = "SELECT posts.*, users.screenname, users.avatar, 
          (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) as comment_count
          FROM posts 
          JOIN users ON posts.user_id = users.id 
          WHERE posts.id > ?
          ORDER BY posts.created_at DESC 
          LIMIT ?";

$stmt = $db->prepare($query);
$stmt->bind_param("ii", $last_id, $limit);
$stmt->execute();
$result = $stmt->get_result();

$blogs = [];
while ($row = $result->fetch_assoc()) {
    $blogs[] = [
        'id' => $row['id'],
        'title' => substr($row['content'], 0, 50) . '...',
        'content' => $row['content'],
        'screenname' => $row['screenname'],
        'avatar' => $row['avatar'],
        'created_at' => date('F d, Y', strtotime($row['created_at'])),
        'comment_count' => $row['comment_count']
    ];
}

header('Content-Type: application/json');
echo json_encode($blogs);
exit;