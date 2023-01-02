

drop table if exists loguser ;

drop table if exists logsession ;
CREATE TABLE IF NOT EXISTS logsession (

  ip VARCHAR(50),
  useragent VARCHAR(200),
  accept VARCHAR(150),
  accept_encoding VARCHAR(100),
  accept_language VARCHAR(150),
  referer VARCHAR(500),

  
  date_save TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ;



drop table if exists logpage ;
CREATE TABLE IF NOT EXISTS logpage (
  id BIGSERIAL PRIMARY KEY,

  ip VARCHAR(50),
  page VARCHAR(500),
  method VARCHAR(10),

  date_save TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
)  ;
