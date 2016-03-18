<?php
    include_once ("dbconnection.php");

    function selfURLBase() {
        $s = empty($_SERVER["HTTPS"]) ? "" : ($_SERVER["HTTPS"] == "on") ? "s" : "";
        $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
        $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":" .$_SERVER["SERVER_PORT"]);
        $app_base = dirname($_SERVER["PHP_SELF"]);
        //return $protocol."://".$_SERVER["SERVER_NAME"].$port.$app_base;
        return $protocol."://www.jcvi.org".$port.$app_base;
    }

    function strleft($s1, $s2) {
        return substr($s1, 0, strpos($s1, $s2));
    }

    $search_line_id = filter_input(INPUT_GET, 'line_id', FILTER_SANITIZE_STRING);

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
         $images[] = array('image_id' => $image_id,
                           'image_url' => selfURLBase()."/get_image.php?image_id=".$image_id);
    }

    $data['images'] = $images;

    header('Content-type: application/json');
    echo json_encode($data);
?>
