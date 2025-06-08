CREATE DATABASE IF NOT EXISTS z16 CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE z16;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE COLLATE utf8_polish_ci NOT NULL,
    password VARCHAR(255) COLLATE utf8_polish_ci NOT NULL,
    image MEDIUMBLOB,
	user_type ENUM('client', 'employee', 'admin') NOT NULL DEFAULT 'client'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE IF NOT EXISTS logins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uid INT NOT NULL,
    last_login DATETIME NOT NULL,
    state INT NOT NULL,
    FOREIGN KEY (uid) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE IF NOT EXISTS topics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    employee_id INT,
    topic_id INT NOT NULL,
    question_datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    client_question TEXT NOT NULL,
    answer_datetime DATETIME,
    employee_answer TEXT,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    FOREIGN KEY (client_id) REFERENCES users(id),
    FOREIGN KEY (employee_id) REFERENCES users(id),
    FOREIGN KEY (topic_id) REFERENCES topics(id)
);

INSERT IGNORE INTO users (username, password, user_type) VALUES
('klient1', 'pass1', 'client'),
('klient2', 'pass2', 'client'),
('pracownik1', 'pass1', 'employee'),
('pracownik2', 'pass2', 'employee'),
('admin', 'admin', 'admin');

INSERT IGNORE INTO topics (name) VALUES
('Sprzedaż nowych usług'),
('Pomoc techniczna'),
('Rezygnacja z usługi'),
('Inne');
