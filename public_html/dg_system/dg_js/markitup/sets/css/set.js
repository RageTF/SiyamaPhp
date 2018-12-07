// ----------------------------------------------------------------------------
// markItUp!
// ----------------------------------------------------------------------------
// Copyright (C) 2008 Jay Salvat
// http://markitup.jaysalvat.com/
// ----------------------------------------------------------------------------
// Html tags
// http://en.wikipedia.org/wiki/html
// ----------------------------------------------------------------------------
// Basic set. Feel free to add more tags
// ----------------------------------------------------------------------------
mySettings = {	
	onShiftEnter:  	{keepDefault:false, replaceWith:'<br />\n'},
	onCtrlEnter:  	{keepDefault:false, openWith:'\n<p>', closeWith:'</p>'},
	onTab:    		{keepDefault:false, replaceWith:'    '},
	markupSet:  [ 	
		
		{name:'full screen', key:'Q', className:'fs',    beforeInsert:function(h) {
												
														    if ($(h.textarea).parent().css('position')=='fixed'){
														    $(h.textarea).parent().removeClass("textareafullscreen");	
														    }else{
        													$(h.textarea).parent().addClass("textareafullscreen");
        													}
        												
    													}
 },
		
	]
}