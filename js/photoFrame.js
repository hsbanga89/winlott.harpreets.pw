$(document).ready(function () {
    function readURL(input) {

        if (input.files && input.files[0]) {
            let reader = new FileReader();

            reader.onload = function (e) {
                let imagePreview = $(".avatar-preview #image-preview");
                imagePreview.css('background-image', 'url(' + e.target.result + ')').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".input-div #image-upload").on("change", function () {
        readURL(this);
    });

    let profileEditButton = $(".profile-edit-button");
    let profileSaveButton = $(".profile-save-button");
    let profileUploadLabel = $(".dp-div .avatar-upload .input-div label");
    let profileEditableInputs = $(".profile-editable-inputs");
    let profileEditableSelects = $(".profile-editable-select");

    profileEditButton.on("click", function () {

        if (profileEditButton.val() === "profile-edit") {
            profileEditButton.val("profile-cancel").text("Cancel");
            profileSaveButton.prop("disabled", false).removeClass("disabled");

            profileUploadLabel.removeClass("disabled");
            profileEditableInputs.removeAttr("disabled");
            profileEditableSelects.removeAttr("disabled");

        } else if (profileEditButton.val() === "profile-cancel") {
            profileEditButton.val("profile-edit").text("Edit");
            profileSaveButton.prop("disabled", true).addClass("disabled");

            profileUploadLabel.addClass("disabled");
            profileEditableInputs.prop("disabled", true);
            profileEditableSelects.prop("disabled", true);
        }
    });
});