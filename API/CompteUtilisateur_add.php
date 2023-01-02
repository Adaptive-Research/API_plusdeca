<?php
header("Access-Control-Allow-Origin: *");



include __DIR__.'/RTY;456/config.php';


// Create connection
$conn_string = "host=".$servername." port=5432 dbname=".$dbname." user=".$username." password=".$password ;
$conn = pg_connect($conn_string);


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
          $Email = $_POST['Email'] ;
          $Password = $_POST['Password'] ;

          $sql1 = "select * from utilisateur_compte where email = '".$Email."'" ;
          if (isset($_POST['debug']))
            echo $sql1."\n" ;
          $result1 = pg_query($conn, $sql1);
          $num_rows1 = pg_num_rows($result1);
          if ( $num_rows1 > 0 ) {
              $row = pg_fetch_assoc($result1) ;
              $idUtilisateur = $row['id'] ;
          } 
          else{
            $sql1 = "insert into utilisateur_compte ( email, password ) values ('".$Email."','".$Password."') returning id" ;
            if (isset($_POST['debug']))
              echo $sql1."\n" ;
        
            $result1 = pg_query($conn, $sql1);
            if($result1 !== false) {
              $row = pg_fetch_row($result1) ;
              $idUtilisateur = $row[0] ;
            }
          }


          $idEntreprise = $_POST['idEntreprise'] ;
          $idRole = (int) $_POST['idRole'] ;

          $sql2 = "select * from entreprise_utilisateur where identreprise = ".$idEntreprise. " and idutilisateur = ".$idUtilisateur   ;
          if (isset($_POST['debug']))
            echo $sql2."\n" ;
          $result2 = pg_query($conn, $sql2);
          $num_rows2 = pg_num_rows($result2);
          if ( $num_rows2 > 0 )        
            $sql3 = "update entreprise_utilisateur set idrole = ".$idRole." where identreprise = ".$idEntreprise. " and idutilisateur = ".$idUtilisateur ;
          else 
            $sql3 = "insert into  entreprise_utilisateur ( identreprise, idutilisateur, idrole ) values (".$idEntreprise.",".$idUtilisateur.",".$idRole.")" ;
  

          if (isset($_POST['debug']))
            echo $sql3."\n" ;

          $result3 = pg_query($conn, $sql3);
          if($result3 !== false)
            echo "OK" ;
          else
            echo "ERROR: Link between Company and User not saved" ;
        

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
