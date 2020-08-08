/* Добавление типов контента*/
INSERT INTO content_types (title, icon_class_name)
VALUES
    ('Текст', 'text'),
    ('Цитата', 'quote'),
    ('Фото', 'photo'),
    ('Видео', 'video'),
    ('Ссылка', 'link');

/* Добавление пользователей*/
INSERT INTO users (email, login, password, avatar)
VALUES
    ('name_email1@gmail.com', 'Лариса', 'user_password1', 'userpic-larisa-small.jpg'),
    ('name_email2@gmail.com', 'Владик', 'user_password2', 'userpic.jpg'),
    ('name_email3@gmail.com', 'Виктор', 'user_password3', 'userpic-mark.jpg');

/* Добавление существующих постов */
INSERT INTO posts (title, content, quote_author, image, site, number_views, user_id, content_type_id)
VALUES
    ('Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих', 'Неизвестный автор', NULL, NULL, 7, 1, 2),
    ('Игра престолов', 'Не могу дождаться начала финального сезона своего любимого сериала!', NULL, NULL, NULL, 5, 2, 1),
    ('Наконец, обработал фотки!', NULL, NULL, 'rock-medium.jpg', NULL, 2, 3, 3),
    ('Моя мечта', NULL, NULL, 'coast-medium.jpg', NULL, 9, 1, 3),
    ('Лучшие курсы', 'Лучшие курсs', NULL, NULL, 'www.htmlacademy.ru', 8, 2, 5);

/* Добавление комментариев к постам */
INSERT INTO comments (content, user_id, post_id)
VALUES
    ('Комментарий1 к цитате', 1, 1),
    ('Комментарий2 к цитате', 2, 1),
    ('Комментарий3 к цитате', 3, 1),
    ('Комментарий1 к игре престолов', 1, 2),
    ('Комментарий2 к игре престолов', 2, 2),
    ('Комментарий2 к игре престолов', 3, 2),
    ('Комментарий1 к обработке фото', 1, 3),
    ('Комментарий2 к обработке фото', 2, 3),
    ('Комментарий3 к обработке фото', 3, 3),
    ('Комментарий1 к мечте', 1, 4),
    ('Комментарий2 к мечте', 2, 4),
    ('Комментарий2 к мечте', 3, 4),
    ('Комментарий1 к лучшим курсам', 1, 5),
    ('Комментарий2 к лучшим курсам', 2, 5),
    ('Комментарий2 к лучшим курсам', 3, 5);

/* Добавить лайк к посту */
INSERT INTO likes (user_id, post_id)
VALUES
    (1, 1),
    (3, 1),
    (2, 1),
    (3, 2),
    (2, 2),
    (1, 3),
    (2, 4),
    (3, 5);


/* подписаться на пользователя */
INSERT INTO subscriptions (author_user_id, subscription_user_id)
VALUES
    (2, 1),
    (1, 2),
    (3, 1),
    (3, 2),
    (1, 3),
    (1, 2);

/* Получить список постов с сортировкой по популярности и вместе с именами авторов и типом контента */
SELECT  p.date_create,
        p.title,
        p.content,
        p.quote_author,
        p.image,
        p.video,
        p.site,
        p.number_views,
        u.login AS user_login
FROM posts AS p
INNER JOIN users AS u ON p.user_id = u.id
ORDER BY p.number_views DESC, p.id ASC

/* Получить список постов для конкретного пользователя */
SELECT  p.date_create,
        p.title,
        p.content,
        p.quote_author,
        p.image,
        p.video,
        p.site,
        p.number_views
FROM posts AS p
WHERE p.user_id = 1

/* Получить список комментариев для одного поста (1), в комментариях должен быть логин пользователя */
SELECT  c.date_create AS comment_date,
        c.content AS comment,
        u.login AS user_login
FROM comments AS c
INNER JOIN users AS u ON c.user_id = u.id
WHERE c.post_id = 1





