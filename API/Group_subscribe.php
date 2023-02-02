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
        
        $sql1 = "select * from groupes where id = ".$idGroupe ;
        if (isset($_POST['debug']))
          echo $sql1."\n" ;

          $result1 = pg_query($conn, $sql1);
          $num_rows1 = pg_num_rows($result1);        
          if($num_rows1 > 0) {
            $row1 = pg_fetch_assoc($result1)  ;
            $NomGroupe = $row1['nom'] ;
            $idCreator = $row1['idutilisateur'] ;
            
            $sql2 = "select * from groupe_utilisateur where idgroupe = ". $idGroupe ." and idutilisateur = ".$idUser ;
            if (isset($_POST['debug']))
            echo $sql2."\n" ;
            
            $result2 = pg_query($conn, $sql2);
            $num_rows2 = pg_num_rows($result2);
            if ( $num_rows2 <= 0 )
            {
              $sql3 = "select  * from utilisateur_infos ui where  ui.iduser = ".$idUser ;
              if (isset($_POST['debug']))
                echo $sql3."\n" ;
              
              $result3 = pg_query($conn, $sql3);
              $num_rows3 = pg_num_rows($result3);
              if ( $num_rows3 > 0 )
              {
                  while($row = pg_fetch_assoc($result3))
                  {

                    if($idCreator !== $idUser){
                      $content = "".$row['prenom']." ".$row['nom']." a rejoint votre groupe ".$NomGroupe."";
                      
                      $sql4 = "insert into groupe_utilisateur( idgroupe, idutilisateur) values('".$idGroupe."','" . $idUser."')" ;
                      $result4 = pg_query($conn, $sql4);
                      if (isset($_POST['debug']))
                        echo $sql4."\n" ;
              
                      if($result4 !== false) {  
                        echo "OK Subscription done" ;

                        $sql5 = "insert into notifications( idutilisateur, notification_content, idtype_notification) values('".$idCreator."','".$content."', 1)" ;
                        $result5 = pg_query($conn, $sql5);
                        if (isset($_POST['debug']))
                          echo $sql5."\n" ;

                        if($result5 !== false) {
                          echo "Notification sent" ;
                        }else {
                          echo "ERROR: Notification don't sent" ;
                        }
                            
                      }
                      else {
                        echo "ERROR: Group submission don't done" ;
                      }
                      
                    }
                    else {
                      echo "ERROR: You can't subscribe to your own group, cause you're the creator" ;
                    }
                  }
              }
            }else {
              echo "ERROR: You're already member of this group" ;
            }
          
        } else {
          echo "ERROR: No Group found" ;
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
