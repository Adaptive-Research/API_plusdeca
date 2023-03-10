

drop table if exists groupes ;
create table groupes (
   id BIGSERIAL PRIMARY KEY,

   iscurrent smallint default 1,

   idutilisateur bigint not null,         -- createur du groupe 
   nom varchar(200),                      -- nom du groupe
   tags varchar(500),                     -- moyen de classer le groupe
   sdescription text,                     -- description de ce que fait le groupe
   group_image bigint,                    -- c'est l'image du groupe 

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

