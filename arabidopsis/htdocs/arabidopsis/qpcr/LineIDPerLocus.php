<?php
    include_once ("dbconnection.php");

    $search_locus = filter_input(INPUT_GET, 'locus', FILTER_SANITIZE_STRING);

    $query = "SELECT distinct CONCAT_WS('-', ap.agro_clone_plate,ap.agro_clone_well,pi.dip_number,pi.plant_number) as line_id
              FROM agro_to_plant ap
              JOIN plant_image pi ON ap.agro_clone_plate = pi.agro_clone_plate AND ap.agro_clone_well = pi.agro_clone_well
              WHERE ap.locus_intended='$search_locus'
              ORDER BY line_id";

    if (!mysql_select_db("town_at_reporter", $connection)) {
        showerror();
    }

    if (!($result = @mysql_query($query, $connection))) {
        showerror();
    }

    $lines = array();
    while ($row = @mysql_fetch_array($result)) {
         $line_id = $row["line_id"];
         $lines[] = array('line_id' => $line_id);
    }

    $data['lines'] = $lines;

    header('Content-type: application/json');
    echo json_encode($data);
?>
