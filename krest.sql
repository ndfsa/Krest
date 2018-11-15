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
    password VARCHAR(200) NOT NULL UNIQUE,
    type VARCHAR(100) NOT NULL,
    birth DATE NOT NULL
);

DROP TABLE IF EXISTS adds;
CREATE TABLE adds(
    id_adds INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_content INT NOT NULL,
    FOREIGN KEY(id_user) REFERENCES user(id_user) ON DELETE CASCADE,
    FOREIGN KEY(id_content) REFERENCES content(id_content) ON DELETE CASCADE
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

DROP PROCEDURE IF EXISTS ins_content;
DELIMITER //
CREATE PROCEDURE ins_content(title VARCHAR(100), url VARCHAR(100),
state VARCHAR(100), description VARCHAR(100), id_user INT)
BEGIN
  DECLARE aux_id INT DEFAULT 0;
  DECLARE exit handler for sqlexception
      BEGIN
      ROLLBACK;
   END;
  START TRANSACTION;
    SET autocommit = 0;
    INSERT INTO content VALUES (NULL, title, url, state, description);
    SELECT id_content INTO aux_id FROM content c WHERE c.title = title AND
      c.url = url AND c.state = state AND c.description = description
      ORDER BY c.id_content DESC LIMIT 1;
    INSERT INTO adds VALUES(NULL, id_user, aux_id);
  COMMIT;
END //
DELIMITER ;
