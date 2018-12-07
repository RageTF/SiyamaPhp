<?php

/**
 * @author mrhard
 * @copyright 2010
 */
 
 defined("_DG_") or die ("ERR");	


if (!$GLOBALS[markitupsetup]){
$GLOBALS[markitupsetup] = true;
?>
<script type="text/javascript" src="/dg_system/dg_js/markitup/jquery.markitup.pack.js"></script>
<link rel="stylesheet" type="text/css" href="/dg_system/dg_js/markitup/skins/simple/style.css" />
<script type="text/javascript" src="/dg_system/dg_js/markitup/sets/html/set.js"></script>
<link rel="stylesheet" type="text/css" href="/dg_system/dg_js/markitup/sets/html/style.css" />		
		
		
		<script>		
		$(document).ready(function()	{
  			$("textarea.wwg").markItUp(mySettings);
  				})

		</script>

<?}?>