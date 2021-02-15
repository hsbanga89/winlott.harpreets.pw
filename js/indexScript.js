$(document).ready(function () {
    "use strict";

    let greeting;
    let homePredictions = $("#home-predictions");
    let currentTime = new Date().getHours();

    if (currentTime <= 11) {
        greeting = "Good Morning!";
    } else if (currentTime >= 12 && currentTime <= 5) {
        greeting = "Good Afternoon!";
    } else {
        greeting = "Good Evening!";
    }

    $(".greetings p").text(greeting);

    $.ajax({
        url: '/ajax/indexAjax.php',
        method: 'GET',
        data: {}
    }).done(function (data) {
        let jsonParsedData = JSON.parse(data);
        let preparePredictedDiv = [];
        let predictDate = new Date(jsonParsedData[0][8]);
        let predictDay;

        if (predictDate.getDay() === 4) {
            predictDay = 'Thursday';
        }

        jsonParsedData[0].pop();

        preparePredictedDiv.push("<div class='d-block m-auto'>");
        $.each(jsonParsedData, function (key, val) {
            for (let i = 0; i < val.length; i++) {
                if (predictDay === 'Thursday' && i === 7) {
                    preparePredictedDiv.push("<span class='badge badge-secondary font-weight-light m-1' style='font-size: 1.3rem; width: 2.5rem;'>"
                        + val[i] +
                        "</span>");
                } else {
                    preparePredictedDiv.push("<span class='badge badge-primary font-weight-light m-1' style='font-size: 1.3rem; width: 2.5rem;'>"
                        + val[i] +
                        "</span>");
                }
            }
        });
        preparePredictedDiv.push("</div>");

        homePredictions.html(preparePredictedDiv.join(' '));
    });
});