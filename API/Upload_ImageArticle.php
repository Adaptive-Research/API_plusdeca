<?php
error_reporting(E_ALL); ini_set('display_errors', 1); 

header("Access-Control-Allow-Origin: *");



$target_dir = "/Uploads/Images/Articles/";



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
      

        //echo "\nFICHIER\n" ;
        //echo print_r($_FILES,true);


        

        $imageFileType = strtolower(pathinfo($_FILES['data']['name'],PATHINFO_EXTENSION));
        $imageFileType = str_replace('\r','', $imageFileType) ;
        $imageFileType = str_replace('\t','', $imageFileType) ;
        $imageFileType = str_replace('\n','', $imageFileType) ;


        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["data"]["tmp_name"]);
        if($check !== false) {

          $uid = str_replace(".","-",uniqid('',true)) ;
          $fichier =  "img_".$uid.".". $imageFileType ;
          $target_file = $target_dir.$fichier;
          echo $_FILES['data']['tmp_name']." --> ".$target_file."\n" ;
          if (move_uploaded_file($_FILES['data']['tmp_name'],$target_file)) {
           
            $sql = "insert into images ( fichier ) values ('".$target_file."') returning id" ;
            $result = pg_query($conn, $sql);
            if($result !== false) {
                $row = pg_fetch_row($result) ;
                echo $row[0] ;
            }
          }
          else
            echo "ERROR: move_uploaded_file did not work" ;
              
        } 
        else 
          echo "ERROR: File is not an image.";
        

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
