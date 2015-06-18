<?php
    include_once ("dbconnection.php");

    $search_line_id = filter_input(INPUT_GET, 'line', FILTER_SANITIZE_STRING);

    if ( count(preg_split("/-/", $search_line_id)) === 4 ) {
        list($plate, $well, $dip_num, $plant_num) = preg_split("/-/", $search_line_id);
    } else {
        die("ERROR: line is not in the right format, i.e. AGRAC-67-3-2");
    }

    $query = "SELECT pi.image_id
              FROM plant_image pi
              WHERE pi.agro_clone_plate = '$plate'
              AND pi.agro_clone_well = $well
              AND pi.dip_number = $dip_num
              AND pi.plant_number = $plant_num
              AND pi.image_id > 0
              ORDER BY pi.image_id";

    if (!mysql_select_db("town_at_reporter", $connection)) {
        showerror();
    }

    if (!($result = @mysql_query($query, $connection))) {
        showerror();
    }

    $images = array();
    while ($row = @mysql_fetch_array($result)) {
         $image_id = $row["image_id"];
         $images[] = array('image_id' => $image_id);
    }

    $data['images'] = $images;

    header('Content-type: application/json');
    echo json_encode($data);
?>
