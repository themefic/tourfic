(function($){
    'use strict';

    $(document).ready(function(){
        var sbp = $('.swiper-button-prev'),
            sbn = $('.swiper-button-next');

        $('.single-slider-wrapper .tf_slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: false,
            dots: false,
            asNavFor: '.tf_slider-nav'
        });

        $('.single-slider-wrapper .tf_slider-nav').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.tf_slider-for',
            dots: false,
            arrows: false,
            centerMode: true,
            focusOnSelect: true
        });

        sbp.on("click", function () {
            $(this).closest(".single-slider-wrapper").find('.tf_slider-for').slick('slickPrev');
        });

        sbn.on("click", function () {
            $(this).closest(".single-slider-wrapper").find('.tf_slider-for').slick('slickNext');
        });

        // Tab controlling
        $('.tf_tab-nav a').on('click',function(e){
            e.preventDefault();
            var targetDiv = $(this).attr('href');

            if(!$(this).hasClass('active')){
                $(this).addClass('active').siblings().removeClass('active');
            }
            $('.tf-tab-container').find(targetDiv).addClass('active').siblings().removeClass('active');

        });

        // FullWidth Container JS
        function fullwidthInit(selector){
            function fullWidth(selector){
                $(selector).each(function(){
                    $(this).width("100%").css({ marginLeft : "-0px" });

                    var window_width = $(window).width();

                    var left_margin = "-"+$(this).offset().left+"px";

                    $(this).width(window_width).css({ marginLeft : left_margin });
                    console.log("Width:",window_width,"Margin Left:",left_margin);
                });
            }
            $(window).on("resize load", function(){
                fullWidth(selector);
            });
        }

        // Usage DOM: <div data-fullwidth="true">...</div> in JS: fullwidthInit("[data-fullwidth=true]");
        fullwidthInit("[data-fullwidth=true]");

        // Share copy
        $('button#share_link_button').click(function(){

            $(this).addClass('copied');
            setTimeout(function(){ $('button#share_link_button').removeClass('copied'); }, 3000);
            $(this).parent().find("#share_link_input").select();
            document.execCommand("copy");
        });

        // Toggle
        $('[data-toggle="true"]').click(function(e){
            e.preventDefault();
            var target = $(this).attr('href');
            $(target).slideToggle('fast');
        });


        // Date picker
        var dateToday = new Date();
        var checkin_input = jQuery( "#check-in-date" ),
            checkout_input = jQuery( "#check-out-date" );

        var dateFormat = 'DD-MM-YYYY';

        // Trigger Check-in Date
        $('.tf_selectdate-wrap, #check-in-out-date').daterangepicker({
            "locale": {
                "format": dateFormat,
                "separator": " - ",
                "firstDay": 1
            },
            minDate : dateToday,
            autoApply: true,
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));

            checkin_input.val( start.format(dateFormat) );
            $('.checkin-date-text').text( start.format(dateFormat) );

            checkout_input.val( end.format(dateFormat) );
            $('.checkout-date-text').text( end.format(dateFormat) );
        });

        // Number Decrement
        $('.acr-dec').on('click',function(e){

            var input = $(this).parent().find('input');
            var min = input.attr('min');

            if ( input.val() > min ) {
                input.val( input.val()-1 ).change();
            }

        });

        // Number Increment
        $('.acr-inc').on('click',function(e){
            var input = $(this).parent().find('input');
            input.val( parseInt(input.val())+1 ).change();
        });

        // Adults change trigger
        $(document).on('change', '#adults', function(){
            var thisVal = $(this).val();

            if ( thisVal > 1 ) {
                $('.adults-text').text(thisVal+" Adults");
            } else {
                $('.adults-text').text(thisVal+" Adult");
            }

        });

        // Children change trigger
        $(document).on('change', '#children', function(){
            var thisVal = $(this).val();

            if ( thisVal > 1 ) {
                $('.child-text').text(thisVal+" Children");
            } else {
                $('.child-text').text(thisVal+" Child");
            }

        });

        // Room change trigger
        $(document).on('change', '#room', function(){
            var thisVal = $(this).val();

            if ( thisVal > 1 ) {
                $('.room-text').text(thisVal+" Rooms");
            } else {
                $('.room-text').text(thisVal+" Room");
            }
        });

        // Adult, Child, Room Selection toggle
        $(document).on('click', '.tf_selectperson-wrap .tf_input-inner', function(){
            $('.tf_acrselection-wrap').slideToggle('fast');
        });

    });

    $(window).load(function(){

    });

})(jQuery);

