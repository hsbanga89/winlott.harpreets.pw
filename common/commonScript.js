$(document).ready(function () {
    "use strict"; // Start of use strict

    let playNav = $("#play-nav");
    let playLink = $("#play-link");

    // Collapse Navbar and Play-Navbar
    let navbarCollapse = function () {
        let mainNav = $("#mainNav");

        if (mainNav.offset().top > 100) {
            mainNav.addClass("navbar-shrink");
            playNav.removeClass("play-nav-expand");
        } else {
            mainNav.removeClass("navbar-shrink");
            playNav.addClass("play-nav-expand");
        }
    };

    // Collapse now if page is not at top
    navbarCollapse();

    // Collapse the navbar when page is scrolled
    $(window).scroll(navbarCollapse);

    playLink.click(function (evt) {
        evt.preventDefault();

        if (playNav.css("top") !== "0px") {
            playNav.animate({
                top: "0",
                'z-index': 1
            }, 300);
        } else {
            playNav.animate({
                top: "-6.5rem",
                'z-index': 1
            }, 300);
        }
    });

    // Turn Tooltips On
    $('[data-toggle="tooltip"]').tooltip();

});


