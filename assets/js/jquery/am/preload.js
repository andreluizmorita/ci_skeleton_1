/**
 * Preload
 * @requires jQuery v1.8.1 or above
 *
 * Version: 1.0.0
 * Author: André Luiz S. Morita <andreluizmorita@gmail.com>
 */

/**
 * For use just insert this javascript together with jquery framework
 * 
 * <script type="text/javascript" src="js/preload.js"></script>
 */

;(function($) {	
	$.aMPreload = {
        defaults : {
            color:'#666',
            backgroundColor:'#ffffff',
            box: '#e4e4e4',
            outShadow: 1000,
            outLoading:1000,
            outText: 1000,
            boxHeight: 5,
            opacity:'1.0',
            text:'Carregando'
        }
	};	
	
	$.fn.extend({
        aMPreload: function(opts)
        {
            var opts = $.extend({}, $.aMPreload.defaults, opts);
			
            
            $('<div/>',{ id: 'aMPreload-shadow'})
                .css({
                    width:  $('html').outerWidth()+'px',
                    height: $('html').outerHeight()+'px',
                    opacity: opts.opacity,
                    position: 'absolute',
                    backgroundColor: opts.backgroundColor,
                    zIndex: 10000000
                })
                .prependTo('body');           
            
            $('<div/>',{ id: 'aMPreload-loading'})
                .css({
                    width:'0px',
                    height:opts.boxHeight,
                    top: (($(window).outerHeight()/2)-opts.boxHeight)+'px',
                    position: 'absolute',
                    backgroundColor: opts.box,
                    zIndex: 10000002
                })
                .prependTo('#aMPreload-shadow');
                
            $('<div/>',{ id: 'aMPreload-text'})
                .css({
                    width:$('html').outerWidth()+'px',
                    height:opts.boxHeight,
                    top: (($(window).outerHeight()/2)+opts.boxHeight)+'px',
                    position: 'absolute',
                    textAlign: 'center',
                    fontWeight: 'bold',
                    display:'none',
                    fontSize:'20px',
                    color:opts.color,
                    backgroundColor: 'none',
                    zIndex: 10000001
                })
                .prependTo('#aMPreload-shadow')
                .text(opts.text);
            
            $('#aMPreload-text').fadeIn(opts.outLoading/2);
            $('#aMPreload-loading').animate({width:$('html').outerWidth()+'px'},opts.outLoading);
            
            $(window).load(function(){                 
                $('#aMPreload-loading').css({width:$('html').outerWidth()+'px'});
                
                $('#aMPreload-loading').animate({height:$(window).outerHeight()+'px',top:'0'},opts.outLoading,function(){
                    $('#aMPreload-text').remove();
                    
                    $('#aMPreload-shadow').fadeOut(opts.outShadow,function(){
                        $('#aMPreload-loading').fadeOut(opts.outLoading);
                    });
                });
                
            })
            .resize(function(){
                $('#aMPreload-shadow').css({
                    width:  $('html').outerWidth()+'px',
                    height: $('html').outerHeight()+'px'
                });
                $('#aMPreload-text').css({
                    width:  $('html').outerWidth()+'px',
                    top: (($(window).outerHeight()/2)+opts.boxHeight)+'px'
                });
                
                $('#aMPreload-text').css({
                    width:  $('html').outerWidth()+'px',
                    top: (($(window).outerHeight()/2)-opts.boxHeight)+'px'
                });
            });
        } 
	});
})(jQuery);

$(document).ready(function(){
    $(window).aMPreload();
});