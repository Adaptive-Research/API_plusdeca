drop table if exists article_categories ;
create table article_categories (
   id BIGSERIAL PRIMARY KEY,
   iscurrent smallint default 1,
   valuelangue varchar(3) default 'fr',     
   category varchar(200)
);

insert article_categories (category) values ("uncategorized") ;



drop table if exists articles ;
create table articles (
  id BIGSERIAL PRIMARY KEY,
  iscurrent smallint default 1,

  isvalidated smallint default 0,
  ispublished smallint default 0,

  idutilisateur BIGINT not null,

  idancestor BIGINT default 0,
  numversion integer default 0,
  lastversion integer default 1,

  article_category int default 1,
  article_title varchar(200) not null,
  article_text text default null,
  article_htmltext text default null,
  article_image varchar(200)  default null,

  date_save timestamp default current_timestamp
) ;

