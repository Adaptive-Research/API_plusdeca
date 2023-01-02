
drop table if exists utilisateur_compte;
create table if not exists utilisateur_compte (
  id bigserial primary key,
  email varchar(250) not null,
  password varchar(250) not null,
  email_verified smallint default 0,

  valuelangue varchar(3) default 'FR',             

  date_save timestamp default current_timestamp 

) ;


drop table if exists utilisateur_session;
create table if not exists utilisateur_session (
  id bigserial primary key,
  iduser bigint not null,
  token varchar(250) not null,
  date_save timestamp default current_timestamp 
) ;



drop table if exists utilisateur_infos;
create table if not exists  utilisateur_infos (
  id bigserial primary key,
  iduser bigint not null,

  prenom varchar(100) not null,
  nom varchar(100) not null,

  email varchar(200)  default null,
  emailvisible smallint default 0,

  telephone varchar(25) default null,
  telephonevisible smallint default 0,

  bio text default null, 
  biovisible smallint default 0,

  date_save timestamp default current_timestamp 
) ;







-- un utilisateur peut avoir un role au sein d'une entreprise pour l'utilisation du logiciel
-- il peut:
--    creer de nouveaux utilisateurs associes a une entreprise
--    assigner un role a un utilisateur de l'entreprise


-- quels sont les roles ?
-- Collaborateur
-- Admin (peut creer des employes et leur assigner un role admin ou collaborateur)
-- Fulladmin (peut creer des employes et leur assigner un role Fulladmin, admin ou collaborateur)

