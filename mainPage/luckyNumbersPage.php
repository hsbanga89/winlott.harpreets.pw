<?php
session_start();
include '../common/functions_file.php';

$result_returned = remember_user();
if (!isset($result_returned)) {
    display_login_page(htmlspecialchars($_SERVER['PHP_SELF']));
}
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
    <div class="mb-3">
        <span class="badge badge-secondary mr-2 px-2 text-light font-weight-light">Instructions</span>
        <small class="text-dark">This page (for now) displays all the individual and combinations numbers saved by
            the user.</small>
        <div class="mx-3">
            <span class="fa fa-info-circle mr-2 text-secondary"></span>
            <small>The page is a work in progress, when finished, the user will be able to predict numbers from the
                numbers they have saved.</small>
        </div>
    </div>
    <h4 class="text-dark">Lucky Numbers</h4>
    <hr>
    <div id="saved-nums-display-area" class="text-left">
        <div id="saved-singles-div"></div>
        <div id="saved-combos-div"></div>
    </div>
</div>


<?php
include '../common/footer.php';
?>
<script src="/js/luckyScript.js"></script>

</body>

</html>
