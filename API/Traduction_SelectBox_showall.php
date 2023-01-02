<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");



class Traduction_API
{
  public $id ;
  public $iscurrent ;
  public $SelectId ;
  public $ValueLangue ;
  public $OptionValue ;
  public $OptionText ;
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
 
  $sql = "select * from traduction_select where valuelangue = '".$VL."' order by select_id, valuelangue, option_value " ;
}
else
  $sql = "select * from traduction_select" ;

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
    $objK->SelectId = $row['select_id'] ;
    $objK->ValueLangue = $row['valuelangue'] ;
    $objK->OptionValue = $row['option_value'] ;
    $objK->OptionText = $row['option_text'] ;

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
