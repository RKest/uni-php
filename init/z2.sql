CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE COLLATE utf8_polish_ci NOT NULL,
    password VARCHAR(255) COLLATE utf8_polish_ci NOT NULL,
    image_data MEDIUMBLOB,
    image_type VARCHAR(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `users` (`id`, `username`, `password`, `image_data`, `image_type`) VALUES
(1, 'user1', 'pass1', null, null),
(2, 'user2', 'pass2', null, null);
