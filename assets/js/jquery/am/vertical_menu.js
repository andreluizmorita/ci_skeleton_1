$(document).ready(function(){
    $('.am-vertical-menu-slider').css({display:'none'});
    
    $('.am-vertical-menu').hover(
        function(){
            obj = $(this);
            $('.am-vertical-menu-title-hover').removeClass('am-vertical-menu-title-hover'); 
            $('.am-vertical-menu-slider').fadeOut(200);
            obj.find('.am-vertical-menu-title').addClass('am-vertical-menu-title-hover');  
            obj.find('.am-vertical-menu-slider').fadeIn(300);
        },
        function(){
            $('.am-vertical-menu-title-hover').removeClass('am-vertical-menu-title-hover'); 
            $('.am-vertical-menu-slider').css({display:'none'});
        }
    );
});
 
    
 

