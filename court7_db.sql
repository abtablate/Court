-- Table for supplies
CREATE TABLE IF NOT EXISTS supplies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    quantity INT NOT NULL,
    category VARCHAR(50),
    date_added DATE NOT NULL
);
-- Table for debts (utang)
CREATE TABLE IF NOT EXISTS debts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    debt_date DATE NOT NULL,
    description VARCHAR(255)
);
-- Court7 Database Schema

CREATE DATABASE IF NOT EXISTS court7;
USE court7;

-- Table for courts
CREATE TABLE IF NOT EXISTS courts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50) NOT NULL
);

-- Table for reservations
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    revenue DECIMAL(10,2) DEFAULT 0.00,
    court_id INT,
    FOREIGN KEY (court_id) REFERENCES courts(id) ON DELETE SET NULL
);

-- Table for users (for login/logout, optional)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Table for reports (example: daily summary)
CREATE TABLE IF NOT EXISTS reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    report_date DATE NOT NULL,
    total_bookings INT DEFAULT 0,
    total_sales DECIMAL(10,2) DEFAULT 0.00
);
