
/*
––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
  FRIDAY - Coupons, Deals, Discounts and Promo Codes Template
–––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––

    - File           : main.js
    - Desc           : Template - JavaScript
    - Version        : 1.1
    - Date           : 2017-03-01
    - Author         : CODASTROID
    - Author URI     : https://themeforest.net/user/codastroid

––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
*/




(function($) {

    "use strict";

    $.fn.hasAttr = function(attr) {  
       if (typeof attr !== typeof undefined && attr !== false && attr !== undefined) {
            return true;
       }
       return false;
    };

    /*-------------------------------------
     Background Image Function
    -------------------------------------*/
    var background_image = function() {
        $("[data-bg-img]").each(function() {
            var attr = $(this).attr('data-bg-img');
            if (typeof attr !== typeof undefined && attr !== false && attr !== "") {
                $(this).css('background-image', 'url('+attr+')');
            }
        });  
    };

    /*-------------------------------------
     Background Color Function
    -------------------------------------*/
    var background_color = function() {
        $("[data-bg-color]").each(function() {
            var attr = $(this).attr('data-bg-color');
            if (typeof attr !== typeof undefined && attr !== false && attr !== "") {
                $(this).css('background-color', attr);
            }
        });  
    };

    var link_void = function() {
        $("a[data-prevent='default']").each(function() {
            $(this).on('click', function(e) {
                e.preventDefault();
            });
        });
    };

    /*-------------------------------------
     Preloader
    -------------------------------------*/
    var preloader = function() {
        if($('#preloader').length) {
            $('#preloader > *').fadeOut(); // will first fade out the loading animation
            $('#preloader').delay(150).fadeOut('slow'); // will fade out the white DIV that covers the website.
            $('body').delay(150).removeClass('preloader-active');
        }
    };

    /*-------------------------------------
     HTML attr direction
    -------------------------------------*/
    var html_direction = function() {
        var html_tag = $("html"),
            dir = html_tag.attr("dir"),
            directions = ['ltr', 'rtl'];
        if (html_tag.hasAttr('dir') && jQuery.inArray(dir, directions)) {
            html_tag.addClass(dir);
        } else {
            html_tag.attr("dir", directions[0]).addClass(directions[0]);
        }
    };
    

    /*-------------------------------------
     CSS fix for IE Mobile
    -------------------------------------*/
    var bugfix = function() {
        if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
          var msViewportStyle = document.createElement('style');
          msViewportStyle.appendChild(
            document.createTextNode(
              '@-ms-viewport{width:auto!important}'
            )
          );
          document.querySelector('head').appendChild(msViewportStyle);
        }
    };

    /*-------------------------------------
     Toggle Class function
    -------------------------------------*/
    var toogle_class = function() {
        $('[data-toggle-class]').each(function(){
            var current = $(this),
                toggle_event = current.data('toggle-event'),
                toggle_class = current.data('toggle-class');

            if (toggle_event == "hover") {
                current.on("mouseenter", function() {
                    if (current.hasClass(toggle_class) === false) {
                        $(this).addClass(toggle_class);
                    }
                });
                current.on("mouseleave", function() {
                    if (current.hasClass(toggle_class) === true) {
                        $(this).removeClass(toggle_class);
                    }
                });
            }
            current.on(toggle_event, function() {
                $(this).toggleClass(toggle_class);
            });
        });
    };


    /*-------------------------------------
     Back Top functions
    -------------------------------------*/
    var back_to_top = function() {
        var backTop = $('#backTop');
        if (backTop.length) {
            var scrollTrigger = 200,
                scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                backTop.addClass('show');
            } else {
                backTop.removeClass('show');
            }
        }
    };
    var click_back = function() {
        var backTop = $('#backTop');
        backTop.on('click', function(e) {
            $('html,body').animate({
                scrollTop: 0
            }, 700);
            e.preventDefault();
        });
    };

    /*-------------------------------------
     Navbar Functions
    -------------------------------------*/
    var navbar_js = function() {
        $('.dropdown-mega-menu > a, .nav-menu > li:has( > ul) > a').append("<span class=\"indicator\"><i class=\"fa fa-angle-down\"></i></span>");
        $('.nav-menu > li ul > li:has( > ul) > a').append("<span class=\"indicator\"><i class=\"fa fa-angle-right\"></i></span>");
        $(".dropdown-mega-menu, .nav-menu li:has( > ul)").on('mouseenter', function () {
            if ($(window).width() > 943) {
                $(this).children("ul, .mega-menu").fadeIn(100);
            }
        });
        $(".dropdown-mega-menu, .nav-menu li:has( > ul)").on('mouseleave', function () {
            if ($(window).width() > 943) {
                $(this).children("ul, .mega-menu").fadeOut(100);
            }
        });
        $(".dropdown-mega-menu > a, .nav-menu li:has( > ul) > a").on('click', function (e) {
            if ($(window).width() <= 943) {
                $(this).parent().addClass("active-mobile").children("ul, .mega-menu").slideToggle(150, function() {
                    
                });
                $(this).parent().siblings().removeClass("active-mobile").children("ul, .mega-menu").slideUp(150);
            }
            e.preventDefault();
        });
        $(".nav-toggle").on('click', function (e) {
            var toggleId = $(this).data("toggle");
            $(toggleId).slideToggle(150);
            e.preventDefault();
        });
    };
    var navbar_resize_load = function() {
        if ($(".nav-header").css("display") == "block") {
            $(".nav-bar").addClass('nav-mobile');
            $('.nav-menu').find("li.active").addClass("active-mobile");
        }
        else {
            $(".nav-bar").removeClass('nav-mobile');
        }

        if ($(window).width() >= 943) {
            $(".dropdown-mega-menu a, .nav-menu li:has( > ul) a").each(function () {
                $(this).parent().children("ul, .mega-menu").slideUp(0);
            });
            $($(".nav-toggle").data("toggle")).show();
            $('.nav-menu').find("li").removeClass("active-mobile");
        }
    };

    /*-------------------------------------
     Social Icons Share
    -------------------------------------*/
    var share_social = function() {
        var share_action = $('.deal-actions .share-btn');
        share_action.on('click',function(){
            var share_icons = $(this).children('.share-tooltip');
            share_icons.toggleClass('in');
        });
    };

    /*-------------------------------------
     Add Deal to Favorite
    -------------------------------------*/
    var add_favorite = function() {
        var like_btn = $('.actions .like-deal');
        like_btn.on('click',function(){
            $(this).toggleClass('favorite');
        });
    };

    /*-------------------------------------
     Carousel slider initiation
    -------------------------------------*/
    var owl_carousel = function() {
        $('.owl-slider').each(function () {
            var carousel = $(this),
                autoplay_hover_pause = carousel.data('autoplay-hover-pause'),
                loop = carousel.data('loop'),
                items_general = carousel.data('items'),
                margin = carousel.data('margin'),
                autoplay = carousel.data('autoplay'),
                autoplayTimeout = carousel.data('autoplay-timeout'),
                smartSpeed = carousel.data('smart-speed'),
                nav_general = carousel.data('nav'),
                navSpeed = carousel.data('nav-speed'),
                xxs_items = carousel.data('xxs-items'),
                xxs_nav = carousel.data('xxs-nav'),
                xs_items = carousel.data('xs-items'),
                xs_nav = carousel.data('xs-nav'),
                sm_items = carousel.data('sm-items'),
                sm_nav = carousel.data('sm-nav'),
                md_items = carousel.data('md-items'),
                md_nav = carousel.data('md-nav'),
                lg_items = carousel.data('lg-items'),
                lg_nav = carousel.data('lg-nav'),
                center = carousel.data('center'),
                dots_global = carousel.data('dots'),
                xxs_dots = carousel.data('xxs-dots'),
                xs_dots = carousel.data('xs-dots'),
                sm_dots = carousel.data('sm-dots'),
                md_dots = carousel.data('md-dots'),
                lg_dots = carousel.data('lg-dots');

            carousel.owlCarousel({
                autoplayHoverPause: autoplay_hover_pause,
                loop: (loop ? loop : false),
                items: (items_general ? items_general : 1),
                lazyLoad: true,
                margin: (margin ? margin : 0),
                autoplay: (autoplay ? autoplay : false),
                autoplayTimeout: (autoplayTimeout ? autoplayTimeout : 1000),
                smartSpeed: (smartSpeed ? smartSpeed : 250),
                dots: (dots_global ? dots_global : false),
                nav: (nav_general ? nav_general : false),
                navText: ["<i class='fa fa-angle-left' aria-hidden='true'></i>", "<i class='fa fa-angle-right' aria-hidden='true'></i>"],
                navSpeed: (navSpeed ? navSpeed : false),
                center: (center ? center : false),
                responsiveClass: true,
                responsive: {
                    0: {
                        items: ( xxs_items ? xxs_items : (items_general ? items_general : 1)),
                        nav: ( xxs_nav ? xxs_nav : (nav_general ? nav_general : false)),
                        dots: ( xxs_dots ? xxs_dots : (dots_global ? dots_global : false))
                    },
                    480: {
                        items: ( xs_items ? xs_items : (items_general ? items_general : 1)),
                        nav: ( xs_nav ? xs_nav : (nav_general ? nav_general : false)),
                        dots: ( xs_dots ? xs_dots : (dots_global ? dots_global : false))
                    },
                    768: {
                        items: ( sm_items ? sm_items : (items_general ? items_general : 1)),
                        nav: ( sm_nav ? sm_nav : (nav_general ? nav_general : false)),
                        dots: ( sm_dots ? sm_dots : (dots_global ? dots_global : false))
                    },
                    992: {
                        items: ( md_items ? md_items : (items_general ? items_general : 1)),
                        nav: ( md_nav ? md_nav : (nav_general ? nav_general : false)),
                        dots: ( md_dots ? md_dots : (dots_global ? dots_global : false))
                    },
                    1199: {
                        items: ( lg_items ? lg_items : (items_general ? items_general : 1)),
                        nav: ( lg_nav ? lg_nav : (nav_general ? nav_general : false)),
                        dots: ( lg_dots ? lg_dots : (dots_global ? dots_global : false))
                    }
                }
            });

        });
    };

    /*-------------------------------------
     Flexslider
    -------------------------------------*/
    var product_slider = function() {
        $('#product_slider_nav').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 150,
            asNavFor: '#product_slider'
        });

        $('#product_slider').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            sync: "#product_slider_nav"
        });
    };

    /*-------------------------------------
     Stars Rating functions
    -------------------------------------*/
    var data_rating = function() {
        $('.rating').each(function () {
            var rating = $(this).find('.rating-stars').attr('data-rating'),
                rating_index = 5 - rating;
            $(this).find('.rating-stars > i').eq(rating_index).addClass('star-active');
        });
    };

    var do_rating = function() {
        var rating_stars_select = $('.rating .rating-stars.rate-allow');
        rating_stars_select.on('mouseenter', function () {
            $(this).find('i').removeClass('star-active');
        });
        rating_stars_select.on('mouseleave', function () {
            data_rating();
        });
        rating_stars_select.on('click', 'i', function () {
            var num_stars = $(this).siblings().length + 1,
                rating_index = $(this).index(),
                rating_count_select = $(this).parent().parent().find('.rating-count'),
                reviews_num = parseInt(rating_count_select.text(), 10),
                rate_value = num_stars - rating_index;
            reviews_num ++;

            $(this).parent().attr('data-rating', rate_value);
            data_rating();
            if ($(this).parent().attr('data-review')) {
                return false;
            }
            else {
                $(this).parent().attr('data-review', '1');
                rating_count_select.text(reviews_num);
            }
        });
    };

    /*-------------------------------------
     Deals Countdown function
    -------------------------------------*/
    var countdown = function(){
        var countdown_select = $("[data-countdown]");
        countdown_select.each(function(){
            $(this).countdown($(this).data('countdown'))
            .on('update.countdown', function(e){
                var format = '%H : %M : %S';
                if (e.offset.totalDays > 0) {
                    format = '%d Day%!d '+format;
                }
                if (e.offset.weeks > 0) {
                    format = '%w Week%!w '+format;
                }
                $(this).html(e.strftime(format));
            });
        }).on('finish.countdown', function(e){
            $(this).html('This offer ha expired!').addClass('disabled');
        });
    };

    /*-------------------------------------
     Delete Item From Cart
    -------------------------------------*/
    var cart_delete_item = function(){
        var close = $("#cart_list").find(".close[data-dismiss='alert']");
        close.on('click', function(){
            if (confirm("Do You Really Want to Delete This item ?") === false) {
                return false;
            }
        });
    };

    /* ================================
       When document is ready, do
    ================================= */
       
        $(document).on('ready', function() {
            preloader();
            $('[data-toggle="tooltip"]').tooltip();
            html_direction();
            background_color();
            background_image();
            link_void();
            click_back();
            bugfix();
            navbar_js();
            share_social();
            add_favorite();
            owl_carousel();
            toogle_class();
            countdown();
            data_rating();
            do_rating();
            countdown();
            cart_delete_item();
        });
        
    /* ================================
       When document is loading, do
    ================================= */
        
        $(window).on('load', function() {
            preloader();
            navbar_resize_load();
            product_slider();
        }); 

    /* ================================
       When Window is resizing, do
    ================================= */
        
        $(window).on('resize', function() {
            navbar_resize_load();
        });

    /* ================================
       When document is Scrollig, do
    ================================= */
        
        $(window).on('scroll', function() {
            back_to_top();
        });

    
})(jQuery);