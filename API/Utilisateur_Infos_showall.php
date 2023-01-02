<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");


class InfosUtilisateur_API
{
  public $id ;
  public $idUser ;

  public $Prenom ;
  public $Nom ;

  public $Email ;
  public $EmailVisible ;

  public $Telephone ;
  public $TelephoneVisible ;

  public $Bio ;
  public $BioVisible ;

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

        if (isset($_POST['idUser']))
          $sql = "select * from utilisateur_infos where iduser = '".$_POST['idUser']."'"  ;
        else
          $sql = "select * from utilisateur_infos where iduser = '".$idUser."'"  ;

        if (isset($_POST['debug']))
          echo $sql."\n" ;
         
        $result = pg_query($conn, $sql);
        $num_rows = pg_num_rows($result);
        if ( $num_rows > 0 )            
        {
          $arr = [] ;

          while($row = pg_fetch_assoc($result))
          {
            $objK = new InfosUtilisateur_API ;
            $objK->id = $row['id'] ;
            $objK->idUser = $row['iduser'] ;
      
            $objK->Prenom = $row['prenom'] ;
            $objK->Nom = $row['nom'] ;
      
            $objK->Email = $row['email'] ;
            $objK->EmailVisible = $row['emailvisible'] ;
      
            $objK->Telephone = $row['telephone'] ;
            $objK->TelephoneVisible = $row['telephonevisible'] ;
      
            $objK->Bio = $row['bio'] ;
            $objK->BioVisible = $row['biovisible'] ;
      
            array_push($arr,$objK) ;
          }
          echo json_encode($arr) ;

        }
        else
          echo "ERROR: no data for user" ;
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
