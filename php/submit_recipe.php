<?php
header('Content-Type: application/json');
require 'db_connect.php';

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $data['user_id'] ?? null;
$title = trim($data['title'] ?? '');
$cuisine = trim($data['cuisine_type'] ?? '');
$diet = trim($data['dietary_pref'] ?? '');
$diff = trim($data['difficulty'] ?? '');
$ingredients = trim($data['ingredients'] ?? '');
$instructions = trim($data['instructions'] ?? '');

if (!$user_id || !$title || !$ingredients || !$instructions) {
    echo json_encode(['success' => false, 'message' => 'Required fields missing.']);
    exit;
}
$stmt = $pdo->prepare('INSERT INTO recipes (user_id, title, cuisine_type, dietary_pref, difficulty, ingredients, instructions) VALUES (?, ?, ?, ?, ?, ?, ?)');
$stmt->execute([$user_id, $title, $cuisine, $diet, $diff, $ingredients, $instructions]);
if ($stmt->rowCount()) {
    echo json_encode(['success' => true, 'message' => 'Recipe submitted.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Submission failed.']);
}
