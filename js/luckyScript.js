$(document).ready(function () {
    let savedSinglesDiv = $("#saved-singles-div");
    let savedCombosDiv = $("#saved-combos-div");
    let savedSinglesArray = [];
    let savedComboArray = [];

    $.ajax({
        url: '/ajaxPhp/luckyAjax.php',
        method: 'GET',
    }).done(function (data) {
            let jsonParsedData = JSON.parse(data);
            let prepareSinglesDiv = [];
            let prepareCombosDiv = [];

            for (let i = 0; i < jsonParsedData[0].length; i++) {
                savedSinglesArray.push(parseInt(jsonParsedData[0][i]));
            }

            $.each(jsonParsedData[1], function (key, val) {
                savedComboArray.push(val);
            });

            savedSinglesArray.sort(function (a, b) {
                return a - b;
            });

            prepareSinglesDiv.push("<div class='card my-2'><div class='card-header'><strong>Saved Single Numbers</strong></div><div class='card-body'>");
            for (let i = 0; i < savedSinglesArray.length; i++) {
                prepareSinglesDiv.push("<span class='badge badge-primary font-weight-light m-1' style='font-size: 1.3rem; width: 2.5rem;'>"
                    + savedSinglesArray[i] +
                    "</span>");
            }
            prepareSinglesDiv.push("</div></div>");

            prepareCombosDiv.push("<div class='card my-2'><div class='card-header'><strong>Saved Combinations</strong></div><div class='card-body'>");
            for (let i = 0; i < savedComboArray.length; i++) {

                prepareCombosDiv.push("<div class='row my-2'>");
                prepareCombosDiv.push("<div class='col-lg-3 my-auto overflow-hidden text-nowrap'>" +
                    "<span class='font-weight-light m-1' style='font-size: 1.3rem;'>"
                    + savedComboArray[i][0] +
                    "</span></div>");

                savedComboArray[i].shift();

                prepareCombosDiv.push("<div class='col-lg-9'>");
                for (let j = 0; j < savedComboArray[i].length; j++) {
                    prepareCombosDiv.push("<span class='badge badge-primary font-weight-light m-1' style='font-size: 1.3rem; width: 2.5rem;'>"
                        + savedComboArray[i][j] +
                        "</span>");
                }
                prepareCombosDiv.push("</div></div>");
            }
            prepareCombosDiv.push("</div></div>");

            savedSinglesDiv.html(prepareSinglesDiv.join(''));
            savedCombosDiv.html(prepareCombosDiv.join(''));
        }
    );
});