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
        $siret = trim($_POST['Siret']) ;
        if ($siret <> "")
        {
            $sw = $_POST['SiteWeb'] ;

            $sql = "insert into entreprise_etablissement ( nom, siteWeb, siret, email, telephone ) values ('" ;
            $sql = $sql.$_POST['Nom']."','".$sw."','".$siret."','" ;
            $sql = $sql.$_POST['Email']."','".$_POST['Telephone']."')" ;

            if (isset($_POST['debug']))
              echo $sql."\n" ;
            $result = pg_query($conn, $sql);
            if($result !== false)
            {
              $sql = "select id from entreprise_etablissement where siret = '".$siret."' order by id desc" ;
              if (isset($_POST['debug']))
                echo $sql."\n" ;     

              $result = pg_query($conn, $sql);
              $num_rows = pg_num_rows($result);
              if ( $num_rows > 0 )                      
              {
                $row = pg_fetch_assoc($result) ;
                $idEntreprise = $row['id'] ;
                if (isset($_POST['debug']))
                  echo "idEntreprise: ".$idEntreprise."\n" ;

                $sql = "insert into  entreprise_utilisateur ( idutilisateur, identreprise, idrole ) values (".$idUser.",".$idEntreprise.",3)" ;
                if (isset($_POST['debug']))
                  echo $sql."\n" ;

                $result = pg_query($conn, $sql);
                if($result !== false)
                  echo "OK:".$idEntreprise  ;
                else
                  echo "ERROR: Company saved but not linked with user" ;
              }
              else
                echo "ERROR: siret not found" ;
            }
            else
              echo "ERROR: Company not saved" ;

        }
        else
          echo "ERROR: Siret empty" ;
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
