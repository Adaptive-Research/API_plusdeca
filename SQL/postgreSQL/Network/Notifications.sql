
drop table if exists notifications ;
create table notifications (
   id BIGSERIAL PRIMARY KEY,

   isread smallint default 1,
  
   idutilisateur bigint not null,         -- identifiant de l'utilsiateur qui reçoit la notification
   notification_content text,   
   idtype_notification smallint not null,
   valuelangue text default 'FR',
   date_save timestamp default current_timestamp
) ;

drop table if exists type_notifications ;
create table type_notifications (
   id BIGSERIAL PRIMARY KEY,   
   nom varchar(200),                      -- nom de la notification
   sdescription text,        
   valuelangue text default 'FR',
   date_save timestamp default current_timestamp
) ;
