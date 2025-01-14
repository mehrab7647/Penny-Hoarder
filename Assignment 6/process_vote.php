<?php
include 'db_connection.php';

// Send JSON response
header('Content-Type: application/json');

// Start session
session_start();
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION["user_id"];
$comment_id = isset($_POST['comment_id']) ? intval($_POST['comment_id']) : 0;
$vote_type = isset($_POST['vote_type']) ? $_POST['vote_type'] : '';

if (!$comment_id || !in_array($vote_type, ['upvote', 'downvote'])) {
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

// Prepare the query to update votes
if ($vote_type === 'upvote') {
    $query = "UPDATE comments SET upvotes = upvotes + 1 WHERE id = ?";
} elseif ($vote_type === 'downvote') {
    $query = "UPDATE comments SET downvotes = downvotes + 1 WHERE id = ?";
}

$stmt = $db->prepare($query);
$stmt->bind_param("i", $comment_id);
if (!$stmt->execute()) {
    echo json_encode(['error' => 'Database update failed']);
    exit;
}

// Fetch the updated vote counts
$query = "SELECT upvotes, downvotes FROM comments WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $comment_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        'upvotes' => $row['upvotes'],
        'downvotes' => $row['downvotes']
    ]);
} else {
    echo json_encode(['error' => 'Comment not found']);
}
?>
