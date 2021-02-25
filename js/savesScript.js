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
            url: "/ajaxPhp/savesAjax.php",
            type: "GET",
            headers: {'submit-value': 'getComboNames'},
            data: {},
            dataType: "text"
        }).done(function (data) {
            let namesArray;

            try {
                namesArray = JSON.parse(data);
                for (let i = 0; i < namesArray.length; i++) {
                    for (let j = 0; j < namesArray[i].length; j++) {
                        comboNamesArray.push(namesArray[i][j]);
                    }
                }
            } catch (e) {
                let errorMessage = "Something went Wrong!";
            }
        });
    });

    comboNameInput.on("input", function () {
        if ($.inArray(comboNameInput.val().slice(0, 30), comboNamesArray) >= 0) {
            comboNamePresent = true;
            comboNameInput.css({
                "border-color": "#dc3545",
                "box-shadow": "0 0 0 0.2rem rgba(220, 53, 69, 0.25)",
                "color": "#dc3545"
            });
        } else {
            comboNamePresent = false;
            comboNameInput.css({
                "border-color": "",
                "box-shadow": "",
                "color": ""
            });
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
            url: "/ajaxPhp/savesAjax.php",
            method: "POST",
            data: savesForm.serializeArray(),
            dataType: "text"
        }).done(function (data) {
            try {
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

            } catch (e) {
                let errorMessage = "Something went wrong!";
            }
        });
        resetForm();
    });
});
