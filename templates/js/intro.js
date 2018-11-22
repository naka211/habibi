$(function ($) {

    $(".btnCookie").click(function (event) {
        event.preventDefault();
        $(".cookie").hide('slow/400/fast', function () {
        });

        $.ajax({
            method: "POST",
            url: base_url+"ajax/setCookie",
            data: { csrf_site_name: token_value }
        });
    });

    var swiper = new Swiper('.swiper_banner.swiper-container', {
        direction: 'vertical',
        mousewheel: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },

    });

    $('.btnMovetop').click(function (e) {
        swiper.slideTo( 0, 1000, false );
    });
});


