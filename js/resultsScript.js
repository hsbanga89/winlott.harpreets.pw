$(document).ready(function () {

    let displayResults = $("#display-results");

    $.get("/ajaxPhp/drawResultsEntrees.php", function (data) {
            try {
                let jsonParsedData = JSON.parse(data);
                let completeCardsDiv = [];
                jsonParsedData.reverse();

                for (let i = 0; i < jsonParsedData.length; i++) {
                    for (let j = 0; j < jsonParsedData[i].length; j++) {
                        let numBadges = [];

                        numBadges.push(
                            "<div class='card my-3'>" +
                            "<div class='card-header'>" +
                            "<div class='row'>" +
                            "<div class='col-md-3'>" +
                            "<span class='lotto-name font-weight-bold'>" + jsonParsedData[i][j]['lottday'] + "</span>" +
                            "</div>" +
                            "<div class='col-md-3'>" +
                            "<span class='draw-date'>" + jsonParsedData[i][j]['lottdate'] + "</span>" +
                            "</div>" +
                            "<div class='col-md-6'>" +
                            "<span class='lotto-draw-no'>" + jsonParsedData[i][j]['drawno'] + "</span>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "<div class='card-body'>" +
                            "<div id='draw-nums' class='d-inline-block'>");

                        $.each(jsonParsedData[i][j], function (key, val) {
                            if (key.slice(0, -1) === 'resultnum') {
                                numBadges.push("<span class='badge badge-primary font-weight-light m-1' style='font-size: 1.3rem; width: 2.5rem;'>"
                                    + val +
                                    "</span>");
                            } else if (key.slice(0, -1) === 'suppnum') {
                                numBadges.push("<span class='badge badge-secondary font-weight-light mx-1' style='font-size: 1.3rem; width: 2.5rem;'>"
                                    + val +
                                    "</span>");
                            }
                        });
                        numBadges.push("</div></div></div>");
                        completeCardsDiv.push(numBadges);
                    }
                }
                for (let i = 0; i < completeCardsDiv.length; i++) {
                    displayResults.append(completeCardsDiv[i].join(''));
                }
            } catch (e) {
                let errorMessage = "No records to display or something went wrong.";
            }
        }
    );
});