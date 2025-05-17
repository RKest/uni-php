CREATE DATABASE z8 CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE z8;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE COLLATE utf8_polish_ci NOT NULL,
    password VARCHAR(255) COLLATE utf8_polish_ci NOT NULL,
    image MEDIUMBLOB
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE logins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uid INT NOT NULL,
    last_login DATETIME NOT NULL,
    state INT NOT NULL,
    FOREIGN KEY (uid) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `users` (`id`, `username`, `password`, `image`) VALUES
(1, 'user1', 'pass1', null),
(2, 'user2', 'pass2', null),
(3, 'admin', 'admin', null);
