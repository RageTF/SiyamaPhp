<?php

/**
 * @author mrhard
 * @copyright 2010
 */
 
 defined("_DG_") or die ("ERR");	

 $dir = '/dg_lib/dg_plugins/wysiwyg/ckeditor/ckeditor/';

if (!$GLOBALS[ckeditorsetup]){
$GLOBALS[ckeditorsetup] = true;
?>
	<script type="text/javascript" src="<?=$dir?>ckeditor.js"></script>
    <script type="text/javascript" src="<?=$dir?>lang/_languages.js"></script>
    <script>
    
    if ( window.CKEDITOR )
{
	(function()
	{
		var showCompatibilityMsg = function()
		{
			var env = CKEDITOR.env;

			var html = '<p><strong>Your browser is not compatible with CKEditor.</strong>';

			var browsers =
			{
				gecko : 'Firefox 2.0',
				ie : 'Internet Explorer 6.0',
				opera : 'Opera 9.5',
				webkit : 'Safari 3.0'
			};

			var alsoBrowsers = '';

			for ( var key in env )
			{
				if ( browsers[ key ] )
				{
					if ( env[key] )
						html += ' CKEditor is compatible with ' + browsers[ key ] + ' or higher.';
					else
						alsoBrowsers += browsers[ key ] + '+, ';
				}
			}

			alsoBrowsers = alsoBrowsers.replace( /\+,([^,]+), $/, '+ and $1' );

			html += ' It is also compatible with ' + alsoBrowsers + '.';

			html += '</p><p>With non compatible browsers, you should still be able to see and edit the contents (HTML) in a plain text field.</p>';

			var alertsEl = document.getElementById( 'alerts' );
			alertsEl && ( alertsEl.innerHTML = html );
		};

		var onload = function()
		{
			// Show a friendly compatibility message as soon as the page is loaded,
			// for those browsers that are not compatible with CKEditor.
			if ( !CKEDITOR.env.isCompatible )
				showCompatibilityMsg();
		};

		// Register the onload listener.
		if ( window.addEventListener )
			window.addEventListener( 'load', onload, false );
		else if ( window.attachEvent )
			window.attachEvent( 'onload', onload );
	})();
}


$(document).ready(function()	{
	$("textarea.wwg").each(function(){
	   var n = $(this).attr('name');
       if (n!=''){
        CKEDITOR.replace( n , {language : '<?=$this->LANGLOAD->_def?>',
        					   toolbar :
                        					[
                        
                                                
                                                ['Bold','Italic','Underline','Strike','-','TextColor','BGColor'],
                                                ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','Subscript','Superscript'],
                                                ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
                                                '/',  
                                                ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar'],
                                                ['Link','Unlink','Anchor'],                      
                                                ['Cut','Copy','Paste','PasteText','PasteFromWord'],
                                                ['Undo','Redo','-','Maximize', 'ShowBlocks','Source','-','SelectAll','RemoveFormat']
                                                
                        
                        					]
});
       }
	})
				})
    
    </script>
<?}?>