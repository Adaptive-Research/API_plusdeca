<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");


class BC_API
{
  public $id ;
  public $idUtilisateur ;
  public $LieuRencontre ;
  public $Entreprise ;
  public $SiteWeb ;
  public $Sexe ;
  public $Prenom ;
  public $Nom ;
  public $Fonction ;
  public $Telephone ;
  public $Email ;
}



include $baseAPI.'/RTY;456/config.php';




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

      $sql = "select * from utilisateur_session where iduser = ".$idUser." and token = '".$token."' "  ;
      if (isset($_POST['debug']))
        echo $sql."\n" ;

      $result = pg_query($conn, $sql);
      $num_rows = pg_num_rows($result);
      if ( $num_rows > 0 )        
      {
        $sql2 = "select * from businesscard where idutilisateur = ".$idUser ;
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
            $objK->idUtilisateur = $row['idutilisateur'] ;
            $objK->LieuRencontre = $row['lieu_rencontre'] ;
            $objK->Entreprise = $row['entreprise'] ;
            $objK->SiteWeb = $row['siteweb'] ;
            $objK->Sexe = $row['sexe'] ;
            $objK->Prenom = $row['prenom'] ;
            $objK->Nom = $row['nom'] ;
            $objK->Fonction = $row['fonction'] ;
            $objK->Telephone = $row['telephone_contact'] ;
            $objK->Email = $row['email'] ;

            array_push($arr,$objK) ;
          }
          echo json_encode($arr) ;
        }
        else
          echo "ERROR: no contact for this user in database" ;

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
