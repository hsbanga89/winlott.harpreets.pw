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
            <small class="text-dark">Select the numbers from all 4 sets and press submit.</small>
            <div class="mx-3">
                <span class="fa fa-info-circle mr-2 text-secondary"></span>
                <small>This game is designed for lotteries with 6 six numbers only. Sum of all numbers must not be
                    greater than 45.</small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7">
            <h4 class="text-dark">Delta System</h4>
            <hr>
            <form id="delta-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group mb-2">
                    <label for="first-btn-group">Pick a number</label>
                    <div class="" id="first-btn-group">
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="1" name="checkbox-set1" data-check_set=1
                                   class="deltaNums" data-toggle="button">1
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="2" name="checkbox-set1" data-check_set=1
                                   class="deltaNums" data-toggle="button">2
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="3" name="checkbox-set1" data-check_set=1
                                   class="deltaNums" data-toggle="button">3
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="4" name="checkbox-set1" data-check_set=1
                                   class="deltaNums" data-toggle="button">4
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="5" name="checkbox-set1" data-check_set=1
                                   class="deltaNums" data-toggle="button">5
                        </label>
                        <label class="exceedInfo float-right" id="exceedInfo1">
                            <span class="badge badge-success" data-check_set=1></span>
                        </label>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="second-btn-group">Pick two numbers</label>
                    <div class="" id="second-btn-group">
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="1" name="checkbox-set2[]" data-check_set=2
                                   class="deltaNums" data-toggle="button">1
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="2" name="checkbox-set2[]" data-check_set=2
                                   class="deltaNums" data-toggle="button">2
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="3" name="checkbox-set2[]" data-check_set=2
                                   class="deltaNums" data-toggle="button">3
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="4" name="checkbox-set2[]" data-check_set=2
                                   class="deltaNums" data-toggle="button">4
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="5" name="checkbox-set2[]" data-check_set=2
                                   class="deltaNums" data-toggle="button">5
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="6" name="checkbox-set2[]" data-check_set=2
                                   class="deltaNums" data-toggle="button">6
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="7" name="checkbox-set2[]" data-check_set=2
                                   class="deltaNums" data-toggle="button">7
                        </label>
                        <label class="exceedInfo float-right" id="exceedInfo2">
                            <span class="badge badge-success" data-check_set=2></span>
                        </label>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="third-btn-group">Pick one number</label>
                    <div class="" id="third-btn-group">
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="7" name="checkbox-set3" data-check_set=3
                                   class="deltaNums" data-toggle="button">7
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="9" name="checkbox-set3" data-check_set=3
                                   class="deltaNums" data-toggle="button">9
                        </label>
                        <label class="exceedInfo float-right" id="exceedInfo3">
                            <span class="badge badge-success" data-check_set=3></span>
                        </label>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="fourth-btn-group">Pick two numbers</label>
                    <div class="" id="fourth-btn-group">
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="8" name="checkbox-set4[]" data-check_set=4
                                   class="deltaNums" data-toggle="button">8
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="9" name="checkbox-set4[]" data-check_set=4
                                   class="deltaNums" data-toggle="button">9
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="10" name="checkbox-set4[]" data-check_set=4
                                   class="deltaNums" data-toggle="button">10
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="11" name="checkbox-set4[]" data-check_set=4
                                   class="deltaNums" data-toggle="button">11
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="12" name="checkbox-set4[]" data-check_set=4
                                   class="deltaNums" data-toggle="button">12
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="13" name="checkbox-set4[]" data-check_set=4
                                   class="deltaNums" data-toggle="button">13
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="14" name="checkbox-set4[]" data-check_set=4
                                   class="deltaNums" data-toggle="button">14
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="checkbox" value="15" name="checkbox-set4[]" data-check_set=4
                                   class="deltaNums" data-toggle="button">15
                        </label>
                        <label class="exceedInfo float-right" id="exceedInfo4">
                            <span class="badge badge-success" data-check_set=4></span>
                        </label>
                    </div>
                </div>
                <div class="form-group row mb-1 mt-3">
                    <div class="col-4 text-right">
                        <button type="button" class="btn btn-outline-danger" id="delta-reset" name="delta-reset">
                            Reset
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-outline-dark deltaSubmit" name="nums-submit">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-5 mt-3 mt-lg-0">
            <h4 class="text-dark">Your Numbers</h4>
            <hr>
            <?php

            if (isset($_POST['nums-submit'])) {
                $num1 = $_POST['checkbox-set1'];
                $num2 = $_POST['checkbox-set2'][0];
                $num3 = $_POST['checkbox-set2'][1];
                $num4 = $_POST['checkbox-set3'];
                $num5 = $_POST['checkbox-set4'][0];
                $num6 = $_POST['checkbox-set4'][1];

                $selectedNums = array($num1, $num2, $num3, $num4, $num5, $num6);
                shuffle($selectedNums);

                $lotNum1 = $selectedNums[0];
                $lotNum2 = $lotNum1 + $selectedNums[1];
                $lotNum3 = $lotNum2 + $selectedNums[2];
                $lotNum4 = $lotNum3 + $selectedNums[3];
                $lotNum5 = $lotNum4 + $selectedNums[4];
                $lotNum6 = $lotNum5 + $selectedNums[5];

                $lot_array = array($lotNum1, $lotNum2, $lotNum3, $lotNum4, $lotNum5, $lotNum6);

                echo "<div class='d-inline-flex'>";
                for ($i = 0; $i < count($lot_array); $i++) {
                    echo "<span class='badge badge-primary font-weight-light m-1' style='font-size: 1.3rem; width: 2.5rem;'>";
                    echo $lot_array[$i];
                    echo "</span>";
                }
                echo '</div>';
            }

            ?>
        </div>
    </div>
</div>

<?php
include '../common/footer.php';
?>

<script src="/js/deltaScript.js"></script>

</body>

</html>