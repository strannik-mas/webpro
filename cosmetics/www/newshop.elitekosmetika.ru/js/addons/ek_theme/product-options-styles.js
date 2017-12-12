// Module for styling radio buttons in Product page
// This module add class for marking active radio button

var OptionsStylingModule = (function($){
    var vars = {
        'activeClass': 'product-option-active',
        'optionBoxSelector': '.ty-product-options__box',
        'optionsBoxSelector': '.ty-product-options__item',
        'behaviorMarkerClass': 'options-styling-behavior'
    };


    var methods = {
        init: function() {
            $(vars.optionBoxSelector).each(function(){
                var $container = $(this);
                var $el = $container.find('input[type="radio"]');
                if($el.is(':checked')) {
                    $container.addClass(vars.activeClass);
                }
            });

            $(vars.optionBoxSelector + ' input[type="radio"]').on('change', function(){
                var $optionBox = $(this).closest(vars.optionBoxSelector);

                var $optionsBox = $optionBox.closest(vars.optionsBoxSelector);
                $optionsBox.find(vars.optionBoxSelector).removeClass(vars.activeClass);
                $optionBox
                    .addClass(vars.activeClass);
            }).each(function(){
                $(this).closest(vars.optionBoxSelector).addClass(vars.behaviorMarkerClass);
            })

        }
    };

    $(methods.init);

    return {
        init: function() {
            return methods.init();
        }
    }

})(jQuery);

    $( document ).ready(function() {
        if (!$('.ty-features-list').children().hasClass('ty-features-list')) {
            $('.ty-features-list').css({'display':'none'});
        }


        $(window).on("load",function(){
                    
                    $.mCustomScrollbar.defaults.scrollButtons.enable=true; //enable scrolling buttons by default
                    $.mCustomScrollbar.defaults.axis="yx"; //enable 2 axis scrollbars by default

            $("ul.ty-product-filters__variants.cm-filter-table").mCustomScrollbar({theme:"rounded-dark"});
        });
    });

/*$(function(){
    $('.ty-menu-vertical .ty-menu__items > .ty-menu__item > .ty-menu__submenu-item-header > .ty-menu__item-link')
        .on('click', function(e){
            e.preventDefault();
            var $submenu = $(this).closest('.ty-menu__item').find('.ty-menu__submenu');
            console.log($submenu[0].style.display);
            if($submenu[0].style.display) {
                $submenu.hide();
            } else {
                $submenu.show();
            }
        });
});*/