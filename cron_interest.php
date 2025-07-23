<?php
// cron_interest.php
// Run this once a day (via cron or Task Scheduler)
require_once __DIR__ . '/backend/config.php';
require_once __DIR__ . '/backend/auth.php';

$pdo = db_connect();

// 2% daily interest for all active stakes
$stmt = $pdo->prepare('SELECT id, amount_staked, stake_date, end_date, earned_usdt FROM stakes WHERE status = "active"');
$stmt->execute();
$stakes = $stmt->fetchAll();

foreach ($stakes as $stake) {
    $now = new DateTime();
    $stake_date = new DateTime($stake['stake_date']);
    $end_date = new DateTime($stake['end_date']);
    $days = min($now->diff($stake_date)->days, $end_date->diff($stake_date)->days);
    $principal = (float)$stake['amount_staked'];
    $earned = $principal * pow(1.02, $days) - $principal; // Compound daily
    if ($earned > (float)$stake['earned_usdt']) {
        $update = $pdo->prepare('UPDATE stakes SET earned_usdt = ? WHERE id = ?');
        $update->execute([round($earned, 6), $stake['id']]);
    }
}
echo "Interest calculation complete.\n";
