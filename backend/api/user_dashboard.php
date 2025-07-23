<?php
session_start();
require_once __DIR__ . '/auth.php';
header('Content-Type: application/json');

if (!is_logged_in()) {
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];
$pdo = db_connect();

// Fetch user info
$stmt = $pdo->prepare('SELECT name, wallet_address FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Fetch staking summary
$stmt = $pdo->prepare('SELECT SUM(amount_staked) as total_staked, SUM(earned_usdt) as total_earnings FROM stakes WHERE user_id = ?');
$stmt->execute([$user_id]);
$summary = $stmt->fetch();

// Fetch staking history
$stmt = $pdo->prepare('SELECT stake_date, end_date, amount_staked, status, earned_usdt FROM stakes WHERE user_id = ? ORDER BY stake_date DESC');
$stmt->execute([$user_id]);
$history = $stmt->fetchAll();

// Fetch referral bonus
$stmt = $pdo->prepare('SELECT SUM(bonus_amount) as referral_bonus FROM referrals WHERE referrer_id = ? AND status = "credited"');
$stmt->execute([$user_id]);
$referral = $stmt->fetch();

$response = [
    'user' => $user,
    'summary' => $summary,
    'history' => $history,
    'referral_bonus' => $referral['referral_bonus'] ?? 0
];
echo json_encode($response);
