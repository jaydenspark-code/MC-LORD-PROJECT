<?php
require 'db.php';
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['user_id'], $data['title'], $data['description'])) {
    echo json_encode(['success' => false, 'message' => 'Missing fields']);
    exit;
}

$user_id = (int)$data['user_id'];
$title = trim($data['title']);
$description = trim($data['description']);
$cuisine_type = $data['cuisine_type'] ?? null;
$dietary_pref = $data['dietary_pref'] ?? null;
$difficulty = $data['difficulty'] ?? null;

try {
    $stmt = $pdo->prepare('INSERT INTO recipes (user_id, title, description, cuisine_type, dietary_pref, difficulty) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$user_id, $title, $description, $cuisine_type, $dietary_pref, $difficulty]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Recipe submission failed']);
}
?>
