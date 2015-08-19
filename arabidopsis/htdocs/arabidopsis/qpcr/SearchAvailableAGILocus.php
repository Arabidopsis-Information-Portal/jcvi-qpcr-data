<?php
    include_once ("dbconnection.php");

    $search_term = filter_input(INPUT_GET, 'search_term', FILTER_SANITIZE_STRING);

    if (!empty($search_term)) {
        $query = "SELECT locus
                  FROM unique_agi_locus_lookup
                  WHERE locus LIKE '%$search_term%'";
    } else {
        $query = "SELECT locus
                  FROM unique_agi_locus_lookup";
    }

    if (!mysql_select_db("town_at_reporter", $connection)) {
        showerror();
    }

    if (!($result = @mysql_query($query, $connection))) {
        showerror();
    }

    $locus_ids = array();
    while ($row = @mysql_fetch_array($result)) {
         $locus_ids[] = array('locus' => trim($row['locus']));
    }

    header('Content-type: application/json');
    echo json_encode($locus_ids);
?>
