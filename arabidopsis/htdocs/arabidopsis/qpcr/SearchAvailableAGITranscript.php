<?php
    include_once ("dbconnection.php");

    $search_term = filter_input(INPUT_GET, 'search_term', FILTER_SANITIZE_STRING);

    if (!empty($search_term)) {
        $query = "SELECT transcript
                  FROM unique_agi_transcripts_lookup
                  WHERE transcript LIKE '%$search_term%'";
    } else {
        $query = "SELECT transcript
                  FROM unique_agi_transcripts_lookup";
    }

    if (!mysql_select_db("town_at_qpcr", $connection)) {
        showerror();
    }

    if (!($result = @mysql_query($query, $connection))) {
        showerror();
    }

    $transcripts = array();
    while ($row = @mysql_fetch_array($result)) {
         $transcripts[] = array('transcript' => trim($row['transcript']));
    }

    header('Content-type: application/json');
    echo json_encode($transcripts);
?>
