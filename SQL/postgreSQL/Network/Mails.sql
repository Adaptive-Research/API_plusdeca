
drop table mails_to ;

create table mails_to (
 id BIGSERIAL PRIMARY KEY,
 idList BIGINT not null,            -- c'est l'identifiant de la liste des destinataires           
 idutilisateur BIGINT not null
)

drop table if exists mails ;
create table mails (
  id BIGSERIAL PRIMARY KEY,
  iscurrent smallint default 1,

  issent smallint default 0,
  idutilisateur_from BIGINT not null,
  
  isList smallint default 0,                -- c'est pour gerer le fait qu'il y a soit 1 destinataire, soit une liste des destinataires 
  idutilisateur_to BIGINT, 
  idList_to BIGINT not null,                -- c'est la liste des destinataires

  idancestor BIGINT default 0,
  numversion integer default 0,
  lastversion integer default 1,

  mail_title varchar(200) not null,
  mail_text text default null,
  mail_htmltext text default null,
  mail_image BIGINT  default 0,

  date_save timestamp default current_timestamp
  date_sent timestamp default current_timestamp
) ;


