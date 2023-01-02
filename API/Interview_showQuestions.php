<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");


class Questions_API
{
  public $idQuestion ;
  public $Question  ;
  public $isMultiline ;
  public $idSelectOption ;
  public $SelectOption ;
  public $idQuestionSuivante ;
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
        $sql = "select temp.*, iso.selectoption from (SELECT ig.idquestion, ig.idquestionSuivante, ig.idselectoption , iq.question, iq.ismultiline " ;
        $sql = $sql." FROM interview_graphe ig, interview_questions iq WHERE ig.idquestion = iq.id and ig.iscurrent = 1" ;
        $sql = $sql." and ig.idinterview = ".$_POST['idInterview'].") temp " ;
        $sql = $sql." left join interview_selectoption iso on temp.idselectoption = iso.id " ;

        if (isset($_POST['debug']))
        echo $sql."\n\n" ;

        $arr = [] ;
        
        $result = pg_query($conn, $sql);
        $num_rows = pg_num_rows($result);
        if ( $num_rows > 0 )     
        {
          while($row = pg_fetch_assoc($result))
          {
            $objK = new Questions_API ;
            $objK->idQuestion = $row['idquestion'] ;
            $objK->Question = $row['question'] ;
            $objK->isMultiline = $row['ismultiline'] ;
            $objK->idSelectOption = $row['idselectoption'] ;
            $objK->SelectOption = $row['selectoption'] ;
            $objK->idQuestionSuivante = $row['idquestionsuivante'] ;

            array_push($arr,$objK) ;
          }
          echo json_encode($arr) ;
        }
        else
          echo "ERROR: no Questions for this Interview in database" ;
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
