<?php
require 'db.php';
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['email'], $data['password'])) {
    echo json_encode(['success' => false, 'message' => 'Missing fields']);
    exit;
}

$email = trim($data['email']);
$password = $data['password'];

$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
    exit;
}

// Check lockout
if ($user['failed_attempts'] >= 3 && $user['lockout_time'] && strtotime($user['lockout_time']) > time() - 180) {
    $remaining = 180 - (time() - strtotime($user['lockout_time']));
    echo json_encode(['success' => false, 'message' => 'Account locked. Try again in ' . $remaining . ' seconds.']);
    exit;
}

if (password_verify($password, $user['password_hash'])) {
    // Reset failed attempts
    $pdo->prepare('UPDATE users SET failed_attempts = 0, lockout_time = NULL WHERE id = ?')->execute([$user['id']]);
    echo json_encode(['success' => true]);
} else {
    $failed = $user['failed_attempts'] + 1;
    $lockout = $failed >= 3 ? date('Y-m-d H:i:s') : NULL;
    $pdo->prepare('UPDATE users SET failed_attempts = ?, lockout_time = ? WHERE id = ?')->execute([$failed, $lockout, $user['id']]);
    $msg = $failed >= 3 ? 'Account locked for 3 minutes.' : 'Invalid credentials';
    echo json_encode(['success' => false, 'message' => $msg]);
}
?>
