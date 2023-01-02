<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");



class Classement_API
{
  public $id ;
  public $idUtilisateur ;
  public $idBusinessCard ;
  public $idCategorie ;
}

include $baseAPI.'/RTY;456/config.php';


// Create connection
$conn_string = "host=".$servername." port=5432 dbname=".$dbname." user=".$username." password=".$password ;
$conn = pg_connect($conn_string);


if (isset($_POST['debug']))
  print_r($_POST) ;



if ( isset($_POST['Submit']) ) // Soit c'est la 1ère sauvegarde, soit c'est au moins une sauvegarde supplémentaire
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

        $sql = "select * from businesscard_classement where idutilisateur = ".$idUser ;


        $arr = [] ;

        $result = pg_query($conn, $sql);
        $num_rows = pg_num_rows($result);
        if ( $num_rows > 0 )
        {
          while($row = pg_fetch_assoc($result))
          {
            $objK = new Categorie_API ;
            $objK->id = $row['id'] ;
            $objK->idUtilisateur = $row['idutilisateur'] ;
            $objK->idBusinessCard = $row['idbusinesscard'] ;
            $objK->idCategorie = $row['idcategorie'] ;

            array_push($arr,$objK) ;
          }
          echo json_encode($arr) ;
        }
        else
          echo "ERROR: no Classification in database for this user" ;
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
