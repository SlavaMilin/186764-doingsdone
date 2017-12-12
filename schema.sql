CREATE DATABASE doingsdone COLLATE utf8_general_ci;
USE doingsdone;

CREATE TABLE IF NOT EXISTS projects (
	project_id INT AUTO_INCREMENT PRIMARY KEY,
	project_name VARCHAR(128),
	user_id INT
)ENGINE = INNODB CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS tasks (
	task_id INT AUTO_INCREMENT PRIMARY KEY,
	task VARCHAR(128) NOT NULL,
	date_start DATETIME,
	date_finish DATETIME,
	date_deadline DATETIME,
	file_link VARCHAR(128),
	user_id INT,
	project_id INT NOT NULL
) ENGINE = INNODB CHARACTER SET=utf8;

CREATE TABLE IF NOT EXISTS users (
	user_id INT AUTO_INCREMENT PRIMARY KEY,
	user_name VARCHAR(128),
	password CHAR(128) NOT NULL,
	email VARCHAR(128) NOT NULL,
	date_registration DATETIME,
	contacts_data VARCHAR(128)
) ENGINE = INNODB CHARACTER SET = utf8;

CREATE UNIQUE INDEX email ON users(email);

CREATE INDEX name_index ON users(user_name);