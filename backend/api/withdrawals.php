<?php
session_start();
require_once __DIR__ . '/auth.php';
header('Content-Type: application/json');

if (!is_logged_in()) {
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

$pdo = db_connect();
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = floatval($_POST['amount'] ?? 0);
    $csrf_token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf_token($csrf_token)) {
        echo json_encode(['error' => 'Invalid CSRF token']);
        exit;
    }
    if ($amount < 5) {
        echo json_encode(['error' => 'Minimum withdrawal is 5 USDT']);
        exit;
    }
    // Get wallet address
    $stmt = $pdo->prepare('SELECT wallet_address FROM users WHERE id = ?');
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    // Insert withdrawal request
    $stmt = $pdo->prepare('INSERT INTO withdrawals (user_id, amount, wallet_address, status) VALUES (?, ?, ?, "pending")');
    if ($stmt->execute([$user_id, $amount, $user['wallet_address']])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Withdrawal request failed']);
    }
    exit;
}

// GET: fetch withdrawal history
$stmt = $pdo->prepare('SELECT requested_at, amount, status FROM withdrawals WHERE user_id = ? ORDER BY requested_at DESC');
$stmt->execute([$user_id]);
$history = $stmt->fetchAll();
echo json_encode(['history' => $history]);
