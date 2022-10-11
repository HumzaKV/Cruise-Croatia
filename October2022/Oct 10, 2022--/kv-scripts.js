function setCookie(e, t, n) {
    var o = new Date;
    o.setTime(o.getTime() + 24 * n * 60 * 60 * 1e3);
    var i = "expires=" + o.toUTCString();
    document.cookie = e + "=" + t + ";" + i + ";path=/"
}

function getCookie(e) {
    for (var t = e + "=", n = decodeURIComponent(document.cookie).split(";"), o = 0; o < n.length; o++) {
        for (var i = n[o];
            " " == i.charAt(0);) i = i.substring(1);
        if (0 == i.indexOf(t)) return i.substring(t.length, i.length)
    }
    return ""
}

jQuery(function($) {
console.log('Script Loaded');

    function currentDate() {
        var d = new Date(),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [month, day, year].join('/');
    }
    let today = currentDate();
    if ($('input#input_19_25').length == 1) {
        $('input#input_19_25').addClass('dateDropper').dateDropper({
            'large': 1,
            'minDate': today,
            'largeDefault': 1,
            'format': 'd/m/Y'
        });
    }
    if ($('input#input_20_25').length == 1) {
        $('input#input_20_25').addClass('dateDropper').dateDropper({
            'large': 1,
            'minDate': today,
            'largeDefault': 1,
            'format': 'd/m/Y'
        });
    }

// ON change country field
    $(document).on('change','#input_2_23',function(){
        let value = $(this).val();
        let currency = 'EUR';
        if(value == 'United States'){
            currency = 'USD';
        }
        if(value == 'United Kingdom'){
            currency = 'GBP';
        }
        if(value == 'Australia'){
            currency = 'AUD';
        }
        // Hidden Currency Field
        $('#input_2_35').val(currency);

    });
	
    // Configure/customize these variables.
    var showChar = 150; // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Read More";
    var lesstext = "Read Less";


    $('.more').each(function() {
        var content = $(this).html();

        if (content.length > showChar) {

            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);

            var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

            $(this).html(html);
        }

    });

    $(".morelink").click(function() {
        if ($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });


    $('.auto_switcher_link').on('click', function(e) {
        e.preventDefault();
        setCookie('cc_format', $(this).data('value'));
        document.location.reload();
    });

    $('.desk_slider').owlCarousel({
        loop: false,
        nav: true,
        dots: false,
        mouseDrag: true,
        margin: 70,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });

    // Day By Day Carousel
    $('.product_list').owlCarousel({
        loop: false,
        nav: true,
        dots: false,
        mouseDrag: true,
        margin: 40,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });

    // Excursion Carousel
    $('.excursion_carousel').owlCarousel({
        loop: false,
        nav: true,
        dots: true,
        mouseDrag: false,
        margin: 40,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });

    // Responsive Menu
    $('.menu-button').click(function() {
        $('.main-menu').toggleClass('active');
        $('.menu-button').toggleClass('open');
    });
    $('#menu-main-navigation .menu-item-has-children').click(function() {
        $(this).toggleClass('active');
    });

    // Mobile Menu Script
    $(document).on('click', 'body', function(e) {
        $('.new_head .mobile-main-menu').removeClass('active');
        $('html').removeClass('open');
        $('#menu-mobile-menu .sub-menu').removeClass('active')
        $('#menu-mobile-menu .sub-menu .submenu-close').remove();
        $('.new_head .menu-button-new').removeClass('close');
    });

    $(document).on('click', 'body', function(e) {
        $('.new_head .mobile-main-menu').removeClass('active');
        $('html').removeClass('open');
        $('#menu-mobile-menu .sub-menu').removeClass('active')
        $('#menu-mobile-menu .sub-menu .submenu-close').remove();
    });

    $(document).on('click', '.navigation-wrapper', function(e) {
        e.stopPropagation();
    });

    //    Menu Bars Click Event
    $(document).on('click', '.new_head .menu-button-new', function(e) {
        //   Toggle Sidebar menu;
        e.stopPropagation();
        $('.new_head .mobile-main-menu').toggleClass('active');
        $('html').toggleClass('open');
        $('.new_head .menu-button-new').toggleClass('close');
    });

    //    Menu Bars Click Event Close
    $(document).on('click', '.new_head .menu-button-new.close', function(e) {
        //   Toggle Sidebar menu;
        e.stopPropagation();
        $('#menu-mobile-menu .sub-menu').removeClass('active')
        $('#menu-mobile-menu .sub-menu .submenu-close').remove();
    });

    $('#menu-mobile-menu li.menu-item-has-children').append('<div class="trig">X</div>');

    $(document).on('click', '#menu-mobile-menu li.menu-item-has-children .trig', function(e) {
        e.stopPropagation();
        let submenu = $(this).prev();
        myabc = $(this);
        if (!submenu.hasClass('active')) {
            submenu.prepend('<li class="submenu-close">Back</li>').addClass('active');
        }
    });

    $(document).on('click', '#menu-mobile-menu li.submenu-close', function(e) {
        e.stopPropagation();
        $(this).parent().removeClass('active');
        $(this).remove();
    });

    $('.navigation-wrapper ul.auto_switche').hide();
    $('.navigation-wrapper .currency-mobile .current-status').on('click', function () {
        $('.navigation-wrapper ul.auto_switche').toggleClass('active');
        $('.navigation-wrapper .currency-mobile .current-status').toggleClass('active');
    });

    // Mobile Menu Script End

    if (!jQuery('body').hasClass('page-id-11244')) {
        $('.menu-item-has-children').click(function() {
            $(this).toggleClass('active');
        });
    }
    //Clickable Entire Div
    jQuery(".blog-item").click(function() {
        if (jQuery(this).find("a").length) {
            window.location.href = jQuery(this).find("a:first").attr("href");
        }
    });
    // Day By Day Carousel
    $('.day').owlCarousel({
        loop: false,
        nav: true,
        dots: false,
        //items: 3,
        //slideBy: 3,
        mouseDrag: true,
        margin: 40,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        responsive: {
            0: {
                items: 1,
                autoHeight: true,
            },
            768: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
    $(window).scroll(function() {
        var scroll = $(this).scrollTop();
        if (scroll >= 10) {
            $(".header-wrapper").addClass("is_sticky");
        } else {
            $(".header-wrapper").removeClass("is_sticky");
        }
    });


    $('.kv-datepicker').datepicker({
        showAnim: 'slideDown',
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy',
        minDate: new Date()
    });

    // gform.addFilter('gform_datepicker_options_pre_init', function(optionsObj, formId, fieldId) {
    //     optionsObj.minDate = new Date();
    //     return optionsObj;
    // });

    $('.kv_loadmore').on('click', function(e) {
        e.preventDefault();
        console.log('1');
        var _link = $(this).find('a').attr('href');
        $('.kv_loadmore').html('<span class="loader">Loading More Posts...</span>');
        $.get(_link, function(data) {
            var post = $("#list-container ul li", data);
            $('#list-container ul').append(post);
            $('.load-more-container').html($(".load-more-container", data));
        });
        $('.kv_loadmore').load(_link + ' .kv_loadmore a');
    });


    //----- OPEN
    $('[data-popup-open]').on('click', function(e) {
        var targeted_popup_class = jQuery(this).attr('data-popup-open');
        $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
        e.preventDefault();
    });

    //----- CLOSE
    $('[data-popup-close]').on('click', function(e) {
        var targeted_popup_class = jQuery(this).attr('data-popup-close');
        $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
        e.preventDefault();
    });


    $(".accordion2").accordion({
        collapsible: true,
        heightStyle: "content"
    });

    //Floating Menu
    $(window).scroll(function() {
        var scroll = $(this).scrollTop();
        if (scroll >= 200) {
            $(".floating_menu_bar").addClass("active");
        } else {
            $(".floating_menu_bar").removeClass("active");
        }
    });

    // Enquire Cookie
    $('.enquiry-now').on('click', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        console.log('URl: ' + url)
        setCookie('enquiry_title', $(this).data('product'));
        document.location = url;
    });

    $('.jp_open').on('click', function() {
        $('.jp_open').toggleClass('active');
        $('.banner_links').slideToggle('slow');
    });

    $(document).on('scroll', function() {
        var scrolled = $(window).scrollTop();
        if (scrolled > 611.484375) {
            $(".mobile-sticky").css({
                'position': 'fixed'
            }).addClass("sticky");
        } else {
            $(".mobile-sticky").css({
                'position': 'static'
            }).removeClass("sticky");
        }
    });

    // Newpop Form
    $(document).on('focus', '.form_area .gform_wrapper .gform_body li .ginput_container input', function() {
        let kingdom = $(this).val()
        $(this).parents("li").find(".gfield_label").addClass("active");
    });

    $(document).on('focusout', '.form_area .gform_wrapper .gform_body li .ginput_container input', function() {
        let kingdom = $(this).val()
        if (kingdom != '') {
            $(this).parents("li").find(".gfield_label").addClass("active");
        } else {
            $(this).parents("li").find(".gfield_label").removeClass("active");
        }
    });
    // Newpop Form End

    // Gallery Box
    $('.gallery_box_inn').slick({
        infinite: true,
        dots: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: '<div class="hc-arrow-left"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
        nextArrow: '<div class="hc-arrow-right"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
    });

    //Product Slider
    $('.cwpc_silder').slick({
        infinite: true,
        dots: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: '<div class="hc-arrow-left"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
        nextArrow: '<div class="hc-arrow-right"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
        responsive: [{
                breakpoint: 480,
                settings: {
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    //Seasonal Charter
    $('.seasonal').slick({
        infinite: true,
        dots: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        centerMode: true,
        prevArrow: '<div class="hc-arrow-left"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
        nextArrow: '<div class="hc-arrow-right"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
        responsive: [{
                breakpoint: 480,
                settings: {
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 3
                }
            }
        ]
    });

     
    $(document).ready(function ($) {
        $('body *').mouseenter(function (e) {
            if (!$(e.target).parents().andSelf().is('.currency-switcher') && !$(e.target).parents().andSelf().is('.current-status')) {
                $('ul.auto_switcher').stop(true, true).delay(200).fadeOut(200);
            }
        });
        $('.current-status').mouseenter(function () {
            $('ul.auto_switcher').stop(true, true).delay(200).fadeToggle(200);
        });
    });

    //Mega Menu
    if ($(window).width() > 992) {
        $(document).ready(function() {
            $('.navigation-wrapper ul.menu>li').hover(function() {
                $(this).addClass('active');
                $(this).find('.sub-menu').stop(true, true).delay(200).fadeIn(200);
            }, function() {
                $(this).removeClass('active');
                $(this).find('.sub-menu').stop(true, true).delay(200).fadeOut(200);
            });
        });
    }

    if ($(window).width() > 768) {
        var scroll = $(window).scrollTop();
        is_sticky(scroll);
        $(window).scroll(function() {
            var scroll = $(this).scrollTop();
            is_sticky(scroll);
        });

        function is_sticky(scroll) {
            var headerElm = $('.header-wrapper'),
                jLinkElm = $('.jump_links'),
                sliderElm = $('section.styled'),
                headOffset = headerElm.offset().top,
                headHeight = headerElm.height();
            if ($('body .jump_links').length == 1) {
                if (scroll >= headHeight) {
                    if ((sliderElm.height() + headHeight) > scroll) { // && scroll < (jLinkOffset-20)
                        headerElm.css('position', 'fixed').addClass('is_sticky--here').removeClass("hide");
                    }
                    // else {
                    //     headerElm.css('position', 'absolute').removeClass('is_sticky--here').addClass("hide");
                    // }
                    if (scroll >= (sliderElm.height() + headHeight)) {
                        jLinkElm.css('position', 'fixed').addClass('is_sticky--here');
                    } else {
                        jLinkElm.css('position', 'static').removeClass('is_sticky--here');
                    }
                } else {
                    headerElm.css('position', 'static').removeClass('is_sticky--here');
                }
            } else {
                if (scroll >= headHeight) {
                    if ((sliderElm.height() + headHeight) > scroll) { // && scroll < (jLinkOffset-20)
                        headerElm.css('position', 'fixed').addClass('is_sticky--here').removeClass("hide");
                    }
                } else {
                    headerElm.css('position', 'static').removeClass('is_sticky--here');
                }
            }
        }
    }

    var sections = $('.full-section'),
        nav = $('.jump-left'),
        nav_height = nav.outerHeight();
    $(window).on('scroll', function() {
        var cur_pos = $(this).scrollTop();
        sections.each(function() {
            var top = $(this).offset().top - 300;
            var bottom = top + $(this).outerHeight();
            if (cur_pos >= top && cur_pos <= bottom) {
                nav.find('a').removeClass('active');
                sections.removeClass('active');
                $(this).addClass('active');
                nav.find('a[href="#' + $(this).attr('id') + '"]').addClass('active');
            }
        });
    });

    $(".flip_box li.item").hover(function() {
       $(this).find('.back').toggleClass('active') 
       $(this).find('.front').toggleClass('active') 
    });

    $(document).on('click', '.toggle_bottom', function() {
        $(this).toggleClass('active').parent().find('.features_inn').slideToggle();
    });

    $(document).on('click', '.toggle_all', function() {
        if ($('.features_inn').is(':hidden')) {
            $('.features_inn:hidden').slideToggle();
        } else {
            $('.features_inn:visible').slideToggle();
        }
    });
});
