<?php
require_once "helpers.php";

date_default_timezone_set('Asia/Yekaterinburg');

/** @var $is_auth integer случайное число из диапазона от 0 до 1 для показа головной навигации */
$is_auth = rand(0, 1);

/** @var $user_name string имя пользователя (свое) */
$user_name = 'Михаил'; // укажите здесь ваше имя

/** @var $host string имя хоста (IP адрес) */
$host = 'localhost';

/** @var $database_user string пользователь базы данных */
$database_user = 'root';

/** @var $database_user_password string пароль пользователя базы данных */
$database_user_password = 'root';

/** @var $database_name string наименование базы данных */
$database_name = 'db_posts';

/** @var $list_content_types string запрос получения типов контента постов */
$list_content_types = 'SELECT title, icon_class_name FROM content_types';

/** @var $list_posts_with_users string запрос получения постов с учетом данных пользователей */
$list_posts_with_users = '
SELECT  p.date_create,
        p.title,
        p.content,
        p.quote_author,
        p.image,
        p.video,
        p.site,
        p.number_views,
        ct.icon_class_name,
        u.login AS user_login,
        u.avatar AS user_avatar
FROM posts AS p
INNER JOIN users AS u ON p.user_id = u.id
INNER JOIN content_types AS ct ON p.content_type_id = ct.id
ORDER BY p.number_views DESC, p.id ASC
';

/** @var $connection_mysql_server mysqli объект, представляющий подключение к серверу MySQL */
$connection_mysql_server = new mysqli($host, $database_user, $database_user_password, $database_name);

/**
 * Закрывает ранее открытое соединение с базой данных
 *
 * @param $connection mysqli объект, представляющий подключение к серверу MySQL
 *
 * @return boolean возвращает TRUE в случае успешного завершения или FALSE в случае возникновения ошибки.
 */
function closeConnection($connection): bool
{
    if(isset($connection))
    {
        $connection->close();
        return true;
    }
    else
        return false;
}

/**
 * Получение данных из базы данных
 *
 * @param $connection string соединение с базой данных
 * @param $query string запрос на выборку данных из БД
 *
 * @return array результат запроса в виде ассоциативного массива
 */
function getData($connection, $query): array
{
    if (!isset($connection) && $connection->connect_error) {
        die('Ошибка подключения (' . $connection->connect_errno . ') '
            . $connection->connect_error);
    }

    if(isset($query))
    {
        $query_result = $connection->query($query);
    }

    if (isset($query_result) && $query_result->num_rows > 0) {
        return $query_result->fetch_all(MYSQLI_ASSOC);
    }
}

/**
 * Показ содержимого в карточках текстовых постов
 *
 * @param $str_text_source string исходный текст
 * @param int $post_character_limit число символов, до которых надо обрезать текст. Значение по умолчанию: 300
 *
 * @return string текствовое содержимое поста
 */
function trimPostByCharacterLimit($str_text_source, $post_character_limit = 300)
{
    /** @var $count_characters integer количество символов для сравнения с лимитом на длину текста */
    $count_characters = 0;

    /** @var $string_words_target array массив для слов целевого текста */
    $string_words_target = array();

    if(empty($str_text_source))
    {
        return "";
    }

    /** @var $str_text_source string текст для поста после замены всех пробельных символов на один пробельный символ */
    $str_text_source = trim(preg_replace('[\s+]', ' ', $str_text_source));

    if (mb_strlen($str_text_source) == 1 && $str_text_source == " ")
    {
        return "";
    }

    if (mb_strlen($str_text_source) > $post_character_limit)
    {

        /** @var $string_words_source array массив строк, разделенных пробелом  */
        $string_words_source = explode(" ", $str_text_source);

        /** @var $string_words_source_length integer количество элементов в массиве */
        $string_words_source_length = count($string_words_source);

        for($i = 0; $i < $string_words_source_length; $i++)
        {
            $count_characters += mb_strlen($string_words_source[$i]);

            if ($count_characters > $post_character_limit)
            {
                break;
            }

            $string_words_target[] = $string_words_source[$i];

            $count_characters++;
        }

        /** @var $str_text_target string итоговый вариант текста для поста */
        $str_text_target = implode(" ", $string_words_target);

        return "<p>$str_text_target...</p><a class=\"post-text__more-link\" href=\"#\">Читать далее</a>";
    }

    return "<p>$str_text_source</p>";
}

/** @var $post_card array результат запроса постов в виде ассоциативного массива */
$post_card = getData($connection_mysql_server, $list_posts_with_users);

/** @var $post_content_type array результат запроса типов контента в виде ассоциативного массива */
$post_content_type = getData($connection_mysql_server, $list_content_types);

closeConnection($connection_mysql_server);

/** @var $date_diff array интервалы (количество лет, дней, часов и минут) разницы между датой публикации поста и текущей датой */
$date_diff = array();

/** @var $current_date DateTime текущая дата */
$current_date = date_create(date_format((new DateTime('now')), 'Y-m-d H:i:s'));

for ($i = 0; $i < count($post_card); $i++)
{
    $date_diff = (array) date_diff(date_create($post_card[$i]['date_create']), date_create(date_format($current_date, 'Y-m-d H:i:s')));
    print($date_diff['y']);
    switch(true)
    {
        case ($date_diff['y'] > 0 || $date_diff['m'] > 0):
            $post_card[$i]['date_diff_words'] = $date_diff['y'] * 12 + $date_diff['m'] .' '. get_noun_plural_form($date_diff['m'], 'месяц', 'месяца', 'месяцев').' назад';
            break;
        case ($date_diff['d'] >= 7):
            $post_card[$i]['date_diff_words'] = $date_diff['d'] / 7 .' '. get_noun_plural_form(($date_diff['d'] / 7), 'неделя', 'недели', 'недель').' назад';
            break;
        case ($date_diff['d'] > 0):
            $post_card[$i]['date_diff_words'] = $date_diff['d'] .' '. get_noun_plural_form($date_diff['d'], 'день', 'дня', 'дней').' назад';
            break;
        case ($date_diff['h'] > 0):
            $post_card[$i]['date_diff_words'] = $date_diff['h'] .' '. get_noun_plural_form($date_diff['h'], 'час', 'часа', 'часов').' назад';
            break;
        case ($date_diff['i'] > 0):
            $post_card[$i]['date_diff_words'] = $date_diff['i'] .' '. get_noun_plural_form($date_diff['i'], 'минута', 'минуты', 'минут').' назад';
            break;
    }
}

/** @var $page_content string итоговый HTML контент для выводов постов */
$page_content = include_template('main.php', ['post_card' => $post_card, 'post_content_type' => $post_content_type]);

/** @var $layout_content string итоговый HTML контент для страницы компоновки  */
$layout_content = include_template('layout.php', ['page_content' => $page_content, 'user_name' => $user_name, 'title_page' => 'readme: популярное']);

print($layout_content);

?>
