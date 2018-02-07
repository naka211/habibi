//Zeduuce JS Layout HTML 2016 - Le Duc Cuong - skype: lecuong2585

// CSG Bootstrap Inputs
(function ($) {
    "use strict";
    $.fn.bootstrapInputs = function () {
        return this.each(function () {
            var $field = $(this);
            var options = {};
            var $data = $field.data();
            for (var i in $data) {
                options[i] = $data[i];
            }

            if ($field.hasClass('form-file-input')) {

                var btnLabel = (options.btnlabel) ? options.btnlabel : 'Choose File';
                var btnClass = (options.btnclass) ? options.btnclass : 'btn-default';
                var btnPosition = (options.btnposition) ? options.btnposition : 'right';
                var addFormControl = true;
                var fnClass = null;

                switch (btnPosition) {
                    case ('left'):
                        btnPosition = {'left': 0};
                        btnClass = btnClass + ' left';
                        fnClass = 'right';
                        break;
                    case ('right'):
                        btnPosition = {'right': 0};
                        btnClass = btnClass + ' right';
                        fnClass = 'left';
                        break;
                    case ('center'):
                        btnPosition = {'width': '100%'};
                        addFormControl = false;
                        fnClass = 'hidden';
                        break;
                }
                // Remove any styling from the input
                $field.removeClass();

                // Wrap it up and put the base input class on it
                var $wrap = $('<div></div>');
                $field.wrap($wrap).parent('div').addClass('form-control-outer clearfix');
                if (addFormControl) {
                    $field.parent('div').addClass('form-control');
                }
                $field.wrap($wrap).parent('div').addClass('form-control-inner');

                // Add a button
                var $button = $('<button></button>').addClass('btn btn-file-input');

                $button.addClass(btnClass).html(btnLabel);
                $field.after($button);

                var $liveButton = $field.next('.btn-file-input');

                // Add a span to display the file name
                var $filename = $('<span></span>').addClass('filename');

                $liveButton.after($filename)
                var $liveFilename = $liveButton.next('.filename');

                // Adjust the input
                $field.css({
                    'height': $liveButton.outerHeight(),
                    'width': '100%',
                    'z-index': 1,
                    'opacity': 0,
                    'position': 'absolute'
                });

                // Position the button
                $liveButton.css({'position': 'absolute', 'z-index': 0}).css(btnPosition);

                // Position the filename
                if (fnClass === 'right') {
                    $liveFilename.css({left: $liveButton.outerWidth()});
                }
                $liveFilename.addClass(fnClass);

                // Handle the button click
                $liveButton.on('click', function () {
                    $field.trigger('click');
                });

                // Handle file added
                $field.on('change', function () {
                    var fileArray = $field.val().split('\\');
                    if (fileArray) {
                        var file = fileArray[fileArray.length - 1];
                        $liveFilename.html(file);
                        console.log($liveFilename.html());
                    }
                });
            }

        });
    }
})(jQuery);
$('.form-file-input').bootstrapInputs();

