CREATE DATABASE z9 CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE z9;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE COLLATE utf8_polish_ci NOT NULL,
    password VARCHAR(255) COLLATE utf8_polish_ci NOT NULL,
    image MEDIUMBLOB
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) COLLATE utf8_polish_ci NOT NULL,
    content TEXT COLLATE utf8_polish_ci NOT NULL,
    file VARCHAR(255) COLLATE utf8_polish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `users` (`id`, `username`, `password`, `image`) VALUES
(1, 'user1', 'pass1', null),
(2, 'user2', 'pass2', null);
