drop table if exists formation_categories ;
create table formation_categories (
   id BIGSERIAL PRIMARY KEY,
   idcategorie smallint, 
   iscurrent smallint default 1,
   valuelangue varchar(3) default 'FR',     
   categorie varchar(200)
);
insert into formation_categories (idcategorie,valuelangue,categorie) values (1,'FR','Efficacité commerciale') ;
insert into formation_categories (idcategorie,valuelangue,categorie) values (2,'FR','Technologie') ;
insert into formation_categories (idcategorie,valuelangue,categorie) values (3,'FR','Juridique') ;
insert into formation_categories (idcategorie,valuelangue,categorie) values (4,'FR','Comptable') ;
insert into formation_categories (idcategorie,valuelangue,categorie) values (5,'FR','Administratif') ;
insert into formation_categories (idcategorie,valuelangue,categorie) values (6,'FR','Autre') ;




drop table if exists formation_groupes ;
create table formation_groupes (
   id BIGSERIAL PRIMARY KEY,
   idgroupe smallint, 
   iscurrent smallint default 1,
   valuelangue varchar(3) default 'FR',     
   groupe varchar(200)
);

insert into formation_groupes (idgroupe,valuelangue,groupe) values (1,'FR','individuelle') ;
insert into formation_groupes (idgroupe,valuelangue,groupe) values (2,'FR','max 5 personnes') ;
insert into formation_groupes (idgroupe,valuelangue,groupe) values (3,'FR','max 10 personnes') ;
insert into formation_groupes (idgroupe,valuelangue,groupe) values (4,'FR','Au dessus de 10 personnes') ;



drop table if exists formations ;
create table formations (
  id BIGSERIAL PRIMARY KEY,
  iscurrent smallint default 1,

  isvalidated smallint default 0,

  idutilisateur BIGINT not null,

  idancestor BIGINT default 0,
  numversion integer default 0,
  lastversion integer default 1,

  valuelangue varchar(3) default 'FR',     

  formation_duree varchar(50) default null,
  formation_idgroupe BIGINT not null,
  formation_tarif varchar(50) default null,


  formation_idcategorie  BIGINT not null,
  formation_title varchar(200) not null,
  formation_text text default null,
  formation_htmltext text default null,
  formation_image varchar(200)  default null,

  date_save timestamp default current_timestamp
) ;

