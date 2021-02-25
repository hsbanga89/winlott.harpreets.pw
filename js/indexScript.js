$(document).ready(function () {
    "use strict";

    $('#dialog-modal').modal('show').children().removeClass('modal-sm');

    let greeting;
    let homePredictionsLottName = $("#home-predictions-lott-name");
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
        url: '/ajaxPhp/indexAjax.php',
        method: 'GET',
        data: {}
    }).done(function (data) {
        try {
            let jsonParsedData = JSON.parse(data);
            let preparePredictedDiv = [];
            let predictDate = new Date(jsonParsedData[1]);
            let lottDay;

            switch (predictDate.getDay()) {
                case 1:
                    lottDay = 'Monday Lotto';
                    break;
                case 2:
                    lottDay = 'Oz Lotto';
                    break;
                case 3:
                    lottDay = 'Wednesday Lotto';
                    break;
                case 4:
                    lottDay = 'Powerball';
                    break;
                case 6:
                    lottDay = 'TattsLotto';
                    break;
                default:
                    lottDay = 'Set for Life';
            }
            homePredictionsLottName.html('<h5>' + lottDay + '</h5>');
            jsonParsedData.pop();

            preparePredictedDiv.push("<div class='d-block m-auto'>");
            for (let i = 0; i < jsonParsedData[0].length; i++) {
                if (lottDay === 'Powerball' && i === 7) {
                    preparePredictedDiv.push("<span class='badge badge-secondary font-weight-light m-1' style='font-size: 1.3rem; width: 2.5rem;'>"
                        + jsonParsedData[0][i] +
                        "</span>");
                } else {
                    preparePredictedDiv.push("<span class='badge badge-primary font-weight-light m-1' style='font-size: 1.3rem; width: 2.5rem;'>"
                        + jsonParsedData[0][i] +
                        "</span>");
                }
            }
            preparePredictedDiv.push("</div>");

            homePredictions.html(preparePredictedDiv.join(' '));
        } catch (e) {
            let errorMessage = "Something went wrong!";
        }
    });
});