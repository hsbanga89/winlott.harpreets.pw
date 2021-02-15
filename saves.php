<?php

session_start();
include 'common/sql/dataSqlMarriage.php';
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

<div class="container outermost-div px-3 px-sm-5">
    <div class="row">
        <div class="col-lg-7">
            <h4 class="text-dark">Save Numbers</h4>
            <hr>
            <form id="saves-form">
                <div class="form-group mb-2">
                    <div class="form-check text-center mb-3">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" value="1" id="singlesRadio" name="optionsRadio"
                                   class="custom-control-input saveNumsOptions" required>
                            <label class="custom-control-label" for="singlesRadio">Individuals</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" value="2" id="combosRadio" name="optionsRadio"
                                   class="custom-control-input saveNumsOptions" required>
                            <label class="custom-control-label" for="combosRadio">Combination</label>
                        </div>
                    </div>
                    <div class="text-center saveNumsDiv">
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="1" name="checkbox[]" class="saveNums"
                                   data-toggle="button">1
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="2" name="checkbox[]" class="saveNums"
                                   data-toggle="button">2
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="3" name="checkbox[]" class="saveNums"
                                   data-toggle="button">3
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="4" name="checkbox[]" class="saveNums"
                                   data-toggle="button">4
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="5" name="checkbox[]" class="saveNums"
                                   data-toggle="button">5
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="6" name="checkbox[]" class="saveNums"
                                   data-toggle="button">6
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="7" name="checkbox[]" class="saveNums"
                                   data-toggle="button">7
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="8" name="checkbox[]" class="saveNums"
                                   data-toggle="button">8
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="9" name="checkbox[]" class="saveNums"
                                   data-toggle="button">9
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="10" name="checkbox[]" class="saveNums"
                                   data-toggle="button">10
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="11" name="checkbox[]" class="saveNums"
                                   data-toggle="button">11
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="12" name="checkbox[]" class="saveNums"
                                   data-toggle="button">12
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="13" name="checkbox[]" class="saveNums"
                                   data-toggle="button">13
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="14" name="checkbox[]" class="saveNums"
                                   data-toggle="button">14
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="15" name="checkbox[]" class="saveNums"
                                   data-toggle="button">15
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="16" name="checkbox[]" class="saveNums"
                                   data-toggle="button">16
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="17" name="checkbox[]" class="saveNums"
                                   data-toggle="button">17
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="18" name="checkbox[]" class="saveNums"
                                   data-toggle="button">18
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="19" name="checkbox[]" class="saveNums"
                                   data-toggle="button">19
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="20" name="checkbox[]" class="saveNums"
                                   data-toggle="button">20
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="21" name="checkbox[]" class="saveNums"
                                   data-toggle="button">21
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="22" name="checkbox[]" class="saveNums"
                                   data-toggle="button">22
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="23" name="checkbox[]" class="saveNums"
                                   data-toggle="button">23
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="24" name="checkbox[]" class="saveNums"
                                   data-toggle="button">24
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="25" name="checkbox[]" class="saveNums"
                                   data-toggle="button">25
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="26" name="checkbox[]" class="saveNums"
                                   data-toggle="button">26
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="27" name="checkbox[]" class="saveNums"
                                   data-toggle="button">27
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="28" name="checkbox[]" class="saveNums"
                                   data-toggle="button">28
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="29" name="checkbox[]" class="saveNums"
                                   data-toggle="button">29
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="30" name="checkbox[]" class="saveNums"
                                   data-toggle="button">30
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="31" name="checkbox[]" class="saveNums"
                                   data-toggle="button">31
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="32" name="checkbox[]" class="saveNums"
                                   data-toggle="button">32
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="33" name="checkbox[]" class="saveNums"
                                   data-toggle="button">33
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="34" name="checkbox[]" class="saveNums"
                                   data-toggle="button">34
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="35" name="checkbox[]" class="saveNums"
                                   data-toggle="button">35
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="36" name="checkbox[]" class="saveNums"
                                   data-toggle="button">36
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="37" name="checkbox[]" class="saveNums"
                                   data-toggle="button">37
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="38" name="checkbox[]" class="saveNums"
                                   data-toggle="button">38
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="39" name="checkbox[]" class="saveNums"
                                   data-toggle="button">39
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="40" name="checkbox[]" class="saveNums"
                                   data-toggle="button">40
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="41" name="checkbox[]" class="saveNums"
                                   data-toggle="button">41
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="42" name="checkbox[]" class="saveNums"
                                   data-toggle="button">42
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="43" name="checkbox[]" class="saveNums"
                                   data-toggle="button">43
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="44" name="checkbox[]" class="saveNums"
                                   data-toggle="button">44
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="45" name="checkbox[]" class="saveNums"
                                   data-toggle="button">45
                        </label>
                    </div>
                    <div class="px-3 my-2 px-md-5">
                        <div class="form-row m-auto" id="combo-name-div">
                            <label for="combo-name" class="col-sm-5 col-xl-4 col-form-label text-nowrap">Combination
                                Title</label>
                            <div class="col-sm-7 col-xl-8">
                                <input type="text" class="form-control text-left" id="combo-name" name="comboName"
                                       placeholder="e.g. combo1">
                            </div>
                        </div>
                    </div>
                    <div class="text-center my-3">
                        <div class="d-inline mx-2">
                            <button type="button" class="btn btn-outline-danger" id="save-reset" name="save-nums-reset">Reset</button>
                        </div>
                        <div class="d-inline mx-2">
                            <button type="submit" class="btn btn-outline-dark saveSubmit" name="save-nums-submit">Submit
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-5 mt-3 mt-lg-0">
            <h4 class="text-dark">Saved Numbers</h4>
            <hr>
            <div id="print-saved-nums-div"></div>
        </div>
    </div>
</div>

<?php
include 'common/footer.html';
?>

<script src="/js/saves.js"></script>

</body>

</html>