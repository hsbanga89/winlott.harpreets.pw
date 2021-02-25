$(document).ready(function () {

    let profileEditCancelDiv = $("#profile-edit-cancel-div");
    let profileSaveButton = $("#profile-save-button");
    let profileUploadLabel = $(".dp-div .avatar-upload .input-div label");
    let profileEditableInputs = $(".profile-editable-inputs");
    let profileEditableSelects = $(".profile-editable-select");

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

    profileEditCancelDiv.click(function () {
        if (this.firstElementChild.id === 'profile-edit-button') {
            profileEditCancelDiv.html('<button type="button" id="profile-cancel-button" ' +
                'class="btn btn-outline-primary px-md-5" value="profile-cancel">Cancel</button>');
            profileSaveButton.prop("disabled", false).removeClass("disabled");
            profileUploadLabel.removeClass("disabled");
            profileEditableInputs.removeAttr("disabled");
            profileEditableSelects.removeAttr("disabled");
        } else {
            profileEditCancelDiv.html('<button type="button" id="profile-edit-button" ' +
                'class="btn btn-outline-primary px-md-5" value="profile-edit">Edit</button>');
            profileSaveButton.prop("disabled", true).addClass("disabled");
            profileUploadLabel.addClass("disabled");
            profileEditableInputs.prop("disabled", true);
            profileEditableSelects.prop("disabled", true);
        }
    });

    $('#dialog-modal').modal('show');
});