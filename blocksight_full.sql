-- blocksight_full.sql
CREATE DATABASE IF NOT EXISTS blocksight CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE blocksight;

-- Users (both company users and investor users)
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(200) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('company','investor','admin') NOT NULL DEFAULT 'company',
  picture VARCHAR(255) DEFAULT NULL, -- investor picture path
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Companies (profile)
CREATE TABLE companies (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  company_name VARCHAR(255) NOT NULL,
  registration_number VARCHAR(150),
  description TEXT,
  industry VARCHAR(150),
  location VARCHAR(150),
  annual_revenue DOUBLE DEFAULT 0,
  net_profit DOUBLE DEFAULT 0,
  revenue_growth_yoy DOUBLE DEFAULT 0,
  profit_margin DOUBLE DEFAULT 0,
  current_ratio DOUBLE DEFAULT 0,
  debt_equity_ratio DOUBLE DEFAULT 0,
  cash_balance DOUBLE DEFAULT 0,
  burn_rate_monthly DOUBLE DEFAULT 0,
  runway_months DOUBLE DEFAULT 0,
  documents_count INT DEFAULT 0,
  document_pdf VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Funding requests
CREATE TABLE funding_requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  company_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  amount_requested DOUBLE NOT NULL,
  funding_type ENUM('equity','loan','either') DEFAULT 'equity',
  equity_offer_percent DOUBLE DEFAULT 0,
  loan_term_months INT DEFAULT NULL,
  loan_interest_rate DOUBLE DEFAULT NULL,
  status ENUM('open','in_negotiation','closed','rejected') DEFAULT 'open',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
);

-- Investments (offers)
CREATE TABLE investments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  funding_request_id INT NOT NULL,
  investor_id INT NOT NULL,
  company_id INT NOT NULL,
  amount DOUBLE NOT NULL,
  type ENUM('equity','loan') NOT NULL,
  terms TEXT,
  status ENUM('pending','confirmed','rejected') DEFAULT 'pending',
  blockchain_tx_hash VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (funding_request_id) REFERENCES funding_requests(id) ON DELETE CASCADE,
  FOREIGN KEY (investor_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
);

-- Basic metrics table that stores the ML-built success_rate_pct (optional)
CREATE TABLE company_metrics (
  company_id INT PRIMARY KEY,
  success_count INT DEFAULT 0,
  failure_count INT DEFAULT 0,
  success_rate_pct DOUBLE DEFAULT NULL,
  last_updated TIMESTAMP NULL,
  FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS `meeting_requests` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `company_user_id` int NOT NULL,
  `investor_user_id` int NOT NULL,
  `meet_time` datetime DEFAULT NULL,
  `message` text,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `meet_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`company_user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`investor_user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;