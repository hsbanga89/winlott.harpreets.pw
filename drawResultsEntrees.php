<?php

session_start();
include 'common/sql/dataSqlMarriage.php';
include 'common/functions_file.php';

$entries = array();
$get_all_draws = "SELECT lottDay, lottDate, drawNo, resultNum1, resultNum2, resultNum3," .
    "resultNum4, resultNum5, resultNum6, resultNum7, suppNum1, suppNum2 FROM lottresults";

$db_connection = openCon();
$result_set = $db_connection->query($get_all_draws);

if ($result_set->num_rows > 0) {
    while ($row = $result_set->fetch_assoc()) {
        $row_elements = array();
        foreach ($row as $index => $item) {
            $row_elements[$index] = $item;
        }
        $entries[] = $row_elements;
    }
    echo json_encode($entries);
}

closeCon($db_connection);
