DROP DATABASE IF EXISTS yeti_cave;
CREATE DATABASE yeti_cave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;
USE yeti_cave;
CREATE TABLE category (
   id INT AUTO_INCREMENT PRIMARY KEY,
   name_category VARCHAR(128) NOT NULL,
   character_code VARCHAR(128) UNIQUE
);
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(128) NOT NULL UNIQUE,
    user_name VARCHAR(128),
    user_password CHAR(255),
    contacts TEXT
);
CREATE TABLE role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(128) UNIQUE
);
CREATE TABLE lot (
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
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (winner_id) REFERENCES user(id),
    FOREIGN KEY (category_id) REFERENCES category(id)
);
CREATE TABLE bet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_bet TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    price_bet INT,
    user_id INT,
    lot_id INT,
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (lot_id) REFERENCES lot(id)
);