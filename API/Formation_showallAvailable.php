<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");


class Formation_API
{
  public $id ;
  public $iscurrent ;
  public $isValidated;
  public $idUtilisateur ;
  public $idAncestor ;
  public $NumVersion ;
  public $Formation_Duree ;
  public $Formation_idGroupe ;
  public $Formation_Tarif ;
  public $Formation_idCategorie ;
  public $Formation_Title ;
  public $Formation_Text ;
  public $Formation_Html ;  
  public $Formation_Image ;
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
        if (isset($_POST['ValueLangue']))
          $sql = "select * from formations where iscurrent = 1 and isvalidated = 1 and valuelangue = '".$_POST['ValueLangue']."'"  ;
        else
          $sql = "select * from formations where iscurrent = 1 and isvalidated = 1"  ;

        if (isset($_POST['debug']))
        echo $sql."\n\n" ;

        $arr = [] ;
        
        $result = pg_query($conn, $sql);
        $num_rows = pg_num_rows($result);
        if ( $num_rows > 0 )
        {
          while($row = pg_fetch_assoc($result))
          {
            $objK = new Formation_API ;
            $objK->id = $row['id'] ;
            $objK->iscurrent = $row['iscurrent'] ;
            $objK->isValidated = $row['isvalidated'] ;

            $objK->idUtilisateur = $row['idutilisateur'] ;

            $objK->idAncestor = $row['idancestor'] ;
            $objK->NumVersion = $row['numversion'] ;

            $objK->Formation_Duree = $row['formation_duree'] ;
            $objK->Formation_idGroupe = $row['formation_idgroupe'] ;
            $objK->Formation_Tarif = $row['formation_tarif'] ;

            $objK->Formation_idCategorie = $row['formation_idcategorie'] ;
            $objK->Formation_Title = $row['formation_title'] ;
            $objK->Formation_Text = $row['formation_text'] ;
            $objK->Formation_Html = $row['formation_htmltext'] ;
            $objK->Formation_Image = $row['formation_image'] ;

            array_push($arr,$objK) ;
          }
          echo json_encode($arr) ;
        }
        else
          echo "ERROR: no Formation available in database" ;
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
