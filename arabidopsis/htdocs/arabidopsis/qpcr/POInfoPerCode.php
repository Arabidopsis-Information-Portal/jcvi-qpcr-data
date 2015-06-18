<?php
    include_once ("dbconnection.php");

    $search_po_code = filter_input(INPUT_GET, 'po_code', FILTER_SANITIZE_STRING);

    $query = "SELECT name, namespace, def
              FROM po_code pc
              WHERE po_code = '$search_po_code'";

    if (!mysql_select_db("town_at_reporter", $connection)) {
        showerror();
    }

    if (!($result = @mysql_query($query, $connection))) {
        showerror();
    }

    $row = @mysql_fetch_array($result);
    $po_code = array('po_name' => $row['name'],
                     'po_namespace' => $row['namespace'],
                     'po_def' => $row['def']);

    header('Content-type: application/json');
    echo json_encode($po_code);
?>
