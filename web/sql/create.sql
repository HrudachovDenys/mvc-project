CREATE DATABASE IF NOT EXISTS `test_db`
      DEFAULT CHARACTER SET utf8
      DEFAULT COLLATE utf8_unicode_ci;

USE `test_db`;

CREATE TABLE `roles`
(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `role` VARCHAR(255) NOT NULL UNIQUE
);

INSERT INTO `roles`(`role`) VALUES
    ("admin"),
    ("unconfirmed"),
    ("user"),
    ("blocked");

CREATE TABLE `countries`
(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `country` VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE `users`
(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL UNIQUE,
    `pass` VARCHAR(255) NOT NULL,
    `salt` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `reg_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `user_profile`
(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `uri_avatar` VARCHAR(255),
    `date_birhday` TIMESTAMP NOT NULL,
    `gender` VARCHAR(20) NOT NULL,
    `firstname` VARCHAR(255),
    `lastname` VARCHAR(255),
    `about_me` VARCHAR(255),
    `country_id` INT UNSIGNED,
    `user_id` INT UNSIGNED,
    FOREIGN KEY (`country_id`) REFERENCES `countries`(`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
);

CREATE TABLE `user_roles`
(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED,
    `role_id` INT UNSIGNED,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
    FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`)
);

CREATE TABLE `tokens`
(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(255) NOT NULL UNIQUE,
    `ip` VARCHAR(255),
    `browser` VARCHAR(255),
    `expiries` TIMESTAMP NOT NULL,
    `user_id` INT UNSIGNED,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
);

CREATE TABLE `confirm_keys`
(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `hash` VARCHAR(255) NOT NULL,
    `expiries` TIMESTAMP,
    `user_id` INT UNSIGNED,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
);



CREATE TABLE `categories`
(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `category` VARCHAR(255) NOT NULL UNIQUE
);

INSERT INTO `categories`(`category`) VALUES
    ("category1"),
    ("category2"),
    ("category3"),
    ("category4");

CREATE TABLE `post_status`
(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `status` VARCHAR(255) NOT NULL UNIQUE
);

INSERT INTO `post_status`(`status`) VALUES
    ("moderation"),
    ("published"),
    ("revision"),
    ("blocked");


CREATE TABLE `posts`
(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `url_title` VARCHAR(255) NOT NULL,
    `text` TEXT NOT NULL,
    `user_id` INT UNSIGNED,
    `date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `category_id` INT UNSIGNED,
    `status_id` INT UNSIGNED,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`),
    FOREIGN KEY (`status_id`) REFERENCES `post_status`(`id`)
); 