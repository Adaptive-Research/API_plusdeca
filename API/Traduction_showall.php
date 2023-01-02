<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");



class Traduction_API
{
  public $id ;
  public $iscurrent ;
  public $Page ;
  public $ValueLangue ;
  public $Message ;
  public $Traduction ;
}

include $baseAPI.'/RTY;456/config.php';


// Create connection
$conn_string = "host=".$servername." port=5432 dbname=".$dbname." user=".$username." password=".$password ;
$conn = pg_connect($conn_string);



if (isset($_POST['debug']))
  print_r($_POST) ;



if ( isset($_POST['Submit']) ) 
{
  $VL = $_POST['ValueLangue'] ;
 
  if (isset($_POST['Page']))
  {
    $Page = $_POST['Page'] ;
    $sql = "select * from traduction where valuelangue = '".$VL."' and page = '".$Page."'" ;
  }
  else
    $sql = "select * from traduction where valuelangue = '".$VL."'" ;
}
else
  $sql = "select * from traduction" ;

if (isset($_POST['debug']))
  echo $sql."\n" ;

$arr = [] ;
 
$result = pg_query($conn, $sql);
$num_rows = pg_num_rows($result);
if ( $num_rows > 0 )
{
  while($row = pg_fetch_assoc($result))
  {
    $objK = new Traduction_API ;
    $objK->id = $row['id'] ;
    $objK->iscurrent = $row['iscurrent'] ;
    $objK->Page = $row['page'] ;
    $objK->ValueLangue = $row['valuelangue'] ;
    $objK->Message = $row['message'] ;
    $objK->Traduction = $row['traduction'] ;

    array_push($arr,$objK) ;
  }
  echo json_encode($arr) ;
}
else
  echo "ERROR: no Translation in database" ;


//$pg_close($conn);
// il ne faut pas closer la connexion a la base car a la fin du script cela se fait automatiquement et 
// si on le fait cela genere une message serveur de type 500




?>
