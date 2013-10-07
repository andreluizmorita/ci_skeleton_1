/*
* PopUp open, print and get content html
*
* Copyright (c) 2011 André Morita
*/

$.fn.selectRange = function(start, end) {
    return this.each(function() {
        if (this.setSelectionRange) {
            this.focus();
            this.setSelectionRange(start, end);
        } else if (this.createTextRange) {
            var range = this.createTextRange();
            range.collapse(true);
            range.moveEnd('character', end);
            range.moveStart('character', start);
            range.select();
        }
    });
};

$.fn.aMEditable = function(options)
{
    var aMEditable_id = 0;
    
    function repeat(n){
        var string = '';
        var i = 0;
        
        for(i; i<=n; i++){
            string += '&nbsp;';
        }
            
        return string;
    }
    
    this.live('click',function(event){
		event.preventDefault();		
		
		var defaults = {
			textarea : 'fit', /* fit */
            background : 'transparent',
            border : 'none',
            inherit : true,
            action : 'edit', /* edit / post / */
            url : false,
            id: aMEditable_id + 1,
            offset : $(this).offset()  
            
		};        
        
		var opts = $.extend({}, defaults, options);
        
        var textarea = 
            $('<textarea></textarea>')
                .css({
                    'width':$(this).width()+'px', 
                    'height':($(this).height()*2)+'px',
                    'position':'absolute',
                    'zIndex':'100000',
                    'top': opts.offset.top+ 'px',
                    'left': opts.offset.left + 'px',
                    'background':opts.background,
                    'border':opts.border,
                    'box-shadow':'none',
                    'overflow':'hidden'  ,
                    'fontFamily':$(this).css('fontFamily'),
                    'color':$(this).css('color'),
                    //'margin':$(this).css('margin'),
                    'padding':$(this).css('padding'),
                    'fontSize' : $(this).css('fontSize'),
                    'fontWeight' : $(this).css('fontWeight'),
                    'textIndent' : $(this).css('textIndent'),
                    'textAlign' :$(this).css('textAlign')
                })
                .html($.trim($(this).text()))
                .attr({
                    'class':'aMEditable-textarea',
                    'id':'aMEditable-textarea-'+opts.id,
                    'rel':$(this).attr('id')
            });
        
        $(this).html(repeat($.trim($(this).text()).length));
        
        $('body').append(textarea);
         
        var objId =  $(this);
        
        $('textarea')
            .focusout(function() {                    
                if(this.value != ''){
                    $(objId).text(this.value).show();
                    
                    $(this).remove();

                }
            })
            .keydown(function(e){
                if (e.keyCode == 13 && !e.shiftKey){
                    e.preventDefault();
                    $(objId).text(this.value).show();
                    
                    $(this).remove();
                }
            });
            
            $('#aMEditable-textarea-'+opts.id).selectRange(0,$('#aMEditable-textarea-'+opts.id).val().length);

    });
}