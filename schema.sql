CREATE DATABASE `db_posts` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `db_posts`;

CREATE TABLE `users` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `registration_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `login` VARCHAR(50) NOT NULL,
    `password` VARCHAR(50) NOT NULL,
    `avatar` VARCHAR(50) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `hashtags` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `title` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `content_types` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `title` VARCHAR(50) NOT NULL,
    `icon_class_name` VARCHAR(20) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `posts` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `date_create` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `title` VARCHAR(50) NOT NULL,
    `content` TEXT NOT NULL,
    `quote_author` VARCHAR(50) NOT NULL,
    `image` VARCHAR(50) NULL,
    `video` VARCHAR(50) NULL,
    `site` VARCHAR(50) NULL,
    `number_views` INT NULL,
    `user_id` INT NOT NULL,
    `content_type_id` INT NOT NULL,
    CONSTRAINT `posts_users_fk`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `posts_content_types_fk`
    FOREIGN KEY (`content_type_id`) REFERENCES `content_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `comments` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `date_create` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `content` TEXT NOT NULL,
    `user_id` INT NOT NULL,
    `post_id` INT NOT NULL,
    CONSTRAINT `comments_users_author_fk`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `comments_posts_fk`
    FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `likes` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `post_id` INT NOT NULL,
    CONSTRAINT `likes_users_fk`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `likes_posts_fk`
    FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `subscriptions` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `author_user_id` INT NOT NULL,
    `subscription_user_id` INT NOT NULL,
    CONSTRAINT `subscriptions_users_author_fk`
    FOREIGN KEY (`author_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `subscriptions_users_subscription_fk`
    FOREIGN KEY (`subscription_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `messages` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `date_create` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `content` TEXT NOT NULL,
    `sender_user_id` INT NOT NULL,
    `recipient_user_id` INT NOT NULL,
    CONSTRAINT `messages_users_sender_fk`
    FOREIGN KEY (`sender_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `messages_users_recipient_fk`
    FOREIGN KEY (`recipient_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `post_hashtags` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `post_id` INT NOT NULL,
    `hashtag_id` INT NOT NULL,
    CONSTRAINT `posthashtags_post_fk`
    FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
    CONSTRAINT `posthashtags_hashtag_fk`
    FOREIGN KEY (`hashtag_id`) REFERENCES `hashtags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE UNIQUE INDEX `email_user_idx` ON `users` (`email`);
CREATE UNIQUE INDEX `login_user_idx` ON `users` (`login`);
CREATE UNIQUE INDEX `post_title_idx` ON `posts` (`title`);
CREATE UNIQUE INDEX `hashtag_title_idx` ON `hashtags` (`title`);
CREATE UNIQUE INDEX `content_type_title_idx` ON `content_types` (`title`);

