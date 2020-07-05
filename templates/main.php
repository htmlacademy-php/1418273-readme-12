<div class="container">
    <h1 class="page__title page__title--popular">Популярное</h1>
</div>
<div class="popular container">
    <div class="popular__filters-wrapper">
        <div class="popular__sorting sorting">
            <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
            <ul class="popular__sorting-list sorting__list">
                <li class="sorting__item sorting__item--popular">
                    <a class="sorting__link sorting__link--active" href="#">
                        <span>Популярность</span>
                        <svg class="sorting__icon" width="10" height="12">
                            <use xlink:href="#icon-sort"></use>
                        </svg>
                    </a>
                </li>
                <li class="sorting__item">
                    <a class="sorting__link" href="#">
                        <span>Лайки</span>
                        <svg class="sorting__icon" width="10" height="12">
                            <use xlink:href="#icon-sort"></use>
                        </svg>
                    </a>
                </li>
                <li class="sorting__item">
                    <a class="sorting__link" href="#">
                        <span>Дата</span>
                        <svg class="sorting__icon" width="10" height="12">
                            <use xlink:href="#icon-sort"></use>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
        <div class="popular__filters filters">
            <b class="popular__filters-caption filters__caption">Тип контента:</b>
            <ul class="popular__filters-list filters__list">
                <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                    <a class="filters__button filters__button--ellipse filters__button--all filters__button--active" href="#">
                        <span>Все</span>
                    </a>
                </li>
                <?php foreach($post_content_type as $val): ?>
                    <?php
                        $title_content_type = strip_tags($val['title']);
                        $class_name_content_type = strip_tags($val['icon_class_name']);
                    ?>
                    <li class="popular__filters-item filters__item">
                    <?php switch($class_name_content_type):
                        case 'photo': ?>
                                <a class="filters__button filters__button--<?=$class_name_content_type ?> button" href="#">
                                    <span class="visually-hidden"><?=$title_content_type ?></span>
                                    <svg class="filters__icon" width="22" height="18">
                                        <use xlink:href="#icon-filter-<?=$class_name_content_type ?>"></use>
                                    </svg>
                                </a>
                            <?php break; ?>
                        <?php case 'video': ?>
                                <a class="filters__button filters__button--<?=$class_name_content_type ?> button" href="#">
                                    <span class="visually-hidden"><?=$title_content_type ?></span>
                                    <svg class="filters__icon" width="24" height="16">
                                        <use xlink:href="#icon-filter-<?=$class_name_content_type ?>"></use>
                                    </svg>
                                </a>
                            <?php break; ?>
                        <?php case 'text': ?>
                                <a class="filters__button filters__button--<?=$class_name_content_type ?> button" href="#">
                                    <span class="visually-hidden"><?=$title_content_type ?></span>
                                    <svg class="filters__icon" width="20" height="21">
                                        <use xlink:href="#icon-filter-<?=$class_name_content_type ?>"></use>
                                    </svg>
                                </a>
                            <?php break; ?>
                        <?php case 'quote': ?>
                                <a class="filters__button filters__button--<?=$class_name_content_type ?> button" href="#">
                                    <span class="visually-hidden"><?=$title_content_type ?></span>
                                    <svg class="filters__icon" width="21" height="20">
                                        <use xlink:href="#icon-filter-<?=$class_name_content_type ?>"></use>
                                    </svg>
                                </a>
                            <?php break; ?>
                        <?php case 'link': ?>
                                <a class="filters__button filters__button--<?=$class_name_content_type ?> button" href="#">
                                    <span class="visually-hidden"><?=$title_content_type ?></span>
                                    <svg class="filters__icon" width="21" height="18">
                                        <use xlink:href="#icon-filter-<?=$class_name_content_type ?>"></use>
                                    </svg>
                                </a>
                            <?php break; ?>
                    <?php endswitch; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="popular__posts">
        <?php foreach($post_card as $key => $val ): ?>
            <?php
                $post_title = strip_tags($val['title']);
                $post_type = strip_tags($val['icon_class_name']);
                $post_content = htmlspecialchars($val['content']);
                $post_quote_author = strip_tags($val['quote_author']);
                $post_image = strip_tags($val['image']);
                $post_video = strip_tags($val['video']);
                $post_site = strip_tags($val['site']);
                $user_name = strip_tags($val['user_login']);
                $user_avatar = strip_tags($val['user_avatar']);
                $post_dates = $postDates[$key];
            ?>
            <article class="popular__post post post-<?=$post_type ?>">
                <header class="post__header">
                    <h2><?=$post_title ?></h2>
                </header>
                <div class="post__main">
                    <!--здесь содержимое карточки-->
                    <?php switch($post_type):
                        case 'quote': ?>
                            <blockquote>
                                <p>
                                    <?=$post_content ?>
                                </p>
                                <cite><?=$post_quote_author?></cite>
                            </blockquote>
                            <?php break; ?>
                        <?php case 'text': ?>
                            <!--содержимое для поста-текста-->
                            <?=trimPostByCharacterLimit($post_content) ?>
                            <?php break; ?>
                        <?php case 'photo': ?>
                            <!--содержимое для поста-фото-->
                            <div class="post-photo__image-wrapper">
                                <img src="img/<?=$post_image ?>" alt="Фото от пользователя" width="360" height="240">
                            </div>
                            <?php break; ?>
                        <?php case 'link': ?>
                            <!--содержимое для поста-ссылки-->
                            <div class="post-link__wrapper">
                                <a class="post-link__external" href="http://" title="Перейти по ссылке">
                                    <div class="post-link__info-wrapper">
                                        <div class="post-link__icon-wrapper">
                                            <img src="https://www.google.com/s2/favicons?domain=vitadental.ru" alt="Иконка">
                                        </div>
                                        <div class="post-link__info">
                                            <h3><?=$post_title ?></h3>
                                        </div>
                                    </div>
                                    <span><?=$post_site ?></span>
                                </a>
                            </div>
                            <?php break; ?>
                        <?php endswitch; ?>
                </div>
                <footer class="post__footer">
                    <div class="post__author">
                        <a class="post__author-link" href="#" title="Автор">
                            <div class="post__avatar-wrapper">
                                <!--укажите путь к файлу аватара-->
                                <img class="post__author-avatar" src="img/<?=$user_avatar ?>" alt="Аватар пользователя">
                            </div>
                            <div class="post__info">
                                <b class="post__author-name"><?=$user_name ?></b>
                                <time title="<?=date_format((new DateTime($post_dates['randomDate'])), 'Y-m-d H:i')?>" class="post__time" datetime="<?=date_format((new DateTime($post_dates['randomDate'])), 'Y-m-d H:i:s')?>">
                                    <?=$post_dates['dateDiffWords'] ?>
                                </time>
                            </div>
                        </a>
                    </div>
                    <div class="post__indicators">
                        <div class="post__buttons">
                            <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                                <svg class="post__indicator-icon" width="20" height="17">
                                    <use xlink:href="#icon-heart"></use>
                                </svg>
                                <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                                    <use xlink:href="#icon-heart-active"></use>
                                </svg>
                                <span>0</span>
                                <span class="visually-hidden">количество лайков</span>
                            </a>
                            <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                                <svg class="post__indicator-icon" width="19" height="17">
                                    <use xlink:href="#icon-comment"></use>
                                </svg>
                                <span>0</span>
                                <span class="visually-hidden">количество комментариев</span>
                            </a>
                        </div>
                    </div>
                </footer>
            </article>
        <?php endforeach; ?>
    </div>
</div>
