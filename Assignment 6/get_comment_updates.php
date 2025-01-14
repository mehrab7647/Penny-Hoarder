<?php
include 'db_connection.php';
session_start();

$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

// Fetch post upvotes
$post_query = "SELECT upvotes FROM posts WHERE id = ?";
$stmt = $db->prepare($post_query);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$post_result = $stmt->get_result()->fetch_assoc();

// Fetch comment upvotes
$comments_query = "SELECT id, upvotes FROM comments WHERE post_id = ? ORDER BY created_at DESC";
$stmt = $db->prepare($comments_query);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$comments_result = $stmt->get_result();

$comments_updates = [];
while ($comment = $comments_result->fetch_assoc()) {
    $comments_updates[] = [
        'id' => $comment['id'],
        'upvotes' => $comment['upvotes']
    ];
}

$response = [
    'post' => ['upvotes' => $post_result['upvotes']],
    'comments' => $comments_updates
];

header('Content-Type: application/json');
echo json_encode($response);
exit;