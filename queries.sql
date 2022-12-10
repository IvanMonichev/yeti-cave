USE yeti_cave;
/* Добавление списка категорий */
INSERT INTO categories (name_category, character_code)
VALUES
    ('boards', 'Доски и лыжи'),
    ('attachment', 'Крепления'),
    ('boots', 'Ботинки'),
    ('clothing', 'Одежда'),
    ('tools', 'Инструменты'),
    ('other', 'Разное');
/* Добавление пользователей */
INSERT INTO users (email, user_name, user_password, contacts)
VALUE
    ('risen15@yandex.ru', 'Иван', '456852', '+79187559982'),
    ('alex-ys@yandex.ru', 'Алексей', '1234567', '+79181273212');
/* Добавление объявления */
INSERT INTO lots
    (lot_name, lot_description, image, start_price, data_finish, step, user_id, category_id)
VALUES
    ('2014 Rossignol District Snowboard', 'Легкий маневренный сноуборд, готовый дать жару в любом парке', 'img/lot-1.jpg', 10999, '2023-01-20', 500, 1, 1),
    ('DC Ply Mens 2016/2017 Snowboard', 'Легкий маневренный сноуборд, готовый дать жару в любом парке', 'img/lot-2.jpg', 159999, '2023-01-02', 1000, 2, 1),
    ('Крепления Union Contact Pro 2015 года размер L/XL', 'Хорошие крепления, надежные и легкие', 'img/lot-3.jpg', 8000, '2023-01-10', 500, 2, 2),
    ('Ботинки для сноуборда DC Mutiny Charocal', 'Теплые и красивые ботинки', 'img/lot-4.jpg', 10999, '2023-01-05', 600, 1, 3),
    ('Куртка для сноуборда DC Mutiny Charocal', 'Легкая, теплая и прочная куртка', 'img/lot-5.jpg', 7500, '2022-12-31', 500, 1, 4),
    ('Маска Oakley Canopy', 'Желтые очки, все будет веселенькое', 'img/lot-6.jpg', 5400, '2022-12-25', 100, 1, 6);

DELETE FROM lots WHERE 1 = 1;

/*Получаем все категории*/
SELECT character_code AS 'Категории' FROM categories;


/*--Получаем открытые лоты, в каждом получаем название, стартовую цену, ссылку на изображение, название категории*/
SELECT lots.lot_name, lots.start_price, lots.image, categories.character_code
FROM lots JOIN categories ON lots.category_id=categories.id;

/*--Показываем лот по его ID и получаем название категории, к которой принадлежит лот*/
SELECT lots.id, lots.data_creation, lots.lot_name, lots.lot_description, lots.image, lots.start_price, lots.data_finish, lots.step, categories.character_code
FROM lots JOIN categories ON lots.category_id=categories.id
WHERE lots.id=4;

/*--Обновляем название лота по его идентификатору*/
UPDATE lots
SET lot_name='Ботинки для сноуборда обычные'
WHERE id=4;

/*--Получаем список ставок для лота по его идентификатору с сортировкой по дате, начиная с самой последней*/
SELECT bets.date_bet, bets.price_bet, lots.lot_name, users.user_name
FROM bets
         JOIN lots ON bets.lot_id=lots.id
         JOIN users ON bets.user_id=users.id
WHERE lots.id=4
ORDER BY bets.date_bet DESC;