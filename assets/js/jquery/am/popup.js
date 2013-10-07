/*
* PopUp open, print and get content html
*
* Copyright (c) 2011 André Morita
*/

$.fn.aMPopUp = function(options)
{
	this.live('click',function(e){
		
		e.preventDefault();		
		
		var defaults = {
			id		: '',
			url		: '',
			css	 	: '',
			print 	: true,
			width	: 850,
			height	: 600,
			scrollbars	: 'yes',
			status  : 'no',
			resizable : 'yes',
			title	: 'Sistema ETAP',
			screenx : 0,
			screeny : 0,
			confirm : false,
			recipeWidth: 800
		};		
		
		var opts = $.extend({}, defaults, options);
		
		var css = '';
		var print = '';
		var js = '';
		var windowPrint = '';
        
		if(this.tagName == 'A' && opts.id == '')
		{
			opts.url = $(this).attr('href');
		}
		
		var setWindows = 'width='+opts.width+',height='+opts.height+',scrollbars='+opts.scrollbars+',status='+opts.status+',resizable='+opts.resizable+',screenx='+opts.screenx+',screeny='+opts.screeny;
				
		if( opts.id != '' && opts.url == '')
		{
			if( opts.url == '')
			{
				var recipe =  window.open('','_blank',setWindows);			
				
				$('link').each(function(index){
					css += '<link rel="stylesheet" type="text/css" href="'+$(this).attr('href')+'" />';
					if(opts.css != '')
					{
						css += '<link rel="stylesheet" type="text/css" href="'+opts.css+'" />';
					}
				});				
				
				if(typeof(opts.id) == 'object')
				{
					for(i=0;i < opts.id.length;i++)
					{
						print += $(opts.id[i]).html()+'<br /><br />';
					}
				}
				else
				{
					print += $(opts.id).html();
				}
				
				if(opts.print == true)
				{
					if(opts.confirm == true)
					{
						js = '<script type="text/javascript" src="'+$('script[src$="jquery_min.js"]').attr('src')+'"></script>'+
							 '<script type="text/javascript" src="'+$('script[src$="popup.js"]').attr('src')+'"></script>'+
							 '<script type="text/javascript">mensagem();</script>';
					}
					else
					{
						windowPrint = '<script type="text/javascript">setTimeout("window.print();",1000);</script>';
					}
				}
				
				var html = 	"<html>" +
							"<head>" +
								"<title>"+opts.title+"</title>"+
								css+
								js+
								windowPrint+
							"</head>" +
							"<body>" +
								"<div style='width:"+opts.recipeWidth+"px; margin:10px auto; background-color:#FFF; padding:10px;'>"+ print +"<div style='clear:both'></div></div>" +
							"</body>" +
							"</html>";
			}
			else
			{
				var recipe =  window.open( opts.url,'_blank',setWindows);
			}	
			recipe.document.open();
			recipe.document.write(html);
			recipe.document.close();
		}
		else
		{
			window.open(opts.url,'_blank',setWindows);
		}	
		return false;
	});
}

var msgConfirm = 'Você deseja imprimir está página agora?\n\n- Para confirmar clique no botão OK\n- Para cancelar clique no botão CANCELAR';
var errorPrint = 'O comando de impressão não pode ser iniciado.\nPor favor pressione a tecla F5 para tentar novamente ou CTRL+P para iniciar a impressão.';
var msgPrint = 'Para imprimir a qualquer momento pressione a tecla F5 ou CTRL+P.';

function mensagem(){
	if (confirm(msgConfirm)){
	  	if(window.print){
	  		window.print();
		}else{
			alert(errorPrint);
		}
	}else{
		alert(msgPrint);
	}
}
