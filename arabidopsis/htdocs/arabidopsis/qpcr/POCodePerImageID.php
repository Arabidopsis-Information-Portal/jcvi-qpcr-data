<?php
    include_once ("dbconnection.php");

    $search_image_id = filter_input(INPUT_GET, 'image', FILTER_SANITIZE_STRING);

    $query = "SELECT pa.po_code, pa.expression, pc.name
              FROM po_assignment pa
              JOIN po_code pc ON pa.po_code = pc.po_code
              WHERE pa.image_id = $search_image_id";

    if (!mysql_select_db("town_at_reporter", $connection)) {
        showerror();
    }

    if (!($result = @mysql_query($query, $connection))) {
        showerror();
    }

    $po_codes = array();
    while ($row = @mysql_fetch_array($result)) {
         $po_code = $row["po_code"];
         $expression = $row["expression"];
         $po_name = $row["name"];
         $po_codes[] = array('po_code' => $po_code,
                             'expression' => $expression,
                             'po_name' => $po_name);
    }

    $data['po_codes'] = $po_codes;

    header('Content-type: application/json');
    echo json_encode($data);
?>
