<?php

session_start();
include 'common/sql/dataSqlMarriage.php';
include 'common/functions_file.php';

$result_returned = remember_user('/saves/php');

if (isset($result_returned)) {
    $user_email = $result_returned;

    if (!isset($_SERVER['HTTP_SUBMIT_VALUE'])) {
        $get_saved_names = "SELECT comboName from savecombo WHERE userEmail = '$user_email'";
        $db_connection = opencon();
        $result_set = $db_connection->query($get_saved_names);

        $combo_names_array = array();

        if ($result_set->num_rows > 0) {
            while ($row = $result_set->fetch_assoc()) {
                $combo_names_array[] = $row['comboName'];
            }
        }
        closeCon($db_connection);

//    Sending all combo names to ajax to stop duplicate names from being used
        echo json_encode($combo_names_array);
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

                $db_connection = openCon();
                $get_user = "SELECT lottSingle FROM savesingles WHERE userEmail = '$user_email'";
                $result_set = $db_connection->query($get_user);

                if ($result_set->num_rows > 0) {
                    while ($row = $result_set->fetch_assoc()) {

//                        If the selected numbers are already saved, search index and push to duplicates array
                        if (in_array($row['lottSingle'], $savedNums)) {
                            $value_index = array_search($row['lottSingle'], $savedNums);
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
                    $insert_single = "INSERT INTO savesingles(userEmail, saveDate, lottSingle) VALUES ('" . $user_email . "', '" . $date_array['this-date'] . "', " . $unique_nums[$i] . ")";
                    $db_connection->query($insert_single);
                }

                closeCon($db_connection);
                print_nums("Numbers saved", $unique_nums, "Numbers already present", $duplicate_nums);
            }

            if ($_POST['optionsRadio'] == 2) {

                $db_connection = openCon();
                $get_user = "SELECT comboNum1, comboNum2, comboNum3, comboNum4, comboNum5, comboNum6, comboNum7, comboNum8 FROM savecombo WHERE userEmail = '$user_email'";
                $result_set = $db_connection->query($get_user);

//                Sort the sent combination
                asort($savedNums);

//                Store combination name
                $combo_name = $_POST['comboName'];

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
                        $combo_column_array[$i] = "comboNum" . ($i + 1);
                    }

                    $combo_column_names = implode(", ", $combo_column_array);
                    $combo_column_fields = implode(",", $unique_nums);

                    $insert_combo = "INSERT INTO savecombo(userEmail, saveDate, comboName," . $combo_column_names . ") VALUES ('$user_email', '" . $date_array['this-date'] . "', '$combo_name', $combo_column_fields)";
                    $db_connection->query($insert_combo);
                }

                closeCon($db_connection);
                print_nums("Combination saved", $unique_nums, "Combination already present", $duplicate_nums);
            }
        }
    }
}

