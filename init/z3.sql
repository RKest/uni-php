CREATE DATABASE z3 CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE z3;

CREATE TABLE guests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ipaddr VARCHAR(50) UNIQUE NOT NULL,
	browser VARCHAR(255) NOT NULL,
	screen_resolution VARCHAR(50) NOT NULL,
	browser_resolution VARCHAR(50) NOT NULL,
	colors INT NOT NULL,
	cookies_allowed BOOLEAN NOT NULL,
	java_allowed BOOLEAN NOT NULL,
	language VARCHAR(50) NOT NULL,
    first_login datetime NOT NULL DEFAULT NOW()
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE COLLATE utf8_polish_ci NOT NULL,
    password VARCHAR(255) COLLATE utf8_polish_ci NOT NULL,
    image MEDIUMBLOB
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `users` (`id`, `username`, `password`, `image`) VALUES
(1, 'user1', 'pass1', null),
(2, 'user2', 'pass2', null);
