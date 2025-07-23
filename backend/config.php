<?php
// config.php
// Database and security configuration for USDT staking platform

// Database settings
define('DB_HOST', 'localhost');
define('DB_NAME', 'usdt_staking');
define('DB_USER', 'root');
define('DB_PASS', ''); // Set your MySQL password

define('SITE_URL', 'http://localhost'); // Update if deploying elsewhere

define('SESSION_NAME', 'usdt_stake_session');
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);

// Security settings
define('PASSWORD_COST', 12); // bcrypt cost

define('CSRF_TOKEN_SECRET', bin2hex(random_bytes(32))); // Secure random value
