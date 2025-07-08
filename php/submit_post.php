<?php
header('Content-Type: application/json');
require 'db_connect.php';

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $data['user_id'] ?? null;
$title = trim($data['title'] ?? '');
$content = trim($data['content'] ?? '');

if (!$user_id || !$title || !$content) {
    echo json_encode(['success' => false, 'message' => 'Required fields missing.']);
    exit;
}
$stmt = $pdo->prepare('INSERT INTO community_posts (user_id, title, content) VALUES (?, ?, ?)');
$stmt->execute([$user_id, $title, $content]);
if ($stmt->rowCount()) {
    echo json_encode(['success' => true, 'message' => 'Post submitted.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Submission failed.']);
}
