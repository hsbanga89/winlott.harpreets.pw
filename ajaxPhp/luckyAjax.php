<?php
session_start();
include '../common/sql/dataSqlMarriage.php';
include '../common/functions_file.php';

$result_returned = remember_user();

if (isset($result_returned)) {

    $user_email = $result_returned;

    $all_single_Numbers = array();
    $all_combos = array();

    $get_saved_singles = "SELECT lottsingle FROM savesingles WHERE useremail = '$user_email'";
    $singles_result_set = db_connect_result($get_saved_singles);

    if ($singles_result_set->num_rows > 0) {
        while ($row = $singles_result_set->fetch_assoc()) {
            $all_single_Numbers[] = $row['lottsingle'];
        }
    }

    $get_saved_combos = "select comboname, combonum1, combonum2, combonum3, combonum4, combonum5, combonum6, combonum7, combonum8 from savecombo WHERE useremail = '$user_email'";
    $combos_result_set = db_connect_result($get_saved_combos);

    if ($combos_result_set->num_rows > 0) {
        while ($row = $combos_result_set->fetch_assoc()) {
            $each_combo = array();

            foreach ($row as $index => $item) {
                if (!empty($item)) {
                    $each_combo[] = $item;
                }
            }
            $all_combos[] = $each_combo;
        }
    }
    send_to_ajax($all_single_Numbers, $all_combos);
} else {
    display_login_page('/luckyNumbersPage.php');
}
