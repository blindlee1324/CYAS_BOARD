CREATE TABLE Users (
	id BIGINT unsigned NOT NULL,
	screen_id VARCHAR(50) NOT NULL,
	name VARCHAR(50) NOT NULL,
	image VARCHAR(128) NOT NULL,
	profile VARCHAR(160) NOT NULL,
	password VARCHAR(64),
	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Posts ( 
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  content mediumtext,
  created datetime,
  user_id BIGINT unsigned NOT NULL,
  user_screen_id VARCHAR(50) NOT NULL,
  user_name varchar(50) NOT NULL,
  user_image varchar(255) NOT NULL,
  hit int(10) unsigned NOT NULL default '0',  
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES Users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;