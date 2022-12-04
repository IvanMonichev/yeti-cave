USE yeti_cave;
/* Добавление списка категорий */
INSERT INTO categories (name_category, character_code) VALUES ('Доски и лыжи', 'boards');
INSERT INTO categories (name_category, character_code) VALUES ('Крепления', 'tools');
INSERT INTO categories (name_category, character_code) VALUES ('Ботинки', 'boots');
INSERT INTO categories (name_category, character_code) VALUES ('Одежда', 'clothing');
INSERT INTO categories (name_category, character_code) VALUES ('Разное', 'other');
/* Добавление пользователей */
INSERT INTO users (email, user_name, user_password, contacts) VALUE ('risen15@yandex.ru', 'Иван', '456852', '+79187559982');
INSERT INTO users (email, user_name, user_password, contacts) VALUE ('alex-ys@yandex.ru', 'Алексей', '1234567', '+79181273212');
/* Добавление объявления */