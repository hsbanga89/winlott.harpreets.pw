<?php
session_start();
include '../common/sql/dataSqlMarriage.php';
include '../common/functions_file.php';

$result_returned = remember_user();

if (isset($result_returned)) {
    $user_email = $result_returned;

    if (isset($_SERVER['HTTP_SUBMIT_VALUE']) && $_SERVER['HTTP_SUBMIT_VALUE'] === 'getComboNames') {
        $get_saved_names = "SELECT comboname from savecombo WHERE useremail = '$user_email'";
        $result_set = db_connect_result($get_saved_names);

        $combo_names_array = array();

        if ($result_set->num_rows > 0) {
            while ($row = $result_set->fetch_assoc()) {
                $combo_names_array[] = $row['comboname'];
            }
        }

//    Sending all combo names to jQuery to stop duplicate names from being used
        send_to_ajax($combo_names_array);
    }

//    Code to save single numbers or combinations depending on the radio option selected
    if (isset($_POST['optionsRadio'])) {
        if (count($_POST['checkbox']) > 0 && count($_POST['checkbox']) <= 8) {

            $unique_nums = array();
            $duplicate_nums = array();

            $date_array = date_function();
            $savedNums = $_POST['checkbox'];

//            If individual radio option is selected
            if ($_POST['optionsRadio'] == 1) {
                $get_user = "SELECT lottsingle FROM savesingles WHERE useremail = '$user_email'";
                $result_set = db_connect_result($get_user);

                if ($result_set->num_rows > 0) {
                    while ($row = $result_set->fetch_assoc()) {

//                        If the selected numbers are already saved, search index and push to duplicates array
                        if (in_array($row['lottsingle'], $savedNums)) {
                            $value_index = array_search($row['lottsingle'], $savedNums);
                            array_push($duplicate_nums, $savedNums[$value_index]);
                            unset($savedNums[$value_index]);
                        }
                    }
                }

//                Numbers not already in database are sent to unique array
                foreach ($savedNums as $k => $v) {
                    array_push($unique_nums, $v);
                }

                for ($i = 0; $i < count($unique_nums); $i++) {
                    $insert_single = "INSERT INTO savesingles(useremail, savedate, lottsingle) VALUES ('" . $user_email . "', '" . $date_array['this-date'] . "', " . $unique_nums[$i] . ")";
                    db_connect_result($insert_single);
                }
                send_to_ajax("Numbers saved", $unique_nums, "Numbers already present", $duplicate_nums);
            }

            if ($_POST['optionsRadio'] == 2 && isset($_POST['comboName']) && strlen($_POST['comboName']) <= 30) {
                $get_user = "SELECT combonum1, combonum2, combonum3, combonum4, combonum5, combonum6, combonum7, combonum8 FROM savecombo WHERE useremail = '$user_email'";
                $result_set = db_connect_result($get_user);

//                Sort the sent combination
                asort($savedNums);

//                Store combination name
                $combo_name = inputCheck(true, $_POST['comboName']);

                if ($result_set->num_rows > 0) {
                    while ($row = $result_set->fetch_assoc()) {
                        $combo_array = array();

                        foreach ($row as $k => $v) {
                            if (strlen($v) !== 0) {
                                $combo_array[$k] = $v;
                            }
                        }

//                        check if current combination is not already stored
                        if (count(array_intersect($combo_array, $savedNums)) === count($savedNums)) {
                            $duplicate_nums = $savedNums;
                            $unique_nums = array();
                            break;
                        } else {
                            $unique_nums = $savedNums;
                        }
                    }
                } else {
                    $unique_nums = $savedNums;
                }

//                Insert combination to database, if not already present
                if (count($duplicate_nums) !== count($savedNums) && count($unique_nums) !== 0) {

//                Store all column names in combo_column_array & all fields in $combo_column_fields
                    $combo_column_array = array();

                    for ($i = 0; $i < count($unique_nums); $i++) {
                        $combo_column_array[$i] = "combonum" . ($i + 1);
                    }

                    $combo_column_names = implode(", ", $combo_column_array);
                    $combo_column_fields = implode(",", $unique_nums);

                    $insert_combo = "INSERT INTO savecombo(useremail, savedate, comboname," . $combo_column_names . ") VALUES ('$user_email', '" . $date_array['this-date'] . "', '$combo_name', $combo_column_fields)";
                    db_connect_result($insert_combo);
                }
                send_to_ajax("Combination saved", $unique_nums, "Combination already present", $duplicate_nums);
            }
        }
    }
} else {
    display_login_page('/mainPage/saveNumbersPage.php');
}

