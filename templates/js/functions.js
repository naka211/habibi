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

//Set expired session time when close tab
var validNavigation = false;

wireUpEvents = function() {
    window.onbeforeunload = function (e) {
        if (!validNavigation) {
            $.ajax({
                method: "POST",
                url: base_url+"ajax/logout",
                data: { csrf_site_name: token_value }
            });
        }
    };


    // Attach the event keypress to exclude the F5 refresh
    $(document).keydown(function(e) {
        if ((e.which || e.keyCode) == 116){
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

    callAjaxFunction = function (profile_id, link) {
        $.ajax({
            method: "POST",
            url: base_url+"ajax/"+link,
            data: { csrf_site_name: token_value, profile_id: profile_id }
        }).done(function() {
            //handle blur action
            if(link == 'blurAvatar'){
                $("#blurBtn"+profile_id).attr({
                    "onclick" : "callAjaxFunction("+profile_id+", 'removeBlurAvatar')",
                    "class" : "btn btnadd_friend"
                });
                $("#blurBtn"+profile_id).text('Fjern sløring');
            }
            if(link == 'removeBlurAvatar'){
                $("#blurBtn"+profile_id).attr({
                    "onclick" : "callAjaxFunction("+profile_id+", 'blurAvatar')",
                    "class" : "btn btn_cancel_request"
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
            }
            if(link == 'removeFavorite'){
                $("#favoriteBtn").attr({
                    "onclick" : "callAjaxFunction("+profile_id+", 'addFavorite')",
                    "title" : "Tilføj favorit",
                    "class" : ""
                });
            }
            //handle block user and remove favorite in page
            if(link == 'removeFavoriteInPage' || link == 'blockUser' || link == 'unblockUser' || link == 'unFriend' || link == 'requestAddFriend' || link == 'cancelAddFriend' || link == 'acceptAddFriend' || link == 'rejectAddFriend' || link == 'reAddFriend'){
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
                $("#requestBtn").text('Tilføj ven');
            }
            if(link == 'unFriendInProfile'){
                $("#requestBtn").attr({
                    "onclick" : "callAjaxFunction("+profile_id+", 'requestAddFriendInProfile')",
                    "class" : "btn btnadd_friend",
                });
                $("#requestBtn").text('Tilføj ven');
            }

            if(link == 'requestAddFriendInFavorite'){
                $('#requestAddFriendBtn'+profile_id).fadeOut();
            }
            if(link == 'addFavoriteInPage'){
                $('#addFavoriteBtn'+profile_id).fadeOut();
            }
        });
    }
    sendBlink = function (profile_id) {
        callAjaxFunction(profile_id, 'sendBlink');
    }


    var checkMessageInterval;
    setCheckMessageInterval = function (profileId) {
        checkMessageInterval = setInterval(function(){checkMessage(profileId);}, 3000);
    }
    stopCheckMessageInterval = function () {
        clearInterval(checkMessageInterval);
    }

    loadMoreMessages = function (profileId, num, first, profileName) {
        $("#modalChat h4").html('Chatbesked med '+profileName);
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
                    }
                }
            });
        }
        ////

        if(first == false){
            $("#loadMoreMessage").remove();
        } else {
            $(".chat ul").html("");
            $(".chat ul").append('<li style="text-align: center;" id="messageLoading">\n' +
                '                        <img src="'+base_url+'templates/images/preloader.gif">\n' +
                '                    </li>');
        }

        //Set onclick function for send message button
        $(".btnSend").attr('onclick', 'sendMessage('+profileId+')');

        $.ajax({
            method: "POST",
            url: base_url+"ajax/loadMoreMessages",
            data: { csrf_site_name: token_value, profileId: profileId, num: num, profileName: profileName },
            success: function (html) {
                $("#messageLoading").fadeOut(100);
                //Add message to ul
                $(".chat ul").prepend(html).hide().fadeIn(1000);
                //Scroll to bottom of ul
                if(first == true){
                    $('.chat ul').scrollTop($('.chat ul').prop("scrollHeight"));
                }
                if( $('.friend'+profileId).length ){
                    $('.friend'+profileId).removeClass('frend_item_new');
                    $('.new').remove();
                }
            }
        });
    }

    checkMessage = function (profileId) {
        $.ajax({
            type: "post",
            url: base_url+"ajax/checkMessage",
            dataType: 'json',
            data: {profileId: profileId, csrf_site_name: token_value}
        }).done(function(data){
            if(data.emptyMessage == true){
                $(".chat ul").html("");
            }
            if(data.newMessage == true){
                $(".chat ul").append(data.html);
                //Scroll to bottom of ul
                $('.chat ul').scrollTop($('.chat ul').prop("scrollHeight"));
            }
        });
    }

    sendMessage = function (profileId) {
        var message = $("#message").val();
        $.ajax({
            type: "post",
            url: base_url+"ajax/sendMessage",
            dataType: 'html',
            data: {message: message, user_to: profileId,'csrf_site_name':token_value}
        }).done(function(html){
            $(".chat ul").append(html);
            //Scroll to bottom of ul
            $('.chat ul').scrollTop($('.chat ul').prop("scrollHeight"));
            $("#message").val("");
            
            $('.friend'+profileId).find('gray_friend_item').html(message);
        });
    }

    //Handle enter key in message
    $('#message').keyup(function(e){
        if(e.keyCode == 13){
            $('.btnSend').click();
        }
    });

    $('.frm_Chat').on('keypress', function(e) {
        return e.which !== 13;
    });
    ////

    confirmRemoveFavorite = function (profileId) {
        $("#confirmText").html("Er du sikker på at fjerne denne person til din favoritliste?");
        $('.btnYes').attr('href', base_url+'user/removeFavorite/'+profileId);
        $.fancybox.open({src: '#modalConfirm'});
    }

    confirmDeleteMessage = function (profileId) {
        $("#confirmText").html("Er du sikkert på at slette hele chat-beskeden?");
        $('.btnYes').attr('href', base_url+'user/deleteMessage/'+profileId);
        $.fancybox.open({src: '#modalConfirm'});
    }

    confirmRemovePhoto = function (photoId) {
        $("#confirmText").html("Er du sikker på at slette billedet?");
        $('.btnYes').attr('href', base_url+'user/deletePhoto/'+photoId);
        $.fancybox.open({src: '#modalConfirm'});
    }

    confirmRemoveBlock = function (profileId) {
        $("#confirmText").html("Er du sikker på at fjerne denne person for at blokere listen?");
        $('.btnYes').attr('href', base_url+'user/unblockUser/'+profileId);
        $.fancybox.open({src: '#modalConfirm'});
    }
});

