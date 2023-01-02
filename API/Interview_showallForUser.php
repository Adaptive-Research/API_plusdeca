<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");


class InterviewUtilisateur_API
{
  public $id ;
  public $iscurrent  ;
  public $isValidated ;
  public $isPublished ;
  public $idUtilisateur ;
  public $idInterview ;
  public $titre ;
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
        if ( isset($_POST['idUtilisateur']) ) 
          $sql = "select iu.*, i.titre from interview_utilisateur iu, interview i where iu.iscurrent = 1 and iu.idinterview = i.id and iu.idutilisateur = ".$_POST['idUtilisateur']  ;
        else 
          $sql = "select iu.*, i.titre from interview_utilisateur iu, interview i where iu.iscurrent = 1 and iu.idinterview = i.id and iu.idutilisateur = ".$idUser  ;

        if (isset($_POST['debug']))
          echo $sql."\n\n" ;

        $arr = [] ;
        
        $result = pg_query($conn, $sql);
        $num_rows = pg_num_rows($result);
        if ( $num_rows > 0 )        
        {
          while($row = pg_fetch_assoc($result))
          {
            $objK = new  InterviewUtilisateur_API ;

            $objK->id = $row['id'] ;
            $objK->iscurrent = $row['iscurrent'] ;
            $objK->isValidated = $row['isvalidated'] ;
            $objK->isPublished = $row['ispublished'] ;
            $objK->idUtilisateur = $row['idutilisateur'] ;
            $objK->idInterview = $row['idinterview'] ;
            $objK->titre = $row['titre'] ;

            array_push($arr,$objK) ;
          }
          echo json_encode($arr) ;
        }
        else
          echo "ERROR: no Interview for this User in database" ;
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
