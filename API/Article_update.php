<?php
header("Access-Control-Allow-Origin: *");



include __DIR__.'/RTY;456/config.php';

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


      $sql = "select * from utilisateur_session where iduser = ".$idUser." and token = '".$token."'"  ;
      if (isset($_POST['debug']))
        echo $sql."\n" ;
      
      $result = pg_query($conn, $sql);
      $num_rows = pg_num_rows($result);
      if ( $num_rows > 0 )        
      {
        $sql2 = "select * from articles where idutilisateur = '".$idUser."' and idancestor = ".$_POST['idAncestor']." order by numversion desc" ;
        if (isset($_POST['debug']))
          echo $sql2."\n" ;

        $result2 = pg_query($conn, $sql2);
        $num_rows2 = pg_num_rows($result2);
        if ( $num_rows2 > 0 )          
        {
          $row = pg_fetch_assoc($result2) ;
          $NumVersion = $row['numversion'] + 1 ;

          $Article_Tags = "" ;
          if ($_POST['Article_Tags'] != "")
              $Article_Tags = str_replace("'","''",$_POST['Article_Tags']) ;

          $ATitle =  str_replace("'","''",$_POST['Article_Title']) ;   
          $ATexte =  str_replace("'","''",$_POST['Article_Text']) ;
          $AHtml =  str_replace("'","''",$_POST['Article_Html']) ;
      

          $sql4 = "insert into articles ( idutilisateur, idancestor, numversion,article_tags, article_title, article_text, article_htmltext, article_image) values ('".$idUser."','" ;
          $sql4 = $sql4.$_POST['idAncestor']."','".$NumVersion."','" ;
          $sql4 = $sql4.$Article_Tags."','".$ATitle."','".$ATexte."','".$AHtml."','" ;
          $sql4 = $sql4.$_POST['Article_Image']."')" ;


          if (isset($_POST['debug']))
            echo $sql4."\n" ;

          $result4 = pg_query($conn, $sql4);
          if($result4 !== false)
          {
            $sql3 = "update articles set lastversion = 0 where idancestor = '".$_POST['idAncestor']."' and numversion <> ".$NumVersion ;
            $result3 = pg_query($conn, $sql3);
            if($result3 !== false)
              echo "OK" ;
            else
              echo "ERROR: update LastVersion not done" ;
          }
          else
            echo "ERROR: Article not updated" ;
        }
        else
          echo "ERROR: no Article with this idAncestor" ;

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
