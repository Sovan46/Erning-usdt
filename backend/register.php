<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $wallet_address = trim($_POST['wallet_address'] ?? '');
    $referral_code = trim($_POST['referral_code'] ?? null);
    $csrf_token = $_POST['csrf_token'] ?? '';

    if (!verify_csrf_token($csrf_token)) {
        die('Invalid CSRF token');
    }

    if (!$name || !$email || !$password || !$wallet_address) {
        die('All fields are required.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid email address.');
    }

    if (register_user($name, $email, $password, $wallet_address, $referral_code)) {
        header('Location: ../public/login.html?registered=1');
        exit;
    } else {
        die('Registration failed. Email may already be registered.');
    }
} else {
    die('Invalid request.');
}
