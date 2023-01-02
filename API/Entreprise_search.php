<?php
header("Access-Control-Allow-Origin: *");


class Search_API
{
  public $value ;
  public $label ;
 
}


include $baseAPI.'/RTY;456/config.php';


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

      $sql = "select * from Utilisateur_Session where idUser = ".$idUser." and token = '".$token."'"  ;
      if (isset($_POST['debug']))
        echo $sql."\n" ;

      $result = pg_query($conn, $sql);
      $num_rows = pg_num_rows($result);
      if ( $num_rows > 0 )      
      {
        
        $searching = $_POST['Searching'] ;

        if ( empty($searching) )
          $sql = "select id,nom from entreprise_etablissement where iscurrent = 1 order by nom limit 25"  ;
        else  
        {
          $searching = str_replace("'","''",$searching) ;
          $sql = "select id,nom from entreprise_etablissement where iscurrent = 1 and nom like '".$searching."%' order by nom limit 25"  ;
        }
        if (isset($_POST['debug']))
          echo $sql."\n" ;        

        $result2 = pg_query($conn, $sql);
        $num_rows2 = pg_num_rows($result2);
        if ( $num_rows2 > 0 )        
        {
          $arr = [] ;
          while($row = pg_fetch_assoc($result2))
          {
            $objK = new Search_API ;
            $objK->value = $row['id'] ;
            $objK->label = $row['nom'] ;

            array_push($arr,$objK) ;
          }
          echo json_encode($arr) ;
        }
        else 
          echo "ERROR: No company for this user" ;
        
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
