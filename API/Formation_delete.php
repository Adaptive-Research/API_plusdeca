<?php
header("Access-Control-Allow-Origin: *");



include __DIR__.'/RTY;456/config.php';

// Create connection
$conn_string = "host=".$servername." port=5432 dbname=".$dbname." user=".$username." password=".$password ;
$conn = pg_connect($conn_string);

if (isset($_POST['debug']))
  print_r($_POST) ;


if ( isset($_POST['Submit']) ) // Soit c'est la 1ère sauvegarde, soit c'est au moins une sauvegarde supplémentaire
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
        if ( isset($_POST['NumVersion']) )
        {
          // on est dans le cas où l'on veut effacer une version de l'formation mais pas toutes les versions
          $sql = "update formations set iscurrent = 0, lastversion = 0 where idancestor  = ".$_POST['idAncestor']. " and numversion = ".$_POST['NumVersion']   ;
          if (isset($_POST['debug']))
            echo $sql."\n" ;    

          $result = pg_query($conn, $sql);
          if($result !== false)
          {
            // la derniere version de l'formation non effacee doit etre mise a LastVersion = 1
            $sql3 = "select Max(numversion) as numversion from formations where iscurrent = 1 and idancestor = '".$_POST['idAncestor']."'" ;
            if (isset($_POST['debug']))
              echo $sql3."\n" ;        

            $result3 = pg_query($conn, $sql3);
            $num_rows3 = pg_num_rows($result3);
            if ( $num_rows3 > 0 )            
            {
              $row3 = pg_fetch_assoc($result3) ;
              $NumVersion = $row3['numversion']  ;

              $sql4 = "update formations set lastversion = 1 where idancestor = '".$_POST['idAncestor']."' and numversion = ".$NumVersion ;
              if (isset($_POST['debug']))
                echo $sql4."\n" ;       

              $result4 = pg_query($conn, $sql4);
              if($result4 !== false)
                echo "OK" ;
              else
                echo "ERROR: Last version not updated" ;
            }
            else 
              echo "OK" ;
          }
          else 
            echo "ERROR: Event not deleted" ;
        }
        else
        {
           // on est dans le cas où l'on veut effacer toutes les versions de l'formation
          $sql = "update formations set iscurrent = 0 where idancestor  = ".$_POST['idAncestor']   ;
          if (isset($_POST['debug']))
            echo $sql."\n" ;        
          $result = pg_query($conn, $sql);
          if($result !== false)
            echo "OK" ;
          else 
            echo "ERROR: Event not deleted" ;
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

//$pg_close($conn);
// il ne faut pas closer la connexion a la base car a la fin du script cela se fait automatiquement et 
// si on le fait cela genere une message serveur de type 500

?>
