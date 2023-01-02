<?php
header("Access-Control-Allow-Origin: *");


if (isset($_POST['debug']))
  print_r($_POST) ;



include __DIR__.'/RTY;456/config.php';


// Create connection
$conn_string = "host=".$servername." port=5432 dbname=".$dbname." user=".$username." password=".$password ;
$conn = pg_connect($conn_string);


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


      $sql = "select * from utilisateur_session where idUser = ".$idUser." and token = '".$token."'"  ;
      if (isset($_POST['debug']))
        echo $sql."\n" ;

      $result = pg_query($conn, $sql);
      $num_rows = pg_num_rows($result);
      if ( $num_rows > 0 )
      {

        $sql = "update events set idutilisateur = '".$idUser."', event_type = '".$_POST['Event_Type']."', event_title = '".$_POST['Event_Title']."' " ;
        $sql = $sql.", event_allday = '".$_POST['Event_AllDay']."' " ;
        $sql = $sql.", event_start = '".$_POST['Event_Start']."', Event_End = '".$_POST['Event_End']."' " ;
        $sql = $sql.", event_location = '".$_POST['Event_Location']."' "  ;
        $sql = $sql.", event_data = '".$_POST['Event_Data']."' "  ;
        $sql = $sql." where id = ".$_POST['idEvent'] ;

        if (isset($_POST['debug']))
          echo $sql."\n" ;

        $result = pg_query($conn, $sql);
        if($result !== false)
          echo "OK" ;
        else
          echo "ERROR: Event not updated" ;

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
