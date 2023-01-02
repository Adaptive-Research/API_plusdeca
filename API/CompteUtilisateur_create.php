<?php
header("Access-Control-Allow-Origin: *");
header("content-type: text/html; charset=utf-8");

var_dump(http_response_code(200));


include __DIR__.'/RTY;456/config.php';



// Create connection
$conn_string = "host=".$servername." port=5432 dbname=".$dbname." user=".$username." password=".$password ;
$conn = pg_connect($conn_string);

if (isset($_POST['debug']))
  print_r($_POST) ;

if ( isset($_POST['Submit']) ) // Soit c'est la 1ère sauvegarde, soit c'est au moins une sauvegarde supplémentaire
{
  $sql = "select * from utilisateur_compte where email = '".$_POST['Email']."'" ;
  if (isset($_POST['debug']))
      echo $sql."\n" ;

  $result = pg_query($conn, $sql);
  $num_rows = pg_num_rows($result);
  if ( $num_rows > 0 )
    echo "ERROR: User already created" ;
  else {
    if (isset($_POST['debug']))
    {
      echo  "Email: ".$_POST['Email']."\n" ;
      echo  "Password: ".$_POST['Password']."\n" ;
    }

    $sql = "insert into utilisateur_compte ( email, password ) values ('".$_POST['Email']."','".$_POST['Password']."') ;" ;
    if (isset($_POST['debug']))
      echo $sql."\n" ;

    $result = pg_query($conn, $sql);
    //echo "lasterror: ".pg_last_error($conn)."\n" ;
    if($result == false)
      echo "ERROR: User Not saved" ;
    else
      echo "OK" ;
  }

}
else 
  echo "ERROR: Submit not found" ;



//$pg_close($conn);  
// il ne faut pas closer la connexion a la base car a la fin du script cela se fait automatiquement et 
// si on le fait cela genere une message serveur de type 500
?>
