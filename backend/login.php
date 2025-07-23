<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $csrf_token = $_POST['csrf_token'] ?? '';

    if (!verify_csrf_token($csrf_token)) {
        die('Invalid CSRF token');
    }

    if (!$email || !$password) {
        die('Email and password are required.');
    }

    if (login_user($email, $password)) {
        header('Location: ../public/dashboard.html');
        exit;
    } else {
        die('Invalid email or password.');
    }
} else {
    die('Invalid request.');
}
