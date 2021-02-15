$(document).ready(function () {
    "use strict"; // Start of use strict

    let playNav = $("#play-nav");
    let playLink = $("#play-link");

    // // Smooth scrolling using jQuery easing
    // $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function () {
    //     if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
    //         let target = $(this.hash);
    //         target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
    //         if (target.length) {
    //             $('html, body').animate({
    //                 scrollTop: (target.offset().top - 54)
    //             }, 1000, "easeInOutExpo");
    //             return false;
    //         }
    //     }
    // });

    // // Closes responsive menu when a scroll trigger link is clicked
    // $('.js-scroll-trigger').on("click", function () {
    //     $('.navbar-collapse').collapse('hide');
    // });

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


