<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");


class Article_API
{
  public $id ;
  public $iscurrent ;
  public $ValueLangue;
  public $Category ;
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


      $sql = "select * from utilisateur_session where iduser = ".$idUser." and token = '".$token."'"  ;
      if (isset($_POST['debug']))
        echo $sql."\n" ;

      $result = pg_query($conn, $sql);
      $num_rows = pg_num_rows($result);
      if ( $num_rows > 0 )
      {
        if (isset($_POST['ValueLangue']))
          $sql = "select * from article_categories where valuelangue = '".$_POST['ValueLangue']."' and iscurrent = 1 order by valuelangue,category" ;

        else
          $sql = "select * from article_categories where iscurrent = 1 order by valuelangue,category" ;

        if (isset($_POST['debug']))
        echo $sql."\n" ;

        $arr = [] ;
        
        $result = pg_query($conn, $sql);
        $num_rows = pg_num_rows($result);
        if ( $num_rows > 0 )
        {
          while($row = pg_fetch_assoc($result))
          {
            $objK = new Article_API ;
            $objK->id = $row['id'] ;
            $objK->iscurrent = $row['iscurrent'] ;
            $objK->ValueLangue = $row['valuelangue'] ;

            $objK->Category = $row['category'] ;

            array_push($arr,$objK) ;
          }
          echo json_encode($arr) ;
        }
        else
          echo "ERROR: no category in database" ;
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
