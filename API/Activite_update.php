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
        $sw = $_POST['SiteWeb'] ;
        $de = $_POST['Description'] ;
        $de = str_replace("'","'",$de) ;


        $sql = "update entreprise_activite set identreprise = '".$_POST['idEntreprise']."', typeactivite = '".$_POST['TypeActivite']."', " ;
        $sql = $sql." nom = '".$_POST['Nom']."', description = '".$de."', siteweb = '". $sw."',  email = '".$_POST['Email']."', telephone = '".$_POST['Telephone']."' " ;
        $sql = $sql." where id = ".$_POST['idActivite'] ;
    
        if (isset($_POST['debug']))
          echo $sql."\n" ;
    
    
        $result = pg_query($conn, $sql);
        if($result !== false)
          echo "OK" ;
        else
          echo "ERROR: Activity not saved" ;
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
