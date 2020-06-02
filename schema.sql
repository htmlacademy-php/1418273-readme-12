CREATE DATABASE `db_posts` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `db_posts`;

CREATE TABLE `users` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `registration_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `email` VARCHAR(20) NOT NULL,
    `login` VARCHAR(20) NOT NULL,
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

CREATE TABLE `roles` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `title` VARCHAR(20) NOT NULL,
    `user` INT NOT NULL,
    CONSTRAINT `roles_users_fk`
    FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE
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
    `user` INT NOT NULL,
    `content_type` INT NOT NULL,
    `hashtag` INT NOT NULL,
    CONSTRAINT `posts_users_fk`
    FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `posts_content_types_fk`
    FOREIGN KEY (`content_type`) REFERENCES `content_types` (`id`) ON DELETE CASCADE,
    CONSTRAINT `posts_hashtags_fk`
    FOREIGN KEY (`hashtag`) REFERENCES `hashtags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `comments` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `date_create` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `content` TEXT NOT NULL,
    `author` INT NOT NULL,
    `post` INT NOT NULL,
    CONSTRAINT `comments_users_author_fk`
    FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `comments_posts_fk`
    FOREIGN KEY (`post`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `likes` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `user` INT NOT NULL,
    `post` INT NOT NULL,
    CONSTRAINT `likes_users_fk`
    FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `likes_posts_fk`
    FOREIGN KEY (`post`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `subscriptions` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `author` INT NOT NULL,
    `subscription` INT NOT NULL,
    CONSTRAINT `subscriptions_users_author_fk`
    FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `subscriptions_users_subscription_fk`
    FOREIGN KEY (`subscription`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `messages` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `date_create` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `content` TEXT NOT NULL,
    `sender` INT NOT NULL,
    `recipient` INT NOT NULL,
    CONSTRAINT `messages_users_sender_fk`
    FOREIGN KEY (`sender`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `messages_users_recipient_fk`
    FOREIGN KEY (`recipient`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `post_hashtags` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `post` INT NOT NULL,
    `hashtag` INT NOT NULL,
    CONSTRAINT `posthashtags_post_fk`
    FOREIGN KEY (`post`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
    CONSTRAINT `posthashtags_hashtag_fk`
    FOREIGN KEY (`hashtag`) REFERENCES `hashtags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE UNIQUE INDEX `email_user_idx` ON `users` (`email`);
CREATE UNIQUE INDEX `login_user_idx` ON `users` (`login`);
CREATE UNIQUE INDEX `post_title_idx` ON `posts` (`title`);
CREATE UNIQUE INDEX `hashtag_title_idx` ON `hashtags` (`title`);
CREATE UNIQUE INDEX `content_type_title_idx` ON `content_types` (`title`);
CREATE UNIQUE INDEX `role_title_idx` ON `roles` (`title`);
