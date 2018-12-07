<?php

/**
 * @author mrhard
 * @copyright 2010
 */

 defined("_DG_") or die ("ERR");	

 $dir = '/dg_lib/dg_plugins/wysiwyg/tinymce/';

if (!$GLOBALS[tinymcesetup]){
$GLOBALS[tinymcesetup] = true;

?>

<script type="text/javascript" src="<?=$dir ?>jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
        language : "<?=$this->LANGLOAD->_def?>",
        editor_selector : "wwg",
		plugins : "style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,cut,copy,paste,pastetext,pasteword,|,link,unlink,anchor,image,|,bullist,numlist,|,outdent,indent,blockquote,|,forecolor,backcolor",
		theme_advanced_buttons2 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons3 : "insertlayer,moveforward,movebackward,absolute,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,|,undo,redo,|,cleanup,help,code,|,preview",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "/dg_system/tinymce/tiny_mce/lists/template_list.js",
		external_link_list_url : "/dg_system/tinymce/tiny_mce/lists/link_list.js",
		external_image_list_url : "/dg_system/tinymce/tiny_mce/lists/image_list.js",
		media_external_list_url : "/dg_system/tinymce/tiny_mce/lists/media_list.js",



use_native_selects : true,
relative_urls:false,
convert_urls:true,
keep_styles : true,
inline_styles : true,
remove_script_host : true,

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>


<?

}

?>