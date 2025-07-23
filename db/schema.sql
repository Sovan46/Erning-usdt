CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    wallet_address VARCHAR(100) NOT NULL,
    referral_code VARCHAR(50) UNIQUE,
    referred_by VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE staking_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    duration_days INT NOT NULL,
    interest_rate DECIMAL(5,2) NOT NULL,
    min_amount DECIMAL(18,6) NOT NULL
);

CREATE TABLE stakes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    plan_id INT NOT NULL,
    amount_staked DECIMAL(18,6) NOT NULL,
    stake_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    earned_usdt DECIMAL(18,6) DEFAULT 0,
    status ENUM('active','completed','cancelled') DEFAULT 'active',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (plan_id) REFERENCES staking_plans(id)
);

CREATE TABLE withdrawals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount DECIMAL(18,6) NOT NULL,
    wallet_address VARCHAR(100) NOT NULL,
    requested_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending','approved','rejected') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE referrals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    referrer_id INT NOT NULL,
    referred_id INT NOT NULL,
    bonus_amount DECIMAL(18,6) DEFAULT 0,
    status ENUM('pending','credited') DEFAULT 'pending',
    FOREIGN KEY (referrer_id) REFERENCES users(id),
    FOREIGN KEY (referred_id) REFERENCES users(id)
);

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
);
