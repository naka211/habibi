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

    $("#frm_register").validate({
        errorPlacement: function(error, element) {
            error.appendTo(element.parent().after());
        },
        rules: {
            "email":{
                required:true,
                email: true,
                remote: {
                    url: base_url+"ajax/checkEmail",
                    type: "POST",
                    data: {
                        csrf_site_name: token_value
                    }
                }
            },
            "name":{
                required:true,
                remote: {
                    url: base_url+"ajax/checkName",
                    type: "POST",
                    data: {
                        csrf_site_name: token_value
                    }
                }
            },
            "year":{
                required:true
            },
            "gender":{
                required:true
            },
            "land":{
                required:true
            },
            "region":{
                required:true
            },
            "password":{
                required:true,
                minlength: 6
            },
            "confirmPassword": {
                required: true,
                equalTo: "#password"
            },
            "find_gender":{
                required:true
            },
            "find_land":{
                required:true
            },
            "find_region":{
                required:true
            }
        },
        messages: {
            "email":{
                required: 'Indtast din email',
                email: 'Indtast venligst en gyldig e-mailadresse',
                remote: 'Denne email er i brug'
            },
            "name":{
                required: 'Indtast din navn',
                remote: 'Denne brugernavn er i brug'
            },
            "year":{
                required: 'Vælg dit fødselsår'
            },
            "gender":{
                required: 'Vælg dit køn'
            },
            "land":{
                required: 'Vælg dit land'
            },
            "region":{
                required: 'Vælg dit region'
            },
            "password":{
                required: 'Skriv dit kodeord',
                minlength: "Adgangskoden skal være på mellem {0} tegn."
            },
            "confirmPassword": {
                required: 'Indtast dit kodeord igen',
                equalTo: 'Genadgangskoden er ikke som kodeord'
            },
            "find_gender":{
                required:'Vælg det køn, du vil søge'
            },
            "find_land":{
                required:'Vælg det land, du vil søge'
            },
            "find_region":{
                required:'Vælg det region, du vil søge'
            }
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

