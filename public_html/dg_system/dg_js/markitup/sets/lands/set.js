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
		{name:'Bold', key:'B', className:'editorbutton_b', openWith:'(!(<strong>|!|<b>)!)', closeWith:'(!(</strong>|!|</b>)!)' },
		{name:'Italic', key:'I', className:'editorbutton_i', openWith:'(!(<em>|!|<i>)!)', closeWith:'(!(</em>|!|</i>)!)'  },

		{separator:'---------------' },
		{name:'Picture', key:'P', className:'editorbutton_img', replaceWith:'<img src="[![Source:!:http://]!]" alt="[![Alternative text]!]" />' },
		{name:'Link', key:'L', className:'editorbutton_a', openWith:'<a href="[![Link:!:http://]!]"(!( title="[![Title]!]")!)>', closeWith:'</a>', placeHolder:'Your text to link...' },
		
        
        {name:'user', key:'U', className:'editorbutton_u', openWith:'<user name="[![Username:!:]!]" />'},
        
        {separator:'---------------' },
		
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