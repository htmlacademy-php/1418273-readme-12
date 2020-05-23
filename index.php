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

$page_content = include_template('main.php', ['post_card' => $post_card]);

$layout_content = include_template('layout.php', ['pageContent' => $page_content, 'userName' => $user_name, 'titlePage' => 'readme: популярное']);

print($layout_content);


?>