$(document).ready(function () {
    var mypicture = $("#mypicture");
    mypicture.owlCarousel({
        pagination: false,
        items: 6, //10 items above 1000px browser width
        itemsDesktop: [1000, 6], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 5], // betweem 900px and 601px
        itemsTablet: [600, 4], //2 items between 600 and 0
        itemsMobile: true // itemsMobile disabled - inherit from itemsTablet option
    });
    var instagram_photo = $("#instagram_photo");
    instagram_photo.owlCarousel({
        pagination: false,
        items: 6, //10 items above 1000px browser width
        itemsDesktop: [1000, 6], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 5], // betweem 900px and 601px
        itemsTablet: [600, 4], //2 items between 600 and 0
        itemsMobile: true // itemsMobile disabled - inherit from itemsTablet option
    });
    /*var owl = $("#owl-chat");
    owl.owlCarousel({
        pagination: false,
        items: 6, //10 items above 1000px browser width
        itemsDesktop: [1000, 6], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 3], // betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0
        itemsMobile: true, // itemsMobile disabled - inherit from itemsTablet option
        autoPlay:8000,
        autoPlayHoverPause:true,
        scrollPerPage : true
    });*/

    // newest_profiles
    var newest_profiles = $("#newest_profiles");
    newest_profiles.owlCarousel({
        margin: 10,
        pagination: false,
        navigation: true,
        navigationText: [
            "<i class='fa fa-chevron-left fa-3x'></i>",
            "<i class='fa fa-chevron-right fa-3x'></i>"],
        items : 6, //10 items above 1000px browser width
        itemsDesktop : [1000,6], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0
        itemsMobile : true, // itemsMobile disabled - inherit from itemsTablet option
        autoPlay:8000,
        autoPlayHoverPause:true,
        scrollPerPage : true
    });

    // owl_latest_profiles
    var owl_latest_profiles = $("#owl_latest_profiles");
    owl_latest_profiles.owlCarousel({
        pagination: false,
        navigation: true,
        navigationText: [
            "<i class='fa fa-chevron-left fa-3x'></i>",
            "<i class='fa fa-chevron-right fa-3x'></i>"],
        items : 2, //10 items above 1000px browser width
        itemsDesktop : [1000,2], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,2], // betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0
        itemsMobile : true // itemsMobile disabled - inherit from itemsTablet option
    });

    // owl_latest_events
    var owl_latest_events = $("#owl_latest_events");
    owl_latest_events.owlCarousel({
        margin: 0,
        pagination: false,
        navigation: true,
        navigationText: [
            "<i class='fa fa-chevron-left fa-3x'></i>",
            "<i class='fa fa-chevron-right fa-3x'></i>"],
        items : 1, //10 items above 1000px browser width
        itemsDesktop : [1000,1], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,1], // betweem 900px and 601px
        itemsTablet: [600,1], //2 items between 600 and 0
        itemsMobile : true // itemsMobile disabled - inherit from itemsTablet option
    });


    /*var owl2 = $("#owl-chat2");
    owl2.owlCarousel({
        pagination: false,
        items: 2, //10 items above 1000px browser width
        itemsDesktop: [1000, 2], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 2], // betweem 900px and 601px
        itemsTablet: [600, 1], //2 items between 600 and 0
        itemsMobile: true, // itemsMobile disabled - inherit from itemsTablet option
        autoPlay:5000,
        autoPlayHoverPause:true,
        scrollPerPage : true
    });*/

    // owl_latest_offers
    var owl_latest_offers = $("#owl_latest_offers");
    owl_latest_offers.owlCarousel({
        pagination: false,
        navigation: true,
        navigationText: [
            "<i class='fa fa-chevron-left fa-3x'></i>",
            "<i class='fa fa-chevron-right fa-3x'></i>"],
        items : 2, //10 items above 1000px browser width
        itemsDesktop : [1000,2], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,2], // betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0
        itemsMobile : true, // itemsMobile disabled - inherit from itemsTablet option
        autoPlay:5000,
        autoPlayHoverPause:true,
        scrollPerPage : true
    });

    // Custom Navigation Events
    $(".next").click(function () {
        owl.trigger('owl.next');
    })
    $(".prev").click(function () {
        owl.trigger('owl.prev');
    })

    $(".next2").click(function () {
        owl2.trigger('owl.next');
    })
    $(".prev2").click(function () {
        owl2.trigger('owl.prev');
    })

    var owl3 = $("#owl-demo3");

    owl3.owlCarousel({
        navigation: false,
        pagination: true,
        singleItem: true,
        autoPlay:8000,
        autoPlayHoverPause:true,
        scrollPerPage : true
    });

    var owl4 = $("#owl-demo4");

    owl4.owlCarousel({
        navigation : true,
        navigationText: [
            "<i class='fa fa-chevron-left fa-3x'></i>",
            "<i class='fa fa-chevron-right fa-3x'></i>"],
        pagination: false,
        singleItem : true,
    });

    var owl5 = $("#owl-gallery");

    owl5.owlCarousel({
        navigation: false,
        pagination: false,
        items: 6, //10 items above 1000px browser width
        itemsDesktop: [1000, 6], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 3], // betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0
        itemsMobile: true // itemsMobile disabled - inherit from itemsTablet option
    });

    var owl6 = $(".owl_bannner_custom");
    owl6.owlCarousel({
        autoPlay:5000,
        autoPlayHoverPause:true,
        scrollPerPage : true,
        navigation : false,
        pagination: false,
        items : 4, //10 items above 1000px browser width
        itemsDesktop : [1000,4], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0
        itemsMobile : true // itemsMobile disabled - inherit from itemsTablet option
    });

    $(".fancybox").fancybox({
        openEffect: 'none',
        closeEffect: 'none'
    });
    //modal always center of the screen
    $('.modal').each(function () {
        var t = $(this),
            d = t.find('.modal-dialog'),
            fadeClass = (t.is('.fade') ? 'fade' : '');
        // render dialog
        t.removeClass('fade')
            .addClass('invisible')
            .css('display', 'block');
        // read and store dialog height
        d.data('height', d.height());
        // hide dialog again
        t.css('display', '')
            .removeClass('invisible')
            .addClass(fadeClass);
    });

    // phase two - set margin-top on every dialog show
    $('.modal').on('show.bs.modal', function () {
        var t = $(this),
            d = t.find('.modal-dialog'),
            dh = d.data('height'),
            w = $(window).width(),
            h = $(window).height();
        // if it is desktop & dialog is lower than viewport
        // (set your own values)
        if (w > 380 && (dh + 60) < h) {
            d.css('margin-top', Math.round(0.96 * (h - dh) / 2));
        } else {
            d.css('margin-top', '');
        }
    });
});

