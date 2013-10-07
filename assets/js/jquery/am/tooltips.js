/**
 * Tooltips
 * @requires jQuery v1.7.1 or above
 * @requires jQuery Easing 1.3.2 or above
 * @requires jQuery UI 1.8 or above for animation font color
 * @requires tooltips.css
 *
 * Version: 1.0.0
 * Author: André Luiz S. Morita <andreluizmorita@gmail.com>
 */

/**
 * Modelo tooltips 
 * 1- Ajax
 *      <a href="teste.php" class="aMTooltips">Teste</a>
 * 2- Img
 *      <im src="" class="aMTooltips">Teste</a>
 * 3- Text
 *      <a rel="seu_texto" class="aMTooltips">Teste</a> 
 *      <span rel="seu_texto" class="aMTooltips">Teste</span> 
 *      
 *     
 * $('.aMTooltips').aMTooltips({width:'500'});
 * 
 */

;(function($) {	
	$.aMTooltips = {
		defaults : {
			speed: 100,
			delay: 200,
            out:200,
			url : '', // if url is set this tooltips AJAX request
			title : '',
			type: 'css',// iframe/ajax
			/* if type is css */
			width: 400,
			height:'auto',
			background:'#eeeeee',
			border: '#666666',
			color:'#666666',
			font:'12px'
		}
	};	
	
	$.fn.extend({
		aMTooltips: function(opts){
			
			var opts = $.extend({}, $.aMTooltips.defaults, opts);
			
			this.live({
		        mouseenter:function(){
		        	opts.offset = $(this).offset();
		        	opts.tLeft = opts.offset.left;
		        	opts.tTop = opts.offset.top;
		        	opts.tWidth = $(this).width();
		        	opts.tHeight = $(this).height();		        		
		        	opts.tTitle = (opts.title == '')? this.title : opts.title;
                    
					if(this.tagName == 'A' && opts.type != 'text'){
						opts.url  = $(this).attr('href');
					}else if(this.tagName == 'IMG' && opts.tTitle == '' && opts.type != 'text'){
						tTitle = (opts.type == 'img') ? '<img src="'+tTitle+'" />' : '<img src="'+this.src+'" />' ;
					}else if(opts.type == 'text'){
                        tTitle = $(this).attr('rel');
                    }
						
					var $content = (opts.type=='text')? $('.am-tooltips-css-content') : $('.am-tooltips-mid') ;
					var $box	 = (opts.type=='text')? $('.am-tooltips-css') : $('.am-tooltips') ;					
					
					if(opts.url != '' && opts.type != 'iframe' && opts.type !='text')
					{
						$.ajax({
					        url: opts.url,	
				    	   	dataType: 'html',
				            type: 'GET',
				    	    timeout: 10000,
				  	       	beforeSend: function(){
				  	       		$("body").prepend( getTip('<div class="am-tooltips-load"></div>', opts) );
				  	       		
				  	       		setTip(opts);
				  	  	    },
				     	    complete: function(){
				     	    	$('.am-tooltips-load').fadeOut(300,function(){
				     	    		$('.am-tooltips-load').remove();	
				     	    	});
				     	    },
				   		    success: function(data, textStatus){
				   		    	$('.am-tooltips-css-content,.am-tooltips-mid').html(data);				   		    	
				   		    }, 
				   	        error: function(xhr,ajaxOption, thrownError) {	
				   	   	       	$content.html('<p class="aMError">Lamento! Ocorreu um erro. Por favor tente mais tarde. '+xhr.status+' : '+thrownError).slideDown(500,'easeOutBack');	
				   	   	    }
				       	});
					}else if(opts.type == 'iframe' && opts.url != ''){
						$("body").prepend( getTip('', opts) );
					
		   		       	setTip(opts);
		       		}else if(opts.type == 'img'){
		       			$("body").prepend( getTip(tTitle, opts) );
						
		   		       	setTip(opts);
					}else if(opts.type == 'text' && opts.url == ''){
						$("body").prepend( getTip(tTitle, opts) );
					
		   		       	setTip(opts);
                    }
		        },
		        mouseleave:function(){
		        	$('.am-tooltips, .am-tooltips-css').fadeOut(opts.out,function(){
		        		$('.am-tooltips, .am-tooltips-css').remove();		        		
		        	});
		        	
		         }
			});	
		}	
	});
	
	setTip = function(opts){
		
		if(opts.type == 'css' || opts.type == 'iframe' || opts.type == 'text')
		{
			$('.am-tooltips-css').css({'width':opts.width});
			$('.am-tooltips-css-content').css({'background':opts.background,'color':opts.color,'border':opts.border,'fontSize':opts.font});
			$('.am-tooltips-css-triagle').css({'borderTop': '10px solid '+opts.background});
			
			if(opts.height != 'auto') $('.am-tooltips-css-content').css({'height':opts.height});
		}
		
		var positionBox = (opts.type == 'css')? 35 : 35;
		var toolWidth = $('.am-tooltips, .am-tooltips-css').outerWidth();
		var topOffset = $('.am-tooltips, .am-tooltips-css').outerHeight();
		var xTip = opts.tLeft - (toolWidth/2) + (opts.tWidth/2) - 3;
		var yTip = opts.tTop - topOffset - positionBox;		
		
		$('.am-tooltips, .am-tooltips-css').css({'top' : yTip, 'left' : xTip});
		
		showTip(opts);
	}
   
	showTip = function(opts){
		$('.am-tooltips, .am-tooltips-css').stop().animate({"top": "+=20px", "opacity": "toggle"}, opts.speed);
	}
	
	getTip = function(content, opts) {		
		if(opts.type == 'css' || opts.type == 'text'){
			var tTip = 
				"<div class='am-tooltips-css'> "+
					"<div class='am-tooltips-css-content'>" +content+
					"</div>"+
					"<div class='am-tooltips-css-triagle-shadow'></div>"+
					"<div class='am-tooltips-css-triagle'></div>"+
				"</div>";
		}else if(opts.type == 'iframe'){
			var tTip = 
				"<div class='am-tooltips-css'> "+
					"<div class='am-tooltips-css-content'>" +
					"<iframe frameborder='0' src='"+opts.url+"' id='am-tooltips-iframe' width='"+(opts.width-30)+"' height='"+(opts.height-30)+"'>"+
					"</iframe>" +
					"</div>"+
					"<div class='am-tooltips-css-triagle-shadow'></div>"+
					"<div class='am-tooltips-css-triagle'></div>"+
				"</div>";
		}else if(opts.type == 'img'){
			var tTip =	
				"<div class='am-tooltips'>" +
					"<div class='am-tooltips-mid'>" +content+
					"</div>" +
					"<div class='am-tooltips-btm'></div>" +
				"</div>";
		}
		return tTip;
	}
})(jQuery);