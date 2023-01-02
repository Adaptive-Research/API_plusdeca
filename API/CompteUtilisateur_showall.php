<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");


class CompteUtilisateur_API
{
  public $id ;
  public $Email ;
  public $Email_verified ;
  public $Password ;
  public $ValueLangue ;
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


$sql = "select * from utilisateur_compte" ;


$arr = [] ;

$result = pg_query($conn, $sql);
$num_rows = pg_num_rows($result);
if ( $num_rows > 0 )
{
  while($row = pg_fetch_assoc($result))
  {
    $objK = new CompteUtilisateur_API ;
    $objK->id = $row['id'] ;
    $objK->Email = $row['email'] ;
    $objK->Email_verified = $row['email_verified'] ;
    $objK->Password = $row['password'] ;
    $objK->ValueLangue = $row['valuelangue'] ;

    array_push($arr,$objK) ;
  }
  echo json_encode($arr) ;
}
else
  echo "ERROR: no user account in database" ;


//$pg_close($conn);
// il ne faut pas closer la connexion a la base car a la fin du script cela se fait automatiquement et 
// si on le fait cela genere une message serveur de type 500


?>
