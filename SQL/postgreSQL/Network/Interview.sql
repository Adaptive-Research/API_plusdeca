
drop table if exists interview ;
create table interview (
   id BIGSERIAL PRIMARY KEY,
   iscurrent smallint default 1,
   titre varchar(200)
) ;



drop table if exists interview_questions ;
create table interview_questions (
    id BIGSERIAL PRIMARY KEY,
    iscurrent smallint default 1,
   
    idinterview bigint not null,

    question varchar(300),
    idselect int default 0,

    ismultiline smallint default 0 

) ;

-- pour reinitialiser l'id de depart apres des insertions 
select pg_get_serial_sequence('interview_questions', 'id');
ALTER SEQUENCE public.interview_questions_id_seq RESTART WITH 9 ;



drop table if exists interview_selectoption ;
create table interview_selectoption (
    id BIGSERIAL PRIMARY KEY,
    iscurrent smallint default 1,
   
    idselect bigint not null,
    selectoption varchar(50)

) ;

select pg_get_serial_sequence('interview_selectoption', 'id');
ALTER SEQUENCE public.interview_selectoption_id_seq RESTART WITH 3 ;


drop table if exists interview_graphe ;
create table interview_graphe (
    id BIGSERIAL PRIMARY KEY,
    iscurrent smallint default 1,
   
    idinterview bigint not null,
    idquestion bigint not null,
    idselectoption bigint not null,

    idquestionsuivante bigint not null

) ;

select pg_get_serial_sequence('interview_graphe', 'id');
ALTER SEQUENCE public.interview_graphe_id_seq RESTART WITH 10 ;









drop table if exists interview_utilisateur ;
create table interview_utilisateur (
    id BIGSERIAL PRIMARY KEY,
    iscurrent smallint default 1,
    isvalidated smallint default 0,
    ispublished smallint default 0,
   
    idinterview bigint not null,
    idutilisateur bigint not null
) ;

ALTER SEQUENCE public.interview_utilisateur_id_seq RESTART WITH 11 ;






drop table if exists interview_reponses ;
create table interview_reponses (
  id BIGSERIAL PRIMARY KEY,
  iscurrent smallint default 1,

  idutilisateur bigint not null,
  idinterview bigint not null,

  idquestion bigint not null,
  reponse text default null,
  
  date_save timestamp default current_timestamp 

 
) ;


