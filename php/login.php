<?php
header('Content-Type: application/json');
require 'db_connect.php';

$data = json_decode(file_get_contents('php://input'), true);
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

if (!$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Email and password required.']);
    exit;
}

// Get user
$stmt = $pdo->prepare('SELECT id, password_hash FROM users WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch();
if (!$user) {
    echo json_encode(['success' => false, 'message' => 'Invalid credentials.']);
    exit;
}
$user_id = $user['id'];

// Check failed attempts in last 3 minutes
$stmt = $pdo->prepare('SELECT COUNT(*) FROM login_attempts WHERE user_id = ? AND success = 0 AND attempt_time > (NOW() - INTERVAL 3 MINUTE)');
$stmt->execute([$user_id]);
$fail_count = $stmt->fetchColumn();
if ($fail_count >= 3) {
    echo json_encode(['success' => false, 'message' => 'Account locked. Try again in 3 minutes.']);
    exit;
}

// Verify password
if (password_verify($password, $user['password_hash'])) {
    // Success: record attempt
    $stmt = $pdo->prepare('INSERT INTO login_attempts (user_id, success) VALUES (?, 1)');
    $stmt->execute([$user_id]);
    echo json_encode(['success' => true, 'message' => 'Login successful.']);
} else {
    // Fail: record attempt
    $stmt = $pdo->prepare('INSERT INTO login_attempts (user_id, success) VALUES (?, 0)');
    $stmt->execute([$user_id]);
    echo json_encode(['success' => false, 'message' => 'Invalid credentials.']);
}
