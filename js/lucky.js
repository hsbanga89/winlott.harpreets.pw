$(document).ready(function () {
    let savedSinglesDiv = $("#saved-singles-div");
    let savedCombosDiv = $("#saved-combos-div");
    let savedSinglesArray = [];
    let savedComboArray = [];

    // function displaySavedSingles() {
    //
    // }
    //
    // displaySavedSingles();


    $.ajax({
        url: '/ajax/luckyAjax.php',
        method: 'GET',
    }).done(function (data) {
        let jsonParsedData = JSON.parse(data);
        let prepareSinglesDiv = [];

        for (let i = 0; i < jsonParsedData[0].length; i++) {
            savedSinglesArray.push(parseInt(jsonParsedData[0][i]));
        }

        savedSinglesArray.sort(function (a, b) {
            return a - b;
        });

        prepareSinglesDiv.push("<div class='form-group mx-auto mb-2 px-2'><h6>Saved Single Numbers</h6><div class='d-block text-left'>");

        for (let i = 0; i < savedSinglesArray.length; i++) {
            prepareSinglesDiv.push("<span class='badge badge-primary font-weight-light m-1' style='font-size: 1.3rem; width: 2.5rem;'>"
                + savedSinglesArray[i] +
                "</span>");
        }
        prepareSinglesDiv.push("</div>");

        savedSinglesDiv.html(prepareSinglesDiv.join(''));
    });

});