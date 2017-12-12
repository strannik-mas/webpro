
    // Button to Top
    $('.btn-scroll-top').hide();
    $(window).scroll(function() {
        if ( $(this).scrollTop() > 500 ) {
            $('.btn-scroll-top').fadeIn('slow');
        } else {
            $('.btn-scroll-top').fadeOut('slow');
        }
    });
    $('.btn-scroll-top').click(function() {
        $('html,body').animate({
            scrollTop: 0
        }, 500);
        $(this).fadeOut('slow');
    });
  //placeholder
   $(document).ready(function () {
     $('input,textarea').focus(function(){
       $(this).data('placeholder',$(this).attr('placeholder'))
       $(this).attr('placeholder','');
     });
     $('input,textarea').blur(function(){
       $(this).attr('placeholder',$(this).data('placeholder'));
     });
 });
//nice select
$(document).ready(function() {
      $('select').niceSelect();      
    });
//mobile
$(document).ready(function() {
     if(window.innerWidth <= 500) {     
      $( ".notice-search" ).find('.map-form').appendTo( $( ".label-links" ) );
       $( ".notice-search" ).find('.map-form').addClass("dropdown-menu");
    }
});


