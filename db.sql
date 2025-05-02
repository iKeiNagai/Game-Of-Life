DROP DATABASE IF EXISTS lifegame;
CREATE DATABASE lifegame;

USE lifegame;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'user'
);

CREATE TABLE game_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pattern_name VARCHAR(100),
    status ENUM('died', 'succeeded'),
    generation_count INT,
    created_at VARCHAR(30),
    ended_at VARCHAR(30),
    user_id INT,
    FOREIGN KEY(user_id) REFERENCES users(id)
);
