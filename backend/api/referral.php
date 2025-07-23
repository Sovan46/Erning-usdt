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

// Get referral link and referred users
$stmt = $pdo->prepare('SELECT referral_code FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();
$referral_link = SITE_URL . '/public/register.html?ref=' . urlencode($user['referral_code']);

$stmt = $pdo->prepare('SELECT u.name, r.bonus_amount, r.status FROM referrals r JOIN users u ON r.referred_id = u.id WHERE r.referrer_id = ?');
$stmt->execute([$user_id]);
$referred = $stmt->fetchAll();

$stmt = $pdo->prepare('SELECT SUM(bonus_amount) as total_bonus FROM referrals WHERE referrer_id = ? AND status = "credited"');
$stmt->execute([$user_id]);
$bonus = $stmt->fetch();

$response = [
    'referral_link' => $referral_link,
    'referred_users' => $referred,
    'total_bonus' => $bonus['total_bonus'] ?? 0
];
echo json_encode($response);
