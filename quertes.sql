/* Добавление типов контента*/
INSERT content_types (title, icon_class_name)
VALUES
    ('Текст', 'text'),
    ('Цитата', 'quote'),
    ('Картинка', 'photo'),
    ('Видео', 'video'),
    ('Ссылка', 'link');

/* Добавление пользователей*/
INSERT users (registration_date, email, login, password)
VALUES
    (now(), 'name_email1@gmail.com', 'user_login1', 'user_password1'),
    (now(), 'name_email2@gmail.com', 'user_login2', 'user_password2'),
    (now(), 'name_email3@gmail.com', 'user_login3', 'user_password3'),
    (now(), 'name_email4@gmail.com', 'user_login4', 'user_password4'),
    (now(), 'name_email5@gmail.com', 'user_login5', 'user_password5');

/* Добавление существующих постов */
INSERT posts (date_create, title, content, quote_author, image, user_id, content_type_id)
VALUES
    (now(), 'Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих', 'Лариса', 'userpic-larisa-small.jpg', 1, 2),
    (now(), 'Игра престолов', 'Не могу дождаться начала финального сезона своего любимого сериала!', 'Владик', 'userpic.jpg', 1, 1),
    (now(), 'Наконец, обработал фотки!', 'rock-medium.jpg', 'Виктор', 'userpic-mark.jpg', 1, 3),
    (now(), 'Моя мечта', 'coast-medium.jpg', 'Лариса', 'userpic-mark.jpg', 2, 3),
    (now(), 'Лучшие курсы', 'www.htmlacademy.rug', 'Владик', 'userpic.jpg', 2, 5);

/* Добавление комментариев к постам */
INSERT comments (date_create, content, user_id, post_id)
VALUES
    (now(), 'Комментарий1 к цитате', 1, 1),
    (now(), 'Комментарий2 к цитате', 2, 1),
    (now(), 'Комментарий1 к игре престолов', 1, 2),
    (now(), 'Комментарий2 к игре престолов', 2, 2),
    (now(), 'Комментарий1 к обработке фото', 1, 3),
    (now(), 'Комментарий2 к обработке фото', 2, 3),
    (now(), 'Комментарий1 к мечте', 1, 4),
    (now(), 'Комментарий2 к мечте', 2, 4),
    (now(), 'Комментарий1 к лучшим курсам', 1, 4),
    (now(), 'Комментарий2 к лучшим курсам', 2, 4);

/* Добавить лайк к посту */
INSERT likes (user_id, post_id)
VALUES
    (3, 1),
    (4, 1),
    (5, 1),
    (3, 2),
    (4, 2),
    (3, 3),
    (5, 4),
    (3, 5);


/* подписаться на пользователя */
INSERT subscriptions (author_user_id, subscription_user_id)
VALUES
    (3, 1),
    (3, 2),
    (4, 1),
    (4, 2),
    (5, 1),
    (5, 2);

/* Получить список постов с сортировкой по популярности и вместе с именами авторов и типом контента */
SELECT  p.date_create,
        p.title,
        p.content,
        p.quote_author,
        p.image,
        p.video,
        p.site,
        p.number_views
        ct.title AS content_type_name,
        u.login AS user_login,
        l.number_likes
FROM posts AS p
INNER JOIN content_types AS ct ON p.content_type_id = ct.id
INNER JOIN users AS u ON p.user_id = u.id
LEFT JOIN (
	SELECT post_id, COUNT(*) AS number_likes
	FROM likes
	GROUP BY post_id
) AS l ON p.id = l.post_id
ORDER BY l.number_likes DESC, p.id ASC

/* Получить список постов для конкретного пользователя */
SELECT  p.date_create,
        p.title,
        p.content,
        p.quote_author,
        p.image,
        p.video,
        p.site,
        p.number_views
        u.login AS user_login
FROM posts AS p
INNER JOIN users AS u ON p.user_id = u.id
WHERE u.id = 1

SELECT  p.date_create,
        p.title,
        p.content,
        p.quote_author,
        p.image,
        p.video,
        p.site,
        p.number_views
        u.login AS user_login
FROM posts AS p
INNER JOIN users AS u ON p.user_id = u.id
WHERE u.id = 2

/* Получить список комментариев для одного поста (1), в комментариях должен быть логин пользователя */
SELECT  p.date_create,
        p.title,
        p.content,
        p.quote_author,
        p.image,
        p.video,
        p.site,
        p.number_views
        c.date_create AS comment_date,
        c.content AS `comment`,
        u.login AS user_login
FROM comments AS c
INNER JOIN posts AS p ON c.post_id = p.id
INNER JOIN users AS u ON c.user_id = u.id
WHERE p.id = 1





