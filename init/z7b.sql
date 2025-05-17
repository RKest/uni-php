CREATE DATABASE z7b CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE z7b;

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

CREATE TABLE measurements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    x1 FLOAT NOT NULL,
    x2 FLOAT NOT NULL,
    x3 FLOAT NOT NULL,
    x4 FLOAT NOT NULL,
    x5 FLOAT NOT NULL,
    datetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `measurements` (`x1`, `x2`, `x3`, `x4`, `x5`) VALUES
(1.0, 2.0, 3.0, 4.0, 5.0);
