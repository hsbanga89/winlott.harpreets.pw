$(document).ready(function () {

    let loginForm = $("form.user");
    let loginEmail = $("form.user #login-input-email");
    let loginPassword = $("form.user #login-input-password");
    let loginRemember = $("form.user #remember-check");

    loginPassword.attr("pattern",);

    function inputError(evt, inputField) {
        evt.preventDefault();
        inputField.addClass("inputErrors");

        setTimeout(function () {
            inputField.removeClass("inputErrors");
        }, 1000);
    }

    loginForm.submit(function (evt) {
        if (loginEmail.val().trim().length === 0) {
            inputError(evt, loginEmail);
        }

        if (loginPassword.val().trim().length === 0) {
            inputError(evt, loginPassword);
        }
    });

    $('#dialog-modal').modal('show');
});
