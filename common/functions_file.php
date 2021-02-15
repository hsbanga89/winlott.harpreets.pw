<?php

function inputCheck($connect, $input): string
{
    $trim_spaces = trim($input);
    $remove_slashes = stripslashes($trim_spaces);
    $strip_tags = strip_tags($remove_slashes);
    $html_entities = htmlentities($strip_tags);

    if ($connect != null) {
        return $connect->real_escape_string($html_entities);
    } else {
        return $html_entities;
    }
}

function redirectTo($interval, $location)
{
    ob_start();
    header("refresh: $interval; url= $location");
    ob_end_flush();
}

function date_function(...$days): array
{
    date_default_timezone_set('Australia/Melbourne');

    $add_days = "";
    $added_days = "";
    if (count($days) > 0) {
        $add_days = 'P' . $days[0] . 'D';
    }

    if (!empty($add_days)) {
        $date_time_object = new DateTime(date('Y-m-d'));
        $added_days = $date_time_object->add(new DateInterval($add_days));
    }

    return array(
        'this-date' => date("Y-m-d"),
        'this-day' => date("l"),
        'this-time' => date("H:i:s"),
        'added-days' => $added_days
    );
}

function print_nums(...$args)
{
    echo json_encode($args);
}

function dialog_modal($dialog_heading, $dialog_message)
{
    echo "<div id='dialog-modal' class='modal' tabindex='-1' role='dialog' aria-labelledby='dialog-modal' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered modal-sm' role='document'>
                <div class='modal-content'>
                    <div class='modal-header''>
                        <strong class='modal-title' id='modalLongTitle'>$dialog_heading</strong>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span class='fa fa-close' aria-hidden='true'></span>
                        </button>
                    </div>
                    <div class='modal-body px-4'>
                        <p>$dialog_message</p>
                    </div>
                </div>
            </div>
        </div>";
}

function remember_user($page_url)
{
    if (isset($_SESSION['winlott-valid-name'])) {
        return $_SESSION['winlott-valid-name'];
    } elseif (isset($_COOKIE['winlott-user']) && isset($_COOKIE['remember-me'])) {
        return $_COOKIE['winlott-user'];
    } else {
        include 'header.html';
        include 'navbar.php';

        $_SESSION['redirected-from'] = $page_url;

        echo "<div class='container outermost-div px-3 px-sm-5 text-dark'>
                <h4 class='text-dark'>Login Required</h4>
                <hr>";
        echo "Unauthorized access. Please <a href='login.php'>Login</a> first.";
        echo "</div>";

        include 'footer.html';
        die();
    }
}
