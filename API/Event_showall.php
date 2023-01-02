<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");


class Event_API
{
  public $id ;
  public $iscurrent ;
  public $idUtilisateur ;
  public $Event_Type ;
  public $Event_Title ;
  public $Event_AllDay ;
  public $Event_Start ;
  public $Event_End ;
  public $Event_Location ;
  public $Event_Data ;
}



include $baseAPI.'/RTY;456/config.php';
include __DIR__.'/RTY;456/test.php';

// Create connection
$conn_string = "host=".$servername." port=5432 dbname=".$dbname." user=".$username." password=".$password ;
$conn = pg_connect($conn_string);

$ip = getIPAddress();  
$sql = "insert into logpage (ip,page,method) values ('" ;
$sql = $sql.$ip."','".$_SERVER['REQUEST_URI']."','".$_SERVER['REQUEST_METHOD']."')" ;
$result = pg_query($conn, $sql);      


if (isset($_POST['debug'])) {
  print_r($_POST) ;
  echo "\n" ;
}

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
        $sql = "select * from events where idutilisateur = '".$idUser."' and iscurrent=1" ;

        if (isset($_POST['debug']))
          echo $sql."\n" ;

        $arr = [] ;
        
        $result = pg_query($conn, $sql);
        $num_rows = pg_num_rows($result);
        if ( $num_rows > 0 )        
        {
          while($row = pg_fetch_assoc($result))
          {
            $objK = new Event_API ;
            $objK->id = $row['id'] ;
            $objK->iscurrent = $row['iscurrent'] ;

            $objK->Event_Type = $row['event_type'] ;
            $objK->Event_Title = $row['event_title'] ;
            $objK->Event_AllDay = $row['event_allday'] ;
            $objK->Event_Start = $row['event_start'] ;
            $objK->Event_End = $row['event_end'] ;
            $objK->Event_Location = $row['event_location'] ;
            $objK->Event_Data = $row['event_data'] ;

            array_push($arr,$objK) ;
          }
          echo json_encode($arr) ;
        }
        else
          echo "ERROR: no Event in database" ;
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
