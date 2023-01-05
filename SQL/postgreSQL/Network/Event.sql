drop table if exists events_type ;
create table events_type (
   id BIGSERIAL PRIMARY KEY,
   event_type int not null,
   sorder int null,
   valuelangue varchar(3),
   nom varchar(200)
) ;

insert into events_type (event_type, sorder,valuelangue,nom) values (1,1,'FR','réunions d''entrepreneurs') ;
insert into events_type (event_type, sorder,valuelangue,nom) values(2,2,'FR','salon') ;
insert into events_type (event_type, sorder,valuelangue,nom) values(3,3,'FR','rendez-vous client') ;
insert into events_type (event_type, sorder,valuelangue,nom) values(4,4,'FR','webinaire') ;
insert into events_type (event_type, sorder,valuelangue,nom) values(999,999,'FR','autre') ;




create table events_format (
   id BIGSERIAL PRIMARY KEY,
   event_type int not null,
   event_format int not null,
   
   sorder int null,
   valuelangue varchar(3),
   nom varchar(200)
) ;

insert into events_format (event_type,event_format,sorder,valuelangue,nom) values (1,1,1,'FR','présentiel format libre') ;
insert into events_format (event_type,event_format,sorder,valuelangue,nom) values(1,2,2,'FR','présentiel en petits groupes') ;
insert into events_type (event_type,event_format,sorder,valuelangue,nom) values(1,3,3,'FR','présentiel speed dating') ;
insert into events_type (event_type,event_format,sorder,valuelangue,nom) values(1,4,4,'FR','en ligne') ;
insert into events_type (event_type,event_format,sorder,valuelangue,nom) values(1,5,5,'FR','mixte (présentiel et en ligne)') ;

insert into events_type (event_type,event_format,sorder,valuelangue,nom) values(4,4,4,'FR','en ligne') ;




-- ce sont tous les events qui existent


drop table if exists events ;
create table events (
  id BIGSERIAL PRIMARY KEY,
  iscurrent smallint default 1,

  event_type int not null,
  event_format int default null,
  event_title varchar(200)  not null,
  event_allday smallint default 0,
  event_start varchar(50),
  event_end varchar(50),
  event_city varchar(200) not null,
  event_location varchar(200) not null,

  event_data text default null,
  
  date_save timestamp default current_timestamp
) ;






-- ce sont les evenements auxquels s'abonne un utilisateur

drop table if exists myevents ;
create table myevents (
  id BIGSERIAL PRIMARY KEY,
  iscurrent smallint default 1,

  idevent bigint not null,
  idutilisateur bigint not null,  -- l'utilisateur s'est abonne a l'evenement

  presence_start varchar(50), -- un evenbement peut durer 2 jours et l'utilisateur a perevu de n'y aller qu'une demi journee
  presence_end varchar(50),

  date_save timestamp default current_timestamp
) ;






-- un utilisateur peut aller a des events, organiser des events, planifier une activite


drop table if exists myactivities ;
create table myactivities (
  id BIGSERIAL PRIMARY KEY,
  iscurrent smallint default 1,


  activity_type int not null,
  activity_format int default null,
  activity_title varchar(200)  not null,
  activity_allday smallint default 0,
  activity_start varchar(50),
  activity_end varchar(50),
  activity_city varchar(200) not null,
  activity_location varchar(200) not null,

  event_data text default null,
  
  date_save timestamp default current_timestamp
) ;


