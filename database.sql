-- =============================================
-- ROBLOX TRACKERS DATABASE SETUP
-- =============================================
-- Run this SQL file in phpMyAdmin or MySQL CLI
-- to create the required database and tables
-- =============================================

-- Create Database
CREATE DATABASE IF NOT EXISTS roblox;
USE roblox;

-- =============================================
-- USERS TABLE
-- =============================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    gender ENUM('male', 'female', '') DEFAULT '',
    birthday DATE NULL,
    robux_balance INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- TRANSACTIONS TABLE
-- =============================================
CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type ENUM('income', 'expense') NOT NULL,
    
    -- For Income
    income_source VARCHAR(100) NULL,
    received_from VARCHAR(100) NULL,
    
    -- For Expense
    item_name VARCHAR(100) NULL,
    bought_in ENUM('game', 'catalog', '') DEFAULT '',
    
    -- Common Fields
    category VARCHAR(50) NULL,
    amount INT NOT NULL DEFAULT 0,
    date DATE NOT NULL,
    notes TEXT NULL,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- GAME SCORES TABLE (for Mini Game)
-- =============================================
CREATE TABLE IF NOT EXISTS game_scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    score INT NOT NULL DEFAULT 0,
    time_seconds INT NOT NULL DEFAULT 0,
    level_reached INT NOT NULL DEFAULT 1,
    played_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- LEADERBOARD TABLE (for Mini Game Rankings)
-- =============================================
CREATE TABLE IF NOT EXISTS leaderboard (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    score INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- INDEXES FOR BETTER PERFORMANCE
-- =============================================
CREATE INDEX idx_transactions_user ON transactions(user_id);
CREATE INDEX idx_transactions_type ON transactions(type);
CREATE INDEX idx_transactions_date ON transactions(date);
CREATE INDEX idx_game_scores_user ON game_scores(user_id);
CREATE INDEX idx_game_scores_score ON game_scores(score DESC);
CREATE INDEX idx_leaderboard_score ON leaderboard(score ASC);

-- =============================================
-- SAMPLE DATA (Optional - Comment out if not needed)
-- =============================================

-- Sample User (password: 12345678)
-- INSERT INTO users (username, password, robux_balance) VALUES 
-- ('testuser', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1000);

-- =============================================
-- END OF SETUP
-- =============================================
