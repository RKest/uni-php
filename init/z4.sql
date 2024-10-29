CREATE DATABASE z4 CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE z4;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE COLLATE utf8_polish_ci NOT NULL,
    password VARCHAR(255) COLLATE utf8_polish_ci NOT NULL,
    image MEDIUMBLOB
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE domains (
    id INT AUTO_INCREMENT PRIMARY KEY,
    host VARCHAR(255) UNIQUE NOT NULL,
    port INT NOT NULL
);

INSERT INTO `users` (`id`, `username`, `password`, `image`) VALUES
(1, 'user1', 'pass1', null),
(2, 'user2', 'pass2', null);
