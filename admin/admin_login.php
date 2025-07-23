<?php
session_start();
require_once __DIR__ . '/../backend/config.php';
$pdo = db_connect();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT * FROM admin WHERE username = ?');
    $stmt->execute([$username]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header('Location: dashboard.php');
        exit;
    } else {
        die('Invalid credentials');
    }
} else {
    die('Invalid request');
}
