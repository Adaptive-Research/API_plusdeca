<?php
header("Access-Control-Allow-Origin: *");
$FichierErreur="/Uploads/Images/404.png"; 
include __DIR__.'/RTY;456/config.php';
$conn_string = "host=".$servername." port=5432 dbname=".$dbname." user=".$username." password=".$password ;
$conn = pg_connect($conn_string);
$sql = "select * from images where id = ".$idImage  ;
if (isset($_POST['debug']))
  echo $sql."\n" ;
$result = pg_query($conn, $sql);
$num_rows = pg_num_rows($result);
if ( $num_rows > 0 )        
{
    $row = pg_fetch_assoc($result) ;
    $filepath=$row['fichier'] ;
    //echo $filepath ;
    
    if (file_exists($filepath)) {
        touch($filepath,filemtime($filepath),time()); 
        $path_parts=pathinfo($filepath);
        switch(strtolower($path_parts['extension']))
        {
        case "gif":
        header("Content-type: image/gif");
        break;
        case "jpg":
        case "jpeg":
        header("Content-type: image/jpeg");
        break;
        case "png":
        header("Content-type: image/png");
        break;
        case "bmp":
        header("Content-type: image/bmp");
        break;
        }
        header("Accept-Ranges: bytes");
        header('Content-Length: ' . filesize($filepath));
        header("Last-Modified: Fri, 03 Mar 2004 06:32:31 GMT");
        readfile($filepath);
        
    }
    else {
    header( "HTTP/1.0 404 Not Found");
    header("Content-type: image/png");
    header('Content-Length: ' . filesize($FichierErreur));
    header("Accept-Ranges: bytes");
    header("Last-Modified: Fri, 03 Mar 2004 06:32:31 GMT");
    readfile($FichierErreur);
    }
    
}
else{
    header( "HTTP/1.0 404 Not Found");
    header("Content-type: image/png");
    header('Content-Length: ' . filesize($FichierErreur));
    header("Accept-Ranges: bytes");
    header("Last-Modified: Fri, 03 Mar 2004 06:32:31 GMT");
    readfile($FichierErreur);
    }
?>
