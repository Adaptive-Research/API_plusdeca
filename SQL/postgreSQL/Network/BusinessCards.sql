

drop table if exists businesscard ;

CREATE TABLE businesscard (
    
id BIGSERIAL PRIMARY KEY,
idutilisateur BIGINT, -- une businesscard est saisie par un utilisateur mais appartient a une entreprise
identreprise BIGINT default 0,  -- identifiant de l'entreprise a laquelle appartient la businesscard


lieu_rencontre varchar(50)  DEFAULT NULL,

entreprise varchar(120)  DEFAULT NULL,
telephone_entreprise varchar(20) DEFAULT NULL,
siteweb  varchar(500) DEFAULT NULL,

sexe varchar(5)  DEFAULT NULL,
prenom varchar(20)  DEFAULT NULL,
nom varchar(100)  DEFAULT NULL,
fonction varchar(100)  DEFAULT NULL,

telephone_contact varchar(20) DEFAULT NULL,
email varchar(100)  DEFAULT NULL,

date_save timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP 

) ;





-- un fichier texte contenant l'historique des echanges
-- dans une entreprise plusieurs personnes peuvent contacter un meme lead 
drop table if exists businesscard_histocontact ;
CREATE TABLE businesscard_histocontact (
   
id BIGSERIAL PRIMARY KEY,

idbusinesscard BIGINT,
idutilisateur BIGINT,
historique TEXT

) ;



/*
date: 26/09/2022
type: rencontre a un salon 
idevent:
etat: a recontacter

date: 21/10/2022
type: appel telephonique
qui: 
commentaire:
etat:
action:

date: 21/10/2022
type: envoi email
qui: 
commentaire:
etat:

date: 22/10/2022
type: reception email
etat:
*/




/*

Une business card est saisie par un utilisateur 
elle doit etre associee a une societe 
- si l'utlisateur n'a qu'une societe c'est assez simple, on associe la business card a la societe
- si l'utlisateur a plusieurs societes, il faut faire choisir a quelle societe appartient la business card


*/






drop table if exists businesscard_infos ;
CREATE TABLE businesscard_infos (

id BIGSERIAL PRIMARY KEY,
idutilisateur BIGINT, 
idbusinesscard BIGINT,

interestedby BIGINT

) ;







-- les 2 tables servent a classer les cartes de visite dans differentes categories
-- cela permet d'organiser le travail sur les prospects
drop table if exists businesscard_categories ;
CREATE TABLE businesscard_categories (
   
id BIGSERIAL PRIMARY KEY,

idutilisateur BIGINT, 
idancestor BIGINT default 0,
categorie varchar(200),
ordre varchar(200) default 0
) ;


drop table if exists businesscard_classement ;
CREATE TABLE businesscard_classement (
   
id BIGSERIAL PRIMARY KEY,

idutilisateur BIGINT, 
idbusinesscard BIGINT,
idcategorie BIGINT default 0

) ;









-- une businessCard appartient a une entreprise mais il est toujours associe a un utilisateur du logiciel qui va devoir 
-- dans une meme entreprise une businesscard peut-etre associe a plusieurs personnes 
drop table if exists businesscard_assignedto ;
CREATE TABLE businesscard_assignedto (
   
id BIGSERIAL PRIMARY KEY,

idbusinesscard BIGINT,
idutilisateur BIGINT 
) ;






