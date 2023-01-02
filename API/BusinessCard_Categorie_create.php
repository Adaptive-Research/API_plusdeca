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
        $cat = str_replace("'","''",$_POST['Categorie']) ;

        $sql = "select * from businesscard_categories where idutilisateur = ".$idUser." and categorie = '".$cat."'"   ;
        if (isset($_POST['debug']))
          echo $sql."\n" ;
        
        $result = pg_query($conn, $sql);
        $num_rows = pg_num_rows($result);
        if ( $num_rows > 0 )      
        {
          echo "ERROR: Category already created" ;
        }
        else {
          if (isset($_POST['idAncestor']))
            $idancestor = $_POST['idAncestor'] ;
          else 
            $idancestor = 0 ;
    
          $sql = "insert into businesscard_categories ( idutilisateur,  idancestor, categorie, ordre ) values (".$idUser.",".$idancestor.",'".$cat."',".$_POST['Ordre'].") RETURNING id" ;
      
          if (isset($_POST['debug']))
            echo $sql."\n" ;
      
      
          $result = pg_query($conn, $sql);
          if($result !== false) {
            $row = pg_fetch_row($result) ;
            $id = $row[0] ;
            if ($idancestor === 0)
            {
              $sql = "update businesscard_categories set idancestor = ".$id." where id = ".$id ;
              if (isset($_POST['debug']))
                echo $sql."\n" ;
              pg_query($conn, $sql);
            }
            
            echo "OK: ".$id ;
          }
          else
            echo "ERROR: Category not saved" ;
        }
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
