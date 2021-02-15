$(document).ready(function () {

    let displayResults = $("#display-results");

    $.get("/drawResultsEntrees.php", function (data) {
            let jsonParsedData = JSON.parse(data);
            jsonParsedData.reverse();

            let completeCardsDiv = [];

            for (let i = 0; i < jsonParsedData.length; i++) {
                let numBadges = [];

                numBadges.push(
                    "<div class='card my-3'>" +
                    "<div class='card-header'>" +
                    "<div class='row'>" +
                    "<div class='col-md-3'>" +
                    "<span class='lotto-name font-weight-bold'>" + jsonParsedData[i]['lottDay'] + "</span>" +
                    "</div>" +
                    "<div class='col-md-3'>" +
                    "<span class='draw-date'>" + jsonParsedData[i]['lottDate'] + "</span>" +
                    "</div>" +
                    "<div class='col-md-6'>" +
                    "<span class='lotto-draw-no'>" + jsonParsedData[i]['drawNo'] + "</span>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "<div class='card-body'>" +
                    "<div id='draw-nums' class='d-inline-block'>");

                $.each(jsonParsedData[i], function (key, val) {
                    if (val.length === 1 || val.length === 2) {
                        if (val !== "0") {
                            if (key.slice(0, -1) === 'resultNum') {
                                numBadges.push("<span class='badge badge-primary font-weight-light m-1' style='font-size: 1.3rem; width: 2.5rem;'>"
                                    + val +
                                    "</span>");
                            } else if (key.slice(0, -1) === 'suppNum') {
                                numBadges.push("<span class='badge badge-secondary font-weight-light mx-1' style='font-size: 1.3rem; width: 2.5rem;'>"
                                    + val +
                                    "</span>");
                            }
                        }
                    }
                });
                numBadges.push("</div></div></div>");

                completeCardsDiv.push(numBadges);
            }

            for (let i = 0; i < completeCardsDiv.length; i++) {
                displayResults.append(completeCardsDiv[i].join(''));
            }
        }
    );
});