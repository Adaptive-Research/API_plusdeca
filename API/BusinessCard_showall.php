<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");


class BC_API
{
  public $id ;
  public $idCategorie ;
  public $Categorie ;
  public $Ordre ;
  public $idEntreprise ;
  public $idUtilisateur ;
  public $LieuRencontre ;
  public $Entreprise ;
  public $TelephoneEntreprise ;
  public $SiteWeb ;
  public $Sexe ;
  public $Prenom ;
  public $Nom ;
  public $Fonction ;
  public $TelephoneContact ;
  public $Email ;
  
}



include $baseAPI.'/RTY;456/config.php';
include __DIR__.'/RTY;456/test.php';


if (isset($_POST['debug'])) {
  print_r($_POST) ;
  echo "\n" ;
}


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


      // Create connection
      $conn_string = "host=".$servername." port=5432 dbname=".$dbname." user=".$username." password=".$password ;
      $conn = pg_connect($conn_string);

      $ip = getIPAddress();  
      $sql = "insert into logpage (ip,page,method) values ('" ;
      $sql = $sql.$ip."','".$_SERVER['REQUEST_URI']."','".$_SERVER['REQUEST_METHOD']."')" ;
      $result = pg_query($conn, $sql);      


      $sql = "select * from utilisateur_session where iduser = ".$idUser." and token = '".$token."' "  ;
      if (isset($_POST['debug']))
        echo $sql."\n" ;

      $result = pg_query($conn, $sql);
      $num_rows = pg_num_rows($result);
      if ( $num_rows > 0 )        
      {
        $sql2 = "select b.id, b.identreprise, b.idutilisateur, b.lieu_rencontre, b.entreprise, b.telephone_entreprise, b.siteweb " ; 
        $sql2 = $sql2.", b.sexe, b.prenom, b.nom, b.fonction, b.telephone_contact, b.email " ;
        $sql2 = $sql2.",temp.idcategorie, temp.categorie, temp.ordre from businesscard b left join ( select bcl.*, bca.categorie, bca.ordre from " ;
        $sql2 = $sql2." businesscard_classement bcl left join businesscard_categories bca on bca.idancestor = bcl.idcategorie and bca.idutilisateur = bcl.idutilisateur  where " ;
        $sql2 = $sql2." bcl.idutilisateur = ".$idUser." ) as temp " ;
        $sql2 = $sql2." on temp.idutilisateur = b.idutilisateur and temp.idbusinesscard = b.id " ;  
        $sql2 = $sql2." where b.idutilisateur = ".$idUser ;
        $sql2 = $sql2." order by b.entreprise, b.nom, b.prenom " ;

        if (isset($_POST['debug']))
         echo $sql2."\n" ;

        $arr = [] ;

        $result2 = pg_query($conn, $sql2);
        $num_rows2 = pg_num_rows($result2);
        if ( $num_rows2 > 0 )
        {
          while($row = pg_fetch_assoc($result2))
          {
            $objK = new BC_API ;
            $objK->id = $row['id'] ;
            $objK->idCategorie = $row['idcategorie'] ;
            $objK->Categorie = $row['categorie'] ;
            $objK->Ordre = $row['ordre'] ;
            $objK->idEntreprise = $row['identreprise'] ;
            $objK->idUtilisateur = $row['idutilisateur'] ;
            $objK->LieuRencontre = $row['lieu_rencontre'] ;
            $objK->Entreprise = $row['entreprise'] ;
            $objK->TelephoneEntreprise = $row['telephone_entreprise'] ;
            $objK->SiteWeb = $row['siteweb'] ;
            $objK->Sexe = $row['sexe'] ;
            $objK->Prenom = $row['prenom'] ;
            $objK->Nom = $row['nom'] ;
            $objK->Fonction = $row['fonction'] ;
            $objK->TelephoneContact = $row['telephone_contact'] ;
            $objK->Email = $row['email'] ;
           
            array_push($arr,$objK) ;
          }
          echo json_encode($arr) ;
        }
        else 
          echo "ERROR: No business card for this user" ;


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
