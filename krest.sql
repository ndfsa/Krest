DROP DATABASE IF EXISTS krest;
CREATE DATABASE krest;

USE krest;

DROP TABLE IF EXISTS content;
CREATE TABLE content
(
  id_content  INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title       VARCHAR(100),
  url         VARCHAR(100),
  state       VARCHAR(100),
  ext         VARCHAR(20),
  dateOf      DATE,
  description TEXT
);

DROP TABLE IF EXISTS user;
CREATE TABLE user
(
  id_user  INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name     VARCHAR(100),
  surname  VARCHAR(100),
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(200) NOT NULL UNIQUE,
  type     VARCHAR(100) NOT NULL,
  birth    DATE         NOT NULL
);

DROP TABLE IF EXISTS adds;
CREATE TABLE adds
(
  id_adds    INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_user    INT NOT NULL,
  id_content INT NOT NULL,
  FOREIGN KEY (id_user) REFERENCES user (id_user)
    ON DELETE CASCADE,
  FOREIGN KEY (id_content) REFERENCES content (id_content)
    ON DELETE CASCADE
);

DROP TABLE IF EXISTS logs;
CREATE TABLE logs
(
  id_log          INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  id_content      INT NOT NULL,
  title_old       VARCHAR(100),
  url_old         VARCHAR(100),
  state_old       VARCHAR(100),
  ext_old         VARCHAR(20),
  description_old TEXT,
  title_new       VARCHAR(100),
  url_new         VARCHAR(100),
  state_new       VARCHAR(100),
  ext_new         VARCHAR(20),
  description_new TEXT
);

DROP PROCEDURE IF EXISTS ins_content;
DELIMITER //
CREATE PROCEDURE ins_content(title VARCHAR(100), url VARCHAR(100),
                             state VARCHAR(100), ext VARCHAR(20), description VARCHAR(100), id_user INT)
BEGIN
  DECLARE aux_id INT DEFAULT 0;
  DECLARE dt DATE;
  DECLARE exit handler for sqlexception
    BEGIN
      ROLLBACK;
    END;
  START TRANSACTION
    ;
    SET autocommit = 0;
    SELECT curdate() INTO dt;
    INSERT INTO content VALUES (NULL, title, url, state, ext, dt, description);
    SELECT id_content INTO aux_id
    FROM content c
    WHERE c.title = title
      AND c.url = url
      AND c.state = state
      AND c.ext = ext
      AND c.description = description
    ORDER BY c.id_content DESC
    LIMIT 1;
    INSERT INTO adds VALUES (NULL, id_user, aux_id);
  COMMIT;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS get_content;
DELIMITER //
CREATE PROCEDURE get_content(str VARCHAR(200))
BEGIN
  SELECT *
  FROM content
  WHERE title LIKE CONCAT('%', str, '%')
     OR description LIKE CONCAT('%', str, '%')
     OR url LIKE CONCAT('%', str, '%')
     OR ext LIKE CONCAT('%', str, '%');
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS get_one;
DELIMITER //
CREATE PROCEDURE get_one(id_content INT)
BEGIN
  SELECT * FROM content c WHERE c.id_content = id_content;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS delete_one;
DELIMITER //
CREATE PROCEDURE delete_one(id INT)
BEGIN
  DELETE FROM content WHERE id_content = id;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS mod_content;
DELIMITER //
CREATE PROCEDURE mod_content(title VARCHAR(100), url VARCHAR(100),
                             state VARCHAR(100), ext VARCHAR(20), description VARCHAR(100), id_content_input INT)
BEGIN
  DECLARE exit handler for sqlexception
    BEGIN
      ROLLBACK;
    END;
  START TRANSACTION
    ;
    UPDATE content c
    SET c.title       = title,
        c.description = description,
        c.url         = url,
        c.ext         = ext,
        c.state       = state
    WHERE c.id_content = id_content_input;
  COMMIT;
END //
DELIMITER ;

DELIMITER //
DROP TRIGGER IF EXISTS log_update;
CREATE TRIGGER log_update
  AFTER UPDATE
  ON content
  FOR EACH ROW
BEGIN
  INSERT INTO logs
  VALUES (NULL,
          NEW.id_content,
          OLD.title,
          OLD.url,
          OLD.state,
          OLD.ext,
          OLD.description,
          NEW.title,
          NEW.url,
          NEW.state,
          NEW.ext,
          NEW.description);
END//
DELIMITER ;

DROP PROCEDURE IF EXISTS get_content_filtered;
DELIMITER //
CREATE PROCEDURE get_content_filtered()
BEGIN
  (SELECT * FROM content c WHERE c.state = 'Urgente') UNION (SELECT * FROM content c WHERE c.state = 'Principal')
  UNION (SELECT * FROM content c WHERE c.state = 'Normal');
END //
DELIMITER ;