$(document).ready(function () {
    // Start slider
    $("#range_50").ionRangeSlider({
        type: "double",
        from_max: 0,
        min: 0,
        max: 1000,
        postfix: " km",
        grid: true
    });
    $(".btnClose").click(function () {
        $('.box_cart').toggle();
    });

    $(".btn_item").click(function (e) {
        e.preventDefault();
        $(this).toggle();
    });

    $(".btn_choose").click(function (e) {
        e.preventDefault();
        $(this).toggleClass("btn_choose_active");
    });

    $(".i_favourite").click(function (e) {
        e.preventDefault();
        $(this).toggleClass("i_favourite_active");
    });

    $(".btn_Approve").click(function (e) {
        e.preventDefault();
        $(this).toggleClass("btn_Approve_active");
    });
});

$(document).ready(function () {

    var sync1 = $("#sync1");
    var sync2 = $("#sync2");

    sync1.owlCarousel({
        singleItem: true,
        slideSpeed: 1000,
        navigation: false,
        pagination: false,
        afterAction: syncPosition,
        responsiveRefreshRate: 200,
    });

    sync2.owlCarousel({
        items: 4,
        itemsDesktop: [1199, 4],
        itemsDesktopSmall: [979, 4],
        itemsTablet: [768, 4],
        itemsMobile: [479, 4],
        pagination: false,
        responsiveRefreshRate: 100,
        afterInit: function (el) {
            el.find(".owl-item").eq(0).addClass("synced");
        }
    });

    function syncPosition(el) {
        var current = this.currentItem;
        $("#sync2")
            .find(".owl-item")
            .removeClass("synced")
            .eq(current)
            .addClass("synced")
        if ($("#sync2").data("owlCarousel") !== undefined) {
            center(current)
        }
    }

    $("#sync2").on("click", ".owl-item", function (e) {
        e.preventDefault();
        var number = $(this).data("owlItem");
        sync1.trigger("owl.goTo", number);
    });

    function center(number) {
        var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
        var num = number;
        var found = false;
        for (var i in sync2visible) {
            if (num === sync2visible[i]) {
                var found = true;
            }
        }

        if (found === false) {
            if (num > sync2visible[sync2visible.length - 1]) {
                sync2.trigger("owl.goTo", num - sync2visible.length + 2)
            } else {
                if (num - 1 === -1) {
                    num = 0;
                }
                sync2.trigger("owl.goTo", num);
            }
        } else if (num === sync2visible[sync2visible.length - 1]) {
            sync2.trigger("owl.goTo", sync2visible[1])
        } else if (num === sync2visible[0]) {
            sync2.trigger("owl.goTo", num - 1)
        }
    }
});

