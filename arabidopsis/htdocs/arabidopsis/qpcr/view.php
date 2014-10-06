<?php
Header(  "Content-type:  image/jpeg");
include_once ("dbconnection.php");
  $file=$_GET["file"];
//	echo $file;
  //$file = clean($file, 4);
  if (empty($file))
     exit;

  if (!mysql_select_db("town_at_reporter", $connection))
     showerror();

  $query = "SELECT image FROM plant_image 
            WHERE image_id = '$file'";

$question = MYSQL_QUERY($query);  
$image = MYSQL_RESULT($question,0,"image");
//
echo $image; 
flush(); 

?>
