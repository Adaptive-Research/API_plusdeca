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
        $Article_Tags = "" ;
        if ($_POST['Article_Tags'] != "")
            $Article_Tags = str_replace("'","''",$_POST['Article_Tags']) ;
        
        $ATitle =  str_replace("'","''",$_POST['Article_Title']) ;   
        $ATexte =  str_replace("'","''",$_POST['Article_Text']) ;
        $AHtml =  str_replace("'","''",$_POST['Article_Html']) ;

        $AImage = $_POST['Article_Image'] ;
          if ($AImage === "")
            $AImage = "0" ; 



        $sql = "insert into articles ( idutilisateur, article_tags, article_title, article_text, article_htmltext, article_image) values ('".$idUser."','" ;
        $sql = $sql.$Article_Tags."','".$ATitle."','".$ATexte."','".$AHtml."','" ;
        $sql = $sql.$AImage."')" ;

        if (isset($_POST['debug']))
          echo $sql."\n" ;

        $result = pg_query($conn, $sql);
        if($result !== false)
        {
          $sql2 = "update articles set idancestor = id , numversion = 1 where idutilisateur = '".$idUser."' and idancestor = 0" ;
          if (isset($_POST['debug']))
          echo $sql2."\n" ;
          $result2 = pg_query($conn, $sql2);
          if($result2 !== false)
            echo "OK" ;
          else
            echo "ERROR: update idAncestor not done" ;

        }
        else
          echo "ERROR: Article not saved" ;

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
