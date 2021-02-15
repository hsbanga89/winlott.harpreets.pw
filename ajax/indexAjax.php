<?php

session_start();
include_once '../common/sql/dataSqlMarriage.php';
include '../common/functions_file.php';

$total_nums = 0;
$lott_array = array();
$date_array = date_function();

if ($date_array['this-day'] == 'Tuesday' || $date_array['this-day'] == 'Friday' || $date_array['this-day'] == 'Sunday') {
    $total_nums = 7;
} elseif ($date_array['this-day'] == 'Thursday') {
    $total_nums = 8;
} else {
    $total_nums = 6;
}

$db_connection = openCon();
$get_all_predictions = "SELECT * FROM predictednums WHERE (DATE(predictdate) = '" . $date_array['this-date'] . "')";
$result_set = $db_connection->query($get_all_predictions);

if ($result_set->num_rows == 0) {
//    Predict numbers for today
    for ($i = 0; count($lott_array) != $total_nums; $i++) {

//        If its thursday, fill the eighth number from 1 to 20
        if (count($lott_array) == 7 && $total_nums == 8) {
            $random_num = mt_rand(1, 20);
            array_push($lott_array, $random_num);
        } else {
            $random_num = mt_rand(1, 45);
            array_push($lott_array, $random_num);
            $lott_array = array_unique($lott_array);
        }
    }

    $lott_names_array = array();

//    Make column names
    for ($i = 0; $i < $total_nums; $i++) {
        $lott_names_array[$i] = "lottnum" . ($i + 1);
    }

    $lott_num_columns_names = implode(", ", $lott_names_array);
    $lott_num_columns_fields = implode(",", $lott_array);

    $insert_predictions = "INSERT INTO predictednums(predictdate," . $lott_num_columns_names . ") VALUES ('" . $date_array['this-date'] . "', " . $lott_num_columns_fields . ")";
    $db_connection->query($insert_predictions);

} else {
//    if numbers have already been predicted earlier today, just display
    while ($row = $result_set->fetch_assoc()) {
        for ($i = 0; $i < $total_nums; $i++) {
            $lott_array[$i] = $row['lottnum' . ($i + 1)];
        }
        array_push($lott_array, $row['predictDate']);
    }
}

closeCon($db_connection);
print_nums($lott_array);