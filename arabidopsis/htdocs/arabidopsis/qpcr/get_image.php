<?php
include_once ("dbconnection.php");

Header(  "Content-type:  image/jpeg");

$image_id = filter_input(INPUT_GET, 'image_id', FILTER_SANITIZE_NUMBER_INT);
$width = filter_input(INPUT_GET, 'width', FILTER_SANITIZE_NUMBER_INT);
$height = filter_input(INPUT_GET, 'height', FILTER_SANITIZE_NUMBER_INT);

if (empty($image_id)) {
    exit;
}

function createImage($image, $width, $height) {
    $src = imagecreatefromstring($image);
    $src_width = imagesx($src);
    $src_height = imagesy($src);

    if (!empty($width) && !empty($height)) {
        $new_w = $src_width <= $width ? $src_width : $width;
        $new_h = $src_height <= $height ? $src_height : $height;
    } elseif (!empty($width)) {
        if ($src_width <= $width) {
            $new_w = $src_width;
            $new_h = $src_height;
        } else {
            $ar = $src_height / $src_width;
            $new_w = $width;
            $new_h = round(abs($new_w * $ar));
        }
    } elseif (!empty($height)) {
        if ($src_height <= $height) {
            $new_w = $src_width;
            $new_h = $src_height;
        } else {
            $ar = $src_width / $src_height;
            $new_h = $height;
            $new_w = round(abs($new_h * $ar));
        }
    }

    $img = imagecreatetruecolor($new_w, $new_h);
    imagecopyresized($img,$src,0,0,0,0,$new_w,$new_h,$src_width,$src_height);
    imagejpeg($img);
    imagedestroy($img);
}

if (!mysql_select_db("town_at_reporter", $connection)) {
    showerror();
}

$query = "SELECT image FROM plant_image
          WHERE image_id = '$image_id'";

$result = @mysql_query($query);
$image = @mysql_result($result,0,"image");

if (!empty($width) || !empty($height)) {
    createImage($image, $width, $height);
}  else {
    echo $image;
}
flush();

?>
