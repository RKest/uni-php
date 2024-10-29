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

