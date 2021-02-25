<?php
session_start();
include 'common/sql/dataSqlMarriage.php';
include 'common/functions_file.php';

$result_returned = remember_user();
?>

<!DOCTYPE html>
<html lang="en">

<?php
include 'common/header.php';
?>

<body>

<?php
include 'common/navbar.php';
?>

<div class="container outermost-div text-center px-3 px-sm-5 text-dark">
    <h2 class="text-dark">Welcome to WinLott</h2>
    <div class="greetings">
        <p class="greetings-pg"></p>
    </div>
    <div>
        <p>
            Here are the predicted numbers for tonight's lottery.
        </p>
    </div>
    <div>
        <div id="home-predictions-lott-name" class="mt-3 mb-2"></div>
        <div id="home-predictions"></div>
    </div>
    <small>* Numbers are predicted for Australian Lotteries every day, automatically.</small>
</div>

<?php
include 'common/footer.php';
?>

<?php
$disclaimer_message = "<p>winlott.harpreets.pw has been developed only to showcase the Operator's programming skills and acts as a portfolio. " .
    "For more information, please see <a href='termsOfUse.php'>Terms & Conditions</a> and <a href='privacyPolicy.php'>Privacy Policy</a>.</p>" .
    "<p>By accessing and using this website, you acknowledge that you have read, understood, and agree with the terms of use and privacy policy.</p>";

$ip_addr = get_client_ip();
$date_array = date_function();

if (isset($ip_addr) && !empty($ip_addr)) {
    $get_all_ips = "SELECT ipaddress, disclaimershown FROM ipaddressvisits WHERE ipaddress = '$ip_addr';";
    $add_new_ip = "INSERT INTO ipaddressvisits(ipaddress, lastvisit, disclaimershown) VALUES ('$ip_addr','" . $date_array['this-date'] . "', 1)";
    $ip_exists = db_connect_result($get_all_ips);

    if ($ip_exists->num_rows < 1) {
        db_connect_result($add_new_ip);
        dialog_modal("Disclaimer", $disclaimer_message, "Accept");
    }
}
?>

<script src="/js/indexScript.js"></script>

</body>

</html>