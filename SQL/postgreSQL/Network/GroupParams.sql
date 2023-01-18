
drop table if exists groupe_params ;
create table groupe_params (
   id BIGSERIAL PRIMARY KEY,

   iscurrent smallint default 1,

   idutilisateur bigint not null,         -- createur du groupe 
   idgroup bigint not null,         -- identifiant du groupe 
   welcomemsg text,                     -- description de ce que fait le groupe
   byemsg text,
   valuelangue text default 'FR',

   date_save timestamp default current_timestamp
) ;
