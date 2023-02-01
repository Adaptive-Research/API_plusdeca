

drop table if exists messages ;
create table messages (
   id BIGSERIAL PRIMARY KEY,

   isread smallint default 1,

   idsender bigint not null,         -- identifiant de l'utilisateur qui envoie le message
   idreceiver bigint not null,         -- identifiant de l'utilsiateur qui reçoit le message
   message_content text,                -- contenu du message
   htmltext text default null,

   date_save timestamp default current_timestamp
) ;
