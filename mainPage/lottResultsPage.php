<?php
session_start();
include '../common/functions_file.php';

$result_returned = remember_user();
?>

<!DOCTYPE html>
<html lang="en">

<?php
include '../common/header.php';
?>

<body>

<?php
include '../common/navbar.php';
?>

<div class="container outermost-div px-3 px-sm-5 text-dark">
    <div class="row">
        <div class="col-12 mb-3">
            <span class="badge badge-secondary mr-2 px-2 text-light font-weight-light">Instructions</span>
            <small class="text-dark">The results from major Australian Lotteries are displayed here.</small>
        </div>
    </div>
    <h4 class="text-dark">Results</h4>
    <hr>
    <div class="legends-div text-right">
        <span id='supplement-nums-legend' class='fa fa-square text-secondary m-0' style='font-size: 0.85rem;'></span>
        <label for='supplement-nums-legend' class='px-1 my-0' style='font-size: 0.75rem;'>Powerball / Supplementary
            Number</label>
    </div>
    <div id="display-results"></div>
</div>

<?php
include '../common/footer.php';
?>
<script src="/js/resultsScript.js"></script>

</body>

</html>