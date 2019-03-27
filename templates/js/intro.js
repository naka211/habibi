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
        slidesPerView: 1,
        mousewheel: true,
        mousewheelControl: true,
        speed: 600,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        }
    });

    swiper.on('slideChange', function () {
        swiper.activeIndex > 0 ? $("#back-to-top-intro").addClass("show") : $("#back-to-top-intro").removeClass("show")
    });

    $('.back-to-top-intro').click(function (e) {
        swiper.slideTo( 0, 1000, false );
    });

    if(jQuery.browser.mobile == true){
        swiper.destroy(false,false);
    }
});


