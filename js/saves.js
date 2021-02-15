$(document).ready(function () {

    let savesForm = $("#saves-form");
    let saveSubmit = $(".saveSubmit");
    let allSavePageInputs = $("form input");
    let allNumCheckboxes = $("form input[type=checkbox]");
    let singlesRadioOption = $("form input#singlesRadio");
    let comboRadioOption = $("form input#combosRadio");
    let comboNameInput = $("#combo-name-div #combo-name");
    let comboNameLabel = $("#combo-name-div label");
    let printSavedNumsDiv = $("#print-saved-nums-div");
    let saveResetButton = $("#saves-form #save-reset");
    let comboNamesArray = [];
    let comboNamePresent = true;
    let selectCounter = 0;

    function disableSaveSubmit() {
        saveSubmit.prop("disabled", true).parent().toggleClass("disabled", true);
        saveSubmit.removeClass("btn-outline-primary").addClass("btn-outline-dark");
    }

    function enableSaveSubmit() {
        saveSubmit.prop("disabled", false).parent().toggleClass("disabled", false);
        saveSubmit.removeClass("btn-outline-dark").addClass("btn-outline-primary");
    }

    function resetForm() {
        savesForm.trigger('reset');
        allNumCheckboxes.parent().removeClass('active').prop('aria-pressed', false);
    }

    function showComboNameInput() {
        if (comboRadioOption.is(":checked")) {
            comboNameInput.prop("disabled", false).show();
            comboNameLabel.show();
        } else {
            comboNameInput.prop("disabled", true).hide();
            comboNameLabel.hide();
        }
    }

    disableSaveSubmit();
    comboNameInput.prop("disabled", true).hide();
    comboNameLabel.hide();

    saveResetButton.click(function (evt) {
        evt.preventDefault();
        resetForm();
    });

    comboRadioOption.on("change", function (evt) {
        showComboNameInput();

        $.ajax({
            url: "/savesAjax.php",
            type: "GET",
            data: {},
            dataType: "text"
        }).done(function (data) {
            let namesArray = JSON.parse(data);

            $.each(namesArray, function (index, value) {
                comboNamesArray.push(value);
            });
        });
    });

    comboNameInput.on("keyup keydown", function () {
        if ($.inArray(comboNameInput.val(), comboNamesArray) >= 0) {
            comboNamePresent = true;
            comboNameInput.addClass("inputErrors");
        } else {
            comboNamePresent = false;
            comboNameInput.removeClass("inputErrors");
        }
    });

    allSavePageInputs.on("click keyup keydown", function () {

        showComboNameInput();
        let checkedElements = allNumCheckboxes.filter((i, checkboxElement) => $(checkboxElement).is(":checked"));
        selectCounter = checkedElements.length;

        if (!singlesRadioOption.is(":checked") && !comboRadioOption.is(":checked")) {
            disableSaveSubmit();
        } else if (singlesRadioOption.is(":checked") && (selectCounter <= 0 || selectCounter > 6)) {
            disableSaveSubmit();
        } else if (comboRadioOption.is(":checked") && (selectCounter < 6 || selectCounter > 8)) {
            disableSaveSubmit();
        } else if (comboRadioOption.is(":checked") && comboNameInput.val().length <= 0) {
            disableSaveSubmit();
        } else if (comboRadioOption.is(":checked") && comboNamePresent === true) {
            disableSaveSubmit();
        } else {
            enableSaveSubmit();
        }
    });

    savesForm.submit(function (evt) {
        evt.preventDefault();

        $.ajax({
            url: "/savesAjax.php",
            method: "POST",
            headers: {'Submit-Value': 'saveSubmit'},
            data: savesForm.serializeArray(),
            dataType: "text"
        }).done(function (data) {
            console.log(data);
            let jsonParsedData = JSON.parse(data);
            let prepareSavedNumsDiv = [];

            $.each(jsonParsedData, function (key, val) {

                if (val.length !== 0 && typeof val === 'object') {
                    prepareSavedNumsDiv.push("<div class='form-group'>");
                    prepareSavedNumsDiv.push("<h6>" + jsonParsedData[key - 1] + "</h6>");
                    prepareSavedNumsDiv.push("<div class='d-inline-flex'>");

                    for (let i = 0; i < val.length; i++) {
                        prepareSavedNumsDiv.push("<span class='badge badge-primary font-weight-light m-1' style='font-size: 1.3rem; width: 2.5rem;'>"
                            + val[i] +
                            "</span>");
                    }
                    prepareSavedNumsDiv.push("</div></div>");
                }
            });
            printSavedNumsDiv.html(prepareSavedNumsDiv.join(' '));
        });
        resetForm();
    });
});
