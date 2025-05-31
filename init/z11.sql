CREATE DATABASE z11 CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE z11;

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

CREATE TABLE animations (
	id INT AUTO_INCREMENT PRIMARY KEY,
	x0 INT NOT NULL,
	y0 INT NOT NULL,
	x_delta INT NOT NULL,
	y_delta INT NOT NULL,
	begin_s INT NOT NULL,
	diameter INT NOT NULL,
	time_s INT NOT NULL,
	color VARCHAR(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `animations` (`x0`, `y0`, `x_delta`, `y_delta`, `begin_s`, `diameter`, `time_s`, `color`) VALUES
(10, 10, 0, 90, 0, 10, 5, 'blue'),
(10, 100, 90, 0, 0, 10, 5, 'blue'),
(100, 100, 0, -90, 0, 10, 5, 'blue'),
(100, 10, -90, 0, 0, 10, 5, 'blue'),
(15, 15, 0, 75, 0, 10, 5, 'green'),
(15, 90, 75, 0, 0, 10, 5, 'green'),
(90, 90, 0, -75, 0, 10, 5, 'green'),
(90, 15, -75, 0, 0, 10, 5, 'green'),
(20, 20, 0, 60, 0, 10, 5, 'red'),
(20, 80, 60, 0, 0, 10, 5, 'red'),
(80, 80, 0, -60, 0, 10, 5, 'red'),
(80, 20, -60, 0, 0, 10, 5, 'red'),
(25, 25, 0, 45, 0, 10, 5, 'yellow'),
(25, 70, 45, 0, 0, 10, 5, 'yellow'),
(70, 70, 0, -45, 0, 10, 5, 'yellow'),
(70, 25, -45, 0, 0, 10, 5, 'yellow');
