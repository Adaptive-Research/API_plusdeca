

drop table if exists entreprise_etablissement ;
create table entreprise_etablissement (
  id BIGSERIAL PRIMARY KEY,
  iscurrent smallint default 1,

  siret varchar(50)  not null,
  nom varchar(200)  not null,
  
  siteweb varchar(200) default null,
  email varchar(200)  default null,
  telephone varchar(25) default null,

  
  date_save timestamp default current_timestamp

  ) ;



drop table if exists entreprise_utilisateur ;
create table entreprise_utilisateur (
  id BIGSERIAL PRIMARY KEY,
  iscurrent smallint default 1,
  identreprise bigint not null,
  idutilisateur bigint not null,

  fondateur varchar(1) default '1',     -- Est-ce que la personne est un fondateur ?
  fonction varchar(100) default null,   -- fonction au sein de l'entreprise
  idrole smallint default 1             -- pour les droits d'acces

  ) ;



drop table if exists entreprise_activite ;
create table entreprise_activite (
  id BIGSERIAL PRIMARY KEY,
  iscurrent smallint default 1,

  identreprise bigint not null,

  typeactivite varchar(200)  default null,
  nom varchar(200)  default null,
  description varchar(1500)  default null,

  siteweb varchar(200) default null,
  email varchar(200)  default null,
  telephone varchar(25) default null,


  date_save timestamp default current_timestamp

  
) ;



