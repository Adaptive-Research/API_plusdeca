<?php
header("Access-Control-Allow-Origin: *");

include __DIR__.'/RTY;456/config.php';
include __DIR__.'/RTY;456/test.php';




function generateToken($length = 30)
{
	return bin2hex(random_bytes($length));
}



// Create connection
$conn_string = "host=".$servername." port=5432 dbname=".$dbname." user=".$username." password=".$password ;
$conn = pg_connect($conn_string);



if (isset($_POST['debug'])) {
  print_r($_POST) ;
  echo "\n" ;
}


if ( isset($_POST['Submit']) ) 
{
    $sql = "select * from utilisateur_compte where email = '".$_POST['Email']."'" ;
    if (isset($_POST['debug']))
      echo $sql."\n" ;
    $result = pg_query($conn, $sql);
    $num_rows = pg_num_rows($result);
    if ( $num_rows > 0 )
    {
      $row = pg_fetch_assoc($result) ;
      $idUser = $row['id'] ;

      $p1 = $_POST['Password'] ;
      $p2 = $row['password'] ;

      if (isset($_POST['debug']))
      {
        echo "password sent: ".$p1."\n" ;
        echo "password from database: ".$p2."\n" ;
      }

      if ( $p1 == $p2  )
      {
        $token = generateToken() ;

        $sql = "insert into utilisateur_session ( iduser, token ) values ('".$idUser."','".$token."')" ;
        if (isset($_POST['debug']))
          echo $sql."\n" ;
        $result = pg_query($conn, $sql);
        if($result !== false) {
          $ip = getIPAddress();  


          $sql = "insert into logsession (ip,useragent,accept,accept_encoding,accept_language,referer) values ('" ;
          $sql = $sql.$ip."','".$_SERVER['HTTP_USER_AGENT']."','".$_SERVER['HTTP_ACCEPT']."','".$_SERVER['HTTP_ACCEPT_LANGUAGE']."','" ;
          $sql = $sql.$_SERVER['HTTP_ACCEPT_ENCODING']."','".$_SERVER['HTTP_REFERER']."')" ;
          $result = pg_query($conn, $sql);            


          echo $idUser.";".$token ;
        }
        else
          echo "ERROR: Session not saved" ;
    
      }
      else
        echo "ERROR: Wrong password" ;

    }
    else
      echo "ERROR: User unkwown" ;

}
else
  echo "Submit not found" ;


//$pg_close($conn);
// il ne faut pas closer la connexion a la base car a la fin du script cela se fait automatiquement et 
// si on le fait cela genere une message serveur de type 500

?>
