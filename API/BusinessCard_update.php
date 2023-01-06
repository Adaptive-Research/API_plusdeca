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
          $id = $_POST['id'] ;

          $sql = "select id from businesscard where idutilisateur = ".$idUser." and id = ".$id ;
          if (isset($_POST['debug']))
            echo $sql."\n" ;

          $result3 = pg_query($conn, $sql);
          $num_rows3 = pg_num_rows($result3);
          if ( $num_rows3 > 0 )
          {          

            $lieu_rencontre = str_replace("'","''",$_POST['LieuRencontre']) ;
            
            $ent = str_replace("'","''",$_POST['Entreprise']) ;
            $telephone_entreprise = str_replace("'","''",$_POST['TelephoneEntreprise']) ;
            $siteweb = str_replace("'","''",$_POST['SiteWeb']) ;

            $sexe = str_replace("'","''",$_POST['Sexe']) ;
            
            $prenom = str_replace("'","''",$_POST['Prenom']) ;
            $nom = str_replace("'","''",$_POST['Nom']) ;
            
            $fonction = str_replace("'","''",$_POST['Fonction']) ;
            $telephone_contact = str_replace("'","''",$_POST['TelephoneContact']) ;
            $email = str_replace("'","''",$_POST['Email']) ;


            if ( isset($_POST['idEntreprise']) )
              $idEntreprise = $_POST['idEntreprise'] ;
            else
              $idEntreprise = 0 ;  


            $sql = "update businesscard set lieu_rencontre = '".$lieu_rencontre."', entreprise = '".$ent."', siteweb = '".$siteweb."', telephone_entreprise = '".$telephone_entreprise."', " ;
            $sql = $sql." identreprise = '".$idEntreprise."', " ;
            $sql = $sql." sexe = '".$sexe."', prenom = '".$prenom."', nom = '".$nom."', fonction = '".$fonction."', telephone_contact = '".$telephone_contact."', " ;
            $sql =  $sql." email = '".$email."' " ;
            $sql = $sql." where id = ".$id ;

            if (isset($_POST['debug']))
              echo $sql."\n" ;
            $result = pg_query($conn, $sql);
            if($result !== false)
              echo "OK" ;
            else
              echo "ERROR: BusinessCard not saved" ;
          }
          else 
            echo "ERROR: BusinessCard not found for this user" ;
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
