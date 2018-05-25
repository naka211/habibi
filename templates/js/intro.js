$(function ($) {

    $(".btnCookie").click(function (event) {
        event.preventDefault();
        $(".cookie").hide('slow/400/fast', function () {
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
                        $('#error-content').html('E-mail eller adgangskode er forkert, prøv igen!');
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

    $("#frm_register").validate({
        errorPlacement: function(error, element) {
            return false;
        },
        rules: {
            "email":{
                required:true,
                email: true
            },
            "name":{
                required:true,
                /*depends: function(element) {
                    //return $("#bonus-material").is(":checked");
                    var username = $("#username").val();
                    $.ajax({
                        method: "POST",
                        url: base_url+"user/checkUsername",
                        data: { username: username, csrf_site_name: token_value },
                        success: function (data) {
                            return data.status;
                            /!*if(data.status == false){
                                $("#username").removeClass('error');
                            } else {
                                $("#username").addClass('error');
                            }*!/
                        }
                    });
                }*/
            },
            "password":{
                required:true
            },
            "confirmPassword": {
                required: true,
                equalTo: "#password"
            },
        },
        submitHandler: function(form){
            $.fancybox.close();
            var formData = new FormData(form);
            $('.se-pre-con').show();
            $.ajax({
                type: "POST",
                url: base_url+"user/register",
                data: formData,
                dataType: 'json',
                mimeType:"multipart/form-data",
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    if(data.status === false){
                        $('.se-pre-con').fadeOut();
                        $('#error-content').html(data.message);
                        $.fancybox.open({src: '#modalError'});
                    } else {
                        location.reload();
                    }
                }
            });
            return false;
        }
    });

    $("#email").blur(function () {
        var email = $("#email").val();
        $.ajax({
            method: "POST",
            url: base_url+"user/checkEmail",
            data: { email: email, csrf_site_name: token_value },
            success: function (data) {
                if(data.status == false){
                    $("#email").removeClass('error');
                } else {
                    $("#email").addClass('error');
                }
            }
        });
    });

    $(".btnCookie").click(function () {
        $.ajax({
            method: "POST",
            url: base_url+"user/setCookie",
            data: { csrf_site_name: token_value }
        });
    })
});

