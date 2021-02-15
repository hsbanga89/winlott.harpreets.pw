$(document).ready(function () {

    let deltaForm = $("#delta-form");
    let allDeltaNums = $(".deltaNums");
    let deltaSubmit = $(".deltaSubmit");
    let deltaResetButton = $("#delta-reset");
    let exceedInfoSpan = $(".exceedInfo span");
    let biggestNum = 45, sum = biggestNum, numsSelected = 0;
    let previousSets = [];

    function disableDeltaSubmit() {
        deltaSubmit.prop("disabled", true).parent().toggleClass("disabled", true);
        deltaSubmit.removeClass("btn-outline-success").addClass("btn-outline-dark");
    }

    function enableDeltaSubmit() {
        deltaSubmit.prop("disabled", false).parent().toggleClass("disabled", false);
        deltaSubmit.removeClass("btn-outline-dark").addClass("btn-outline-success");
    }

    function resetForm() {
        deltaForm.trigger('reset');
        disableDeltaSubmit();
        numsSelected = 0;
        sum = biggestNum;
        exceedInfoSpan.html("");
        allDeltaNums.prop("disabled", false);
        allDeltaNums.parent().removeClass('active disabled').prop('aria-pressed', false);
    }

    disableDeltaSubmit();

    deltaResetButton.click(function (evt) {
        evt.preventDefault();
        resetForm();
    });

    allDeltaNums.on("click", function (evt) {
        let disable;
        let selectedValue = $(this).prop("value");

        // Get the data-chk_set value.
        let check_set = $(this).data("check_set");

        // Get the checkboxes of this set.
        let this_set = allDeltaNums.filter((i, check) => $(check).data("check_set") === check_set);

        // Get all checked buttons.
        let checkedButtonsInSet = this_set.filter((i, check) => $(check).is(":checked"));

        // Get all unchecked buttons.
        let uncheckedButtonsInSet = this_set.filter((i, check) => !$(check).is(":checked"));

        // Disabling other buttons after maximum number of buttons are selected in a set.
        if (check_set === 2 || check_set === 4) {
            disable = checkedButtonsInSet.length >= 2;
        } else {
            disable = checkedButtonsInSet.length >= 1;
        }

        // Enable/disable and add/remove class on buttons
        uncheckedButtonsInSet.prop("disabled", disable).parent().toggleClass("disabled", disable);

        // Preventing the total from going over the biggest number.
        stopExceed($(this), selectedValue);

        exceedInfoFunction(sum, numsSelected, check_set);

        if (numsSelected !== 6 || sum < 0) {
            disableDeltaSubmit();
        } else {
            enableDeltaSubmit();
        }
    });

    function stopExceed(this_element, this_value) {
        if (this_element.is(":checked")) {
            sum -= parseInt(this_value);
            numsSelected++;
        } else {
            if (this_element.focus() && !this_element.is("checked")) {
                sum += parseInt(this_value);
                numsSelected--;
            }
        }
    }

    function exceedInfoFunction(sum, numsSelected, currentSet) {
        let exceedInfoSet;
        let exceedInfo;

        exceedInfoSet = "#exceedInfo" + previousSets.pop();
        exceedInfo = $(exceedInfoSet + " span");
        exceedInfo.html("");

        exceedInfoSet = "#exceedInfo" + currentSet;
        exceedInfo = $(exceedInfoSet + " span");

        exceedInfo.html("Remaining : " + sum);
        previousSets.push(currentSet);

        if ((sum >= 0 && sum < 27) && numsSelected < 6) {
            exceedInfo.removeClass("badge-success").removeClass("badge-danger").addClass("badge-warning");
        } else if (sum < 0) {
            exceedInfo.removeClass("badge-success").removeClass("badge-warning").addClass("badge-danger");
        } else {
            if (sum >= 0 && numsSelected === 6) {
                exceedInfo.removeClass("badge-warning").removeClass("badge-danger").addClass("badge-success");
                exceedInfo.html("\u2713 Done");
            }
        }
    }
});