<?php

session_start();
include '../common/sql/dataSqlMarriage.php';
include '../common/functions_file.php';

$result_returned = remember_user('/lucky.php');

if (isset($result_returned)) {

    $user_email = $result_returned;
    $all_single_Numbers = array();

    $get_saved_singles = "SELECT lottSingle FROM savesingles WHERE userEmail = '$user_email'";
    $db_connection = openCon();
    $result_set = $db_connection->query($get_saved_singles);

    if ($result_set->num_rows > 0) {
        while ($row = $result_set->fetch_assoc()) {
            $all_single_Numbers[] = $row['lottSingle'];
        }
    }

    print_nums($all_single_Numbers);
}
