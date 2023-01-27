<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");

class InfosUtilisateur_API
{
  public $id ;
  public $Groupe_Nom;

  public $idUtilisateur ;
  public $Prenom ;
  public $Nom ;
  public $Fonction ;
  public $Entreprise ;

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


        $sql1 = "select g.id, g.nom as gnom, gu.idutilisateur, ui.prenom, ui.nom, eu.fonction, ee.nom as entreprise from groupe_utilisateur gu 
                left join utilisateur_infos ui on gu.idutilisateur = ui.iduser
                left join groupes g on gu.idgroupe = g.id
                left join entreprise_utilisateur eu on eu.idutilisateur = gu.idutilisateur
                left join entreprise_etablissement ee on ee.id = eu.identreprise
                where g.id = ".$_POST['id'] ;
        
        if (isset($_POST['debug']))
          echo $sql1."\n" ;
        
        $arr = [] ;
        $result1 = pg_query($conn, $sql1);
        $num_rows1 = pg_num_rows($result1);
        if ( $num_rows1 > 0 )
        {
              while($row = pg_fetch_assoc($result1))
              {

                  $objK = new InfosUtilisateur_API ;

                  $objK->id = $row['id'] ;
                  $objK->Groupe_Nom = $row['gnom'] ;


                  $objK->idUtilisateur = $row['idutilisateur'] ;
            
                  $objK->Prenom = $row['prenom'] ;
                  $objK->Nom = $row['nom'] ;

                  $objK->Fonction = $row['fonction'] ;
                  $objK->Entreprise = $row['entreprise'] ;
            
                  array_push($arr,$objK) ;
              }
              echo json_encode($arr) ;
        }
        else
          echo "ERROR: no user for this group in database" ;
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
