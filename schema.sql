CREATE DATABASE doingsdone COLLATE utf8_general_ci;
USE doingsdone;

CREATE TABLE IF NOT EXISTS projects (
	project_id INT AUTO_INCREMENT PRIMARY KEY,
	project_name CHAR(128)
)
  ENGINE = INNODB CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS tasks (
	task_id INT AUTO_INCREMENT PRIMARY KEY,
	task CHAR(128) NOT NULL,
	date_start DATETIME,
	date_finish DATETIME,
	date_deadline DATETIME,
	file_link CHAR(128)
)
  ENGINE = INNODB CHARACTER SET=utf8;

CREATE TABLE IF NOT EXISTS users (
	user_id INT AUTO_INCREMENT PRIMARY KEY,
	user_name CHAR(128),
	password CHAR(128) NOT NULL,
	email CHAR(128) NOT NULL,
	date_registration DATETIME,
	contacts_data CHAR(128)
)
  ENGINE = INNODB CHARACTER SET = utf8;

CREATE UNIQUE INDEX user_name ON users(user_name);
CREATE UNIQUE INDEX email ON users(email);

CREATE INDEX name_index ON users(user_name);