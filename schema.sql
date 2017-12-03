CREATE DATABASE doingsdone;
USE doingsdone;

CREATE TABLE projects (
	id INT AUTO_INCREMENT PRIMARY KEY,
	project_name CHAR(128),

	user_name CHAR(128)
);
CREATE TABLE tasks (
	id INT AUTO_INCREMENT PRIMARY KEY,
	task CHAR(128) NOT NULL,
	date_start DATE,
	date_finish DATE,
	date_deadline DATE,
	file_link CHAR(128),

	project_name CHAR(128),
	user_name CHAR(128)
);
CREATE TABLE users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	user_name CHAR(128),
	password CHAR(128) NOT NULL,
	email CHAR(128) NOT NULL,
	date_registration DATE,
	contacts_data CHAR(128)
);

CREATE UNIQUE INDEX user_name ON users(user_name);
CREATE UNIQUE INDEX email ON users(email);

CREATE INDEX name_index ON users(user_name);