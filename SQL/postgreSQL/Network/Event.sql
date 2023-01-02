drop table if exists events_type ;
create table events_type (
   id BIGSERIAL PRIMARY KEY,
   sorder int null,
   nom varchar(200)
) ;

insert into events_type (sorder, nom) values (1,'réunions d''entrepreneurs') ;
insert into events_type (sorder,nom) values(2,'salon') ;
insert into events_type (sorder,nom) values(3,'rendez-vous client') ;
insert into events_type (sorder,nom) values(4,'webinaire') ;
insert into events_type (sorder,nom) values(999, 'autre') ;



drop table if exists events ;
create table events (
  id BIGSERIAL PRIMARY KEY,
  iscurrent smallint default 1,

  idutilisateur bigint not null,

  event_type int not null,
  event_title varchar(200)  not null,
  event_allday smallint default 0,
  event_start varchar(50),
  event_end varchar(50),
  event_location varchar(200)  not null,

  event_data text default null,

  
  date_save timestamp default current_timestamp

 
) ;


