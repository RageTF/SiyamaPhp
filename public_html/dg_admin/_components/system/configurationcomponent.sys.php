<?

/**
 * @author Maltsev Vladimir
 * @copyright 2010
 * 
 */
 if ($this->access('configurationcomponent','access')){
 define(_VER_,1);
 define(_URL_,'/dg_admin/?comp=system&use=configurationcomponent&func=');
 
 						$f = 'varchar'; 		$type[$f]='varchar(300)';				$format[$f]='300';						 	$def[$f]=true;			
						$f = 'memo'; 			$type[$f]='text';						$format[$f]='edit';							$def[$f]=true;			
						$f = 'int'; 			$type[$f]='int(9)';						$format[$f]='9|-999999999|999999999';		$def[$f]=true;			
						$f = 'float'; 			$type[$f]='float(9,2)';					$format[$f]='9|-999999999|999999999|2';		$def[$f]=true;			
						$f = 'date'; 			$type[$f]='date';						$format[$f]='0';								 			
						$f = 'time'; 			$type[$f]='time';						$format[$f]='0';									 			
						$f = 'datetime'; 		$type[$f]='datetime';					$format[$f]='0';									
						$f = 'file'; 			$type[$f]='text';						$format[$f]='*';						    $def[$f]=true;			
						$f = 'list'; 			$type[$f]='text';						$format[$f]='';								$def[$f]=true;			
						$f = 'bool'; 			$type[$f]="int(1) DEFAULT '0'";			$format[$f]='0';							$def[$f]=true;
                      			
						

 
 if (array_key_exists('mycomp',$_GET)){
 	
 	
 		$mycomp = $this->_Q->QA("SELECT * FROM <||>dgcomponent__regedit WHERE `id`='".$this->_Q->e($_GET['mycomp'])."' LIMIT 1");

 							if ($mycomp['id']!=''){
							 $fields = $this->_Q->QW("SHOW FIELDS FROM `<||>mycomp__".$mycomp['ind']."`");
							
							foreach ($fields as $i=>$row){
								
								$fd[$row[0]]=true;
								
							}
							}
							
							if ($mycomp['ind']!=''){
								
								define("_LOC_",_DR_.'/_comp/'.$this->inf['info']['dir'].'/'.$mycomp['ind'].'/');
								$fc = new dg_file;
                                $fc->createdir(_LOC_.'_tpl/');
							}	
 }
 
 if (array_key_exists('field',$_GET) && $mycomp['id']!=''){

 		$field = $this->_Q->QA("SELECT * FROM <||>dgcomponent__fields WHERE `comp`='".$mycomp['id']."' AND `id`='".$this->_Q->e($_GET['field'])."' LIMIT 1");
	
 }
 
 
 
 	$this->_right='<h2>'.$this->LANG['compsystem']['configurationcomponentname'].'</h2>
	 
	 <li style="background:url(/dg_system/dg_img/icons/wand.png) no-repeat left center;"><a href="'._URL_.'master:0">'.$this->LANG['confcomp']['master'].'</a></li>
 	 <li style="background:url(/dg_system/dg_img/icons/color_swatch_2.png) no-repeat left center;"><a href="'._URL_.'index">'.$this->LANG['confcomp']['list'].'</a></li>

	 <div class="r"></div>
	 ';

	if ($this->_func=='index'){//TODO:index
		
		/**
		 * выводим список компонентов
		 */
		
		
		
		
		?>
		
		<h2><?=$this->LANG['compsystem']['configurationcomponentname']?></h2>
        
        <div class="help"><?=$help['index']?></div><p>&nbsp;</p>
		
		<?
		
		
		
		$total='';
		
		
		$QW = $this->_Q->QW("SELECT * FROM <||>dgcomponent__regedit");
		
		foreach ($QW as $i=>$row){
			
			$total.='<li>';
			$ico = '/dg_system/dg_img/icons/color_swatch_2.png';
			if ($row['ico']!=''){
				
				$ico=$row['ico'];
			}
			
				$total.='<span style="width:620px; background:url('.$ico.') no-repeat left center;"><a href="'._URL_.'master:0&mycomp='.$row['id'].'">'.$row['name'].'</a></span>';
				$total.='<span style="width:20px;"><a href="'._URL_.'master:2&mycomp='.$row['id'].'"><img src="/dg_system/dg_img/icons/application_view_list.png" title="'.$this->LANG['confcomp']['master_2'].'" /></a></span>';
				$total.='<span style="width:20px;"><a href="'._URL_.'master:3&mycomp='.$row['id'].'"><img src="/dg_system/dg_img/icons/application_view_gallery.png" title="'.$this->LANG['confcomp']['master_3'].'" /></a></span>';
				$total.='<span style="width:20px;"><a href="'._URL_.'master:4&mycomp='.$row['id'].'"><img src="/dg_system/dg_img/icons/application_go.png" title="'.$this->LANG['confcomp']['master_4'].'" /></a></span>';
				$total.='<span style="width:20px;"><a href="'._URL_.'master:5&mycomp='.$row['id'].'&re='.urlencode($_SERVER["REQUEST_URI"]).'" class="removeaccess"><img src="/dg_system/dg_img/icons/cross.png" title="'.$this->LANG['main']['remove'].'" /></a></span>';
			$total.='</li>'."\n";
		}
		
		
		if ($total!=''){
			
			?><div class="dg_list">
			<?=$total?>
			</div> <?
		}
		
		
	}
	
	
	if ($this->_func=='master:0'){//TODO:master:0
		
		/**
		 * создаем компонент
		 */
		 
		 
		 ?>
		 
		 <h2><?=$this->LANG['confcomp']['master']?></h2>
		 <h3><?=$this->LANG['confcomp']['master_0']?></h3>
         <div class="help"><?=$help['master:0']?></div><p>&nbsp;</p>
		 
		 <form method="post" enctype="multipart/form-data">	  <?=$this->_security->creat_key()?>
	    	<div class="dg_form">
	    	<?
			
			
			if (array_key_exists('go',$_POST)){
				
				
				$error='';
				
				$n = $this->inf['info']['prefix'].'mycomp__'.$this->_Q->e($_POST['ind']);
				
					if (trim($_POST['name'])==''){ $error.='<li>'.$this->LANG['confcomp']['master_error1'].' <b>'.$this->LANG['confcomp']['master_0_name'].'</b></li>'; }
					if ($mycomp['id']==''){
						if (trim($_POST['ind'])==''){ $error.='<li>'.$this->LANG['confcomp']['master_error1'].' <b>'.$this->LANG['confcomp']['master_0_compname'].'</b></li>'; }
						if (!lat($_POST['ind'])){ $error.='<li>'.$this->LANG['confcomp']['master_0_compname_note'].'</li>'; }
				    }
				
				/* проверяем на наличие созданной директории */
					if ($error=='' && $mycomp['id']==''){
					
						if ( file_exists(_DR_.'/_comp/'.$this->inf['info']['dir'].'/'.$_POST['ind']) ){ $error='<li>'.$this->LANG['confcomp']['master_error2'].'</li>'; }
						
						if ($this->_Q->table_exists($n)){ $error.='<li>'.$this->LANG['confcomp']['master_error3'].'</li>'; }
						
					}
				
				if ($error!=''){
					foreach ($_POST as $i=>$v){ $mycomp[$i] = $v; }
					?>
					<div class="dg_error"><?=$error?></div><p>&nbsp;</p>
					<?
					
				}else{
					if ($_FILES['install']['name']!=''){
						
						
						
						/* работаем через инсталятор */
						
						
						$infofile = new dg_file;
							
						$t=time();
                        $fc = new dg_file;
						$fc->createdir(_DR_.'/temp');
						$uploaddir = _DR_.'/temp/';
						$uploadfile = $uploaddir . basename($t.$_FILES['install']['name']);
						
						
						if (move_uploaded_file($_FILES['install']['tmp_name'], $uploadfile)) {

							/*загрузили*/
							
							dg_file::chmod($uploadfile);
							
							$tempdir = _DR_.'/_comp/'.$this->inf['info']['dir'].'/'.$_POST['ind'].'/';
							$fc = new dg_file;
						    $fc->createdir($tempdir);
									
							
							$zip = new ZipArchive;
							if ($zip->open($uploadfile) === TRUE) {
							    $zip->extractTo($tempdir);
							    $zip->close();
							    
							    /*Распоковали*/
							    
							    if (file_exists($tempdir.'info.txt')){
							    	
							    	/*Проверели, информационный файл есть*/
							    	
							    
							    	$compinfo = explode('--info--',$infofile->read($tempdir.'info.txt'));
							    	
							    	if ( is_numeric($compinfo[0])){
							    		
							    		/*Проверели подпись*/
							    		
							    		if (_VER_>=$compinfo[0]){
							    			
							    			/*Проверели на соответствие версии*/
							    			
							    			
							    			/*БД*/
							    										    						    			
							    			
							    			
							    			if ( file_exists($tempdir.'db.sql') ){
							    				
								    			/*Добавляем компанент в реестр*/
										
												$this->_Q->_error='';
												$this->_Q->_table = 'dgcomponent__regedit';
												$this->_Q->_arr = array('name'=>$_POST['name'],'ind'=>$_POST['ind'],'ico'=>str_replace('%dir%',$this->inf['info']['dir'],$compinfo[2]),'des'=>$compinfo[3]);
												$last_id = $this->_Q->QI();		
												
												if (trim($this->_Q->_error)==''){
													
														$sqllist = $infofile->read($tempdir.'db.sql');
														
														
														
														$sqllist = str_replace('%table%',$n,$sqllist);
														$sqllist = str_replace('%comp_id%',$last_id,$sqllist);
														
									    				$list = explode('[end]',$sqllist);
									    				$sqlerror='';
									    				
									    				foreach ($list as $i=>$v){
									    					if (trim($v)!=''){
									    					$this->_Q->Q($v);
									    					if (trim($this->_Q->_error)!=''){
									    						
									    						$sqlerror.=$this->_Q->_error.' ('.$this->_Q->_sql.')<br/>';
									    					}
									    					}
									    				}
									    				
									    				if ($sqlerror==''){
									    					
									    					/*все отлично, едем дальше*/
									    					
									    					unlink($tempdir.'info.txt');
									    					unlink($tempdir.'db.sql');
									    					header('Location:'._URL_.'master:1&mycomp='.$last_id);
									    					
									    					
									    				}else{
									    					
									    				echo'<div class="dg_error">'.$this->LANG['confcomp']['master_0_instal_error_7'].'<br />'.$sqlerror.'<br />'.$this->_Q->_sql.'</div><p>&nbsp;</p>';	
														$infofile->full_del_dir($tempdir);	
														
														$this->_Q->_table='dgcomponent__regedit';
														$this->_Q->_where="WHERE `id`='".$this->_Q->e($last_id)."'";
														$this->_Q->QD();
														$this->_Q->_table='dgcomponent__fields';
														$this->_Q->_where="WHERE `comp`='".$this->_Q->e($last_id)."'";
														$this->_Q->QD();	
														if($this->_Q->table_exists($n)){$this->_Q->Q("DROP TABLE ".$n);}													
									    				}
													
												}else{
													
													echo'<div class="dg_error">'.$this->LANG['confcomp']['master_0_instal_error_6'].' <br />'.$this->_Q->_error.'</div><p>&nbsp;</p>';	
												    $infofile->full_del_dir($tempdir);
												}
							    				
							    				/**/
							    				
							    			}else{
							    			
											 echo'<div class="dg_error">'.$this->LANG['confcomp']['master_0_instal_error_5'].'</div><p>&nbsp;</p>';	
							    			 $infofile->full_del_dir($tempdir);	
							    			}
							    									    			
							    		}else{
							    			echo'<div class="dg_error">'.$this->LANG['confcomp']['master_0_instal_error_4'].'</div><p>&nbsp;</p>';
							    		    $infofile->full_del_dir($tempdir);
										}
							    		
							    	}else{
							    		echo'<div class="dg_error">'.$this->LANG['confcomp']['master_0_instal_error_3'].'  '.$compinfo[0].'</div><p>&nbsp;</p>';
							    	    $infofile->full_del_dir($tempdir);
									}
							    	
							    }else{
							    	echo'<div class="dg_error">'.$this->LANG['confcomp']['master_0_instal_error_2'].'</div><p>&nbsp;</p>';
							    	$infofile->full_del_dir($tempdir);
							    }
							    
							} else {
							   echo'<div class="dg_error">'.$this->LANG['confcomp']['master_0_instal_error_1'].'</div><p>&nbsp;</p>'; 							   
							   $infofile->full_del_dir($tempdir);
							   
							}
							
							
						}else{
						 echo'<div class="dg_error">'.$this->LANG['confcomp']['master_0_instal_error_0'].'</div><p>&nbsp;</p>';	
						}
						
						
						
					}else{
					
					/*все хорошо, создаем таблицу + создаем директорию + служебные файлы в ней*/
					
					
					if ($mycomp['id']==''){
					
								$this->_Q->_sql="CREATE TABLE IF NOT EXISTS ".$n."
								(id int(6) NOT NULL auto_increment,
                                `sys_name` varchar(300),
								`sys_order` int(9) DEFAULT '0',
								`sys_page` int(9) DEFAULT '0',
								`sys_show` int(1) DEFAULT '0',
								PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
								$this->_Q->Q();		
								
									
								
								if ($this->_Q->_error!=''){
									
									foreach ($_POST as $i=>$v){ $mycomp[$i] = $v; }
									
									echo '<div class="dg_error">'.$this->_Q->_error.'</div>';
									
								}else{
									
									
									$this->_Q->_table = 'dgcomponent__regedit';
									$this->_Q->_arr = array('name'=>$_POST['name'],'ind'=>$_POST['ind']);
									$last_id = $this->_Q->QI();
									
									$fc = new dg_file;
						            $fc->createdir(_DR_.'/_comp/'.$this->inf['info']['dir'].'/'.$_POST['ind']);
									
									header('Location:'._URL_.'master:1&mycomp='.$last_id);
									
								}	
				  }else{
									$this->_Q->_table = 'dgcomponent__regedit';
									$this->_Q->_arr = array('name'=>$_POST['name']);
									$this->_Q->_where = " WHERE `id`=".$mycomp['id'];
									$this->_Q->QU();				  	
				  					header('Location:'._URL_.'master:1&mycomp='.$mycomp['id']);
				  }	
				  
				  }
				  
				}
				
			}
			
			
			?>
	    	<p><?=$this->LANG['confcomp']['master_0_name']?><br />
			<input type="text" name="name" value="<?=$mycomp['name']?>" />
			</p>
			
			<p><?=$this->LANG['confcomp']['master_0_compname']?><br /><span class="comment"><?=$this->LANG['confcomp']['master_0_compname_note']?></span><br />
			<input type="text" name="ind" value="<?=$mycomp['ind']?>" <? if ($mycomp['id']!=''){ ?> disabled="disabled" <? } ?> /><? if ($mycomp['id']!=''){ ?> <input type="hidden" name="ind" value="<?=$mycomp['ind']?>" /> <? }  ?>
			</p>
			<? if ($mycomp['id']==''){ ?>
			<p><?=$this->LANG['confcomp']['master_0_instal']?><br /><input type="file" name="install" /></p>
	    	<?}?>
	    	<p>
				<input type="submit" name="go" value="<?=$this->LANG['main']['next']?>" />
			</p>
	    	
		 	</div>
		 </form>
		 
		 <?
		
	}
	
	
	if ($this->_func=='master:1'){//TODO:master:1
		/**
		 * описание и иконка
		 */
		
		if ($mycomp['id']==''){ echo $this->LANG['confcomp']['comp_not_found']; }else{
			
			?>
			
		 <h2><?=$this->LANG['confcomp']['master']?></h2>
		 <h3><b><?=$mycomp['name']?></b>: <?=$this->LANG['confcomp']['master_1']?></h3>
         <div class="help"><?=$help['master:1']?></div><p>&nbsp;</p>
		 
		 <form method="post" enctype="multipart/form-data"> <?=$this->_security->creat_key()?>
		 
		 	<div class="dg_form">
			 <?
			 
			 
			 	if (array_key_exists('go',$_POST) ){
			 		
					$uploaddir =_DR_.'/_comp/'.$this->inf['info']['dir'].'/'.$mycomp['ind'].'/';
					if (trim($_FILES['ico']['name'])!=''){
		   
					$uploadfile = $uploaddir . basename($_FILES['ico']['name']);
					
				   
					if (move_uploaded_file($_FILES['ico']['tmp_name'], $uploadfile) && ( dg_file::type(basename($_FILES['ico']['name'])) == 'png' || dg_file::type(basename($_FILES['ico']['name'])) == 'jpg' || dg_file::type(basename($_FILES['ico']['name'])) == 'gif' )) {
						
						
						if ($mycomp['ico']!='' && file_exists(_DR_.$mycomp['ico'])){ unlink(_DR_.$mycomp['ico']); }
						
						$arr['ico'] = str_replace(_DR_,'',$uploadfile);
						
					} 			 
					}		
					
					
					$arr['des'] = htmlspecialchars_decode($_POST['des']);
					
						$this->_Q->_table = 'dgcomponent__regedit';
						$this->_Q->_arr = $arr;
						$this->_Q->_where = " WHERE `id`=".$mycomp['id'];
						$this->_Q->QU();
						
						header('Location:'._URL_.'master:2&mycomp='.$mycomp['id']);
			 		
			 	}
			 
			 
			 ?>
			 <p><?=$this->LANG['confcomp']['master_1_des']?><br />
			 <textarea name="des"><?=htmlspecialchars($mycomp['des'])?></textarea>
			 </p>
			 
			 <p><?=$this->LANG['confcomp']['master_1_ico']?><br /><span class="comment"><?=$this->LANG['main']['imgaccess']?></span><br />
			 <input type="file" name="ico" /> <? if ($mycomp['ico']!='') { echo $this->LANG['confcomp']['master_1_ico_view'].' <img src="'.$mycomp['ico'].'" /> <span class="comment">'.$this->LANG['confcomp']['master_1_ico_view_note'].'</span>'; } ?>
			 </p>
			 
	    	<p>
				<input type="submit" name="go" value="<?=$this->LANG['main']['next']?>" />
			</p>
						 </div>
		 
		 </form>
			
			<?
			
		}
		
	}
	
	
	
	
	
	
	
	/**
	 * 
	 * 
	 * 
	 * 
	 * 
	 * работа
	 * с
	 * полями
	 * компонента
	 * 
	 * 
	 * 
	 * 
	 * 
	 */
	
	
	
	
	
	
	
	
	if ($this->_func=='master:2'){//TODO:master:2
		
		/**
		 * список полей
		 */
		
		if ($mycomp['id']==''){ echo $this->LANG['confcomp']['comp_not_found']; }else{
			
			
	 $this->_right.='<li style="background:url(/dg_system/dg_img/icons/add.png) no-repeat left center;"><a href="'._URL_.'master:2:0&mycomp='.$mycomp['id'].'">'.$this->LANG['confcomp']['master_2_new'].'</a></li>
 	 ';
	 $this->_right.='<div class="r"></div>';		
		
		
		
		
		$QW = $this->_Q->QW("SELECT * FROM <||>dgcomponent__fields WHERE `comp`='".$mycomp['id']."' ORDER BY `order`");
		$total='';
		
		
		foreach ($QW as $i=>$row){
			
			$total.='<li id="f_'.$row['id'].'">';
			
			$s=''; $s2='';
			
			if (!$fd[$row['ind']]){ $s='<s>'; $s2='</s> <b>'.$this->LANG['confcomp']['master_2_nofield'].'</b>'; }
			$im = 'brick.png';
            if ($row['main']==1){
                $im = 'bricks_green.png';
            }
			$total.='<span style="width:680px; background:url(/dg_system/dg_img/icons/'.$im.') no-repeat left center;">'.$s.'<a href="'._URL_.'master:2:0&mycomp='.$mycomp['id'].'&field='.$row['id'].'">'.$row['name'].'</a> ('.$row['ind'].')'.$s2.'<br /><font class="comment">'.$this->LANG['confcomp']['types'][$row['type']].'</font></span>';
			$total.='<span style="width:20px;"><a href="'._URL_.'master:2:2&mycomp='.$mycomp['id'].'&field='.$row['id'].'&re='.urlencode($_SERVER["REQUEST_URI"]).'" class="removeaccess"><img src="/dg_system/dg_img/icons/cross.png" title="'.$this->LANG['main']['remove'].'" align="absmiddle" /></a></span>';
			
			$total.='</li>';
			
		}
			
			?>
			
		 <h2><?=$this->LANG['confcomp']['master']?></h2>
		 <h3><b><?=$mycomp['name']?></b>: <?=$this->LANG['confcomp']['master_2']?></h3>
          <div class="help"><?=$help['master:2']?></div><p>&nbsp;</p>
		<?
		
		if ($total!=''){
			
			?> 
			
			
			<script> 
	var sort=false;
	$(function() {
		$(".sortable").sortable({
			placeholder: 'state-highlight',
            axis:'y',
			stop: function (event,ui){
				$("#saveorder,#cancelorder").removeAttr('disabled');
				sort = true;
			}
		});
		$(".sortable").disableSelection();
		$("#cancelorder").click(function(){
			$(".sortable").sortable( 'cancel' );
			$("#saveorder,#cancelorder").attr('disabled','true'); sort=false;
		});
		
		$("#saveorder").click(function(){
					var total=''; 				
					$('.sortable li').each(function(){
						
						total+=$(this).attr('id')+';';
						
					})
					
					
					$.post('<?=_URL_?>savefieldorder&mycomp=<?=$mycomp['id']?>',{items:total},function(data){
						
						if (data!='ok'){
							
							alert (data);
							$(".sortable").sortable( 'cancel' ); sort=false
							
						}
					})
					
			$("#saveorder,#cancelorder").attr('disabled','true');  sort=false;
		});
	
	$("a").click(function(){
		
		if (sort)	return confirm(lang_textareakey);
		
	});
		
	});
	</script> 	
			
			
			<div class="dg_list sortable"><?=$total?></div> 
			
   <p>&nbsp;</p>
   <p> <input type="button" id="saveorder" disabled value="<?=$this->LANG['main']["save_order"]?>" /> 
   <input type="button" id="cancelorder" disabled value="<?=$this->LANG['main']["cancel"]?>" /> </p>			
			<?
			
		}else{
			echo $this->LANG['confcomp']['master_2_nofields'];
		}
		
	  }	
	}
	
	
	if ($this->_func=='savefieldorder'){//TODO:savefieldorder
		
		/**
		 * сохраняем порядок полей
		 */ 
		
	   if ($mycomp['id']==''){ echo $this->LANG['confcomp']['comp_not_found']; }else{	
							$_POST['items'] = str_replace('f_','',$_POST['items']);
					
					$ex = explode(';',$_POST['items']);
					
					$y=0;
					foreach ($ex as $i=>$v){
						if (trim($v)!=''){
							$y++;
						 	  $this->_Q->_table="dgcomponent__fields";
						 	  $this->_Q->_arr = array('order'=>$y);
						 	  $this->_Q->_where = " WHERE `id`='" . $this->_Q->e($v) . "'";
							  $this->_Q->QU();
							  if ($this->_Q->_error!=''){ echo $this->_Q->_error; exit;}
						}
					}
					echo 'ok';
		}
		
	}
	
	if ($this->_func=='master:2:0'){//TODO:master:2:0
		
		/**
		 * создать / редактировать поле
		 */
		
		if ($mycomp['id']==''){ echo $this->LANG['confcomp']['comp_not_found']; }else{
			
			
	 $this->_right.='<li style="background:url(/dg_system/dg_img/icons/add.png) no-repeat left center;"><a href="'._URL_.'master:2:0&mycomp='.$mycomp['id'].'">'.$this->LANG['confcomp']['master_2_new'].'</a></li>
 	 ';
	 $this->_right.='<div class="r"></div>';		
			
			?>
			
		 <h2><?=$this->LANG['confcomp']['master']?></h2>
		 <? if ($field['id']==''){ ?>
		 <h3><b><?=$mycomp['name']?></b>: <?=$this->LANG['confcomp']['master_2_new']?></h3>
		 <?}else{?>
		 <h3><b><?=$mycomp['name']?></b>: <?=$this->LANG['confcomp']['master_2_edit']?> <?=$field['name']?> (<?=$field['ind']?>)</h3>	
		 <?}?>
         <div class="help"><?=$help['master:2:0']?></div><p>&nbsp;</p>
	     <form method="post"> <?=$this->_security->creat_key()?>
			<div class="dg_form">
			
			<?
			
				if (array_key_exists('go',$_POST)){
					
					$error='';
					
					if (trim($_POST['name'])==''){$error.='<li>'. $this->LANG['confcomp']['master_error1'] .' <b>'. $this->LANG['confcomp']['master_2_name'] .'</b></li>';}
					if (trim($_POST['ind'])==''){$error.='<li>'. $this->LANG['confcomp']['master_error1'] .' <b>'. $this->LANG['confcomp']['master_2_ind'] .'</b></li>';}
					if (!lat($_POST['ind'])){ $error.='<li> <b>'. $this->LANG['confcomp']['master_2_ind_note'] .'</b></li>'; }
					
					if ($error==''){
						
						if ( $field['id']=='' || ($field['ind']!=$_POST['ind']) ){
						
							$fields = $this->_Q->QW("SHOW FIELDS FROM `<||>mycomp__".$mycomp['ind']."`");
							
							foreach ($fields as $i=>$row){
								
								if ( $row[0]==trim($_POST['ind'])){ $error.='<li>'.$this->LANG['confcomp']['master_error4'].'</li>'; }
								
							}
						
						}
						
					}
					
					if ($error==''){
						
						
						/**
						 * Создаем поле в таблице
						 * Создаем запись в реестре полей
						 */
	
						$n = $_POST['type'];
						
						//print_r($type);
						
						if ( !array_key_exists($n,$type) ){
							
							$error.='<li>'.$this->LANG['confcomp']['master_error5'].'</li>';
							
						}
						
						if ( $error=='' ){
							
							if ($field['id']==''){
								$this->_Q->Q("ALTER TABLE `<||>mycomp__".$mycomp['ind']."` ADD `".$this->_Q->e($_POST['ind'])."` ".$type[$n]);
							}else{
								if ($field['ind']!=$_POST['ind'] || $field['type']!=$_POST['type']){
									$this->_Q->Q("ALTER TABLE `<||>mycomp__".$mycomp['ind']."` CHANGE  `".$field['ind']."` `".$this->_Q->e($_POST['ind'])."` ".$type[$n]);
								}
							}
							
							if ($this->_Q->_error!=''){ $error.='<li>'.$this->_Q->_error.'</li>'; $error.='<li><b>'.$this->_Q->_sql.'</b></li>'; }else{
								
								
								$last = $this->_Q->QA("SELECT * FROM <||>dgcomponent__fields WHERE `comp`=".$mycomp['id']." ORDER BY `order` DESC LIMIT 1 ");
								
								$arr['comp'] = $mycomp['id'];
								$arr['name'] = $_POST['name'];
								$arr['ind'] = $_POST['ind'];
								$arr['des'] = $_POST['des'];
                                

                                $arr['main']=$_POST['main'];

                                
                                
								if ($field['id']==''){
								
									$arr['order'] = $last['order']+1;	
									$arr['type'] = $n;
									$arr['format'] = $format[$n];										
								
								}else{
								
									if ($field['ind']!=$_POST['ind']  || $field['type']!=$_POST['type']){
										$arr['type'] = $n;
										$arr['format'] = $format[$n];											
									}	
									
								}
															
								
								
								foreach($arr as $i=>$v){ $arr[$i] = htmlspecialchars_decode($v); }
								
								
								$this->_Q->_table = "dgcomponent__fields";
								$this->_Q->_arr = $arr;
								if ($field['id']==''){
									$last_id = $this->_Q->QI();
								}else{
									$this->_Q->_where = "WHERE `id`=".$field['id'];
									$this->_Q->QU(); 
									$last_id = $field['id'];
								}
								header("Location:"._URL_."master:2:1&&mycomp=".$mycomp['id']."&field=".$last_id);
								
							}
								
						}
					
						
					}
					
					if ($error!=''){
						
						
						foreach($_POST as $i=>$v){$field[$i]=$v;}
						
						?>
						
						<div class="dg_error"><?=$error?></div>
						
						<?
						
					}
					
					
				}
			
			
			?>
			
			<p><?=$this->LANG['confcomp']['master_2_name']?><br /><input type="text" name="name" value="<?=htmlspecialchars($field['name'])?>" /></p>
			<p><?=$this->LANG['confcomp']['master_2_ind']?><br /><span class="comment"><?=$this->LANG['confcomp']['master_2_ind_note']?></span><br /><input type="text" name="ind" value="<?=htmlspecialchars($field['ind'])?>" /> <label> <input type="checkbox" name="main" value="1" <? if ($field['main']==1){ echo ' checked '; } ?> /> <?=$this->LANG['confcomp']['master_2_main']?></label></p>
			<p><?=$this->LANG['confcomp']['master_2_type']?> <select name="type"><?
			
			
			if (is_array($this->LANG['confcomp']['types'])){
				
				
				foreach ($this->LANG['confcomp']['types'] as $i=>$v){
					
					?>
					<option value="<?=$i?>"<? if ($i==$field['type']){ echo ' selected="selected" '; } ?>><?=$v?></option>
					<?
				}
				
			}
			
			?></select> <? if ($field['id']!=''){ ?> <br /><b><?=$this->LANG['confcomp']['master_2_type_note']?></b> <? } ?></p>
			
			
			<p><?=$this->LANG['confcomp']['master_2_des']?><br /><textarea name="des"><?=htmlspecialchars($field['des'])?></textarea></p>
			
 
			
	    	<p>
				<input type="submit" name="go" value="<?=$this->LANG['main']['next']?>" />
			</p>			
			
			</div>
         </form>
			 		
		<?
	  }	
	}	
	
	
	if ($this->_func=='master:2:1'){//TODO:master:2:1
		
		/**
		 * формат поля от его типа
		 */
		
		if ( $field['id']=='' ){
			
			echo $this->LANG['confcomp']['field_not_found'];
			
		}else{
			
			$ex = explode('|',$field['format']);
				 $this->_right.='<li style="background:url(/dg_system/dg_img/icons/add.png) no-repeat left center;"><a href="'._URL_.'master:2:0&mycomp='.$mycomp['id'].'">'.$this->LANG['confcomp']['master_2_new'].'</a></li>
 	 ';
	 $this->_right.='<div class="r"></div>';
			
			?>
			
		 <h2><?=$this->LANG['confcomp']['master']?></h2>
		 <h3><b><?=$mycomp['name']?></b>: <?=$this->LANG['confcomp']['master_2_setting']?>  <?=$field['name']?> (<?=$field['ind']?>)</h3>	
		 <div class="help"><?=$help['master:2:1']?></div><p>&nbsp;</p>
		 <form method="post"> <?=$this->_security->creat_key()?>
		 	<div class="dg_form">
		 	
		 		<?
		 		
		 		
		 		if ( array_key_exists('go',$_POST) ){
		 			
		 			
		 			foreach($_POST as $i=>$v){ $_POST[$i] = htmlspecialchars_decode($v); }
		 			$error='';
		 			
		 			/*меняем формат и вносим изменения в реестр*/
		 			
		 			
		 			
		 			if ( $field['type']=='varchar'){
		 				
		 				$this->_Q->Q("ALTER TABLE `<||>mycomp__".$mycomp['ind']."` CHANGE `".$field['ind']."` `".$field['ind']."` varchar(".$this->_Q->e($_POST['f0']).")");
		 				$error = $this->_Q->_error;					
		 				
		 			}
		 			if ( $field['type']=='int'){		 				
		 				$d='';
		 				
		 				if (trim($_POST['def'])!=''){
		 					
		 					$d = " DEFAULT '".$this->_Q->e($_POST['def'])."'";
		 				}
		 				
		 				$this->_Q->Q("ALTER TABLE `<||>mycomp__".$mycomp['ind']."` CHANGE `".$field['ind']."` `".$field['ind']."` int(".$this->_Q->e($_POST['f0']).")".$d);
		 				$error = $this->_Q->_error;					
		 				
		 			}		 			
		 			if ( $field['type']=='float'){
		 				$d='';
		 				
		 				if (trim($_POST['def'])!=''){
		 					
		 					$d = " DEFAULT '".$this->_Q->e( str_replace(',','.',$_POST['def']) )."'";
		 				}		 				
		 				$this->_Q->Q("ALTER TABLE `<||>mycomp__".$mycomp['ind']."` CHANGE `".$field['ind']."` `".$field['ind']."` float(".$this->_Q->e($_POST['f0']).",".$this->_Q->e($_POST['f3']).")".$d);
		 				$error = $this->_Q->_error;					
		 				
		 			}		 			
		 			if ($error==''){
		 				
								
								$str = '';
								
								foreach ($_POST as $i=>$v){
									
									if ( $i{0}=='f' ){
										
										$str.=$v.'|';
										
									}
									
								}	 				
		 				
								$this->_Q->_table = "dgcomponent__fields";
								$this->_Q->_arr = array('format'=>$str,'def'=>$_POST['def']);
								$this->_Q->_where = " WHERE `id`=".$field['id'];
								$this->_Q->QU();
		 						header("Location:"._URL_."master:2&mycomp=".$mycomp['id']);
		 				
		 			}else{
		 				
		 				
		 				echo '<div class="dg_error">'.$error.'</div>';
		 				
		 				
		 			}
		 			
		 			
		 		}
		 		
				 
				if ( is_array($this->LANG['confcomp']['format'][$field['type']]) ){
					
					
					foreach ($this->LANG['confcomp']['format'][$field['type']] as $i=>$v){
						
						
						
							if ($field['type']=='memo' || $field['type']=='list' ){
								
								if ($field['type']=='memo'){
									
								$ch='';
								if ( $ex[$i]=='edit' ){ $ch=' checked="checked" '; }	
	 							echo '<p><label>';
	 							echo '<input type="checkbox" name="f'.$i.'" value="edit" '.$ch.' />';
	 							echo ' '.$v.'</label></p>';									
									
									
								}
								
								if ($field['type']=='list'){
									
									
	 							echo '<p>'.$v;
	 							echo '<textarea name="f'.$i.'">'. htmlspecialchars($ex[$i]) .'</textarea>';
	 							echo '</p>';									
									
									
								}
								

								
							}else{
						 
 							   if ($i==0 && ($field['type']=='date' || $field['type']=='time' || $field['type']=='datetime')){
 									$ch='';
								if ( $ex[$i]=='1' ){ $ch=' checked="checked" '; }						   	
 	 							echo '<p><label>';
	 							echo '<input type="checkbox" name="f'.$i.'" value="1" '.$ch.' />';
	 							echo ' '.$v.'</label></p>';							
								 	   	
 							   }else{
 							   
	 							echo '<p>'.$v.'<br />';
	 							echo '<input type="text" name="f'.$i.'" value="'. htmlspecialchars($ex[$i]) .'" />';
	 							echo '</p>';
							   }
							   
							    
							}
					}
					
					
				}
				
				
				if ($def[$field['type']]){
					
					
					?> <p><?=$this->LANG['confcomp']['def']?><br /> <input type="text" name="def" value="<?= htmlspecialchars($field['def'])?>" /> </p> <?
				}
				
				
				 
				 ?>
	    	<p>
				<input type="submit" name="go" value="<?=$this->LANG['main']['next']?>" />
			</p>			 		
		 		
		 		
		 		
			</div>
		 </form>		
			
			
			<?
			
		}
		
	}
	
	
	if ($this->_func=='master:2:2'){//TODO:master:2:2
		
		/**
		 * удаляем поле
		 */
				if ( $field['id']=='' ){
			
			echo $this->LANG['confcomp']['field_not_found'];
			
		}else{
			
				 $this->_right.='<li style="background:url(/dg_system/dg_img/icons/add.png) no-repeat left center;"><a href="'._URL_.'master:2:0&mycomp='.$mycomp['id'].'">'.$this->LANG['confcomp']['master_2_new'].'</a></li>
 	 ';
	 $this->_right.='<div class="r"></div>';
			
			
			
				$error='';
				
				if ($this->accesspassword()){
				
					if ( $fd[$field['ind']] ){
						
						$this->_Q->Q("ALTER TABLE `<||>mycomp__".$mycomp['ind']."` DROP `".$this->_Q->e($field['ind'])."`");
						$error = $this->_Q->_error;
					}
					
					if ($error==''){
						
						$this->_Q->_where = "WHERE `id`=".$field['id'];
						$this->_Q->_table = 'dgcomponent__fields';
						$this->_Q->QD();
						header("Location:"._URL_."master:2&mycomp=".$mycomp['id']);
						
					}else{
						
						?> <div class="dg_error"><?=$error?></div> <?
						
					}
			  	header("Location:"._URL_."master:2&mycomp=".$mycomp['id']);
              }	
			
			
		
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	/**
	 * 
	 * 
	  
	 * 
	 * 
	 * работа
	 * с 
	 * шаблонами
	 * компонента
	 * 
	 * 
	 * 
	 * 
	 * 
	 */
	 
	 
	 
	 
	 
	 
	 if ($this->_func=='master:3'){//TODO:master:3
	 	
	 	/**
	 	 * список шаблонов
	 	 */
	 	 if ( $mycomp['id']=='' ){
			
			echo $this->LANG['confcomp']['comp_not_found'];
			
		}else{
	 	 
	 	 $this->_right.='<li style="background:url(/dg_system/dg_img/icons/add.png) no-repeat left center;"><a href="'._URL_.'master:3:0&mycomp='.$mycomp['id'].'">'.$this->LANG['confcomp']['master_3_new'].'</a></li> <div class="r"></div>';
	 	 
	 	 ?>
		  
		  
		 <h2><?=$this->LANG['confcomp']['master']?></h2>
		 <h3><b><?=$mycomp['name']?></b>: <?=$this->LANG['confcomp']['master_3']?></h3>
         <div class="help"><?=$help['master:3']?></div><p>&nbsp;</p>
		  
		  <?
	 	 
	 	 $total='';
			  $opendir = opendir ( _LOC_.'_tpl/');
		      while ( $file = readdir ($opendir))
		      {
		        if (( $file != ".") && ($file != "..") && (is_dir( _LOC_.'_tpl/'.$file)) && $file!='.svn')
		        {
		          $total.='<li>';
		          
		          $total.='<span style="width:660px;background:url(/dg_system/dg_img/icons/palette.png) no-repeat left center;"><a href="'._URL_.'master:3:1&mycomp='.$mycomp['id'].'&tpl='.$file.'">'.$file.'</a></span>';
		          $total.='<span style="width:20px;"><a href="'._URL_.'master:3:0&mycomp='.$mycomp['id'].'&tpl='.$file.'"><img src="/dg_system/dg_img/icons/cog.png" title="'.$this->LANG['confcomp']['master_3_setting'].'"></a></span>';
		          $total.='<span style="width:20px;"><a href="'._URL_.'master:3:2&mycomp='.$mycomp['id'].'&tpl='.$file.'&re='.urlencode($_SERVER["REQUEST_URI"]).'" class="removeaccess"><img src="/dg_system/dg_img/icons/cross.png" title="'.$this->LANG['main']['remove'].'"></a></span>';
		          
		          $total.='</li>';
		        }
		      }
		      closedir ($opendir);
    
	 	  if ($total!=''){
	 	  	?> <div class="dg_list"><?=$total?></div> <?
	 	  }else{
	 	  	echo $this->LANG['confcomp']['master_3_nofields'];
	 	  }
	 	 
	 	}
	 }
	 
	 
	 if ($this->_func=='master:3:0'){//TODO:master:3:0
	 	
		 /**
	 	 * создаем / редактируем шаблон
		 */
		 
	 	 if ( $mycomp['id']=='' ){
			
			echo $this->LANG['confcomp']['comp_not_found'];
			
		}else{		 
		 
$this->_right.='<li style="background:url(/dg_system/dg_img/icons/add.png) no-repeat left center;"><a href="'._URL_.'master:3:0&mycomp='.$mycomp['id'].'">'.$this->LANG['confcomp']['master_3_new'].'</a></li> <div class="r"></div>';
	 	 
		 
		 ?>
		 
		 <h2><?=$this->LANG['confcomp']['master']?></h2>
		 <h3><b><?=$mycomp['name']?></b>: <?=$this->LANG['confcomp']['master_3_new']?></h3>
		 
		 <form method="post"> <?=$this->_security->creat_key()?>
		 
		 	<div class="dg_form">
		 	
		 	<?
		 	
		 	$file = new dg_file;
		 	
			if ($_GET['tpl']!='' && file_exists(_LOC_.'_tpl/'.$_GET['tpl'].'/')) {
				
				$inf['name'] = $_GET['tpl'];
				$dir = _LOC_.'_tpl/'.$_GET['tpl'].'/';
				$inf['des'] = htmlspecialchars($file->read($dir.'readme.txt'));
				
			}
			 
		if ( array_key_exists('go',$_POST) ){
		 	
		 	
		 	$error='';
		 	
		 	if ($inf['name']==''){
		 		if ( trim($_POST['name'])=='' ){ $error.='<li>'.$this->LANG['confcomp']['master_error1'].' <b>'.$this->LANG['confcomp']['master_3_name'].'</b></li>'; }
		 		if ( !lat($_POST['name']) ){$error.='<li>'.$this->LANG['confcomp']['master_3_name_note'].'</li>';}
		 	}
		 	if ( $error=='' ){
		 		
		 		
		 		if ( file_exists( _LOC_.'_tpl/'.$_POST['name'] ) ){ $error.='<li>'.$this->LANG['confcomp']['master_error2'] .'</li>'; }
		 		
		 	}
		 	
		 	
		 if ($inf['name']==''){	
		 	if ($error==''){
		 		
		 		$dir = _LOC_.'_tpl/'.$_POST['name'].'/';
		 		 
	 		    $fc = new dg_file;
						$fc->createdir($dir);
	 		    
	 		    
	 		    
		 		
		 		
		 		$file->create($dir.'readme.txt', htmlspecialchars_decode($_POST['des']) );
		 		
		 		
		 		/**
		 		 * 
		 		 * 
		 		 * prefix
		 		 * sufix
		 		 * content
		 		 * sql
		 		 * 
		 		 * 
		 		 */
		 		 
		 		 $file->create($dir.'list.prefix.sys.php','');
		 		 $file->create($dir.'list.sufix.sys.php','<?=page_parse($p[$page]["max"],$total)?>');
		 		 $file->create($dir.'list.content.sys.php','<div id="l_<?=$row["id"]?>">'."\n".'</div>');
				 $file->create($dir.'list.sql.sys.php','<? $sql = "SELECT * FROM `".$table."` WHERE `sys_show`=1 AND `sys_page`=".$page." ORDER BY `sys_order` ".$limit; ?>');
	             $file->create($dir.'admin.sql.sys.php','<? $sql = "SELECT * FROM `".$table."` WHERE `sys_page`=".$page." ORDER BY `sys_order` ".$limit; ?>');
	  
		 		 
				 $file->create($dir.'one.prefix.sys.php','');
		 		 $file->create($dir.'one.sufix.sys.php','<p><a href="<?=$p[$page]["url"]?>"><?=$p[$page]["name"]?></a></p>');
		 		 $file->create($dir.'one.content.sys.php','<div id="o_<?=$row["id"]?>">'."\n".'</div>');
		 		 $file->create($dir.'one.sql.sys.php','<? $sql = "SELECT * FROM `".$table."` WHERE `sys_show`=1 AND `sys_page`=".$page." AND `id`='."'".'".$object."'."'".' LIMIT 1" ?>');
				 
				 $file->create($dir.'main.css','');
				 $file->create($dir.'main.js','');
		 		
				 $file->create($dir.'after.sys.php','');
				 $file->create($dir.'before.sys.php','');	
				 
				 header("Location:"._URL_."master:3:1&mycomp=".$mycomp['id'].'&tpl='.$_POST['name']); 		
		 		
		 	}else{
		 		
		 		foreach ($_POST as $i=>$v){ $inf[$i]=$v; }
		 		
		 		?> <div class="dg_error"><?=$error?></div> <?
		 	}
		 	
		 	}else{
		 	 header("Location:"._URL_."master:3:1&mycomp=".$mycomp['id'].'&tpl='.$inf['name']);	
		 	}
		 	
		 	
		 	
		 	
		 }
			 
			 
			 ?>
		 	
		 	<p><?=$this->LANG['confcomp']['master_3_name']?><br /><span class="comment"><?=$this->LANG['confcomp']['master_3_name_note']?></span><br />
				<input type="text" name="name" value="<?=$inf['name']?>" <? if ($_GET['tpl']!='' && file_exists(_LOC_.'_tpl/'.$_GET['tpl'].'/')) { ?> disabled="disabled" <? } ?> /> 
			</p>
			<p><?=$this->LANG['confcomp']['master_3_des']?><br />
				<textarea name="des"><?=$inf['des']?></textarea>
			</p>
			
	    	<p>
				<input type="submit" name="go" value="<?=$this->LANG['main']['next']?>" />
			</p>			
		 	</div>
		 </form>		 
		 
		 <? 
	 	
	  }	
	 }
	 
	 
	 
	 if ($this->_func=='master:3:1'){//TODO:master:3:1
	 	
		 /**
	 	 * настройки шаблона
		 */
		 
	 	 if ( $mycomp['id']=='' ){
			
			echo $this->LANG['confcomp']['comp_not_found'];
			
		}else{	
		
		
			if ($_GET['tpl']=='' || !file_exists(_LOC_.'_tpl/'.$_GET['tpl'].'/')){
				
			echo $this->LANG['confcomp']['tpl_not_found'];		
				
			}else{
				
				$this->_right.='<li style="background:url(/dg_system/dg_img/icons/add.png) no-repeat left center;"><a href="'._URL_.'master:3:0&mycomp='.$mycomp['id'].'">'.$this->LANG['confcomp']['master_3_new'].'</a></li> <div class="r"></div>';
	 	 				
				$dir = _LOC_.'_tpl/'.$_GET['tpl'].'/';
				$file = new dg_file;
				
				
				
				if (array_key_exists('load',$_POST)){
					
					 
					 
			 		 $file->create($dir.'list.prefix.sys.php',htmlspecialchars_decode($_POST['list_prefix']));
			 		 $file->create($dir.'list.sufix.sys.php', htmlspecialchars_decode($_POST['list_sufix']) );
			 		 $file->create($dir.'list.content.sys.php',htmlspecialchars_decode($_POST['list_content']));
					 $file->create($dir.'list.sql.sys.php',htmlspecialchars_decode($_POST['list_sql']));
                     $file->create($dir.'admin.sql.sys.php',htmlspecialchars_decode($_POST['admin_sql']));
		
			 		 
					 $file->create($dir.'one.prefix.sys.php',htmlspecialchars_decode($_POST['one_prefix']));
			 		 $file->create($dir.'one.sufix.sys.php',htmlspecialchars_decode($_POST['one_sufix']));
			 		 $file->create($dir.'one.content.sys.php',htmlspecialchars_decode($_POST['one_content']));
			 		 $file->create($dir.'one.sql.sys.php',htmlspecialchars_decode($_POST['one_sql']));
					 
					 $file->create($dir.'main.css',htmlspecialchars_decode($_POST['css']));
					 $file->create($dir.'main.js',htmlspecialchars_decode($_POST['js']));
			 		
					 $file->create($dir.'after.sys.php',htmlspecialchars_decode($_POST['after']));
					 $file->create($dir.'before.sys.php',htmlspecialchars_decode($_POST['before']));					
					
					if ($this->_ajax){ echo 'ok'; exit; }
				}

			?>
			
			
<h2><?=$this->LANG['confcomp']['master']?></h2>
<h3><b><?=$mycomp['name']?></b>: <?=$this->LANG['confcomp']['master_3_setting']?> <?=$_GET['tpl']?></h3>

<div class="help"><?=$help['master:3:1']?></div><p>&nbsp;</p>


<script type="text/javascript" src="/dg_system/dg_js/markitup/jquery.markitup.pack.js"></script>
<link rel="stylesheet" type="text/css" href="/dg_system/dg_js/markitup/skins/simple/style.css" />		 			 
<script type="text/javascript" src="/dg_system/dg_js/markitup/sets/default/set.js"></script>
<link rel="stylesheet" type="text/css" href="/dg_system/dg_js/markitup/sets/default/style.css" />				 			 
		 			 
		 			 
	<script type="text/javascript">
	$(function() {
		$("#tabs textarea").markItUp(mySettings);
		$("#tabs").tabs();
		
	});
	</script>	 
	
   <form method="post" class="ajax"  autocomplete="off">	 <?=$this->_security->creat_key()?>
   <input type="hidden" name="load" value="1" />
	 <div class="dg_form">			 
				<div id="tabs">
					<ul>
						<li><a href="#tabs-1" class="ct"><?=$this->LANG['confcomp']['master_3_file_list']?></a></li>
						<li><a href="#tabs-2" class="ct"><?=$this->LANG['confcomp']['master_3_file_one']?></a></li>
						<li><a href="#tabs-3" class="ct"><?=$this->LANG['confcomp']['master_3_file_cssjs']?></a></li>
						<li><a href="#tabs-4" class="ct"><?=$this->LANG['confcomp']['master_3_file_kernel']?></a></li>
					</ul>
					<div id="tabs-1">
					
					
					<p><?= $this->LANG['confcomp']['master_3_file_prefix']?><br />
						<textarea name="list_prefix"><?=htmlspecialchars($file->read($dir.'list.prefix.sys.php'))?></textarea>
					</p>
					<p><?= $this->LANG['confcomp']['master_3_file_content']?><br />
						<textarea name="list_content"><?=htmlspecialchars($file->read($dir.'list.content.sys.php'))?></textarea>
					</p>					
					<p><?= $this->LANG['confcomp']['master_3_file_sufix']?><br />
						<textarea name="list_sufix"><?=htmlspecialchars($file->read($dir.'list.sufix.sys.php'))?></textarea>
					</p>
					<p><?= $this->LANG['confcomp']['master_3_file_sql']?><br />
						<textarea name="list_sql"><?=htmlspecialchars($file->read($dir.'list.sql.sys.php'))?></textarea>
					</p>
					<p><?= $this->LANG['confcomp']['master_3_file_admin_sql']?><br />
						<a name="adminsql"></a><textarea name="admin_sql"><?=htmlspecialchars($file->read($dir.'admin.sql.sys.php'))?></textarea>
					</p>					
						
					</div>
					<div id="tabs-2">
				
					<p><?= $this->LANG['confcomp']['master_3_file_prefix']?><br />
						<textarea name="one_prefix"><?=htmlspecialchars($file->read($dir.'one.prefix.sys.php'))?></textarea>
					</p>
					<p><?= $this->LANG['confcomp']['master_3_file_content']?><br />
						<textarea name="one_content"><?=htmlspecialchars($file->read($dir.'one.content.sys.php'))?></textarea>
					</p>					
					<p><?= $this->LANG['confcomp']['master_3_file_sufix']?><br />
						<textarea name="one_sufix"><?=htmlspecialchars($file->read($dir.'one.sufix.sys.php'))?></textarea>
					</p>
					<p><?= $this->LANG['confcomp']['master_3_file_sql']?><br />
						<textarea name="one_sql"><?=htmlspecialchars($file->read($dir.'one.sql.sys.php'))?></textarea>
					</p>
						
					
					</div>
					<div id="tabs-3">
					<p><?= $this->LANG['confcomp']['master_3_file_css']?><br />
						<textarea name="css"><?=htmlspecialchars($file->read($dir.'main.css'))?></textarea>
					</p>
					<p><?= $this->LANG['confcomp']['master_3_file_js']?><br />
						<textarea name="js"><?=htmlspecialchars($file->read($dir.'main.js'))?></textarea>
					</p>			
					</div>
					<div id="tabs-4">
		
					<p><?= $this->LANG['confcomp']['master_3_file_after']?><br />
						<textarea name="after"><?=htmlspecialchars($file->read($dir.'after.sys.php'))?></textarea>
					</p>
					<p><?= $this->LANG['confcomp']['master_3_file_before']?><br />
						<textarea name="before"><?=htmlspecialchars($file->read($dir.'before.sys.php'))?></textarea>
					</p>		
					</div>
				</div>	
			<p>&nbsp;</p>	
			<p><input type="submit" name="save" value="<?=$this->LANG['main']['save']?>" /> 

	<input type="reset" name="reset" value="<?=$this->LANG['main']['cancel']?>" /></p>		
				
	  </div>				 			 
	</form>		
			<?				
				
				
				
			}
			
		}	
	}	 
	 
	 
	 if ($this->_func=='master:3:2'){//TODO:master:3:2
	 	/**
	 	 * удаление шаблона
	 	 */
	 	if ( $mycomp['id']=='' ){
			
			echo $this->LANG['confcomp']['comp_not_found'];
			
		}else{	
		
		
			if ($_GET['tpl']=='' || !file_exists(_LOC_.'_tpl/'.$_GET['tpl'].'/')){
				
			 echo $this->LANG['confcomp']['tpl_not_found'];		
				
			}else{

    			if ($this->accesspassword()){
    				
    				
    					$f = new dg_file;
    					$f->full_del_dir(_LOC_.'_tpl/'.$_GET['tpl']);
    				
    				header("Location:"._URL_."master:3&mycomp=".$mycomp['id']);
    			}
				
			}
		}	
	
	 	
	 }
	 
	 
	 
	 
	 
	 
	 /**
	  * 
	  * 
	  * 
	  * 
	  * 
	  * экспорт
	  * 
	  * 
	  * 
	  * 
	  * 
	  */
	  
	  
	  if ($this->_func=='master:4'){//TODO:master:4
	  	/**
	  	 * экспортируем компонент
	  	 */
	  	
	 	 if ( $mycomp['id']=='' ){
			
			echo $this->LANG['confcomp']['comp_not_found'];
			
		}else{
	 	 
	 	 
	 	 
	 	 ?>
		  
		  
		 <h2><?=$this->LANG['confcomp']['master']?></h2>
		 <h3><b><?=$mycomp['name']?></b>: <?=$this->LANG['confcomp']['master_4']?></h3>
		 
		 <form method="post"> <?=$this->_security->creat_key()?>
		 	<div class="dg_form">
		 	
		 	<?
			 
			 
			 if (array_key_exists('go',$_POST)){
			 	/*информация*/
			 	$info= _VER_."--info--";
			 	$info.= $this->ver."--info--";
				$info.= str_replace($this->inf['info']['dir'],'%dir%',$mycomp['ico']) ."--info--";
			 	$info.=$mycomp['des'];
			 	
			 	/*структура таблицы*/
			 	
			 	$sql='';
			 	
			 	$QW = $this->_Q->QW("SHOW FIELDS FROM `<||>mycomp__".$mycomp['ind']."`");
			 	
			 	foreach ($QW as $i=>$row){
					$d='';			 	
					if ($row[4]!=''){ $d=" DEFAULT '".$row[4]."'"; }
					
					if ($row[0]!='id'){
						$sql.='		`'.$row[0].'` '.$row[1].$d.' '.",\n";
			 		}
			 	}
			 	
			 	
			 	$sql="	CREATE TABLE IF NOT EXISTS %table%
		(id int(6) NOT NULL auto_increment,
".$sql."		PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;[end]\n";
			 	
			    
				
				$fields_row='';
			 	$QW = $this->_Q->QW("SELECT * FROM <||>dgcomponent__fields WHERE `comp`=".$mycomp['id']);

			 	
			 	foreach ($QW as $i=>$row){
						$sql.="INSERT INTO <||>dgcomponent__fields (`comp`,`name`,`ind`,`des`,`type`,`def`,`format`,`order`,`show`) VALUES ('%comp_id%','".$this->_Q->e($row['name'])."','".$this->_Q->e($row['ind'])."','".$this->_Q->e($row['des'])."','".$this->_Q->e($row['type'])."','".$this->_Q->e($row['def'])."','".$this->_Q->e($row['format'])."','".$this->_Q->e($row['order'])."','".$this->_Q->e($row['show'])."');[end]\n";

			 	}				
				
				$GLOBALS['comp']['dir']='';
				$GLOBALS['comp']['files']='';
				
				function treecompfile($s){
					
					
					
							$dir = opendir ($s);
		       while ( $file = readdir ($dir))
		       {
		         if (( $file != ".") && ($file != ".."))
		         {
		          	if (is_file($s.'/'.$file)){ $GLOBALS['comp']['files'][]=str_replace('//','/',$s.'/'.$file); } 
		          	if (is_dir($s.'/'.$file) && $file!='.svn'){ $GLOBALS['comp']['dir'][]=str_replace('//','/',$s.'/'.$file); treecompfile($s.'/'.$file); }
		         }
		       }
		       closedir ($dir);
     
					
					
					
				}
				treecompfile(_LOC_);
				
			$fc = new dg_file;
						$fc->createdir(_DR_.'/temp');
				$name = 'mycomp_'.$mycomp['ind'].'_'.time();
				
				if ( is_array($GLOBALS['comp']['dir']) && is_array($GLOBALS['comp']['files']) ){
				$zip = new ZipArchive;
				
			    
					    
					    foreach ($GLOBALS['comp']['dir'] as $i=>$v){
					     	if ($zip->open(_DR_.'/temp/'.$name.'.zip', ZipArchive::CREATE) === TRUE) {	
								    	if($zip->addEmptyDir(str_replace(_LOC_,'',$v))) {
								    		
								    	}else{
								    		echo 'error addEmptyDir: '.str_replace(_LOC_,'',$v); 
											exit;
								    	}
								    	$zip->close();
					    	}else{ 
					    		echo 'error: zip->open: '._DR_.'/temp/'.$name.'.zip'; 
								exit; }
					    }
                        
					    
					    foreach ($GLOBALS['comp']['files'] as $i=>$v){
					     	if ($zip->open(_DR_.'/temp/'.$name.'.zip', ZipArchive::CREATE) === TRUE) {	

										$zip->addFile($v, str_replace(_LOC_,'',$v));
								    	$zip->close();
					    	}else{ 
					    		echo 'error: zip->open: '._DR_.'/temp/'.$name.'.zip'; 
								exit; }
					    }	
						
						
							if ($zip->open(_DR_.'/temp/'.$name.'.zip', ZipArchive::CREATE) === TRUE) {	

										$zip->addFromString('info.txt', $info);
										$zip->addFromString('db.sql', $sql);
								    	$zip->close();
					    	}else{ 
					    		echo 'error: zip->open: '._DR_.'/temp/'.$name.'.zip'; 
								exit; }				    
					    
					    dg_file::chmod('/temp/'.$name.'.zip');
					    header("Location:/temp/".$name.'.zip');
				 
				
			 }	
			 }
			 
			 
			 
			 ?>
		 	
		 	
		 	<p><?=$this->LANG['confcomp']['master_4_go']?></p>
	    	<p>
				<input type="submit" name="go" value="<?=$this->LANG['main']['next']?>" />
			</p>		 		
		 	</div>
		 </form>
		  
		  <?	  	
	  	
	  	}
	  	
	  	
	  }
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  /**
	   * 
	   * 
	   * 
	   * 
	   * 
	   * Удаление
	   * 
	   * 
	   * 
	   * 
	   */
	   
	   
	   if ($this->_func=='master:5'){//TODO:master:5
	   	
	   	
	 	 if ( $mycomp['id']=='' ){
			
			echo $this->LANG['confcomp']['comp_not_found'];
			
		}else{
	 	 
	 	 
	 	 
	 	 ?>
		  
		  
		 <h2><?=$this->LANG['confcomp']['master']?></h2>
		 <h3><b><?=$mycomp['name']?></b>: <?=$this->LANG['confcomp']['master_5']?></h3>
		 
		 
		 	
		<?
        
        if ($this->accesspassword()){
            
            $this->_Q->Q("DROP TABLE `<||>mycomp__".$mycomp['ind']."`");
            if ($this->_Q->_error==''){
            $this->_Q->_table = "pages";
            $this->_Q->_arr = array('comp'=>'system:static');
            $this->_Q->_where = "WHERE `comp` LIKE 'conf:".$mycomp['ind'].":%'";
            $this->_Q->QU();
            
            $this->_Q->_table = "dgcomponent__regedit";
            $this->_Q->_where = "WHERE `id`=".$mycomp['id'];
            $this->_Q->QD();
            
            $f = new dg_file;
            $f->full_del_dir(_LOC_);
            
            header('Location:'._URL_.'index');
            }else{
                echo $this->_Q->_error;
            }
            
        }
        
		}
	   }
	  
	  
	  
	
	
	
	/**
	 * меню
	 */
	 
	 if ( substr_count($this->_func,'master:')===1 && $mycomp['id']!='' && $this->_func!='master:0' ){
	 	
	 	$this->_right.='
		 <h3>'.$mycomp['name'].'</h3>
		 
 	 				    <li style="background:url(/dg_system/dg_img/icons/application_view_list.png) no-repeat left center;"><a href="'._URL_.'master:2&mycomp='.$mycomp['id'].'">'.$this->LANG['confcomp']['master_2'].'</a></li>
 	 					<li style="background:url(/dg_system/dg_img/icons/application_view_gallery.png) no-repeat left center;"><a href="'._URL_.'master:3&mycomp='.$mycomp['id'].'">'.$this->LANG['confcomp']['master_3'].'</a></li>
	  					<li style="background:url(/dg_system/dg_img/icons/application_go.png) no-repeat left center;"><a href="'._URL_.'master:4&mycomp='.$mycomp['id'].'">'.$this->LANG['confcomp']['master_4'].'</a></li>
	  
	  ';
	 	
	 }
}
?>