DROP DATABASE IF EXISTS yeti_cave;
CREATE DATABASE yeti_cave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;
USE yeti_cave;
CREATE TABLE categories (
   id INT AUTO_INCREMENT PRIMARY KEY,
   character_code VARCHAR(128) UNIQUE,
   name_category VARCHAR(128) NOT NULL
);
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(128) NOT NULL UNIQUE,
    user_name VARCHAR(128),
    user_password CHAR(255),
    contacts TEXT
);
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(128) UNIQUE
);
CREATE TABLE lots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    lot_name VARCHAR(255) NOT NULL,
    lot_description TEXT,
    image VARCHAR(255),
    start_price INT,
    data_finish TIMESTAMP,
    step INT,
    user_id INT,
    winner_id INT,
    category_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (winner_id) REFERENCES users(id),
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FULLTEXT (lot_name, lot_description)
);
CREATE TABLE bets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_bet TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    price_bet INT,
    user_id INT,
    lot_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (lot_id) REFERENCES lots(id)
);

CREATE FULLTEXT INDEX lot_ft_search ON lots(lot_name, lot_description);
