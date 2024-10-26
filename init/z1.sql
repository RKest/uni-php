CREATE TABLE `users` (
	`id` smallint(6) NOT NULL,
	`username` varchar(128) COLLATE utf8_polish_ci NOT NULL,
	`password` varchar(128) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

ALTER TABLE `users` ADD PRIMARY KEY (`id`);
ALTER TABLE `users` MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'user1', 'pass1'),
(2, 'user2', 'pass2');
