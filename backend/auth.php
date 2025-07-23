<?php
require_once __DIR__ . '/../backend/config.php';

function db_connect() {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die('Database connection failed: ' . $e->getMessage());
    }
}

function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function register_user($name, $email, $password, $wallet_address, $referral_code = null, $referred_by = null) {
    $pdo = db_connect();
    $hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => PASSWORD_COST]);
    $stmt = $pdo->prepare('INSERT INTO users (name, email, password, wallet_address, referral_code, referred_by) VALUES (?, ?, ?, ?, ?, ?)');
    return $stmt->execute([$name, $email, $hashed_password, $wallet_address, $referral_code, $referred_by]);
}

function login_user($email, $password) {
    $pdo = db_connect();
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        return true;
    }
    return false;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function logout_user() {
    session_unset();
    session_destroy();
}
