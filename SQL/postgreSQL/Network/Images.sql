

drop table if exists images ;
create table images (
  id BIGSERIAL PRIMARY KEY,
  fichier varchar(500)  default null
) ;



