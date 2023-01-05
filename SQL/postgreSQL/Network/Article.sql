drop table if exists article_categories ;

drop table if exists article_rubriques ;
create table article_rubriques (
   id BIGSERIAL PRIMARY KEY,
   iscurrent smallint default 1,
   rubrique varchar(200)
);

insert into article_rubriques (rubrique) values ('Nouvelles du réseau') ;
insert into article_rubriques (rubrique) values ('Rencontres à venir') ;
insert into article_rubriques (rubrique) values ('Les articles de nos entrepreneurs') ;
insert into article_rubriques (rubrique) values ('Trouvé sur le net') ;
insert into article_rubriques (rubrique) values ('Un entrepreneur en lumière') ;


drop table if exists articles ;
create table articles (
  id BIGSERIAL PRIMARY KEY,
  iscurrent smallint default 1,

  ispublished smallint default 0,

  idutilisateur BIGINT not null,

  idancestor BIGINT default 0,
  numversion integer default 0,
  lastversion integer default 1,

  article_rubrique int default 3, 
  article_tags varchar(200) default null,
  article_title varchar(200) not null,
  article_text text default null,
  article_htmltext text default null,
  article_image BIGINT  default 0,

  date_save timestamp default current_timestamp
) ;



