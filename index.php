<!DOCTYPE html>
<html lang="en">

<?php
include 'common/header.html';
?>

<body>

<?php
include 'common/navbar.php';
?>

<div class="container outermost-div text-center px-3 px-sm-5">
    <h2 class="text-dark">Welcome to WinLott</h2>
    <div class="greetings">
        <p class="greetings-pg"></p>
    </div>
    <p>
        Here are the predicted numbers for tonight's lottery.
    </p>
    <div id="home-predictions"></div>
</div>

<?php
include 'common/footer.html';
?>
<script src="/js/indexScript.js"></script>

</body>

</html>