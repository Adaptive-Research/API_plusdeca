
use PlusDeCA ;
drop table if exists Jobs ;
CREATE TABLE IF NOT EXISTS Jobs (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  iscurrent INT,
  NomJob  VARCHAR(50),
  Status INT,
  InfoSup VARCHAR(300),
  Author INT(11),
  date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;


use PlusDeCA ;
drop table if exists JoursFeries  ;
CREATE TABLE IF NOT EXISTS JoursFeries(
  id INT(11) NOT NULL AUTO_INCREMENT,
  iscurrent INT,                          # 1 si oui, 0 si non

  CalendrierJoursFeries VARCHAR(30),			# France, ....
  Sdate VARCHAR(10),  										# dd/mm/yyyy 14/07/2018
  Motif VARCHAR(50),											# paques, fête du travail

  author INT(11),                         # author contient l id de la table users
  date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY(id))  ;



drop table if exists Crontab ;
CREATE TABLE IF NOT EXISTS Crontab (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  iscurrent INT,

  Jour varchar(10) NOT NULL,
  Heure TIME NOT NULL,
  idRSS INT(11) NOT NULL,

  Author INT(11),
  date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;
