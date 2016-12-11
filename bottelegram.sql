CREATE DATABASE bottelegram;

USE bottelegram;

CREATE TABLE resposta (
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  update_id int(11) NOT NULL,
  nome varchar(30) NOT NULL,
  comando varchar(45) NOT NULL,
  bot_resposta varchar(255) NOT NULL,
  data_resposta datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);
