<?php
header("Access-Control-Allow-Origin: *");

$target_dir = "/Uploads/BusinessCards/";


function ImportFile($conn,$idUser,$idCategorie, $target_file) {
  $file = fopen($target_file,"r") ;
  if ($file !== false) {




    $ligne1 = str_replace('"','',strtoupper(fgets($file)));
    $fields = explode(",", $ligne1); 

    $index_LieuRencontre=array_search("LIEURENCONTRE",$fields);

    $index_Entreprise = array_search("ENTREPRISE",$fields);
    $index_TelephoneEntreprise =array_search("TELEPHONEENTREPRISE",$fields);
    $index_SiteWeb = array_search("SITEWEB",$fields);
    

    $index_Sexe=array_search("SEXE",$fields);
    $index_Prenom =array_search("PRENOM",$fields);
    $index_Nom =array_search("NOM",$fields);

    $index_Fonction=array_search("FONCTION",$fields);
    $index_TelephoneContact=array_search("TELEPHONECONTACT",$fields);
    $index_Email=array_search("EMAIL",$fields);

    while ($ligne = strtoupper(fgets($file)))
    {
      $ligne = str_replace('"','',$ligne);
      $ligne = str_replace("'","''",$ligne);
      $arr =  explode(",", $ligne); 

      if ($index_LieuRencontre !== false)
        $value_LieuRencontre =$arr[$index_LieuRencontre] ;
      else 
        $value_LieuRencontre = "" ;

      
      if ($index_Entreprise !== false)
        $value_Entreprise =$arr[$index_Entreprise] ;
      else 
        $value_Entreprise = "" ;

      if ($index_TelephoneEntreprise !== false)
        $value_TelephoneEntreprise =$arr[$index_TelephoneEntreprise] ;
      else 
        $value_TelephoneEntreprise = "" ;

      if ($index_SiteWeb !== false)
        $value_SiteWeb =$arr[$index_SiteWeb] ;
      else 
        $value_SiteWeb = "" ;

      if ($index_Sexe !== false)
        $value_Sexe =$arr[$index_Sexe] ;
      else 
        $value_Sexe = "" ;

      if ($index_Prenom !== false)
        $value_Prenom =$arr[$index_Prenom] ;
      else 
        $value_Prenom = "" ;

      if ($index_Nom !== false)
        $value_Nom =$arr[$index_Nom] ;
      else 
        $value_Nom = "" ;

      if ($index_Fonction !== false)
        $value_Fonction =$arr[$index_Fonction] ;
      else 
        $value_Fonction = "" ;

      if ($index_TelephoneContact !== false)
        $value_TelephoneContact =$arr[$index_TelephoneContact] ;
      else 
        $value_TelephoneContact = "" ;
      
        if ($index_Email !== false)
        $value_Email =$arr[$index_Email] ;
      else 
        $value_Email = "" ;

      $sql = "insert into businesscard ( idutilisateur, lieu_rencontre, entreprise, telephone_entreprise,siteweb, sexe , prenom, nom, fonction,telephone_contact,email ) values ('" ;
      $sql = $sql.$idUser."','" ;
      $sql = $sql.$value_LieuRencontre."','".$value_Entreprise."','".$value_TelephoneEntreprise."','".$value_SiteWeb."','"  ;
      $sql = $sql.$value_Sexe."','".$value_Prenom."','".$value_Nom."','" ;
      $sql = $sql.$value_Fonction."','".$value_TelephoneContact."','".$value_Email."') returning id" ;

      if (isset($_POST['debug']))
        echo $sql."\n" ; 
      $result = pg_query($conn, $sql);
      if($result !== false) {
        $row = pg_fetch_row($result) ;
        $id = $row[0] ;
        $sql2 = "insert into businesscard_classement (idutilisateur, idbusinesscard, idcategorie ) values (" ;
        $sql2 = $sql2.$idUser.",".$id.",".$idCategorie.")" ;
        if (isset($_POST['debug']))
          echo $sql2."\n" ; 
        $result2 = pg_query($conn, $sql2);          
      }
     
    }
    echo "OK file ".$_FILES['data']['name']." imported\n" ;

    fclose($file);
    return true ;
 }
 echo "ERROR: file ".$target_file." not opened\n" ;
 return false ;

}



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
      
        $Categorie = $_POST['Categorie'] ;
        $sql = "select idancestor from businesscard_categories where idutilisateur = ".$idUser." and categorie = '".$Categorie."'"  ;
        if (isset($_POST['debug']))
          echo $sql."\n" ;
        $result = pg_query($conn, $sql);
        $num_rows = pg_num_rows($result);
        if ( $num_rows > 0 )
        {
          $row = pg_fetch_assoc($result) ;
          $idCategorie = $row['idancestor'] ;
        }
        else 
          $idCategorie = 0 ;
        echo "\nidCategorie: ".$idCategorie."\n" ;



        echo "\nFICHIER\n" ;
        print_r($_FILES);


        // Les lignes ci-dessous sont faites pour verifier que le fichier est bien un csv
        $csvMimes =array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if (isset($_FILES['data']['tmp_name'])) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES['data']['tmp_name']);
            echo "mime: ",$mime."\n" ;
            if (in_array($mime, $csvMimes) === true) {
              echo "OK: the file is  a csv\n" ;
            
              $uid = str_replace(".","-",uniqid('',true)) ;
              $target_file = $target_dir."BC_".$uid.".csv" ;
              echo $_FILES['data']['tmp_name']." --> ".$target_file."\n" ;
              if (move_uploaded_file($_FILES['data']['tmp_name'],$target_file))
                ImportFile($conn,$idUser,$idCategorie, $target_file) ;
            }
            else 
              echo "ERROR: the file is not a csv" ;
          
            finfo_close($finfo);
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
else
  echo "ERROR: Submit not found" ;

//$pg_close($conn);
// il ne faut pas closer la connexion a la base car a la fin du script cela se fait automatiquement et 
// si on le fait cela genere une message serveur de type 500

?>