// Ajax Scripts
(function($){
    'use strict';

    $(document).ready(function(){

        // Email Capture
        $(document).on('submit', 'form.tf-room', function(e){
            e.preventDefault();

            var $this = $(this);

            var formData = new FormData(this);
            formData.append('action', 'tf_room_booking');

            $.ajax({
                type: 'post',
                url: tf_params.ajax_url,
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function(data){
                    $this.block({
                        message: null,
                        overlayCSS: {
                            background: "#fff",
                            opacity: .5
                        }
                    });

                    $('.tf_notice_wrapper').html("").hide();
                },
                complete: function(data){
                    $this.unblock();
                },
                success: function(data){
                    $this.unblock();

                    var response = JSON.parse(data);

                    if( response.status == 'error' ) {
                        var errorHtml = "";

                        response.errors.forEach( function( text ){
                            errorHtml += '<div class="woocommerce-error">'+text+'</div>';
                        } );

                        $('.tf_notice_wrapper').html( errorHtml ).show();

                        $("html, body").animate({ scrollTop: 0 }, 300);
                        return false;
                    } else {

                        if ( response.redirect_to ) {
                            window.location.replace( response.redirect_to );
                        } else {
                            jQuery(document.body).trigger('added_to_cart');
                        }

                    }
                },
                error: function(data){
                    console.log(data);

                },

            });

        });
    });

})(jQuery);

// Infinite Scroll
(function($){
    'use strict';

    $(document).ready(function(){

        var flag = false;
        var main_xhr;

        var amPushAjax = function( url ){
            if(main_xhr && main_xhr.readyState != 4){
                main_xhr.abort();
            }
            main_xhr = $.ajax({
                url: url,
                asynch: true,
                beforeSend: function() {
                    $( document ).find( '.tf_posts_navigation' ).addClass( 'loading' );
                    flag = true;
                },
                success: function(data) {
                    //console.log(data);
                    $('.archive_ajax_result').append($('.archive_ajax_result', data).html());

                    $('.tf_posts_navigation').html($('.tf_posts_navigation', data).html());

                    //document.title = $(data).filter('title').text();

                    flag = false;

                    $( document ).find( '.tf_posts_navigation' ).removeClass( 'loading' );

                }
            });
        };

        // Feed Ajax Trigger
        $( document ).on('click', '.tf_posts_navigation a.next.page-numbers', function(e){
            e.preventDefault();

            var targetUrl = ( e.target.href ) ? e.target.href : $(this).context.href;
            amPushAjax( targetUrl );
            //window.history.pushState({url: "" + targetUrl + ""}, "", targetUrl);
        });
        // End Feed Ajax Trigger

        // Feed Click Trigger
        $( window ).on('scroll', function(e){
            $('.tf_posts_navigation a.next.page-numbers').each(function(i,el){

                var $this = $(this);

                var H = $(window).height(),
                    r = el.getBoundingClientRect(),
                    t=r.top,
                    b=r.bottom;

                var tAdj = parseInt(t-(H/2));

                if ( flag === false && (H >= tAdj) ) {
                    console.log( 'inview' );
                    $this.trigger('click');
                } else {
                    console.log( 'outview' );
                }
            });
        });
        // End Feed Click Trigger

    });

})(jQuery);