<?php
    include_once ("dbconnection.php");

    function search_images($images, $val) {
        foreach ($images as $a) {
            if ($a['image_id'] == $val) {
                return True;
            }
        }
        return False;
    }

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

    $query = "SELECT pi.image_id, pa.po_code, pa.expression, pc.name
              FROM plant_image pi
              JOIN po_assignment pa on pi.image_id = pa.image_id
              JOIN po_code pc on pa.po_code = pc.po_code
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
    $po_codes = array();
    while ($row = @mysql_fetch_array($result)) {
         $image_id = $row["image_id"];
         $po_code = $row["po_code"];
         $expression = $row["expression"];
         $po_name = $row["name"];

         if (!search_images($images, $image_id)) {
             $images[] = array('image_id' => $image_id,
                               'image_url' => selfURLBase()."/get_image.php?image_id=".$image_id);
         }
         $po_codes[$image_id][] = array('po_code' => $po_code, 'po_name' => $po_name, 'expression' => $expression);
    }

    foreach ($images as $i) {
        $i['po_codes'] = $po_codes[$i['image_id']];
        $data['images'][] = $i;
    }

    header('Content-type: application/json');
    echo json_encode($data);
?>
