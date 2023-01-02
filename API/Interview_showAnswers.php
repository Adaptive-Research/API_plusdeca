<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");


class Answers_API
{
  public $id ;
  public $iscurrent ;
  public $idUtilisateur ;
  public $idInterview ;
  public $idQuestion ;
  public $Reponse  ;
  public $Date_save ;
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
        $sql = "select * from interview_reponses where idutilisateur = ".$idUser. " and idinterview = '".$_POST['idInterview']."' and iscurrent = 1";

        if (isset($_POST['debug']))
        echo $sql."\n\n" ;

        $arr = [] ;
        
        $result = pg_query($conn, $sql);
        $num_rows = pg_num_rows($result);
        if ( $num_rows > 0 )
        {
          while($row = pg_fetch_assoc($result))
          {
            $objK = new Answers_API ;
            $objK->id = $row['id'] ;
            $objK->iscurrent = $row['iscurrent'] ;
            $objK->idUtilisateur = $row['idutilisateur'] ;
            $objK->idInterview = $row['idinterview'] ;
            $objK->idQuestion = $row['idquestion'] ;
            $objK->Reponse = $row['reponse'] ;
            $objK->Date_save = $row['date_save'] ;

            array_push($arr,$objK) ;
          }
          echo json_encode($arr) ;
        }
        else
          echo "ERROR: no Answers for this Interview for this user in database" ;
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
