/* Добавление типов контента*/
INSERT INTO content_types (title, icon_class_name)
VALUES
    ('Текст', 'text'),
    ('Цитата', 'quote'),
    ('Картинка', 'photo'),
    ('Видео', 'video'),
    ('Ссылка', 'link');

/* Добавление пользователей*/
INSERT INTO users (email, login, password)
VALUES
    ('name_email1@gmail.com', 'user_login1', 'user_password1'),
    ('name_email2@gmail.com', 'user_login2', 'user_password2'),
    ('name_email3@gmail.com', 'user_login3', 'user_password3'),
    ('name_email4@gmail.com', 'user_login4', 'user_password4'),
    ('name_email5@gmail.com', 'user_login5', 'user_password5');

/* Добавление существующих постов */
INSERT INTO posts (title, content, quote_author, image, user_id, content_type_id)
VALUES
    ('Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих', 'Лариса', 'userpic-larisa-small.jpg', 1, 2),
    ('Игра престолов', 'Не могу дождаться начала финального сезона своего любимого сериала!', 'Владик', 'userpic.jpg', 1, 1),
    ('Наконец, обработал фотки!', 'rock-medium.jpg', 'Виктор', 'userpic-mark.jpg', 1, 3),
    ('Моя мечта', 'coast-medium.jpg', 'Лариса', 'userpic-mark.jpg', 2, 3),
    ('Лучшие курсы', 'www.htmlacademy.rug', 'Владик', 'userpic.jpg', 2, 5);

/* Добавление комментариев к постам */
INSERT INTO comments (content, user_id, post_id)
VALUES
    ('Комментарий1 к цитате', 1, 1),
    ('Комментарий2 к цитате', 2, 1),
    ('Комментарий1 к игре престолов', 1, 2),
    ('Комментарий2 к игре престолов', 2, 2),
    ('Комментарий1 к обработке фото', 1, 3),
    ('Комментарий2 к обработке фото', 2, 3),
    ('Комментарий1 к мечте', 1, 4),
    ('Комментарий2 к мечте', 2, 4),
    ('Комментарий1 к лучшим курсам', 1, 4),
    ('Комментарий2 к лучшим курсам', 2, 4);

/* Добавить лайк к посту */
INSERT INTO likes (user_id, post_id)
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
INSERT INTO subscriptions (author_user_id, subscription_user_id)
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
FROM posts AS p
WHERE p.user_id = 1

/* Получить список комментариев для одного поста (1), в комментариях должен быть логин пользователя */
SELECT  c.date_create AS comment_date,
        c.content AS comment,
        u.login AS user_login
FROM comments AS c
INNER JOIN users AS u ON c.user_id = u.id
WHERE c.post_id = 1





