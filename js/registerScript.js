$(document).ready(function () {
    let todayDate;
    let minDate;
    let maxDate;
    let registerForm = $("#register-form");
    let registerFirstname = $("#register-firstname");
    let registerLastname = $("#register-lastname");
    let registerDatepicker = $("#register-birthdate");
    let registerCountry = $("#register-country");
    let registerEmail = $("#register-email");
    let registerPassword = $("#register-password");
    let registerRepeatPassword = $("#register-password-repeat");
    let registerSubmitButton = $("form #register-button");
    let registerFieldsArray = [
        registerFirstname,
        registerLastname,
        registerDatepicker,
        registerCountry,
        registerEmail,
        registerPassword,
        registerRepeatPassword
    ];

    function dateFunction() {
        let fullDate = new Date();
        let currentDate = fullDate.getDate();
        let currentMonth = fullDate.getMonth();
        let currentYear = fullDate.getFullYear();
        let minYear = fullDate.getFullYear() - 99;
        let maxYear = fullDate.getFullYear() - 18;

        if (currentDate.toString().length < 2) {
            currentDate = '0' + currentDate;
        }

        if (currentMonth.toString().length < 2) {
            currentMonth++;
            currentMonth = '0' + currentMonth;
        }

        todayDate = [currentYear, currentMonth, currentDate].join('-').toString();
        minDate = [minYear, currentMonth, currentDate].join('-');
        maxDate = [maxYear, currentMonth, currentDate].join('-');
    }

    dateFunction();

    registerDatepicker.on("focus", function () {
        $(this).attr("type", "date");
        $(this).attr({"min": minDate, "max": maxDate});
    });

    registerDatepicker.on("focusout", function () {
        if (!$(this).val()) {
            $(this).attr("type", "text");
        }
    });

    registerCountry.on("change", function () {
        registerCountry.css("color","#495057");
    });

    registerForm.submit(function (evt) {
        registerSubmitButton.prop("disable", true);

        for (let i = 0; i < registerFieldsArray.length; i++) {
            if (registerFieldsArray[i].attr("id") === 'register-country') {
                if (registerFieldsArray[i].val() === '' || registerFieldsArray[i].val() === null) {
                    evt.preventDefault();
                    registerFieldsArray[i].addClass("inputErrors");

                    setTimeout(function () {
                        registerFieldsArray[i].removeClass("inputErrors");
                    }, 1000);
                }
            } else {
                if (registerFieldsArray[i].val().trim().length === 0) {
                    evt.preventDefault();
                    registerFieldsArray[i].addClass("inputErrors");

                    setTimeout(function () {
                        registerFieldsArray[i].removeClass("inputErrors");
                    }, 1000);
                }
            }
        }
    });

    $('#dialog-modal').modal('show');
});