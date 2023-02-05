<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");


class Groupe_API
{
  public $id ;
  public $iscurrent ;
  public $idutilisateur ;
  public $tags ;
  public $nom ;
  public $sdescription ;  
  public $htmltext ;  
  public $group_city ;
  public $group_image ;
  public $group_number;
  public $isMember;
  public $isCreator ;
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
        $sql = "select g.*, temp.nombre, temp2.ismember  from groupes g 
        left join ( select idgroupe, count(*) as nombre from groupe_utilisateur  group by idgroupe )  temp on g.id = temp.idgroupe
        left join ( select idgroupe, id as IsMember from groupe_utilisateur where idutilisateur = ".$idUser."  ) temp2 on g.id = temp2.idgroupe
        where g.iscurrent = 1 
        order by g.id desc " ;

        if (isset($_POST['debug']))
        echo $sql."\n" ;
        
        $arr = [] ;
        
        $result = pg_query($conn, $sql);
        $num_rows = pg_num_rows($result);
        if ( $num_rows > 0 )
        {
          while($row = pg_fetch_assoc($result))
          {
            $objK = new Groupe_API ;

            if ( $row['ismember'] !== null) 
              $isMember = true;
            else 
              $isMember = false;

            if ($row['idutilisateur'] === $idUser)  
              $isCreator = true ;
            else 
              $isCreator = false ;

            $objK->id = $row['id'] ;
            $objK->iscurrent = $row['iscurrent'] ;
            $objK->idutilisateur = $row['idutilisateur'] ;
            $objK->tags = $row['tags'] ;
            $objK->nom = $row['nom'] ;
            $objK->sdescription = $row['sdescription'] ;
            $objK->htmltext = $row['htmltext'] ;
            $objK->group_city = $row['group_city'] ;
            $objK->group_image = $row['group_image'] ;
            $objK->group_number = $row['nombre'] ;
            $objK->isMember = $isMember ;
            $objK->isCreator = $isCreator ;

            array_push($arr,$objK) ;
          }
          echo json_encode($arr) ;
        }
        else
          echo "ERROR: no Group in database" ;
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
