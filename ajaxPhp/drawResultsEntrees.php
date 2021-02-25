<?php
session_start();
include '../common/sql/dataSqlMarriage.php';
include '../common/functions_file.php';

$entries = array();
$get_all_draws = "SELECT lottday, lottdate, drawno, resultnum1, resultnum2, resultnum3, resultnum4, resultnum5, resultnum6, resultnum7, suppnum1, suppnum2 FROM lottresults";
$result_set = db_connect_result($get_all_draws);

if ($result_set->num_rows > 0) {
    while ($row = $result_set->fetch_assoc()) {
        $filtered_row = array();
        foreach ($row as $index => $item) {
            if (!empty($item)) {
                $filtered_row[$index] = $item;
            }
        }
        $entries[] = $filtered_row;
    }
}

if (!empty($entries)) {
    send_to_ajax(array_reverse($entries));
}