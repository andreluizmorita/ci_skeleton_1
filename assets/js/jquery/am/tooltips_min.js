(function(a){a.aMTooltips={defaults:{speed:200,delay:300,url:"",title:"",type:"",width:400,background:"#eeeeee",border:"#666666",color:"#666666",font:"12px"}};a.fn.extend({aMTooltips:function(b){b=a.extend({},a.aMTooltips.defaults,b);this.live({mouseenter:function(){var c=a(this).offset();var d=c.left;var e=c.top;var f=a(this).width();var g=a(this).height();var h=b.title==""?this.title:b.title;if(this.tagName=="A"){b.url=a(this).attr("href")}else if(this.tagName=="IMG"&&h==""){h=b.type=="img"?'<img src="'+h+'" />':'<img src="'+this.src+'" />'}var i=b.type=="css"?a(".am-tooltips-css-content"):a(".am-tooltips-mid");var j=b.type=="css"?a(".am-tooltips-css"):a(".am-tooltips");if(b.url!=""){a.ajax({url:b.url,dataType:"html",type:"GET",timeout:1e4,beforeSend:function(){a(this).html('<div class="am-tooltips-load"></div>')},complete:function(){a(".am-tooltips-load").remove()},success:function(c,g){boxHeight=j.height();a("body").prepend(getTip(c,b.type));if(b.type=="css"){a(".am-tooltips-css").css({width:b.width});a(".am-tooltips-css-content").css({background:b.background,color:b.color,border:b.border,fontSize:b.font});a(".am-tooltips-css-triagle").css({borderTop:"10px solid "+b.background})}setTip(e,d,b.speed,b.type,f)},error:function(a,b,c){i.html('<p class="aMError">Lamento! Ocorreu um erro. Por favor tente mais tarde. '+a.status+" : "+c).slideDown(500,"easeOutBack")}})}else{a("body").prepend(getTip(h,b.type));if(b.type=="css"){a(".am-tooltips-css").css({width:b.width});a(".am-tooltips-css-content").css({background:b.background,color:b.color,border:b.border,fontSize:b.font});a(".am-tooltips-css-triagle").css({borderTop:"10px solid "+b.background})}setTip(e,d,b.speed,b.type,f)}},mouseleave:function(){a(".am-tooltips, .am-tooltips-css").hide(100);a(".am-tooltips, .am-tooltips-css").remove()}})}});setTip=function(b,c,d,e,f){var g=e=="css"?50:30;var h=a(".am-tooltips, .am-tooltips-css").width();var i=a(".am-tooltips, .am-tooltips-css").height();var j=f==undefined?c-h/2+"px":c-h/2+f/2+"px";var k=b-i-g+"px";a(".am-tooltips, .am-tooltips-css").css({top:k,left:j});showTip(d)};showTip=function(b){a(".am-tooltips, .am-tooltips-css").animate({top:"+=20px",opacity:"toggle"},b)};getTip=function(a,b){if(b=="css"){var c="<div class='am-tooltips-css'> "+"<div class='am-tooltips-css-content'>"+a+"</div>"+"<div class='am-tooltips-css-triagle-shadow'></div>"+"<div class='am-tooltips-css-triagle'></div>"+"</div>"}else{var c="<div class='am-tooltips'>"+"<div class='am-tooltips-mid'>"+a+"</div>"+"<div class='am-tooltips-btm'></div>"+"</div>"}return c}})(jQuery)