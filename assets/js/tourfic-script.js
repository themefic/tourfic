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
            $(target).slideToggle();
        });


        // Date picker
        var dateToday = new Date();
        var checkin_input = jQuery( "#check-in-date" ),
            checkout_input = jQuery( "#check-out-date" );

        var dateFormat = 'dd-mm-yy';

        checkin_input.datepicker({
            //format: 'dd/mm/yyyy',
            dateFormat: dateFormat,
            minDate: 0,
            onSelect: function(date) {
                checkout_input.datepicker( "option", "minDate", new Date( checkin_input.datepicker( "getDate" ) ) );
                console.log(date);
            }
        });

        checkout_input.datepicker({
            //format: 'dd/mm/yyyy',
            dateFormat: dateFormat,
            minDate: 0,
            onSelect: function(date) {

            }
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