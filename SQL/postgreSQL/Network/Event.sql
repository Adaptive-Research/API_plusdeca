
drop table if exists events_type ;
create table events_type (
   id BIGSERIAL PRIMARY KEY,
   event_type smallint not null,
   sorder smallint null,
   valuelangue varchar(3) DEFAULT 'FR',
   nom varchar(200)
) ;

insert into events_type (event_type, sorder,valuelangue,nom) values (1,1,'FR','réunion de groupe') ;
insert into events_type (event_type, sorder,valuelangue,nom) values(2,2,'FR','salon') ;
insert into events_type (event_type, sorder,valuelangue,nom) values(3,3,'FR','webinaire') ;
insert into events_type (event_type, sorder,valuelangue,nom) values(999,999,'FR','autre') ;



create table events_format (
   id BIGSERIAL PRIMARY KEY,
   event_type smallint not null,
   event_format smallint not null,
   
   sorder smallint ,
   valuelangue varchar(3) DEFAULT 'FR',
   nom varchar(200)
) ;

-- ce sont les types de format en fonction du type d'evenement
insert into events_format (event_type,event_format,sorder,valuelangue,nom) values (1,1,1,'FR','présentiel') ;
insert into events_type (event_type,event_format,sorder,valuelangue,nom) values(1,2,2,'FR','en ligne') ;
insert into events_type (event_type,event_format,sorder,valuelangue,nom) values(1,3,3,'FR','mixte (présentiel et en ligne)') ;

insert into events_format (event_type,event_format,sorder,valuelangue,nom) values (2,1,1,'FR','présentiel') ;
insert into events_format (event_type,event_format,sorder,valuelangue,nom) values (3,1,1,'FR','présentiel') ;
insert into events_format (event_type,event_format,sorder,valuelangue,nom) values (3,4,2,'FR','téléphone') ;
insert into events_type (event_type,event_format,sorder,valuelangue,nom) values(4,4,1,'FR','en ligne') ;

insert into events_format (event_type,event_format,sorder,valuelangue,nom) values (999,1,1,'FR','présentiel') ;
insert into events_type (event_type,event_format,sorder,valuelangue,nom) values(999,2,2,'FR','en ligne') ;
insert into events_type (event_type,event_format,sorder,valuelangue,nom) values(999,3,3,'FR','mixte (présentiel et en ligne)') ;





-- ce sont tous les events qui existent. Cela comprend les salons que l'on recupere sur internet et les evenements orgaanises par nos membres

drop table if exists events ;
create table events (
  id BIGSERIAL PRIMARY KEY,
  iscurrent smallint default 1,

  event_type smallint not null,
  event_format smallint default null,
  event_title varchar(200)  not null,
  event_allday smallint default 0,
  event_start varchar(50),
  event_end varchar(50),
  event_city varchar(200) not null,         -- c'est la ville pour geolocaliser
  event_location varchar(500) not null,     -- c'est l'adresse un peu plus precise

  event_data text default null,             -- cela sert a contenir des infos supplementaires sur l'evenement
  
  date_save timestamp default current_timestamp
) ;




drop table if exists events_type_organisateur ;
create table events_type_organisateur (
   id BIGSERIAL PRIMARY KEY,
   type_organisateur smallint default 0,
   sorder smallint null,
   valuelangue varchar(3) DEFAULT 'FR',
   nom varchar(200)
) ;

insert into events_type_organisateur (type_organisateur, sorder,valuelangue,nom) values (1,1,'FR','organisateur') ;
insert into events_type_organisateur (type_organisateur, sorder,valuelangue,nom) values (2,2,'FR','co organisateur') ;





drop table if exists events_organisateur ;
create table events_organisateur (
  id BIGSERIAL PRIMARY KEY,
  iscurrent smallint default 1,

  idevent bigint not null,
  idutilisateur bigint not null,  -- l'utilisateur a organise ou co organise l'evenement

  idtype_organisateur smallint ,  -- contient soit orgnaisateur soit co organisateur 
  
  date_save timestamp default current_timestamp
) ;




-- ce sont les evenements auxquels va un utilisateur

drop table if exists myevents ;
create table myevents (
  id BIGSERIAL PRIMARY KEY,
  iscurrent smallint default 1,

  idevent bigint not null,
  idutilisateur bigint not null,  -- l'utilisateur s'est abonne a l'evenement 

  presence_start varchar(50), -- un evenement peut durer 2 jours et l'utilisateur a prevu de n'y aller qu'une demi journee
  presence_end varchar(50),

  date_save timestamp default current_timestamp
) ;




drop table if exists activity_type ;
create table activity_type (
   id BIGSERIAL PRIMARY KEY,
   activity_type smallint not null,
   sorder smallint null,
   valuelangue varchar(3) DEFAULT 'FR',
   nom varchar(200)
) ;

insert into events_type (event_type, sorder,valuelangue,nom) values (1,1,'FR','réunion de groupe') ;
insert into events_type (event_type, sorder,valuelangue,nom) values(2,2,'FR','salon') ;
insert into events_type (event_type, sorder,valuelangue,nom) values(3,3,'FR','rendez-vous client') ;
insert into events_type (event_type, sorder,valuelangue,nom) values(4,4,'FR','webinaire') ;
insert into events_type (event_type, sorder,valuelangue,nom) values(999,999,'FR','autre') ;




-- un utilisateur peut aller a des events, organiser des events, planifier une activite
-- la table ci-dessous sert a planifier une activite 

drop table if exists myactivities ;
create table myactivities (
  id BIGSERIAL PRIMARY KEY,
  iscurrent smallint default 1,


  idutilisateur bigint not null,  -- l'utilisateur s'est abonne a l'evenement

  activity_type int not null,
  activity_format int default null,
  activity_title varchar(200)  not null,
  activity_allday smallint default 0,
  activity_start varchar(50),
  activity_end varchar(50),
  activity_city varchar(200) not null,
  activity_location varchar(200) not null,

  activity_data text default null,
  
  date_save timestamp default current_timestamp
) ;