$(document).ready(function () {
    var sync3 = $(".sync3");
    var sync4 = $(".sync4");

    sync3.owlCarousel({
        singleItem: true,
        slideSpeed: 1000,
        navigation: false,
        pagination: false,
        afterAction: syncPosition,
        responsiveRefreshRate: 200,
    });

    sync4.owlCarousel({
        items: 5,
        itemsDesktop: [1199, 5],
        itemsDesktopSmall: [979, 4],
        itemsTablet: [768, 3],
        itemsMobile: [479, 3],
        pagination: false,
        responsiveRefreshRate: 100,
        afterInit: function (el) {
            el.find(".owl-item").eq(0).addClass("synced");
        }
    });

    function syncPosition(el) {
        var current = this.currentItem;
        $(".sync4")
            .find(".owl-item")
            .removeClass("synced")
            .eq(current)
            .addClass("synced")
        if ($(".sync4").data("owlCarousel") !== undefined) {
            center(current)
        }
    }

    $(".sync4").on("click", ".owl-item", function (e) {
        e.preventDefault();
        var number = $(this).data("owlItem");
        sync3.trigger("owl.goTo", number);
    });

    function center(number) {
        var sync2visible = sync4.data("owlCarousel").owl.visibleItems;
        var num = number;
        var found = false;
        for (var i in sync2visible) {
            if (num === sync2visible[i]) {
                var found = true;
            }
        }

        if (found === false) {
            if (num > sync2visible[sync2visible.length - 1]) {
                sync4.trigger("owl.goTo", num - sync2visible.length + 2)
            } else {
                if (num - 1 === -1) {
                    num = 0;
                }
                sync4.trigger("owl.goTo", num);
            }
        } else if (num === sync2visible[sync2visible.length - 1]) {
            sync4.trigger("owl.goTo", sync2visible[1])
        } else if (num === sync2visible[0]) {
            sync4.trigger("owl.goTo", num - 1)
        }

    }
});

$(document).ready(function () {
    var sync5 = $("#sync5");
    var sync6 = $("#sync6");

    sync5.owlCarousel({
        singleItem: true,
        slideSpeed: 1000,
        navigation: false,
        pagination: false,
        afterAction: syncPosition,
        responsiveRefreshRate: 200,
    });

    sync6.owlCarousel({
        items: 5,
        itemsDesktop: [1199, 5],
        itemsDesktopSmall: [979, 4],
        itemsTablet: [768, 3],
        itemsMobile: [479, 3],
        pagination: false,
        responsiveRefreshRate: 100,
        afterInit: function (el) {
            el.find(".owl-item").eq(0).addClass("synced");
        }
    });

    function syncPosition(el) {
        var current = this.currentItem;
        $("#sync6")
            .find(".owl-item")
            .removeClass("synced")
            .eq(current)
            .addClass("synced")
        if ($("#sync6").data("owlCarousel") !== undefined) {
            center(current)
        }
    }

    $("#sync6").on("click", ".owl-item", function (e) {
        e.preventDefault();
        var number = $(this).data("owlItem");
        sync5.trigger("owl.goTo", number);
    });

    function center(number) {
        var sync2visible = sync4.data("owlCarousel").owl.visibleItems;
        var num = number;
        var found = false;
        for (var i in sync2visible) {
            if (num === sync2visible[i]) {
                var found = true;
            }
        }

        if (found === false) {
            if (num > sync2visible[sync2visible.length - 1]) {
                sync5.trigger("owl.goTo", num - sync2visible.length + 2)
            } else {
                if (num - 1 === -1) {
                    num = 0;
                }
                sync5.trigger("owl.goTo", num);
            }
        } else if (num === sync2visible[sync2visible.length - 1]) {
            sync5.trigger("owl.goTo", sync2visible[1])
        } else if (num === sync2visible[0]) {
            sync5.trigger("owl.goTo", num - 1)
        }

    }
});

