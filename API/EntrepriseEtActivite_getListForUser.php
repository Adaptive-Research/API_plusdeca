<?php
header("Access-Control-Allow-Origin: *");


class EntrepriseActivite_Utilisateur_API
{
  public $id ;
  public $idUtilisateur ;
  public $Fonction ;
  public $idEntreprise ;
  public $Siret ;
  public $Nom ;
  public $Entreprise_SiteWeb ;
  public $Entreprise_Email ;
  public $Entreprise_Telephone ;
  public $idActivite ;
  public $TypeActivite;
  public $Activite_Nom;
  public $Activite_SiteWeb;
  public $Activite_Email;
  public $Activite_Telephone;
  public $Description;
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
        echo "token: ".$token."\n\n" ;

      $sql = "select * from utilisateur_session where iduser = ".$idUser." and token = '".$token."'"  ;
      if (isset($_POST['debug']))
        echo $sql."\n\n" ;

      $result = pg_query($conn, $sql);
      $num_rows = pg_num_rows($result);
      if ( $num_rows > 0 )
      {
        $idUtilisateur = $_POST['idUtilisateur'] ;


        $sql = " select u.id, u.idutilisateur, u.fonction, u.identreprise , e.siret, e.nom, e.siteweb as entreprise_siteweb, e.email as entreprise_email, " ;
        $sql = $sql." e.telephone as entreprise_telephone, temp.id as idactivite, temp.typeactivite, temp.nom as activite_nom, temp.siteweb as activite_siteweb, ";
        $sql = $sql." temp.email as activite_email, temp.telephone as activite_telephone, temp.description " ;
        $sql = $sql." from entreprise_utilisateur u, entreprise_etablissement e left join  (select * from entreprise_activite a where a.iscurrent = 1) as temp ";
        $sql = $sql." on temp.identreprise = e.id where u.idutilisateur = '".$idUtilisateur."'" ;
        $sql = $sql." and e.id = u.identreprise  and u.iscurrent = 1 and e.iscurrent = 1 order by u.identreprise, temp.id asc" ;

        if (isset($_POST['debug']))
          echo $sql."\n\n" ;        
        $result2 = pg_query($conn, $sql);
        $num_rows2 = pg_num_rows($result);
        if ( $num_rows2 > 0 )
        {
          $arr = [] ;
          while($row = pg_fetch_assoc($result2))
          {
            $objK = new EntrepriseActivite_Utilisateur_API ;
            $objK->id = $row['id'] ;
            $objK->idUtilisateur = $row['idutilisateur'] ;
            $objK->Fonction = $row['fonction'] ;
            $objK->idEntreprise = $row['identreprise'] ;
            $objK->Siret = $row['siret'] ;
            $objK->Nom = $row['nom'] ;
            $objK->Entreprise_SiteWeb = $row['entreprise_siteweb'] ;
            $objK->Entreprise_Email = $row['entreprise_email'] ;
            $objK->Entreprise_Telephone = $row['entreprise_telephone'] ;
            $objK->idActivite = $row['idactivite'] ;
            $objK->TypeActivite= $row['typeactivite'] ;
            $objK->Activite_Nom= $row['activite_nom'] ;
            $objK->Activite_SiteWeb= $row['activite_siteweb'] ;
            $objK->Activite_Email= $row['activite_email'] ;
            $objK->Activite_Telephone= $row['activite_telephone'] ;
            $objK->Description= $row['description'] ;            
           
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
