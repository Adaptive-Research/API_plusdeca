<?php
header("Access-Control-Allow-Origin: *");


class Entreprise_Utilisateur_API
{
  public $id ;
  public $iscurrent ;
  public $idUtilisateur ;
  public $Fondateur ;
  public $Fonction ;


  public $idEntreprise ;
  public $Siret ;
  public $NomEntreprise ;
  public $SiteWeb ;
  public $Email ;
  public $Telephone ;
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
        $idUtilisateur = $_POST['idUtilisateur'] ;

        $sql = "select u.*, e.siret, e.nom, e.siteweb, e.email, e.telephone from entreprise_utilisateur u, entreprise_etablissement e " ;
        $sql =  $sql." where u.idutilisateur = ".$idUtilisateur." and e.id = u.identreprise and e.iscurrent = 1 and u.iscurrent = 1"  ;
        if (isset($_POST['debug']))
          echo $sql."\n" ;        
        $result2 = pg_query($conn, $sql);
        $num_rows2 = pg_num_rows($result2);
        if ( $num_rows2 > 0 )        
        {
          $arr = [] ;
          while($row = pg_fetch_assoc($result2))
          {
            $objK = new Entreprise_Utilisateur_API ;
            $objK->id = $row['id'] ;
            $objK->iscurrent = $row['iscurrent'] ;
            $objK->idUtilisateur = $row['idutilisateur'] ;
            $objK->Fondateur = $row['fondateur'] ;
            $objK->Fonction = $row['fonction'] ;

            $objK->idEntreprise = $row['identreprise'] ;
            $objK->Siret = $row['siret'] ;
            $objK->NomEntreprise = $row['nom'] ;
            $objK->SiteWeb = $row['siteweb'] ;
            $objK->Email = $row['email'] ;
            $objK->Telephone = $row['telephone'] ;

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
