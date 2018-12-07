<?php

/*
 * demiurgo.cms
 *
 * Copyright 2009-2010 by the demiurgo.team (http://www.dg-team.net/).
 * All rights reserved.
 * Licensed under GPLv3
 * This version may have been modified pursuant to   the GNU General Public License, and as 
 * distributed it includes or is derivative of works licensed under the 
 * GNU General Public License or other free or open source software licenses.
 *
 */
if ($this->access('settings','access')){
    define(_URL_,'/dg_admin/?comp=system&use=logs&func=');
    $logfile = new dg_file;
    $logs = $logfile->read(_DR_.'/cache/log.chl');
     if ( array_key_exists('clear',$_POST) ){
     	$logfile->create(_DR_.'/cache/log.chl',' ');
        if ($this->_ajax){echo 'ok'; exit;}else{
            header("Location:"._URL_.'index');
        }
     }
    ?>
    <script>
    $(document).ready(function()	{
    	$("#clear").click(function(){
    	   $.post('/dg_admin/?comp=system&use=logs',{clear:true},function(data){
    	      if (data=='ok') $('.logs').html(''); else alert (data);
    	   });
           return false;
    	});
    				})
    </script>
    <p><a href="#" id="clear"><img src="/dg_system/dg_img/icons/cross.png" /></a></p>
    <ul class="logs"><?
    
     
    if(trim($logs)!=''){
        $ex = explode('end;',$logs);
        krsort($ex);
        foreach($ex as $i=>$v){
            if (trim($v)!=''){
        	$exx = explode('$$',$v);
            
                ?>
                <li class="<?=$exx[1]?>"><?=date("d.m.Y H:i",$exx[0])?> <em><a href="<?=$exx[2]?>" target="_blank"><?=$exx[3]?></a></em> <div><strong><?=$exx[4]?></strong></div><detals><br /></detals></li>
                <?
            
            }
        }
    }
    ?></ul><?
}
?>