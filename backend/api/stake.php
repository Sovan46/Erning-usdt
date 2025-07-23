<?php
session_start();
require_once __DIR__ . '/../auth.php';
header('Content-Type: application/json');

if (!is_logged_in()) {
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

$user_id = $_SESSION['user_id'];
$plan_days = intval($_POST['plan'] ?? 0);
$amount = floatval($_POST['amount'] ?? 0);
$csrf_token = $_POST['csrf_token'] ?? '';

if (!verify_csrf_token($csrf_token)) {
    echo json_encode(['error' => 'Invalid CSRF token']);
    exit;
}

if ($amount < 1) {
    echo json_encode(['error' => 'Minimum stake is 1 USDT']);
    exit;
}

$pdo = db_connect();
// Get plan info
$stmt = $pdo->prepare('SELECT id, interest_rate FROM staking_plans WHERE duration_days = ?');
$stmt->execute([$plan_days]);
$plan = $stmt->fetch();
if (!$plan) {
    echo json_encode(['error' => 'Invalid staking plan']);
    exit;
}
$plan_id = $plan['id'];
$interest_rate = $plan['interest_rate'];

$stake_date = date('Y-m-d H:i:s');
$end_date = date('Y-m-d H:i:s', strtotime("+$plan_days days"));

$stmt = $pdo->prepare('INSERT INTO stakes (user_id, plan_id, amount_staked, stake_date, end_date, earned_usdt, status) VALUES (?, ?, ?, ?, ?, 0, "active")');
if ($stmt->execute([$user_id, $plan_id, $amount, $stake_date, $end_date])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Failed to create stake']);
}
