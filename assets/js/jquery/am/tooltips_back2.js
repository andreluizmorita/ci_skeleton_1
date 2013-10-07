/*
* ToolTips
*
* Copyright (c) 2011 André Morita
*/
;(function($) {	
	$.aMTooltips = {
		defaults : {
			speed: 200,
			delay: 300,
			url : '',
			title : '',
			type: '',
			/* if type is css */
			width: 400,
			height:200,
			background:'#eeeeee',
			border: '#666666',
			color:'#666666',
			font:'12px'
		}
	};	
	
	$.fn.extend({
		aMTooltips: function(settings){
			
			settings = $.extend({}, $.aMTooltips.defaults, settings);
			
			this.live({
		        mouseenter:function(){
		        		var offset = $(this).offset();
		        		var tLeft = offset.left;
		        		var tTop = offset.top;
		        		var tWidth = $(this).width();
		        		var tHeight = $(this).height();
		        		
		        		var tTitle = (settings.title == '')? this.title : settings.title;
						
		        		$('.aMNotice').html('Offset-left: '+offset.left+' Offset-right: '+offset.top+' Width: '+tWidth+' Height: '+tHeight);
		        		
						if(this.tagName == 'A'){
							settings.url  = $(this).attr('href');
						}else if(this.tagName == 'IMG' && tTitle == '' ){
							tTitle = (settings.type == 'img') ? '<img src="'+tTitle+'" />' : '<img src="'+this.src+'" />' ;
						}
						
						var $content = (settings.type=='css')? $('.am-tooltips-css-content') : $('.am-tooltips-mid') ;
						var $box	 = (settings.type=='css')? $('.am-tooltips-css') : $('.am-tooltips') ;

						if(settings.url != '' && settings.type != 'iframe'){
							$.ajax({
						        url: settings.url,	
					    	   	dataType: 'html',
					            type: 'GET',
					    	    timeout: 10000,
					  	       	beforeSend: function(){	
					  	  	       	$(this).html('<div class="am-tooltips-load"></div>');	
					  	  	    },
					     	    complete: function(){	
					     	    	$('.am-tooltips-load').remove();	
					     	    },
					   		    success: function(data, textStatus){
					   		    	boxHeight = $box.height();	
					   		 
					   		    	
					   		    	$("body").prepend( getTip(data, settings.type) );
					   		    	
					   		    	if(settings.type == 'css'){
										$('.am-tooltips-css').css({'width':settings.width});
										$('.am-tooltips-css-content').css({'background':settings.background,'color':settings.color,'border':settings.border,'fontSize':settings.font});
										$('.am-tooltips-css-triagle').css({'borderTop': '10px solid '+settings.background});
									}
					   		    	
					   		       setTip(tTop, tLeft, settings.speed, settings.type,tWidth);
					   		    }, 
					   	        error: function(xhr,ajaxOption, thrownError) {	
					   	   	       	$content.html('<p class="aMError">Lamento! Ocorreu um erro. Por favor tente mais tarde. '+xhr.status+' : '+thrownError).slideDown(500,'easeOutBack');	
					   	   	    }
					       	});
						}else if(settings.type == 'iframe' && settings.url != ''){
							$("body").prepend( getTip('', settings.type, settings) );
							
							$('.am-tooltips-css').css({'width':settings.width});
							$('.am-tooltips-css-content').css({'background':settings.background,'color':settings.color,'border':settings.border,'fontSize':settings.font});
							$('.am-tooltips-css-triagle').css({'borderTop': '10px solid '+settings.background});							
				   		    
			   		       setTip(tTop, tLeft, settings.speed, settings.type,tWidth);
		        		}else{
							$("body").prepend( getTip(tTitle, settings.type) );
							
							if(settings.type == 'css'){
								$('.am-tooltips-css').css({'width':settings.width});
								$('.am-tooltips-css-content').css({'background':settings.background,'color':settings.color,'border':settings.border,'fontSize':settings.font});
								$('.am-tooltips-css-triagle').css({'borderTop': '10px solid '+settings.background});
							}
				   		    
			   		       setTip(tTop, tLeft, settings.speed, settings.type,tWidth);
						}
						
		            },
		         mouseleave:function(){
		        	 $('.am-tooltips, .am-tooltips-css').hide(100);
		        	 $('.am-tooltips, .am-tooltips-css').remove();
		         }
			});	
		}	
		
	});
	
	setTip = function(top, left, speed, type, width){
		var positionBox = (type == 'css')? 60 : 40;
		
		var toolWidth = $('.am-tooltips, .am-tooltips-css').width();
		var topOffset = $('.am-tooltips, .am-tooltips-css').height();
		
		var xTip = (width == undefined)? (left-(toolWidth/2))+"px" : (left-(toolWidth/2)+(width/2))+"px" ;
		
		var yTip = (top-topOffset-positionBox)+"px";
		$('.am-tooltips, .am-tooltips-css').css({'top' : yTip, 'left' : xTip});
		
		showTip(speed);
	}
   
	showTip = function(speed){
		$('.am-tooltips, .am-tooltips-css').animate({"top": "+=20px", "opacity": "toggle"}, speed);
	}
	
	getTip = function(content,type, settings) {
		if(type == 'css')
		{
			var tTip = 
				"<div class='am-tooltips-css'> "+
					"<div class='am-tooltips-css-content'>" +content+
					"</div>"+
					"<div class='am-tooltips-css-triagle-shadow'></div>"+
					"<div class='am-tooltips-css-triagle'></div>"+
				"</div>";
			
			
		}
		else if(type == 'iframe')
		{
			var tTip = 
				"<div class='am-tooltips-css'> "+
					"<div class='am-tooltips-css-content'>" +
					"<iframe frameborder='0' src='"+settings.url+"' id='am-tooltips-iframe' width='"+(settings.width-30)+"' height='"+(settings.height-30)+"'>"+
					"</iframe>" +
					"</div>"+
					"<div class='am-tooltips-css-triagle-shadow'></div>"+
					"<div class='am-tooltips-css-triagle'></div>"+
				"</div>";
		}
		else
		{
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