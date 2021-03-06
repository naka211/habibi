$(function ($) {

    /*$(function () {
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
    });*/


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

    /*$('.btnShowlist').click(function (event) {
        event.preventDefault();
        $('.list_action').fadeToggle("fast", function () {
        });
    });*/

    /*var swiper = new Swiper('.swiper_banner.swiper-container', {
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

    });*/

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
        loop: false,
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

//Set expired session time when close tab
var validNavigation = false;

wireUpEvents = function() {
    window.onbeforeunload = function (e) {
        if (!validNavigation) {
            $.ajax({
                method: "POST",
                url: base_url+"ajax/changeLoginStatus",
                data: { csrf_site_name: token_value }
            });
        }
    };


    //Detect click refresh and back on browser navigation
    if(performance.navigation.type == 1 || performance.navigation.type == 2){
        validNavigation = true;
    }
    // Attach the event keypress to exclude the F5 refresh
    $(document).keydown(function(e) {
        if ((e.which || e.keyCode) == 116){
            validNavigation = true;
        }
        if (e.keyCode == 65 && e.ctrlKey) {
            validNavigation = true;
        }
    });

    // Attach the event click for all links in the page
    $("a").bind("click", function() {
        validNavigation = true;
    });

    // Attach the event submit for all forms in the page
    $("form").bind("submit", function() {
        validNavigation = true;
    });

    // Attach the event click for all inputs in the page
    $("input[type=submit]").bind("click", function() {
        validNavigation = true;
    });

}

$(document).ready(function() {
    //Capture the close tab event
    wireUpEvents();

    /*$('input[type=radio][name=chat]').change(function() {
        $.ajax({
            method: "POST",
            url: base_url+"ajax/changeChatStatus",
            data: { csrf_site_name: token_value, status: this.value}
        });
    });*/

    callAjaxFunction = function (profile_id, link, fadeOut) {
        if (fadeOut === undefined) {
            fadeOut = true;
        }
        $.ajax({
            method: "POST",
            url: base_url+"ajax/"+link,
            data: { csrf_site_name: token_value, profile_id: profile_id }
        }).done(function() {
            //handle blur action
            if(link == 'blurAvatar'){
                $("#blurBtn"+profile_id).attr({
                    "onclick" : "confirmRemoveBlur("+profile_id+", 'Er du sikker på du vil fjerne sløringen for pågældende profil ?')",
                    "class" : "btn bntMessage marginOnMobile"
                });
                $("#blurBtn"+profile_id).text('Fjern sløring');
            }
            if(link == 'removeBlurAvatar'){
                $("#blurBtn"+profile_id).attr({
                    "onclick" : "confirmBlur("+profile_id+", 'Er du sikker på du vil sløre dine billeder for den pågældende profil igen ?')",
                    "class" : "btn btn_cancel_request mb0 marginOnMobile widthAuto"
                });
                $("#blurBtn"+profile_id).text('Sløring');
            }
            // Handle favorite
            if(link == 'addFavorite'){
                $("#favoriteBtn").attr({
                    "onclick" : "callAjaxFunction("+profile_id+", 'removeFavorite')",
                    "title" : "Fjern favorit",
                    "class" : "hover"
                });
                $('#message-content').html('Du har tilføjet profilen som favorit');
                $.fancybox.open({src: '#modalMessage'});
            }
            if(link == 'removeFavorite'){
                $("#favoriteBtn").attr({
                    "onclick" : "callAjaxFunction("+profile_id+", 'addFavorite')",
                    "title" : "Tilføj favorit",
                    "class" : ""
                });
            }
            //handle block user and remove favorite in page
            if(link == 'removeFavoriteInPage' || link == 'blockUser' || link == 'unblockUser' || link == 'unFriend' || link == 'requestAddFriend' || link == 'cancelAddFriend' || link == 'acceptAddFriend' || link == 'rejectAddFriend' /*|| link == 'reAddFriend'*/ || (link == 'deleteMessage' && fadeOut == true) || link == 'deleteVisited' || link == 'deleteVisitMe'){
                $(".profile"+profile_id).fadeOut();
            }
            //handle request in page
            if(link == 'requestAddFriendInProfile'){
                $("#requestBtn").attr({
                    "onclick" : "callAjaxFunction("+profile_id+", 'cancelAddFriendInProfile')",
                    "class" : "btn btn_cancel_request",
                });
                $("#requestBtn").text('Annuller anmodning');
            }
            if(link == 'cancelAddFriendInProfile'){
                $("#requestBtn").attr({
                    "onclick" : "callAjaxFunction("+profile_id+", 'requestAddFriendInProfile')",
                    "class" : "btn btnadd_friend",
                });
                $("#requestBtn").text('Venneanmodning');
            }
            if(link == 'unFriendInProfile'){
                $("#requestBtn").attr({
                    "onclick" : "callAjaxFunction("+profile_id+", 'requestAddFriendInProfile')",
                    "class" : "btn btnadd_friend",
                });
                $("#requestBtn").text('Venneanmodning');
            }

            if(link == 'requestAddFriendInFavorite'){
                $('#requestAddFriendBtn'+profile_id).attr({
                    "onclick" : "callAjaxFunction("+profile_id+", 'cancelAddFriendInFavorite')",
                    "class" : "btn btn_cancel_request mb0",
                });
                $('#requestAddFriendBtn'+profile_id).text('Annuller anmodning');
            }
            if(link == 'cancelAddFriendInFavorite'){
                $('#requestAddFriendBtn'+profile_id).attr({
                    "onclick" : "callAjaxFunction("+profile_id+", 'requestAddFriendInFavorite')",
                    "class" : "btn bntMessage",
                });
                $('#requestAddFriendBtn'+profile_id).text('Venneanmodning');
            }
            if(link == 'addFavoriteInPage'){
                $('#addFavoriteBtn'+profile_id).fadeOut();
            }
        });
    }
    sendBlink = function (profile_id) {
        callAjaxFunction(profile_id, 'sendBlink');
        $('#message-content').html('Du har sendt et blink');
        $.fancybox.open({src: '#modalMessage'});
    }

    deletePhoto = function (photoId) {
        $.ajax({
            method: "POST",
            url: base_url+"ajax/deletePhoto",
            data: { csrf_site_name: token_value, photoId: photoId }
        }).done(function() {
            $('.photo'+photoId).fadeOut();
        });
    }


    var checkMessageInterval;
    setCheckMessageInterval = function (profileId) {
        checkMessageInterval = setInterval(function(){checkMessage(profileId);}, 3000);
    }
    stopCheckMessageInterval = function () {
        clearInterval(checkMessageInterval);
    }

    loadMoreMessages = function (profileId, num, first, isMobile, profileName) {
        $('#modalChat .bntBlock').attr('onclick', 'confirmDeleteMessage('+profileId+', "Er du sikker på du vil slette chat historik?")');
        $("#modalChat h4").html('Chatbesked med '+profileName);
        //Get latest message id
        $.ajax({
            type: "get",
            url: base_url+"ajax/getLatestMsgId/"+profileId,
            data: {'csrf_site_name':token_value}
        }).done(function(id){
            $('#latestMsgId').val(id);
        });
        //Open chat box
        if(first == true){
            $.fancybox.open({
                src  : '#modalChat',
                type : 'inline',
                opts : {
                    afterShow : function( instance, current ) {
                        setCheckMessageInterval(profileId);
                    },
                    afterClose : function () {
                        stopCheckMessageInterval();
                        $("#profileId").val('');
                    },
                    touch: false,
                    keyboard: false
                }
            });
        }
        ////

        if(first == false){
            $("#loadMoreMessage").remove();
        } else {
            $(".chat ul").html("");
            $(".chat ul").prepend('<li style="text-align: center;" id="messageLoading">\n' +
                '                        <img src="'+base_url+'templates/images/preloader.gif" width="64">\n' +
                '                    </li>');
        }

        $("#message").focus();
        //Set onclick function for send message button
        $(".btnSend").attr('onclick', 'sendMessage('+profileId+',"", '+isMobile+')');
        //Set profileId to hidden file
        $("#profileId").val(profileId);

        $.ajax({
            method: "POST",
            url: base_url+"ajax/loadMoreMessages",
            data: { csrf_site_name: token_value, profileId: profileId, num: num},
            success: function (html) {
                $("#messageLoading").fadeOut(100);
                //Add message to ul
                $(".chat ul").prepend(html).hide().fadeIn(1000);
                //Scroll to bottom of ul
                if(first == true){
                    $('.chat ul').scrollTop($('.chat ul').prop("scrollHeight"));
                }
                //setCheckMessageInterval(profileId);

                if(isMobile == false && num != ''){
                    $(".message"+num).emojioneArea();
                    $(".message"+num).data("emojioneArea").disable();
                }
                /*if( $('.friend'+profileId).length ){
                    $('.friend'+profileId).removeClass('frend_item_new');
                    $('.new').remove();
                }*/
            }
        });
    }

    checkMessage = function (profileId) {
        $.ajax({
            type: "post",
            url: base_url+"ajax/checkMessage",
            dataType: 'json',
            data: {profileId: profileId, latestMsgId: $('#latestMsgId').val(),csrf_site_name: token_value}
        }).done(function(data){
            if(data.emptyMessage == true){
                $(".chat ul").html("");
            }
            if(data.newMessage == true){
                $('#latestMsgId').val(data.latestMsgId);
                $(".chat ul").append(data.html);
                if(isMobile == false){
                    $(".message"+data.num).emojioneArea();
                }
                //Scroll to bottom of ul
                $('.chat ul').scrollTop($('.chat ul').prop("scrollHeight"));
            }
        });
    }

    sendMessage = function (profileId, message, isMobile) {
        if(message == ''){
            var message = $("#message").val();
        }

        //set input in blank
        $("#message").val("");
        $(".frm_Chat .emojionearea-editor").html("");
        if(message == ''){
            $('#message-content').html('Indtast venligst en besked');
            $.fancybox.open({src: '#modalMessage'});
        } else {
            $('#message').focus();
            stopCheckMessageInterval();

            $.ajax({
                type: "post",
                url: base_url+"ajax/sendMessage",
                dataType: 'html',
                data: {message: message, user_to: profileId,'csrf_site_name':token_value}
            }).done(function(data){
                var data = $.parseJSON(data);
                $('#latestMsgId').val(data.latestMsgId);
                $(".chat ul").append(data.html);
                //Scroll to bottom of ul
                $('.chat ul').scrollTop($('.chat ul').prop("scrollHeight"));
                if(isMobile == false){
                    $(".message"+data.messageId).emojioneArea();
                    $(".message"+data.messageId).data("emojioneArea").disable();
                }
                //$('.friend'+profileId).find('gray_friend_item').html(message);
                setCheckMessageInterval(profileId);

                $.ajax({
                    type: "post",
                    url: base_url+"ajax/saveMessageToFirebase",
                    dataType: 'html',
                    data: {message: message, profileId: profileId, 'csrf_site_name':token_value}
                }).done(function(data){
                    //console.log(data);
                });
            });
        }
    }

    $("#deletePreviewImage").click(function () {
        $('canvas').remove();
        $('#imgContainer').hide();
        $('#messageImage').val('');
        $(".waiting").fadeOut(100);
        //Undo prevent default
        $('#messageImage').unbind('click');

        var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
        if (isMobile) {
            $("#message").removeAttr('disabled');
        } else {
            $("#message").data("emojioneArea").enable();
        }
    })

    iOSversion = function() {
        if (/iP(hone|od|ad)/.test(navigator.platform)) {
            var v = (navigator.appVersion).match(/OS (\d+)_(\d+)_?(\d+)?/);
            return [parseInt(v[1], 10), parseInt(v[2], 10), parseInt(v[3] || 0, 10)];
        }
    }

    /*setInterval(checkSession, 10*60*1000);
    function checkSession() {
        $.ajax({
            url: base_url+"ajax/checkSession",
            success: function(status) {
                if (status == 1){
                    $.ajax({
                        method: "POST",
                        url: base_url+"ajax/logout",
                        data: { csrf_site_name: token_value, message: 'Du er blevet logget af automatisk, da der ikke har været aktivitet i en periode.' }
                    });
                }
            }
        });
    }*/

    //Dropdown menu
    // show hide submenu

    var theToggle = document.getElementById('toggle');

    // based on Todd Motto functions
    // https://toddmotto.com/labs/reusable-js/

    // hasClass
    function hasClass(elem, className) {
        return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
    }
    // addClass
    function addClass(elem, className) {
        if (!hasClass(elem, className)) {
            elem.className += ' ' + className;
        }
    }
    // removeClass
    function removeClass(elem, className) {
        var newClass = ' ' + elem.className.replace( /[\t\r\n]/g, ' ') + ' ';
        if (hasClass(elem, className)) {
            while (newClass.indexOf(' ' + className + ' ') >= 0 ) {
                newClass = newClass.replace(' ' + className + ' ', ' ');
            }
            elem.className = newClass.replace(/^\s+|\s+$/g, '');
        }
    }
    // toggleClass
    function toggleClass(elem, className) {
        var newClass = ' ' + elem.className.replace( /[\t\r\n]/g, " " ) + ' ';
        if (hasClass(elem, className)) {
            while (newClass.indexOf(" " + className + " ") >= 0 ) {
                newClass = newClass.replace( " " + className + " " , " " );
            }
            elem.className = newClass.replace(/^\s+|\s+$/g, '');
        } else {
            elem.className += ' ' + className;
        }
    }

    theToggle.onclick = function() {
        toggleClass(this, 'on');
        return false;
    }
});

