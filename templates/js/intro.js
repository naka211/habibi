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
                        location.reload();
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

    /*$("#email").blur(function () {
        var email = $("#email").val();
        $.ajax({
            method: "POST",
            url: base_url+"ajax/checkEmail",
            data: { email: email, csrf_site_name: token_value },
            success: function (data) {
                if(data.status == false){
                    $("#email").removeClass('error');
                } else {
                    $("#email").addClass('error');
                }
            }
        });
    });*/


});

