<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");


class Entreprise_API
{
  public $id ;
  public $iscurrent ;
  public $Siret ;
  public $Nom ;
  public $SiteWeb ;
  public $Email ;
  public $Telephone ;
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

$sql = "select * from entreprise_etablissement where iscurrent = 1" ;


$arr = [] ;

$result = pg_query($conn, $sql);
$num_rows = pg_num_rows($result);
if ( $num_rows > 0 )
{
  while($row = pg_fetch_assoc($result))
  {
    $objK = new Entreprise_API ;
    $objK->id = $row['id'] ;
    $objK->iscurrent = $row['iscurrent'] ;
    $objK->Nom = $row['nom'] ;
    $objK->Siret = $row['siret'] ;
    $objK->SiteWeb = $row['siteWeb'] ;
    $objK->Email = $row['email'] ;
    $objK->Telephone = $row['telephone'] ;

    array_push($arr,$objK) ;
  }
  echo json_encode($arr) ;
}
else
  echo "ERROR: no company in database" ;


//$pg_close($conn);
// il ne faut pas closer la connexion a la base car a la fin du script cela se fait automatiquement et 
// si on le fait cela genere une message serveur de type 500


?>
