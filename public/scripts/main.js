$(document).ready(function(){
    $(window).bind('scroll', function() {
        var navHeight = $( window ).height()+5;
        if ($(window).scrollTop() > navHeight) {
            $('nav').removeClass('navbar-static-top');
            $('nav').addClass('navbar-fixed-top');
            $('.navbar-wrapper').addClass('body-fixed-top');
        }
        else {
            $('nav').removeClass('navbar-fixed-top');
            $('nav').addClass('navbar-static-top');
            $('.navbar-wrapper').removeClass('body-fixed-top');
        }
    });
});
