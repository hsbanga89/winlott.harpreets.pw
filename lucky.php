<?php

session_start();
include 'common/functions_file.php';

$result_returned = remember_user(htmlspecialchars($_SERVER['PHP_SELF']));

if (!isset($result_returned)) {
    die();
}

?>

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
    <div class="row">
        <div class="col-lg-7">
            <h4 class="text-dark">Lucky Numbers</h4>
            <hr>
            <div id="saved-singles-div" class="form-row">
            </div>
            <div id="saved-combos-div">

            </div>
        </div>
    </div>
</div>

<?php
include 'common/footer.html';
?>
<script src="js/lucky.js"></script>

</body>

</html>
