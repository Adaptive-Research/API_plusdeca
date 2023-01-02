<?php
header("Access-Control-Allow-Origin: *");



include __DIR__.'/RTY;456/config.php';


// Create connection
$conn_string = "host=".$servername." port=5432 dbname=".$dbname." user=".$username." password=".$password ;
$conn = pg_connect($conn_string);

//print_r($_POST) ;
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
        $Formation_idCategorie =  str_replace("'","''",$_POST['Formation_idCategorie']) ; 

        $Formation_Duree =  str_replace("'","''",$_POST['Formation_Duree']) ;   
        $Formation_idGroupe =  str_replace("'","''",$_POST['Formation_idGroupe']) ;             
        $Formation_Tarif =  str_replace("'","''",$_POST['Formation_Tarif']) ;             
        
        $ATitle =  str_replace("'","''",$_POST['Formation_Title']) ;   
        $ATexte =  str_replace("'","''",$_POST['Formation_Text']) ;
        $AHtml =  str_replace("'","''",$_POST['Formation_Html']) ;



        $sql = "insert into formations ( idutilisateur, formation_duree, formation_idgroupe, formation_tarif, formation_idcategorie, formation_title, formation_text, formation_htmltext, formation_image) values ('".$idUser."','" ;
        $sql = $sql.$Formation_Duree."','".$Formation_idGroupe."','".$Formation_Tarif."','" ;
        $sql = $sql.$Formation_idCategorie."','".$ATitle."','".$ATexte."','".$AHtml."','" ;
        $sql = $sql.$_POST['Formation_Image']."')" ;

        if (isset($_POST['debug']))
          echo $sql."\n" ;

        $result = pg_query($conn, $sql);
        if($result !== false)
        {
          $sql2 = "update formations set idancestor = id , numversion = 1 where idutilisateur = '".$idUser."' and idancestor = 0" ;
          if (isset($_POST['debug']))
          echo $sql2."\n" ;
          $result2 = pg_query($conn, $sql2);
          if($result2 !== false)
            echo "OK" ;
          else
            echo "ERROR: update idAncestor not done" ;

        }
        else
          echo "ERROR: Formation not saved" ;

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
