

drop table if exists groupes ;
create table groupes (
   id BIGSERIAL PRIMARY KEY,

   iscurrent smallint default 1,

   idutilisateur bigint not null,         -- createur du groupe 
   nom varchar(200),                      -- nom du groupe
   tags varchar(500),                     -- moyen de classer le groupe
   sdescription text,                     -- description de ce que fait le groupe
   htmltext text default null,
   group_city varchar(200),                    -- c'est la ville du groupe 
   group_image bigint,                    -- c'est l'image du groupe 
   idgroupeparams bigint default null,
   default_validation smallint default 1,

   date_save timestamp default current_timestamp
) ;

drop table if exists groupe_manager ;
create table groupe_manager (
   id BIGSERIAL PRIMARY KEY,
   idgroupe bigint not null,                        -- id du groupe dont l'utilisateur est l'un des managers
   idutilisateur bigint not null,                   -- manager du groupe
   date_save timestamp default current_timestamp    -- date d'attribution du role de manager du groupe 
) ;


drop table if exists groupe_utilisateur ;
create table groupe_utilisateur (
   id BIGSERIAL PRIMARY KEY,
   idgroupe bigint not null,                        -- id du groupe auquel est abonne l'utilisateur
   idutilisateur bigint not null,                   -- membre du groupe
   date_save timestamp default current_timestamp    -- date d'entree dans le groupe 
 
) ;

-- le premier groupe que je vaia creer c'est: Entreprendre en pays de Nemours





drop table if exists groupe_params ;
create table groupe_params (
   id BIGSERIAL PRIMARY KEY,

   iscurrent smallint default 1,

   idgroup bigint not null,             -- identifiant du groupe 
   welcomemsg text,                     -- description de ce que fait le groupe
   byemsg text,
   valuelangue text default 'FR',

   date_save timestamp default current_timestamp
) ;
