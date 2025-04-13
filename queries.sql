INSERT INTO categories (name, code)
VALUES ('Доски и лыжи', 'boards'),
       ('Крепления', 'attachment'),
       ('Ботинки', 'boots'),
       ('Одежда', 'clothing'),
       ('Инструменты', 'tools'),
       ('Разное', 'other');

INSERT INTO users (email, name, password, contacts)
VALUES ('gonzik@mail.com', 'Gonzik', '1122334', 'Большая Толстая 3В'),
       ('btr@gmail.com', 'Буратино', 'FDsd+_', 'Москва, ш. Энтузиастов'),
       ('narod@narod.ru', 'Test-Test', '123456789012', 'Нидерланды, село Макрелево, улица Казанская 13А, корпус Б'),
       ('chigur@yahoo.com', 'Игорь', 'DsddDS:"', 'Казань'),
       ('czn@yandex.ru', 'Артем', '||||---1q2', 'Нью-Йорк, центральный парк'),
       ('ruki3suki@ruki3suki.com', 'Марсюша', 'sgfd12', 'Болотского 19-32'),
       ('animal@lamina.la', 'Животное', 'DSSSqq+_', 'Киев, Киевская область, РФ'),
       ('qwerty@fgff.ui', 'Оно', 'qqqmmm___', 'Москва, Украина');

INSERT INTO lots (name, description, img, start_price, finish_time, bet_step, user_id, winner_id, category_id)
VALUES ('2014 Rossignol District Snowboard', 'Элитный Сноуборд 2014 года', 'lot-1.jpg', 10999, '2025-05-04 21:19', 50, 2, null, 1),
       ('DC Ply Mens 2016/2017 Snowboard', 'Обычный Сноуборд 2016/2017 года', 'lot-2.jpg', 159999, '2025-05-06', 10, 3, null, 1),
       ('Крепления Union Contact Pro 2015 года размер L/XL', 'Супер крепкие крепления из бумаги', 'lot-3.jpg', 8000, '2025-10-18 19:30', 150, 3, null, 2),
       ('Ботинки для сноуборда DC Mutiny Charocal', 'Теплые шлепанцы для сноуборда', 'lot-4.jpg', 10999, '2025-04-03 21:03', 30, 4, null, 3),
       ('Куртка для сноуборда DC Mutiny Charocal', 'Дорогая шерстяная майка', 'lot-5.jpg', 7500, '2025-05-07 23:43', 15, 5, null, 4),
       ('Маска Oakley Canopy', 'Мемная маска Гая Фокса для low iq', 'lot-6.jpg', 5400, '2025-04-05 19:34', 70, 2, null, 6);

INSERT INTO bets (price, user_id, lot_id)
VALUES (10, 3, 1),
       (111, 5, 6),
       (243, 8, 3),
       (999, 4, 2),
       (1, 7, 5),
       (5, 3, 4),
       (167, 6, 6);

/*Получение всех категорий*/
SELECT * FROM categories;

/*Получение самых новых открытых лотов - название, стартовую цену, ссылку на изображение, название категории*/
SELECT lots.name AS lot_name, start_price, img AS lot_img, categories.name AS category
FROM lots
    INNER JOIN categories ON lots.category_id = categories.id;

/*Получение лота по его ID (2) + название его категори*/
SELECT lots.name AS lot_name, created_at, start_price, finish_time, bet_step, description, img, categories.name
FROM lots
    INNER JOIN categories ON lots.category_id = categories.id
WHERE lots.id = 2;

/*Обновление названия лота по ID (6)*/
UPDATE lots SET name = 'Маска Oakley Canopy 2025'
            WHERE id = 6;

/*Получение списока ставок для лота по его идентификатору (6) с сортировкой по дате*/
SELECT bets.price AS bet_price, users.name AS user
FROM bets
    INNER JOIN lots ON bets.lot_id = lots.id
    INNER JOIN users ON bets.user_id = users.id
WHERE lots.id = 6
ORDER BY date DESC;
