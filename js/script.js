// products

$(document).ready(function(){
    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        responsive:{
            0:{
                items: 1
            },
            600:{
                items: 2
            },
            1000:{
                items: 4
            }
        }
    });
});


// brands

$(document).ready(function(){
    $('.brand-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        dots: false,
        autoplay: true,
        autoplayTimeout: 3000, // 3 seconds
        autoplayHoverPause: true,
        responsive:{
            0:{
                items: 2
            },
            600:{
                items: 4
            },
            1000:{
                items: 6
            }
        }
    });
});
