

drop table if exists config ;
CREATE TABLE config (
  id BIGSERIAL  PRIMARY KEY,
  iscurrent smallint DEFAULT 1,
  typeitem varchar(100) NOT NULL,
  parameter varchar(100) NOT NULL,
  item varchar(100) NOT NULL,
  ordre bigint NOT NULL,
  date_save timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP 
) ;

--
-- Déchargement des données de la table `Config`
--

INSERT INTO config (id, typeitem, parameter, item, ordre, date_save) VALUES
(1,  '[Messages]', 'FR', 'Messages', 0, '2019-02-02 08:59:09'),
(2, '[Messages]', 'EN', 'Mails', 0, '2019-02-02 08:59:09'),
(3,  '[Messages]', 'ES', 'Mensages', 0, '2019-02-02 08:59:09'),
(4,  '[Actualités]', 'DE', 'Nachrichten', 0, '2019-02-02 08:59:09');




drop table if exists password_reset_requests ;
CREATE TABLE IF NOT EXISTS password_reset_requests (
  id BIGSERIAL  PRIMARY KEY,
  email varchar(250) NOT NULL,
  token varchar(250) NOT NULL,
  expiration_date varchar(250) NOT NULL
) ;




drop table if exists users;
CREATE TABLE IF NOT EXISTS users (
  id BIGSERIAL  PRIMARY KEY,
  iscurrent smallint default 1,

  genre VARCHAR(5) NOT NULL,          
  prenom  VARCHAR(75),                
  nom  VARCHAR(75),                  

  email varchar(250) NOT NULL,
  spassword varchar(250) NOT NULL,
  email_verified int,

  group_name varchar(50) NOT NULL,

  valuelangue VARCHAR(3),              
  langue VARCHAR(30),                    

  author BIGINT,                        

  date_registered TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
  last_login BIGINT

) ;

insert into users (genre,prenom,nom,email,spassword,email_verified,valuelangue,langue,group_name) values ('Homme','Daniel','Dupard','ddupard68@gmail.com','$2y$10$Tq78wolGcEXPK5A4oLh/nOWqh.yVcD6NWkTK/AqBxCiVs04766fqC',1,'FR','Français','FullAdmin') ;
insert into users (genre,prenom,nom,email,spassword,email_verified,valuelangue,langue,group_name) values ('Homme','Demo','','demo@gmail.com','$2y$10$WMjwKgPHhyFSU668nLyr/O3mInqoNhd9ITz7YMpj6s37HRikH4wu2',1,'FR','Français','Demo') ;




drop table if exists user_groups ;
CREATE TABLE IF NOT EXISTS user_groups (
  group_name varchar(50) NOT NULL  PRIMARY KEY
) ;


insert into user_groups (group_name) values ('Guest') ;  
insert into user_groups (group_name) values ('Demo') ;
insert into user_groups (group_name) values ('FullAdmin') ;



drop table if exists user_sessions ;
CREATE TABLE IF NOT EXISTS user_sessions (
  id BIGSERIAL  PRIMARY KEY,
  token varchar(250) NOT NULL,
  user_id BIGINT NOT NULL,
  expires BIGINT NOT NULL
) ;




drop table if exists  pages_visibleby ;
CREATE TABLE IF NOT EXISTS pages_visibleby (
  page_name varchar(200) NOT NULL,			 
  visibleby varchar(50)              
) ;
ALTER TABLE  pages_visibleby ADD CONSTRAINT u_constrainte UNIQUE NULLS NOT DISTINCT (page_name, visibleby);



insert into pages_visibleby (page_name,visibleby) values ('./index.php','FullAdmin') ;
insert into pages_visibleby (page_name,visibleby) values ('./index.php','Demo') ;

insert into pages_visibleby (page_name,visibleby) values ('./index_FullAdmin.php','FullAdmin') ;
insert into pages_visibleby (page_name,visibleby) values ('./index_Demo.php','Demo') ;

insert into pages_visibleby (page_name,visibleby) values ('./JobGenerateFiles.php','FullAdmin') ;

insert into pages_visibleby (page_name,visibleby) values ('./Article_CollectData.php','FullAdmin') ;
insert into pages_visibleby (page_name,visibleby) values ('./Article_showall.php','FullAdmin') ;

insert into pages_visibleby (page_name,visibleby) values ('./Article_showANettoyer.php','FullAdmin') ;
insert into pages_visibleby (page_name,visibleby) values ('./Article_Nettoyer.php','FullAdmin') ;


insert into pages_visibleby (page_name,visibleby) values ('./users.php','FullAdmin') ;
insert into pages_visibleby (page_name,visibleby) values ('./user_delete.php','FullAdmin') ;
insert into pages_visibleby (page_name,visibleby) values ('./user_modify.php','FullAdmin') ;
insert into pages_visibleby (page_name,visibleby) values ('./user_create.php','FullAdmin') ;


insert into pages_visibleby (page_name,visibleby) values ('./Entreprise_create.php','FullAdmin') ;
insert into pages_visibleby (page_name,visibleby) values ('./Entreprise_showall.php','FullAdmin') ;
insert into pages_visibleby (page_name,visibleby) values ('./Article_Sans_Entreprise.php','FullAdmin') ;




