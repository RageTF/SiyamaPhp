<?php

/**
 * @author mrhard
 * @copyright 2010
 */

  
 define("_COMP_URL_",_URL_.'editpage&id='.$inf['id'].'&act=');  
 define("_COMP_TABLE_","mycomp__".$comp[1]);
 
 if (!$this->_Q->dg_table_exists(_COMP_TABLE_)){
    
    echo $this->LANG['main']['system_error'];
    
 }else{
    
    $ci= $this->_Q->QA("SELECT * FROM <||>dgcomponent__regedit WHERE `ind`='" . $this->_Q->e($comp[1]) . "' LIMIT 1");
    if ($ci['id']==''){
        
        echo $this->LANG['main']['system_error'];
        
    }else{
        
        $sqlfile = _DR_.'/_comp/'.$this->inf['info']['dir'].'/'.$ci['ind'].'/';
         
        if (!file_exists($sqlfile)){
             echo $this->LANG['main']['system_error'];
        }else{
 
 
             $this->_right.='    <li style="background:url(/dg_system/dg_img/icons/add.png) no-repeat left center;"><a href="'. _COMP_URL_ .'update">'.$this->LANG['confcomp']['editpage_add'].'</a></li>';


            if ($this->_act=='index'){//TODO:index
                $f='';
                $fn='';
                $ft='';
                $ff='';
                
              
                $fields = $this->_Q->QW("SELECT * FROM `<||>dgcomponent__fields` WHERE `comp`='".$ci['id']."' ORDER BY `order`");
                
                foreach($fields as $row){
                 if ( $row['main']==1){
                    $fn[]=$row['name'];
                    $f[]=$row['ind'];
                    $ft[]=$row['type'];
                    $ff[]=$row['format'];
                 }
                }
                
               $sql ="SELECT * FROM `<||>". _COMP_TABLE_ ."` WHERE `sys_page`='".$inf['id']."'" ;                   
               $sqltplfile = $sqlfile.'_tpl/'.$comp[2].'/admin.sql.sys.php';
               
               $SORT=false;
               $DESCSORT=false;
               
                if (file_exists($sqltplfile )){
                    $table = '<||>'._COMP_TABLE_;
                    $page = $inf['id'];
                    $s=0;
                    $max=15;
                    $maxx=$max;
                    if ( array_key_exists('page',$_GET) && $_GET['page']!='' && is_numeric($_GET['page']) && $_GET['page']!=0)  $s=($_GET['page']-1)*$max;
                    
                    
                    
                    
                    if($s!=0){$s--;$max++;}
                    
                    $limit = ' LIMIT '.$this->_Q->e($s).','.$this->_Q->e($max).'';
                    
                    
                    include_once $sqltplfile;
                    
                    
                    $totalitem = $this->_Q->QN( str_replace($limit,'',$sql) );
                    
                    
                    $this->_Q->Q($sql);
                    
                    if ($this->_Q->_error!=''){
                        $sql ="SELECT * FROM `<||>". _COMP_TABLE_ ."` WHERE `sys_page`='".$inf['id']."'" ;
                        echo '<p>'.$this->LANG['confcomp']['master_3_file_admin_sql_error'].'<br /><strong><a href="/dg_admin/?comp=system&use=configurationcomponent&func=master:3:1&mycomp='.$ci['id'].'&tpl='.$comp[2].'#adminsql">'.$this->_Q->_error.'</a></strong></p>';
                    }
                }
                
                
                if ( substr_count($sql,'ORDER BY `sys_order`')==1 ){
                    $SORT=true;
                    if ( substr_count($sql,'ORDER BY `sys_order` DESC')==1 ){
                        $DESCSORT=true;
                    }
                }
                
                if (!is_array($fn)){
                    echo $this->LANG['confcomp']['master_2_main_error'];
                }else{
                ?>

                <div class="dg_table dg_list w95">
                <div class="dg_tr w95">
                <div class="dg_td"><strong>id</strong></div>
                <?
                
                                        foreach($fn as $name){
                        	?>
                            <div class="dg_td"><strong><?=$name?></strong></div>
                            
                            <?
                        }
                
                ?>
                <div class="dg_td">&nbsp;</div>
                <div class="dg_td">&nbsp;</div>
                </div>
                <?
                function dg_shortstring($val){
                    if ( mb_strlen(strip_tags($val),'UTF-8')<=50 ){return strip_tags($val);}else{ return '<span title="'.str_replace('"','',strip_tags($val)).'" class="shorttext">'.mb_substr( strip_tags($val),0,25,'UTF-8' ).'<br />'.mb_substr( strip_tags($val),25,25,'UTF-8' ).'<br />'.mb_substr( strip_tags($val),50,25,'UTF-8' ).'</span>...'; }
                }
                function dg_showval($val,$type,$d=''){
                        $p = explode('|',$d);
                       
                       if ($type=='list' && trim($val)!=''){
                        
                        $ex = explode("\n",$p[0]);
                            
                            foreach($ex as $i=>$v){

                                $exin=explode(':',$v);
                                if ($exin[0]==$val){
                                    if (trim($exin[1])!=''){return '('.trim($exin[0]).') '.trim($exin[1]);}
                                    return trim($exin[0]);
                                }
                                
                            }                      
                       }
                       
                       if ($type=='bool'){
                        if ($val==1){return 'yes';}else{return 'no';}
                       }
                       if ($type=='file'  && trim($val)!=''){
                        $ex = explode('/',$val);
                        $t = explode('.',$ex[count($ex)-1]);
                        $tp = strtolower($t[count($t)-1]);
                        if (count($t)<2){ $tp=''; }
                        
                        return '<a href="'.$val.'" target="_blank" class="filetype file_'.$tp.'">'.dg_shortstring($ex[count($ex)-1]).'</a>';
                       }
                    
                return dg_shortstring($val);
                        
                }

                ?>
                
                 
                
                <?
                
                $QW = $this->_Q->QW($sql);
                $first='';
                $last=0;
                foreach($QW as $row){
                	if ($row[0]!=''){
                	   $show='';
                       if ($row['sys_show']==0){ $show=' na'; }
                	   echo '<div class="dg_tr w95 dg_trsort'.$show.'" id="'.$row['id'].'">';
                       if ($first=='') {$first = $row['sys_order'];}
                       $last=$row['sys_order'];
                       if (is_array($f)){
                         	?>
                            <div class="dg_td" style="width:30px;"><?=$row['id']?></div>
                            
                            <?                       
                        foreach($f as $o=>$name){
                        	?>
                            <div class="dg_td"><?=dg_showval($row[$name],$ft[$o],$ff[$o])?></div>
                            
                            <?
                        }
                        
                        echo '<div class="dg_td" style="width:20px;"><a href="'. _COMP_URL_ .'update&ids='.$row['id'].'&page='.$_GET['page'].'"><img src="/dg_system/dg_img/icons/page_white_edit.png" title="'.$this->LANG['main']['edit'].'" align="absmiddle" /></a></div>
                              <div class="dg_td" style="width:20px;"><a href="'. _COMP_URL_ .'remove&ids='.$row['id'].'&re='. urlencode($_SERVER["REQUEST_URI"]) .'"><img src="/dg_system/dg_img/icons/page_white_delete.png" title="'.$this->LANG['main']['remove'].'" align="absmiddle" /></a></div>';
                        
                       }
                       echo '</div>';
                       
                	}
                }
                $pp=ceil($totalitem/$maxx);

                ?>
               
                </div>
                
                   <p>&nbsp;</p>
                    <p> <input type="button" id="saveorder" disabled value="<?=$this->LANG['main']["save_order"]?>" /> 
                    <input type="button" id="cancelorder" disabled value="<?=$this->LANG['main']["cancel"]?>" /> </p>	
                    <? if($totalitem>$maxx){ ?>
                    <ul class="parseNavigation inline">
                    <?
                   
                    $p_sel=0;
                    if ($_GET['page']!='' && is_numeric($_GET['page'])){ $p_sel=$_GET['page']; }
                    $p_start=0;
                    $p_max=5;
                    
                    if ($p_sel>3){ $p_start=$p_sel-3; }
                    $mmax = $p_max+$p_start-2;
                    
                    if (($mmax+1)>$pp){ $mmax=$pp-1; $p_start=$mmax-5;}
                    if ($p_start<1){ $p_start=0; }
                    
                     //echo $pp;
                    
                    for ($i=$p_start; $i<=$mmax; $i++){
                        $sel=''; if (($i+1)==$p_sel){ $sel=' class="act"'; }
                        if(($i+1)<=$pp)echo '          <li'.$sel.'><a href="'._COMP_URL_.'index&page='.($i+1).'">'.($i+1).'</a></li>'."\n";
                    }
                    
                    ?>
                    </ul>
                    
                    
                    
                    
                  <?}?>
                  <?
                    
                   $s_p_s = $this->_Q->QA("SELECT * FROM <||>dgcomponent__texts WHERE `page_id`=".$inf['id']);
                    
                   if ( array_key_exists('s_p_s',$_POST) ){
                   	    $s_p_sarr['prefix'] = htmlspecialchars_decode($_POST['prefix']);
                        $s_p_sarr['sufix'] = htmlspecialchars_decode($_POST['sufix']);
                        $s_p_sarr['showmodule'] = $_POST['showmodule'];
                        $s_p_sarr['page_id'] = $inf['id'];
                        $this->_Q->_table = 'dgcomponent__texts';
                        $this->_Q->_arr = $s_p_sarr;
                        
                        if ($s_p_s['id']==''){
                            $this->_Q->QI();
                        }else{
                            $this->_Q->_where = ' WHERE `id`='.$s_p_s['id'];
                            $this->_Q->QU();
                        }
                        header("Location:".$_SERVER["REQUEST_URI"]);
                   }
                  
                  
                  ?>
                  <h3>Дополнительно</h3>
                  <div class="dg_form">
                        <form method="post"> <?=$this->_security->creat_key()?>
                            <p>Перед списком<textarea name="prefix" class="wwg"><?= htmlspecialchars($s_p_s['prefix'])?></textarea></p>
                            <p>После списка<textarea name="sufix" class="wwg"><?= htmlspecialchars($s_p_s['sufix'])?></textarea></p>
                            <p> <label> <input type="checkbox" name="showmodule" value="1" <? if ($s_p_s['showmodule']==1) echo ' checked '; ?> /> Отображать в модулях</label></p>
                            <p><input type="submit" name="s_p_s" value="Сохранить" /></p>
                        </form>
                 </div>
                 <?=$this->plugin('wysiwyg');?>
                 <?if($SORT){?>

                                <script>
                                    $(document).ready(function()	{
                                    		$(".dg_list").sortable({
                                    			placeholder: 'dg_tableholder',
                                                items:'.dg_trsort',
                                                axis:'y',
                                                start: function(event, ui) { 
                                                     
                                                   $(ui.item).addClass('dgtrsort'); 
                                                    
                                                    },
                                                stop: function(event, ui) { 
                                                     
                                                   $(ui.item).removeClass('dgtrsort'); 
                                                   $("#saveorder,#cancelorder").removeAttr('disabled');
				                                    sort = true; 
                                                    }
                                    
                                    		}).css('cursor','n-resize');
                    		                $(".dg_list").disableSelection();
                                            		$("#cancelorder").click(function(){
		  	                                               $(".dg_list").sortable( 'cancel' );
                                                            $("#saveorder,#cancelorder").attr('disabled','true'); sort=false;
		                                             });
                                                     
                                		$("#saveorder").click(function(){
                                					var total=''; 	
                                                    var t=<?=$first?>;
                                                   		
                                					$('.dg_trsort').each(function(){
                                						
                                						total+=$(this).attr('id')+':'+ (t) +';';
                                						<? if(!$DESCSORT){?>t++;<?}else{?>t--;<?}?>
                                					})
                                					
                                                    $.post('<?=_COMP_URL_?>saveorder',{p:total},function(data){if(data!='ok'){alert(data);}});
                                					
            
                                					
                                			$("#saveorder,#cancelorder").attr('disabled','true');  sort=false;
                                		});                                    	
                                        
                                        	$("a").click(function(){
		
		                                      if (sort)	return confirm(lang_textareakey);
		
	                                        });
                                        
                                    				});
                            </script>
                   <?}?>
                
                <?
                }
            }
            
            if ($this->_act=='saveorder'){//TODO:saveorder
            dg_page::SetLastTime();
                $ex = explode(';',$_POST['p']);
                foreach($ex as $i=>$v){
                    if (trim($v)!=''){
                    	$p = explode(':',$v);
                        if ( is_numeric($p[0]) && is_numeric($p[1]) ){
                            $arr='';
                            $arr['sys_order'] = $p[1];
                            $this->_Q->_where=" WHERE `id`='".$this->_Q->e($p[0])."' AND `sys_page`='".$inf['id']."'";
                            $this->_Q->_arr=$arr;
                            $this->_Q->_table=_COMP_TABLE_;
                            $this->_Q->QU();
                            if ($this->_Q->_error!=''){ echo $this->_Q->_error; exit; }
                        }
                    }
                }
                echo 'ok';
                $this->_Q->_table='pages';
                $this->_Q->_where='WHERE `id`='.$inf['id'];
                $this->_Q->_arr = array('lastmod'=>time());
                $this->_Q->QU();
            }
            
            if ($this->_act=='remove'){//TODO:remove
            dg_page::SetLastTime();
                if ( array_key_exists('ids',$_GET) ){
                    $inf = $this->_Q->QA("SELECT * FROM <||>"._COMP_TABLE_." WHERE `id`='".$this->_Q->e($_GET['ids'])."'");
                    if ($inf['id']!=''){
                        if ( array_key_exists('go',$_POST) ){
                            if ( array_key_exists('remove',$_POST) ){
                                
                                $this->_Q->_where="WHERE `id`=".$inf['id'];
                                $this->_Q->_table = _COMP_TABLE_;
                                $this->_Q->QD();
                            }
                            
                                            $this->_Q->_table='pages';
                                            $this->_Q->_where='WHERE `id`='.$inf['id'];
                                            $this->_Q->_arr = array('lastmod'=>time());
                                            $this->_Q->QU();
                                                        
                            if ($_GET['re']!=''){
                                header("Location:".urldecode($_GET['re']));
                            }else{
                                header("Location:"._COMP_URL_.'index');
                            }
                            
                        }
                        
                        ?>
                        
                        
                        <form method="post">
                         <?=$this->_security->creat_key()?>
                            <div class="dg_form">
                            <p><?=$this->LANG['main']['remove_note']?></p>
                            <p><input type="submit" name="remove" value="<?=$this->LANG['main']['remove']?>" />
                            <input type="submit" name="cancel" value="<?=$this->LANG['main']['cancel']?>" />
                            <input type="hidden" name="go" value="1" /></p>
                            </div>
                        </form>
                        
                        <?
                    }
                } 
                               
            }
            
            if ($this->_act=='update'){//TODO:update
                
                
                if ( array_key_exists('ids',$_GET) ){
                    $val = $this->_Q->QA("SELECT * FROM <||>"._COMP_TABLE_." WHERE `id`='".$this->_Q->e($_GET['ids'])."'");
                }
                
                $this->_right.='    <li style="background:url(/dg_system/dg_img/icons/text_list_numbers.png) no-repeat left center;"><a href="'. _COMP_URL_ .'index">'.$this->LANG['confcomp']['editpage_list'].'</a></li>';
                
                
                if (array_key_exists('go',$_POST)){//TODO:update:go
                
                dg_page::SetLastTime();
                
                
                
                    $arr='';
                $error='';    
                $QW= $this->_Q->QW("SELECT * FROM <||>dgcomponent__fields WHERE `comp`='" . $ci['id'] . "' ORDER BY `order` ");
                foreach ($QW as $i=>$row){
                
                    $format='';
                    $format = explode('|',$row['format']);
                   
                   if (array_key_exists('field_'.$row['ind'],$_POST)){ 
                    $n='field_'.$row['ind']; 
                    
                    $arr[$row['ind']] = htmlspecialchars_decode($_POST[$n]);
                    
                    
                                if ($row['type']=='varchar'){
                                    if ( mb_strlen($_POST[$n],'UTF-8')>$format[0]  ){
                                        $error.='<li><strong>'.$row['name'].'</strong>: '.$this->LANG['confcomp']['format']['varchar_error'][0].'</li>';
                                    }
                                }
                                if ($row['type']=='int' || $row['type']=='float'){
                                    if ($_POST[$n]!=''){
                                        if(!is_numeric($_POST[$n])){
                                           $error.='<li><strong>'.$row['name'].'</strong>: '.$this->LANG['confcomp']['format']['int_error'][3].'</li>';  
                                        }else{
                                                if ( mb_strlen($_POST[$n],'UTF-8')>$format[0] && $row['type']=='int'){
                                                    $error.='<li><strong>'.$row['name'].'</strong>: '.$this->LANG['confcomp']['format']['int_error'][0].'</li>';
                                                }
                                                if ( mb_strlen($_POST[$n],'UTF-8')>($format[0]+$format[3]+1) && $row['type']=='float'){
                                                    $error.='<li><strong>'.$row['name'].'</strong>: '.$this->LANG['confcomp']['format']['int_error'][0].'</li>';
                                                }
                                                if ($_POST[$n]<$format[1]){
                                                    $error.='<li><strong>'.$row['name'].'</strong>: '.$this->LANG['confcomp']['format']['int_error'][1].'</li>';
                                                }
                                                if ($_POST[$n]>$format[2]){
                                                    $error.='<li><strong>'.$row['name'].'</strong>: '.$this->LANG['confcomp']['format']['int_error'][2].'</li>';
                                                }
                                         } 
                                     }         
                                }

  
                                                
                    
                   } 
                
                
                }
                
                if ($error!=''){
                    ?>
                    <ul class="dg_error"><?=$error?></ul>
                    <?
                    foreach($arr as $i=>$v){
                    	$val[$i] = $v;
                    }

                    
                }else{
                   if ($val['id']==''){
                    $last = $this->_Q->QA("SELECT * FROM <||>"._COMP_TABLE_." WHERE `sys_page`='".$inf['id']."' ORDER BY `sys_order` DESC LIMIT 1");
                    $arr['sys_order'] = $last['sys_order']+1;
                    
                   } 
                   $arr['sys_page'] = $inf['id'];
                   if (is_numeric($_POST['page_id'])) $arr['sys_page'] = $_POST['page_id'];
                   $arr['sys_show']=$_POST['sys_show'];
                    $this->_Q->_table = _COMP_TABLE_;
                    $this->_Q->_arr = $arr;
                    if ($val['id']==''){
                        $id = $this->_Q->QI();
                    }else{
                        $this->_Q->_where = "WHERE `id`=".$val['id'];
                        $this->_Q->QU();
                        $id = $val['id'];
                    }
                    
                        if ($this->_Q->_error!=''){
                            ?>
                            <ul class="dg_error"><?=$this->_Q->_error?></ul>
                            <?
                            foreach($arr as $i=>$v){
                            	$val[$i] = $v;
                            }
        
                            
                        }else{                    
                                        $this->_Q->_table='pages';
                                        
                                        $this->_Q->_arr = array('lastmod'=>time());
                                        $this->_Q->_where='WHERE `id`='.$arr['sys_page'];
                                        $this->_Q->QU();
                                        $this->_Q->_where='WHERE `id`='.$inf['id'];
                                        $this->_Q->QU();
                                        
                            if ($_POST['lo']==1){
                                header("Location:"._COMP_URL_.'index&page='.$_GET['page'].'#item'.$id);
                            }else{
                                header("Location:"._COMP_URL_.'update&ids='.$val['id']);
                            }
                    }

                }

                }
                
                
                ?>
                
                <form method="post" id="updatei"> <?=$this->_security->creat_key()?>
                 <div class="dg_form">
                
                <?
            
                $QW= $this->_Q->QW("SELECT * FROM <||>dgcomponent__fields WHERE `comp`='" . $ci['id'] . "' ORDER BY `order` ");
                foreach ($QW as $i=>$row){
                    $format='';
                    $format = explode('|',$row['format']);
                    
                    
                    
                    if ( $val[$row['ind']] == '' && $val['id']=='' ) $val[$row['ind']] = $row['def'];
                    
                    
                    
                    if ($row['type']=='varchar'){ //TODO:update:varchar                       
                    
                        ?>                        
                            <p><?=$row['name']?><br /><? if (trim($row['des'])!=''){ ?> <span class="comment"><?=$row['des']?></span><br /> <? } ?>
                                <input type="text" name="field_<?=$row['ind']?>" id="field_<?=$row['ind']?>" maxlength="<?=$format[0]?>" class="w90" value="<?=htmlspecialchars($val[$row['ind']])?>" />
                            </p>                        
                        <?   
                    }
                    
                    if ($row['type']=='memo'){ //TODO:update:memo                       
                        ?>                        
                            <p><?=$row['name']?><br /><? if (trim($row['des'])!=''){ ?> <span class="comment"><?=$row['des']?></span><br /> <? } ?>
                                <textarea name="field_<?=$row['ind']?>" id="field_<?=$row['ind']?>"  class="w80<? if ($format[0]=='edit'){ echo ' wwg'; } ?>"><?=htmlspecialchars($val[$row['ind']])?></textarea>
                            </p>                        
                        <?   
                        
                        if ($format[0]=='edit'){$this->plugin('wysiwyg');}
                        
                    }                    

                    if ($row['type']=='int'){   //TODO:update:int                     
                        ?>                        
                            <p><?=$row['name']?><br /><? if (trim($row['des'])!=''){ ?> <span class="comment"><?=$row['des']?></span><br /> <? } ?>
                                <input type="number" name="field_<?=$row['ind']?>" id="field_<?=$row['ind']?>" maxlength="<?=($format[0]+1)?>" class="w15" value="<?=htmlspecialchars($val[$row['ind']])?>" />
                            </p>                        
                        <?   
                    }     

                    if ($row['type']=='float'){ //TODO:update:float                       
                        ?>                        
                            <p><?=$row['name']?><br />
                                <input type="number" name="field_<?=$row['ind']?>" id="field_<?=$row['ind']?>" maxlength="<?=($format[0]+1+$format[3])?>" class="w15" value="<?=htmlspecialchars($val[$row['ind']])?>" />
                            </p>                        
                        <?   
                    }                                   

                    if ($row['type']=='date'){ //TODO:update:date    
                        
                        if ($val[$row['ind']]=='' && $format[1]==1 ){ $val[$row['ind']]=date("Y-m-d"); }
                        
                        ?>                        
                            <p><?=$row['name']?><br /><? if (trim($row['des'])!=''){ ?> <span class="comment"><?=$row['des']?></span><br /> <? } ?>
                                <input type="date" name="field_<?=$row['ind']?>" id="field_<?=$row['ind']?>"  class="w20 date" value="<?=htmlspecialchars($val[$row['ind']])?>" />
                            </p>                        
                        <?   
                    } 
                    
                    if ($row['type']=='time'){   //TODO:update:time
                        if ($val[$row['ind']]=='' && $format[1]==1 ){ $val[$row['ind']]=date("H:i:s"); }
                        ?>                        
                            <p><?=$row['name']?><br /><? if (trim($row['des'])!=''){ ?> <span class="comment"><?=$row['des']?></span><br /> <? } ?>
                                <input type="time" name="field_<?=$row['ind']?>" id="field_<?=$row['ind']?>"  class="w20" value="<?=htmlspecialchars($val[$row['ind']])?>" />
                            </p>                        
                        <?   
                    } 
                    
                    if ($row['type']=='datetime'){//TODO:update:datetime
                        if ($val[$row['ind']]=='' && $format[1]==1 ){ $val[$row['ind']]=date("Y-m-d H:i:s"); }
                        ?>                        
                            <p><?=$row['name']?><br /><? if (trim($row['des'])!=''){ ?> <span class="comment"><?=$row['des']?></span><br /> <? } ?>
                                <input type="datetime" name="field_<?=$row['ind']?>" id="field_<?=$row['ind']?>"  class="w20 datetime" value="<?=htmlspecialchars($val[$row['ind']])?>" />
                            </p>                        
                        <?   
                    }
                    
                    if ($row['type']=='file'){ //TODO:update:file                       
                        ?>                        
                            <p><?=$row['name']?><br /><? if (trim($row['des'])!=''){ ?> <span class="comment"><?=$row['des']?></span><br /> <? } ?>
                                <input type="text" name="field_<?=$row['ind']?>" id="field_<?=$row['ind']?>"  class="w50" value="<?=htmlspecialchars($val[$row['ind']])?>" /> <input type="button" value="<?=$this->LANG['main']['upload']?>" onclick="window.open('/dg_admin/?comp=source&use=filemanager&ajax&to=field_<?=$row['ind']?>&ft=<?=$format[0]?>','fileeditor','height=600,width=1000,left=0,top=0,scrollbars=yes');  return false;" />
                            </p>                        
                        <?   
                    }                    
                                       
                    if ($row['type']=='list'){ //TODO:update:list                       

                        ?>                        
                            <p><?=$row['name']?><br /><? if (trim($row['des'])!=''){ ?> <span class="comment"><?=$row['des']?></span><br /> <? } ?>
                                <select name="field_<?=$row['ind']?>" id="field_<?=$row['ind']?>">
                                <?
                                
                                $list = explode("\n",$format[0]);
                                foreach ($list as $a=>$b){
                                    if (trim($b)!=''){
                                        $sel = '';
                                        
                                        $list_in = explode(':',$b);
                                        if (trim($list_in[0])!=''){
                                            if ($list_in[1]==''){ $list_in[1] = $list_in[0]; }
                                            $list_in[0] = str_replace("\n",'',$list_in[0]);
                                            $list_in[1] = str_replace("\n",'',$list_in[1]);
                                            $list_in[0] = str_replace("\r",'',$list_in[0]);
                                            $list_in[1] = str_replace("\r",'',$list_in[1]);
                                            if ( $list_in[0] == $val[$row['ind']] ) $sel = ' selected ';
                                            ?>
                                            <option value="<?=$list_in[0]?>"<?=$sel?>><?=$list_in[1]?></option>
                                            <?
                                        }
                                        
                                    }
                                }
                                
                                ?>
                                </select>
                            </p>                        
                        <?   
                    } 
                    
                    if ($row['type']=='bool'){ //TODO:update:bool                       
                        ?>                        
                            <p><?=$row['name']?><br /><? if (trim($row['des'])!=''){ ?> <span class="comment"><?=$row['des']?></span><br /> <? } ?>
                               <label><input type="radio" name="field_<?=$row['ind']?>" id="field_<?=$row['ind']?>" value="1" <? if ($val[$row['ind']]==1){ echo ' checked '; } ?> /> <?=$this->LANG['main']['yes']?></label> 
                               <label><input type="radio" name="field_<?=$row['ind']?>" id="field_<?=$row['ind']?>" value="0" <? if ($val[$row['ind']]==0){ echo ' checked '; } ?>/> <?=$this->LANG['main']['no']?></label> 
                            </p>                        
                        <?   
                    }  
                    
                    if ($row['type']=='imglist'){ //TODO:update:bool                       
                        ?>                        
                            <p><?=$row['name']?><br /><? if (trim($row['des'])!=''){ ?> <span class="comment"><?=$row['des']?></span><br /> <? } ?>
                              <div class="dg_form">
                                <p><a href="#"><?=$this->LANG['confcomp']['editpage']['imglist']['upload']?></a></p>
                              </div>
                            </p>                        
                        <?   
                    }                                        
                    
                    
                }
                
                
                
                ?>
            
                <p> <label> <input type="checkbox" name="sys_show" value="1" <? if ($val['sys_show']==1 || $val['sys_show']==''){ echo ' checked '; } ?> /> <?=$this->LANG['confcomp']['editpage_show']?></label> 
                <select name="page_id" id="page_id">
                    <?
                    
                        $QW = $this->_Q->QW("SELECT * FROM <||>pages WHERE `comp` LIKE 'conf:".$comp[1].":%'");
                        foreach($QW as $i=>$srow){
                        	if ($srow[0]!=''){
                        	   $sel='';
                               if ($inf['id']==$srow['id']) $sel=' selected ';
                               echo '<option value="'.$srow['id'].'"'.$sel.'>'.$srow['name'].' ('.$srow['id'].')</option>';
                               
                        	}
                        }
                  
                    ?>
                </select></p>
                <p><input type="submit" name="go" value="<?=$this->LANG['main']['save']?>" />
                 <select name="lo">
                    <option value="1"><?=$this->LANG['confcomp']['editpage_saveandgo']?></option>
                    <option value="2"><?=$this->LANG['confcomp']['editpage_saveandgoback']?></option>
                 </select>
                </p>
                    </div>
                </form>
                <script>
                $(document).ready(function()	{
                	$("#updatei").submit(function(){
                	   if ($("#page_id").val()!=<?=$inf['id']?>){
                	       return confirm("<?=$this->LANG['confcomp']['editpage_repage']?>");
                	   }
                	});
                				})
                </script>
                <?
            
            }
        }   
   } 
}
$this->_right.='<div class="r"></div>';
                $this->_right.='    <li style="background:url(/dg_system/dg_img/icons/application_go.png) no-repeat left center;"><a href="'. $p->_pages[$inf['id']]['url'] .'" target="_blank">'.$this->LANG['compsource']['title_pages_go'].'</a></li>
                    <li style="background:url(/dg_system/dg_img/icons/hammer.png) no-repeat left center;"><a href="'._URL_.'update&id='.$inf['id'].'">'.$this->LANG['compsource']['title_pages_setting_page'].'</a></li>
                    <li style="background:url(/dg_system/dg_img/icons/cross.png) no-repeat left center;"><a href="'._URL_.'remove&id='.$inf['id'].'">'.$this->LANG['compsource']['title_pages_remove'].'</a></li>
                    <div class="r"></div>';



	 	$this->_right.='
		 <h3>'.$this->LANG['confcomp']['editpage_c'].'</h3>
		 
 	 				    <li style="background:url(/dg_system/dg_img/icons/application_view_list.png) no-repeat left center;"><a href="/dg_admin/?comp=system&use=configurationcomponent&func=master:2&mycomp='.$ci['id'].'">'.$this->LANG['confcomp']['master_2'].'</a></li>
 	 					<li style="background:url(/dg_system/dg_img/icons/application_view_gallery.png) no-repeat left center;"><a href="/dg_admin/?comp=system&use=configurationcomponent&func=master:3&mycomp='.$ci['id'].'">'.$this->LANG['confcomp']['master_3'].'</a></li>';
?>