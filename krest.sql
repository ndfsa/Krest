DROP DATABASE IF EXISTS krest;
CREATE DATABASE krest;

USE krest;

DROP TABLE IF EXISTS content;
CREATE TABLE content(
    id_content INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    url VARCHAR(100),
    state VARCHAR(100),
    description TEXT
);

DROP TABLE IF EXISTS user;
CREATE TABLE user(
    id_user INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    surname VARCHAR(100),
    username VARCHAR(100) NOT NULL UNIQUE,
    passhash VARCHAR(200) NOT NULL UNIQUE,
    type VARCHAR(100) NOT NULL,
    birth DATE NOT NULL
);

DROP TABLE IF EXISTS adds;
CREATE TABLE adds(
    id_adds INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_content INT NOT NULL,
    FOREIGN KEY(id_user) REFERENCES user(id_user) ON UPDATE CASCADE,
    FOREIGN KEY(id_content) REFERENCES content(id_content) ON UPDATE CASCADE
);

DROP TABLE IF EXISTS logs;
CREATE TABLE logs(
    id_user INT NOT NULL,
    id_content INT NOT NULL,
    title_old VARCHAR(100),
    url_old VARCHAR(100),
    state_old VARCHAR(100),
    description_old TEXT,
    title_new VARCHAR(100),
    url_new VARCHAR(100),
    state_new VARCHAR(100),
    description_new TEXT
);
