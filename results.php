<!DOCTYPE html>
<html lang="en">

<?php
include 'common/header.html';
?>

<body>

<?php
include 'common/navbar.php';
?>

<div class="container outermost-div px-3 px-sm-5 text-dark">
    <h4 class="text-dark">Results</h4>
    <hr>
    <div class="legends-div text-right">
        <span id='supplement-nums-legend' class='fa fa-square text-secondary m-0' style='font-size: 0.85rem;'></span>
        <label for='supplement-nums-legend' class='px-1 my-0' style='font-size: 0.75rem;'>Powerball / Supplementary Number</label>
    </div>
    <div id="display-results"></div>
</div>

<?php
include 'common/footer.html';
?>
<script src="/js/results.js"></script>

</body>

</html>