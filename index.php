<?php
require_once "helpers.php";

date_default_timezone_set('Asia/Yekaterinburg');

/** @var $is_auth integer случайное число из диапазона от 0 до 1 для показа головной навигации */
$is_auth = rand(0, 1);

/** @var $user_name имя пользователя (свое) */
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
 * @param $strTextSource string исходный текст
 * @param int $postCharacterLimit число символов, до которых надо обрезать текст. Значение по умолчанию: 300
 *
 * @return string текствовое содержимое поста
 */
function trimPostByCharacterLimit($strTextSource, $postCharacterLimit = 300)
{
    /** @var $countCharacters integer количество символов для сравнения с лимитом на длину текста */
    $countCharacters = 0;

    /** @var $stringWordsTarget array массив для слов целевого текста */
    $stringWordsTarget = array();

    if(empty($strTextSource))
    {
        return "";
    }

    /** @var $strTextSource string текст для поста после замены всех пробельных символов на один пробельный символ */
    $strTextSource = trim(preg_replace('[\s+]', ' ', $strTextSource));

    if (mb_strlen($strTextSource) == 1 && $strTextSource == " ")
    {
        return "";
    }

    if (mb_strlen($strTextSource) > $postCharacterLimit)
    {

        /** @var $stringWordsSource array массив строк, разделенных пробелом  */
        $stringWordsSource = explode(" ", $strTextSource);

        /** @var $stringWordsSourceLength integer количество элементов в массиве */
        $stringWordsSourceLength = count($stringWordsSource);

        for($i = 0; $i < $stringWordsSourceLength; $i++)
        {
            $countCharacters += mb_strlen($stringWordsSource[$i]);

            if ($countCharacters > $postCharacterLimit)
            {
                break;
            }

            $stringWordsTarget[] = $stringWordsSource[$i];

            $countCharacters++;
        }

        /** @var $strTextTarget string итоговый вариант текста для поста */
        $strTextTarget = implode(" ", $stringWordsTarget);

        return "<p>$strTextTarget...</p><a class=\"post-text__more-link\" href=\"#\">Читать далее</a>";
    }

    return "<p>$strTextSource</p>";
}

/** @var $post_card array результат запроса постов в виде ассоциативного массива */
$post_card = getData($connection_mysql_server, $list_posts_with_users);

/** @var $post_content_type array результат запроса типов контента в виде ассоциативного массива */
$post_content_type = getData($connection_mysql_server, $list_content_types);

closeConnection($connection_mysql_server);

/** @var $postDates array даты постов */
$postDates = array();

/** @var $currentDate DateTime текущая дата */
$currentDate = date_create(date_format((new DateTime('now')), 'Y-m-d H:i:s'));

for ($i = 0; $i < count($post_card); $i++)
{
    $postDates[$i]['randomDate'] = generate_random_date($i);
    $postDates[$i]['dateDiff'] = (array) date_diff(date_create($postDates[$i]['randomDate']), date_create(date_format($currentDate, 'Y-m-d H:i:s')));
    switch(true)
    {
        case ($postDates[$i]['dateDiff']['y'] > 0 || $postDates[$i]['dateDiff']['m'] > 0):
            $postDates[$i]['dateDiffWords'] = $postDates[$i]['dateDiff']['y'] * 12 + $postDates[$i]['dateDiff']['m'] .' '. get_noun_plural_form($postDates[$i]['dateDiff']['m'], 'месяц', 'месяца', 'месяцев').' назад';
            break;
        case ($postDates[$i]['dateDiff']['d'] >= 7):
            $postDates[$i]['dateDiffWords'] = $postDates[$i]['dateDiff']['d'] / 7 .' '. get_noun_plural_form(($postDates[$i]['dateDiff']['d'] / 7), 'неделя', 'недели', 'недель').' назад';
            break;
        case ($postDates[$i]['dateDiff']['d'] > 0):
            $postDates[$i]['dateDiffWords'] = $postDates[$i]['dateDiff']['d'] .' '. get_noun_plural_form($postDates[$i]['dateDiff']['d'], 'день', 'дня', 'дней').' назад';
            break;
        case ($postDates[$i]['dateDiff']['h'] > 0):
            $postDates[$i]['dateDiffWords'] = $postDates[$i]['dateDiff']['h'] .' '. get_noun_plural_form($postDates[$i]['dateDiff']['h'], 'час', 'часа', 'часов').' назад';
            break;
        case ($postDates[$i]['dateDiff']['i'] > 0):
            $postDates[$i]['dateDiffWords'] = $postDates[$i]['dateDiff']['i'] .' '. get_noun_plural_form($postDates[$i]['dateDiff']['i'], 'минута', 'минуты', 'минут').' назад';
            break;
    }
}

/** @var $page_content string итоговый HTML контент для выводов постов */
$page_content = include_template('main.php', ['post_card' => $post_card, 'postDates' => $postDates, 'post_content_type' => $post_content_type]);

/** @var $layout_content string итоговый HTML контент для страницы компоновки  */
$layout_content = include_template('layout.php', ['pageContent' => $page_content, 'userName' => $user_name, 'titlePage' => 'readme: популярное']);

print($layout_content);

?>