$(document).ready(function () {
    if ($('#list1').length == 1) {
        var checkList = document.getElementById('list1');
        var items = document.getElementById('items');
        checkList.getElementsByClassName('anchor')[0].onclick = function (evt) {
            if (items.classList.contains('visible')) {
                items.classList.remove('visible');
                items.style.display = "none";
            }
            else {
                items.classList.add('visible');
                items.style.display = "block";
            }
        }
        items.onblur = function (evt) {
            items.classList.remove('visible');
        }
    }
});

$(document).ready(function () {
    if ($('#list2').length == 1) {
        var checkList = document.getElementById('list2');
        var items = document.getElementById('items2');
        checkList.getElementsByClassName('anchor')[0].onclick = function (evt) {
            if (items.classList.contains('visible')) {
                items.classList.remove('visible');
                items.style.display = "none";
            }
            else {
                items.classList.add('visible');
                items.style.display = "block";
            }
        }
        items.onblur = function (evt) {
            items.classList.remove('visible');
        }
    }
});

$(document).ready(function () {
    if ($('#list3').length == 1) {
        var checkList = document.getElementById('list3');
        var items = document.getElementById('items3');
        checkList.getElementsByClassName('anchor')[0].onclick = function (evt) {
            if (items.classList.contains('visible')) {
                items.classList.remove('visible');
                items.style.display = "none";
            }
            else {
                items.classList.add('visible');
                items.style.display = "block";
            }
        }
        items.onblur = function (evt) {
            items.classList.remove('visible');
        }
    }
});

$(document).ready(function () {
    if ($('#list4').length == 1) {
        var checkList = document.getElementById('list4');
        var items = document.getElementById('items4');
        checkList.getElementsByClassName('anchor')[0].onclick = function (evt) {
            if (items.classList.contains('visible')) {
                items.classList.remove('visible');
                items.style.display = "none";
            }
            else {
                items.classList.add('visible');
                items.style.display = "block";
            }
        }
        items.onblur = function (evt) {
            items.classList.remove('visible');
        }
    }
});

$(document).ready(function () {
    if ($('#list5').length == 1) {
        var checkList = document.getElementById('list5');
        var items = document.getElementById('items5');
        checkList.getElementsByClassName('anchor')[0].onclick = function (evt) {
            if (items.classList.contains('visible')) {
                items.classList.remove('visible');
                items.style.display = "none";
            }
            else {
                items.classList.add('visible');
                items.style.display = "block";
            }
        }
        items.onblur = function (evt) {
            items.classList.remove('visible');
        }
    }
});

$(document).ready(function () {
    if ($('#list6').length == 1) {
        var checkList = document.getElementById('list6');
        var items = document.getElementById('items6');
        checkList.getElementsByClassName('anchor')[0].onclick = function (evt) {
            if (items.classList.contains('visible')) {
                items.classList.remove('visible');
                items.style.display = "none";
            }
            else {
                items.classList.add('visible');
                items.style.display = "block";
            }
        }
        items.onblur = function (evt) {
            items.classList.remove('visible');
        }
    }
});

$(document).ready(function () {
    if ($('#list7').length == 1) {
        var checkList = document.getElementById('list7');
        var items = document.getElementById('items7');
        checkList.getElementsByClassName('anchor')[0].onclick = function (evt) {
            if (items.classList.contains('visible')) {
                items.classList.remove('visible');
                items.style.display = "none";
            }
            else {
                items.classList.add('visible');
                items.style.display = "block";
            }
        }
        items.onblur = function (evt) {
            items.classList.remove('visible');
        }
    }
});