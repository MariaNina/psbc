$(document).ready(function () {
    $('.owl-carousel').owlCarousel({
        autoplay: true,
        autoplayhoverpause: true,
        items: 4,
        nav: false,
        lazyLoad: true,
        loop: true,
        dots: true,
        margin: 7,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 3,
            },
        },
    });

});
