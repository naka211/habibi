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

        $.ajax({
            method: "POST",
            url: base_url+"ajax/setCookie",
            data: { csrf_site_name: token_value }
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

        $.ajax({
            method: "POST",
            url: base_url+"ajax/setCookiePanik",
            data: { csrf_site_name: token_value }
        });
    });

    $('.btnPennic').click(function (event) {
        $.ajax({
            method: "POST",
            url: base_url+"ajax/logout",
            data: { csrf_site_name: token_value },
            success: function () {
                window.open('https://www.youtube.com', '_self');
            }
        });
    });

    /*var swiper = new Swiper('.swiper_banner.swiper-container', {
        direction: 'vertical',
        mousewheel: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });

    var width = $(window).width();
    if(width <= 768){
        swiper.destroy(false,false);
    }*/

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
                    if(data.status == true){
                        //$('#modalLogin').modal('hide');
                        window.location.href = base_url+'user/start';
                    } else {
                        $('.se-pre-con').fadeOut();
                        $('#error-content').html(data.message);
                        $.fancybox.open({src: '#modalError'});
                    }
                }
            });
            return false;
        }
    });

    $("#frm_forgotPassword").validate({
        errorPlacement: function(error, element) {
            return false;
        },
        rules: {
            "email":{
                required:true,
                email: true
            }
        },
        submitHandler: function(form){
            $.fancybox.close();
            var formData = new FormData(form);
            $('.se-pre-con').show();
            $.ajax({
                type: "POST",
                url: base_url+"user/forgotPassHandler",
                data: formData,
                dataType: 'json',
                mimeType:"multipart/form-data",
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    $('.se-pre-con').fadeOut();
                    if(data.status === true){
                        $('#message-content').html(data.message);
                        $.fancybox.open({src: '#modalMessage'});
                    } else {
                        $('#error-content').html(data.message);
                        $.fancybox.open({src: '#modalError'});
                    }
                }
            });
            return false;
        }
    });

    $("#frm_contact").validate({
        errorPlacement: function(error, element) {
            return false;
        },
        rules: {
            'name': 'required',
            "email":{
                required:true,
                email: true
            },
            'phone': 'required',
            'message': 'required'
        },
        submitHandler: function(form){
            $.fancybox.close();
            var formData = new FormData(form);
            $('.se-pre-con').show();
            $.ajax({
                type: "POST",
                url: base_url+"user/contact",
                data: formData,
                dataType: 'json',
                mimeType:"multipart/form-data",
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    $('.se-pre-con').fadeOut();
                    if(data.status === true){
                        $('#message-content').html(data.message);
                        $.fancybox.open({src: '#modalMessage'});
                    } else {
                        $('#error-content').html(data.message);
                        $.fancybox.open({src: '#modalError'});
                    }
                }
            });
            return false;
        }
    });
});