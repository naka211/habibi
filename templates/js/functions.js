$(function ($) {

    $(function () {
        $('.hider').click(function () {
            return $(this).parent('.message').removeClass('blur');
        });


    });

    $(".btnCookie").click(function (event) {
        event.preventDefault();
        $(".cookie").hide('slow/400/fast', function () {
        });
    });


    // sticky menu
    $(function () {
        var top = $('#menu').offset().top - parseFloat($('#menu').css('marginTop').replace(/auto/, 0));
        var footTop = $('#footer').offset().top - parseFloat($('#footer').css('marginTop').replace(/auto/, 0));

        var maxY = footTop - $('#menu').outerHeight();

        $(window).scroll(function (evt) {
            var y = $(this).scrollTop();
            if (y > top) {
                if (y < maxY) {
                    $('#menu').addClass('fixed').removeAttr('style');
                } else {
                    $('#menu').removeClass('fixed').css({
                        position: 'absolute',
                        top: (maxY - top) + 'px'
                    });
                }
            } else {
                $('#menu').removeClass('fixed');
            }
        });
    });

    $(function () {
        $(document).ready(function () {
            return $(window).scroll(function () {
                return $(window).scrollTop() > 200 ? $("#back-to-top").addClass("show") : $("#back-to-top").removeClass("show")
            }), $("#back-to-top").click(function () {
                return $("html,body").animate({
                    scrollTop: "0"
                })
            })
        })
    });

    $('#scrollup').click(function () {
        $("html, body").animate({scrollTop: 0}, 400);
        return false;
    });

    $('.btnShowlist').click(function (event) {
        event.preventDefault();
        $('.list_action').fadeToggle("fast", function () {
        });
    });

    $('.btnClose_xs').click(function (event) {
        event.preventDefault();
        $('.box_notify').hide('slow/400/fast', function () {
        });
    });

    var swiper = new Swiper('.swiper_banner.swiper-container', {
        direction: 'vertical',
        // effect: 'fade',
        // autoplay: {
        //     delay: 2500,
        //     disableOnInteraction: false,
        // },
        mousewheel: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },

    });

    //matchHeight columm
    $('.mh').matchHeight();

    //CENTERED MODALS
    $(function () {
        function reposition() {
            var modal = $(this),
                dialog = modal.find('.modal-dialog');
            modal.css('display', 'block');

            // Dividing by two centers the modal exactly, but dividing by three 
            // or four works better for larger screens.
            dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
        }

        // Reposition when a modal is shown
        $('.modal').on('show.bs.modal', reposition);
        // Reposition when the window is resized
        $(window).on('resize', function () {
            $('.modal:visible').each(reposition);
        });
    });


    $('.owl_banner_info').owlCarousel({
        loop: true,
        margin: 10,
        items: 1,
    });

    $('.owl_trySearch').owlCarousel({
        loop: true,
        margin: 30,
        items: 3,
        nav: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 2,
                nav: true
            },
            600: {
                items: 3,
                nav: false
            },
            1000: {
                items: 4,
                nav: true,
                loop: false
            }
        },
    });

    $('.owl_latestProfiles').owlCarousel({
        loop: true,
        margin: 30,
        items: 4,
        nav: true,
        dots: false,
        responsive: {
            0: {
                items: 2,
                nav: true
            },
            600: {
                items: 3,
                nav: false
            },
            1000: {
                items: 4,
                nav: true,
                loop: false
            }
        },
    });

    $('.owl_mostvisitedProfiles').owlCarousel({
        loop: true,
        margin: 20,
        items: 5,
        nav: true,
        dots: false,
        responsive: {
            0: {
                items: 2,
                nav: true
            },
            600: {
                items: 3,
                nav: false
            },
            1000: {
                items: 5,
                nav: true,
                loop: false
            }
        },
    });

    $('.owl_gallerys').owlCarousel({
        loop: true,
        margin: 10,
        items: 7,
        nav: true,
        dots: false,
        responsiveClass: true,
        responsive: {
            0: {
                items: 2,
                nav: true
            },
            600: {
                items: 3,
                nav: false
            },
            1000: {
                items: 7,
                nav: true,
                loop: false
            }
        },
    });
});

/* ScrollTrigger */
window.counter = function () {
    var span = this.querySelector('span');
    var current = parseInt(span.textContent);

    span.textContent = current + 1;
};

document.addEventListener('DOMContentLoaded', function () {
    var trigger = new ScrollTrigger({
        addHeight: true
    });
});

$(document).ready(function () {
    $("#frm_login").validate({
        errorPlacement: function(error, element) {
            return false;
        },
        rules: {
            "email":{
                required:true,
                email: true
            },
            "password":{
                required:true
            },
        },
        submitHandler: function(form){
            $.fancybox.close();
            var formData = new FormData(form);
            $('.se-pre-con').show();
            $.ajax({
                type: "POST",
                url: base_url+"user/login",
                data: formData,
                dataType: 'json',
                mimeType:"multipart/form-data",
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    if(data.status === true){
                        //$('#modalLogin').modal('hide');
                        location.reload();
                    } else {
                        $('.se-pre-con').fadeOut();
                        $('#error-content').html('E-mail eller adgangskode er forkert, prøv igen!');
                        $.fancybox.open({src: '#modalError'});
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
            return false;
        }
    });

});
