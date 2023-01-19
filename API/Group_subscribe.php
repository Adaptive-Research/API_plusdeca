<?php
header("Access-Control-Allow-Origin: *");



include __DIR__.'/RTY;456/config.php';


// Create connection
$conn_string = "host=".$servername." port=5432 dbname=".$dbname." user=".$username." password=".$password ;
$conn = pg_connect($conn_string);

//print_r($_POST) ;
if (isset($_POST['debug']))
  print_r($_POST) ;



if ( isset($_POST['Submit']) ) 
{

  if (isset($_POST['token']))
  {
    if (isset($_POST['debug']))
        echo "TokenSent: ".$_POST['token']."\n" ;
    $pos = strpos($_POST['token'], ";");
    if ($pos >= 0)
    {
      $idUser = trim(substr($_POST['token'],0,$pos)) ;
      if (isset($_POST['debug']))
        echo "idUser: ".$idUser."\n" ;

      $token = trim(substr($_POST['token'],$pos+1)) ;
      if (isset($_POST['debug']))
        echo "token: ".$token."\n" ;


      $sql = "select * from utilisateur_session where iduser = ".$idUser." and token = '".$token."'"  ;
      if (isset($_POST['debug']))
        echo $sql."\n" ;

      $result = pg_query($conn, $sql);
      $num_rows = pg_num_rows($result);
      if ( $num_rows > 0 )
      {
        
        $idGroupe = "" ;
        if ($_POST['idgroupe'] != "")
        $idGroupe = str_replace("'","''",$_POST['idgroupe']) ;
        
        $sql1 = "select a.* from groupe_utilisateur a where a.idgroupe = ". $idGroupe ."and a.idutilisateur = " . $idUser. "";

        if($sql1 !=  null) {

          $sql2 = "insert into groupe_utilisateur( idgroupe, idutilisateur) values('".$idGroupe."','" . $idUser."')" ;
  
          if (isset($_POST['debug']))
            echo $sql2."\n" ;
  
          $result = pg_query($conn, $sql2);
          if($result !== false) {
              echo "OK" ;
          }
          else {
            echo "ERROR: Group submission don't done" ;
          }
        } else {
          echo "ERROR: You're already memeber of this group" ;
        }

      }
      else
        echo "ERROR: Token unknown" ;
    }
    else
      echo "ERROR: Token does not have the right format" ;

  }
  else
    echo "ERROR: No token" ;

}
else
  echo "ERROR: Submit not found" ;

//$pg_close($conn);
// il ne faut pas closer la connexion a la base car a la fin du script cela se fait automatiquement et 
// si on le fait cela genere une message serveur de type 500


?>