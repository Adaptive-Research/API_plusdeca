
drop table traduction ;
CREATE TABLE traduction (
    id BIGSERIAL PRIMARY KEY,
    iscurrent BIGINT DEFAULT 1,
    
    page varchar(100) DEFAULT NULL,
    valuelangue varchar(5) NOT NULL,
    message TEXT NOT NULL,
    traduction TEXT NOT NULL,
    date_save timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP 
)  ;



drop table traduction_select ;
CREATE TABLE traduction_select (
    id BIGSERIAL PRIMARY KEY,
    iscurrent BIGINT DEFAULT 1,
    
    select_id varchar(100) DEFAULT NULL,
    valuelangue varchar(5) NOT NULL,
    option_value varchar(50) Not NULL,
    option_text TEXT NOT NULL,
    date_save timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP 
)  ;
