<?php

function db_connect_result($query_string)
{
    $db_connection = openCon();
    $query_result = $db_connection->query($query_string);
    closeCon($db_connection);
    return $query_result;
}

function inputCheck(bool $db_input, string $input): string
{
    $trim_spaces = trim($input);
    $remove_slashes = stripslashes($trim_spaces);
    $strip_tags = strip_tags($remove_slashes);
    $html_entities = htmlentities($strip_tags);

    if ($db_input === true) {
        $db_connection = openCon();
        $escaped_string = $db_connection->real_escape_string($html_entities);
        closeCon($db_connection);
        return $escaped_string;
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

function get_client_ip(): string
{
    $client_ip = '';

    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        if ($_SERVER['HTTP_X_FORWARDED_FOR'] !== '127.0.0.1' && $_SERVER['HTTP_X_FORWARDED_FOR'] !== '::1') {
            $client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
        if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
            $client_ip = $_SERVER['REMOTE_ADDR'];
        }
    }
    return $client_ip;
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
        try {
            $date_time_object = new DateTime(date('Y-m-d'));
            $added_days = $date_time_object->add(new DateInterval($add_days));
        } catch (Exception $e) {
            return array("Something went wrong ");
        }
    }

    return array(
        'this-date' => date("Y-m-d"),
        'this-day' => date("l"),
        'this-time' => date("H:i:s"),
        'added-days' => $added_days
    );
}

function send_to_ajax(...$args)
{
    echo json_encode($args);
}

function dialog_modal($dialog_heading, $dialog_message, $button_text)
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
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-primary' data-dismiss='modal'>$button_text</button>
                    </div>
                </div>
            </div>
        </div>";
}

function remember_user()
{
    if (isset($_SESSION['winlott-valid-name'])) {
        return $_SESSION['winlott-valid-name'];
    } elseif (isset($_COOKIE['winlott-user']) && isset($_COOKIE['remember-me'])) {
        $_SESSION['winlott-valid-name'] = $_COOKIE['winlott-user'];
        return $_SESSION['winlott-valid-name'];
    } else {
        return null;
    }
}

function display_login_page($page_url)
{
    include 'header.php';
    include 'navbar.php';

    $_SESSION['redirected-from'] = $page_url;

    echo "<div class='container outermost-div px-3 px-sm-5 text-dark'>
                <h4 class='text-dark'>Login Required</h4>
                <hr>";
    echo "Please <a href='/mainPage/letMeIn.php'>Login</a> first.";
    echo "</div>";

    include 'footer.php';
    die();
}
