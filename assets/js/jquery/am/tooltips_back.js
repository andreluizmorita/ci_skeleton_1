/*
* ToolTips
*
* Copyright (c) 2011 André Morita
*/
$.fn.aMTooltips = function(options)
{
	var defaults = {
		speed: 200,
		delay: 300,
		url : '',
		text : ''
	};

	var options = $.extend(defaults, options);

	alert(this.id);
	
	getTip = function() {
		var tTip =	"<div class='am-tooltips'>" +
						"<div class='am-tooltips-mid'></div>" +
						"<div class='am-tooltips-btm'></div>" +
					"</div>";
		return tTip;
	}
	
	$("body").prepend(getTip());

	$(this).each(function(){

		var $this = $(this);
		var tip = $('.am-tooltips');
		var tipInner = $('.am-tooltips .am-tooltips-mid');
		
		if(options.text == '')
		{
			var tTitle = (this.title);
		}
		else
		{
			var tTitle = options.text;
		}
		
		this.title = "";
	


		$this.hover(
			function(e) 
			{
				var offset = $(this).offset();
				var tLeft = offset.left;
				var tTop = offset.top;
				var tWidth = $this.width();
				var tHeight = $this.height();
				
				tipInner.html(tTitle+'X:'+tTop+' Y:'+ tLeft);
				setTip(tTop, tLeft);
				setTimer();
				
				if(this.tagName == 'A')
				{
					options.url  = $(this).attr('href');
				}
				
				if(options.url != '')
				{
					e.preventDefault();
					$('#cont-materias').slideUp(500).empty();
				    
					$.ajax({
				        url: options.url,	
			    	   	dataType: 'html',
			            type: 'GET',
			    	    timeout: 1000,
			  	       	beforeSend: function(){	
			  	  	       	$('.am-tooltips-mid').html('<div class="am-tooltips-load"></div>');	},
			     	    complete: function(){	$('.am-tooltips-load').remove();	},
			   		    success: function(data, textStatus){	
			   	   		    $('.am-tooltips-mid').delay(1000).html(data).slideDown(500,'easeOutBack');	
			   		    }, 
			   	        error: function(xhr,ajaxOption, thrownError) {	
			   	   	       	$('.am-tooltips-mid').html('<p class="aMError">Lamento! Ocorreu um erro. Por favor tente mais tarde. '+xhr.status+' : '/*+thrownError*/).slideDown(500,'easeOutBack');	
			   	   	    }
			       	});
				}
			},
			function(e)
			{
				stopTimer();
				tip.hide();
			}
		);		   

	setTimer = function() {
		$this.showTipTimer = setInterval("showTip()", defaults.delay);
	}

	stopTimer = function() {
		clearInterval($this.showTipTimer);
	}
		
	setTip = function(top, left)
	{
		var topOffset = tip.height();
		var xTip = (left-30)+"px";
		var yTip = (top-topOffset)+"px";
		tip.css({'top' : yTip, 'left' : xTip});
	}
   
	showTip = function(){
		stopTimer();
		tip.animate({"top": "+=20px", "opacity": "toggle"}, defaults.speed);
	}
});
};