<?php
require_once "helpers.php";

date_default_timezone_set('Asia/Yekaterinburg');

$is_auth = rand(0, 1);

$user_name = 'Михаил'; // укажите здесь ваше имя

$post_card = [
    [
        'post_title' => 'Цитата',
        'post_type'  => 'post-quote',
        'post_content' => 'Мы в жизни любим только раз, а после ищем лишь похожих',
        'user_name' => 'Лариса',
        'user_avatar' => 'userpic-larisa-small.jpg'
    ],
    [
        'post_title' => 'Игра престолов',
        'post_type'  => 'post-text',
        'post_content' => ' Не могу дождаться начала финального сезона своего любимого сериала!',
        'user_name' => 'Владик',
        'user_avatar' => 'userpic.jpg'
    ],
    [
        'post_title' => 'Наконец, обработал фотки!',
        'post_type'  => 'post-photo',
        'post_content' => 'rock-medium.jpg',
        'user_name' => 'Виктор',
        'user_avatar' => 'userpic-mark.jpg'
    ],
    [
        'post_title' => 'Моя мечта',
        'post_type'  => 'post-photo',
        'post_content' => 'coast-medium.jpg',
        'user_name' => 'Лариса',
        'user_avatar' => 'userpic-larisa-small.jpg'
    ],
    [
        'post_title' => 'Лучшие курсы',
        'post_type'  => 'post-link',
        'post_content' => 'www.htmlacademy.ru',
        'user_name' => 'Владик',
        'user_avatar' => 'userpic.jpg'
    ]
];

function trimPostByCharacterLimit($strTextSource, $postCharacterLimit = 300)
{
    $countCharacters = 0; // количество символов
    $stringWordsTarget = array(); // массив для слов целевого текста

    if(empty($strTextSource))
    {
        return "";
    }

    $strTextSource = trim(preg_replace('[\s+]', ' ', $strTextSource));

    if (mb_strlen($strTextSource) == 1 && $strTextSource == " ")
    {
        return "";
    }

    if (mb_strlen($strTextSource) > $postCharacterLimit)
    {
        $stringWordsSource = explode(" ", $strTextSource);

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

        $strTextTarget = implode(" ", $stringWordsTarget);

        return "<p>$strTextTarget...</p><a class=\"post-text__more-link\" href=\"#\">Читать далее</a>";
    }

    return "<p>$strTextSource</p>";
}

$postDates = array();

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

$page_content = include_template('main.php', ['post_card' => $post_card, 'postDates' => $postDates]);

$layout_content = include_template('layout.php', ['pageContent' => $page_content, 'userName' => $user_name, 'titlePage' => 'readme: популярное']);

print($layout_content);


?>
