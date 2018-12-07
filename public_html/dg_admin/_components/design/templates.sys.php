<?

/**
 * @author Maltsev Vladimir
 * @copyright 2009
 * 
 */
 if ($this->access('templates','access')){
define(_URL_,'/dg_admin/?comp=design&use=templates&func=');
$info = dg_source();
$this->_right='


<h2>'.$this->LANG['compdesign']['designname'].'</h2>
<li style="background:url(/dg_system/dg_img/icons/add.png) no-repeat left center;"><a href="'._URL_.'update">'.$this->LANG['compdesign']['title_update_create'].'</a></li>
';

if ($this->_func=='index'){//TODO:index
	
/**
 * Список дизайн-шаблонов
 */	

	
	
	?>
	
	<h2><?=$this->LANG['compdesign']['designname']?></h2>
	
	<div class="help"><?=$help['index']?></div><p>&nbsp;</p>
	
	<?
	
	$total='';
 				$dir = opendir (_DR_.'/_tpl/'.$info['info']['dir']);
  						while ( $file = readdir ($dir))
  						{
    						if (( $file != ".") && ($file != "..") && ( is_dir(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$file)) && (file_exists(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$file.'/index.dg.php')) && $file!='.svn' )
    							{
									 
									 $total.="\n".'<li><span style="width:640px;background:url(/dg_system/dg_img/icons/palette.png) no-repeat left center;"><a href="'._URL_.'update&tpl='.$file.'">'.$file.'</a></span>';
									 $total.='		
									 
									 <span style="width:20px;"><a href="'._URL_.'incl&w=css&tpl='.$file.'" id="css"><img src="/dg_system/dg_img/icons/page_white_css.png" title="'.$this->LANG['main']['list'].' CSS" align="absmiddle" /></a></span> 
									 <span style="width:20px;"><a href="'._URL_.'incl&w=js&tpl='.$file.'"  id="js"><img src="/dg_system/dg_img/icons/page_white_js.png" title="'.$this->LANG['main']['list'].' JS" align="absmiddle"/></a></span> 
									 <span style="width:20px;"><a href="'._URL_.'remove&tpl='.$file.'&re='.urlencode($_SERVER["REQUEST_URI"]).'" id="remove" class="removeaccess"><img src="/dg_system/dg_img/icons/cross.png" title="'.$this->LANG['main']['remove'].'" align="absmiddle" /></a></span> ';
									 
									 $total.='</li>';
									 								
    							}
  						}
  				closedir ($dir);	
  				
  	if ($total!=''){			
	
   ?>
   
   <div class="dg_list"><?=$total?></div>
   
   <?
   
   }else{
   	
   echo '<p>'.	$this->LANG['compdesign']['title_not_found'].'</p>';
   	
   }
	
}


if ($this->_func=='update'){//TODO:update
	/**
	 * создаем, редактируем файл шаблона
	 * если в GET есть tpl, то редактируем
	 */
	
	$tpl='';
	
	if ( array_key_exists('tpl',$_GET) ){ $tpl=$_GET['tpl']; }
	
	


	
	if ( $tpl=='' ){
		
		
	$this->_right.='
	<div class="r"></div>
 <div class="showpanel">
    	<li style="background:url(/dg_system/dg_img/icons/palette.png) no-repeat left center;"><a href="?comp=design&use=templates">'.$this->LANG['compdesign']['designname'].'</a></li>
 </div>	
	
	
	';		
		
		?>
	<h2><?=$this->LANG['compdesign']['title_update_create_full']?></h2>	
	<div class="help"><?=$help['new']?></div><p>&nbsp;</p>
	<div class="dg_form">	
		<form method="post">
		
		 <?=$this->_security->creat_key()?>
			<p><?=$this->LANG['compdesign']['title_insert_new_name']?></p>
			<p class="comment"><?=$this->LANG['compdesign']['title_insert_new_name_note']?></p>
			
			<?
			
			if (array_key_exists('go',$_POST)){
				
				
				$error='';
				
				if ( !lat($_POST['tplname']) || trim($_POST['tplname'])==''  ){ $error.='<li>'.$this->LANG['compdesign']['title_insert_new_name_note'].'</li>'; }
			    if (file_exists(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_POST['tplname'])){ $error.='<li>'.$this->LANG['compdesign']['title_insert_new_name_file_found'].'</li>'; }
			
					if ($error!=''){
				
					?>  <div class="dg_error"><?=$error?></div><p>&nbsp;</p> <?
				
					}else{
				
				      /* создаем дизайн шаблон */
				      
				      $tpl_f = new dg_file;
				      $tpl_f->createdir(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_POST['tplname']);
				      $tpl_f->createdir(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_POST['tplname'].'/css/');
				      $tpl_f->createdir(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_POST['tplname'].'/js/');
				      $tpl_f->createdir(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_POST['tplname'].'/img/');
				      
				      
				      
				      $deftpl = '<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$this->_title?></title>
<?=$this->head()?>
</head>
<body>
<header>demiurgo.cms</header>
	<section>
        <?=$this->content()?>
    </section>
<footer>&copy;</footer>
</body>
</html>';


					$f = new dg_file;
					$f->create(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_POST['tplname'].'/index.dg.php',$deftpl);
					$f->create(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_POST['tplname'].'/css/main.css','/*demiurgo.cms*/');
					$f->create(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_POST['tplname'].'/js/main.js','/*demiurgo.cms*/');

                       
                      $f->clearcache('tpl');  					
					
					header("Location:"._URL_."update&tpl=".$_POST['tplname']);
				      
				      
				
					}
			
				
			}
			
			
			?>
			
			<p><input type="text" name="tplname" value="<?=$_POST['tplname']?>" /> <input type="submit" name="go" value="<?=$this->LANG['main']['next']?>" /></p>
		
		
		</form>
   </div>		
		
		
		<?
		
		
	}else{
		
	if ( file_exists(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/index.dg.php') ){
		
			$f = new dg_file;
			
			
			if (array_key_exists('source',$_POST) && trim($_POST['source'])!=''){
				
				$f->create(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/index.dg.php',(htmlspecialchars_decode( $_POST['source']) ));	
				$f->clearcache('tpl');  	
                if (!$this->_ajax){
				header("Location:"._URL_."update&tpl=".$_GET['tpl']);
				}else{
					echo 'ok'; exit;
				}
			}
		
	$this->_right.='
	<div class="r"></div>
 <div class="showpanel">
    	<li style="background:url(/dg_system/dg_img/icons/palette.png) no-repeat left center;"><a href="?comp=design&use=templates">'.$this->LANG['compdesign']['designname'].'</a></li>
		<li style="background:url(/dg_system/dg_img/icons/page_white_css.png) no-repeat left center;"><a href="'._URL_.'incl&w=css&tpl='.$_GET['tpl'].'" id="css">'.$this->LANG['main']['list'].' CSS</a></li>
		<li style="background:url(/dg_system/dg_img/icons/page_white_js.png) no-repeat left center;"><a href="'._URL_.'incl&w=js&tpl='.$_GET['tpl'].'"  id="js">'.$this->LANG['main']['list'].' JS</a></li>
	</div>	
	
	
	';			
	
		
		?>
		
		
<script type="text/javascript" src="/dg_system/dg_js/markitup/jquery.markitup.pack.js"></script>
<link rel="stylesheet" type="text/css" href="/dg_system/dg_js/markitup/skins/simple/style.css" />
<script type="text/javascript" src="/dg_system/dg_js/markitup/sets/tpl/set.js"></script>
<link rel="stylesheet" type="text/css" href="/dg_system/dg_js/markitup/sets/tpl/style.css" />		
		
		
		<script>
		
		$(document).ready(function()	{
  			$("#sourcetextarea").markItUp(mySettings);
  				})
		
		
		</script>
		
		<h2><?=$this->LANG['compdesign']['title_edit_head']?> <?=$_GET['tpl']?></h2>
	 <div class="help"><?=$help['update']?></div><p>&nbsp;</p>
	

	<div class="dg_form">
	
	<form method="post" id="templateform" class="ajax" autocomplete="off" >
	 <?=$this->_security->creat_key()?>
	<p>HTML</p>
	<p><textarea name="source" id="sourcetextarea"><?= htmlspecialchars($f->read(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/index.dg.php')) ?></textarea></p>
	
	<p><input type="submit" name="save" value="<?=$this->LANG['main']['save']?>" /> 

	<input type="reset" name="reset" value="<?=$this->LANG['main']['cancel']?>" /></p>
	
	</form>
	</div>	<p>&nbsp;</p>
		 <div class="dg_info">
	 <h3><?=$this->LANG['main']['info']?></h3>	
		<p><?=$this->LANG['compdesign']['title_edit_info_dir']?> <b><?='/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/'?></b></p>
		<p><?=$this->LANG['compdesign']['title_edit_info_dir_css']?> <b><?='/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/css/'?></b></p>
		<p><?=$this->LANG['compdesign']['title_edit_info_dir_js']?> <b><?='/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/js/'?></b></p>
	</div>
		
		<?
		
		
		
		
		}else{
			
			echo '<p>'.	$this->LANG['compdesign']['title_not_found'].'</p>';
		 	
		}
		
	}


	
}


	
	
	
	if ($this->_func=="remove"){//TODO:remove
		/**
		 * удаляем шаблон со всем содержимым
		 */
		
	if ( file_exists(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/') && $_GET['tpl']!='' ){	
	$this->_right.='
	<div class="r"></div>
 <div class="showpanel">	
	<li style="background:url(/dg_system/dg_img/icons/palette.png) no-repeat left center;"><a href="?comp=design&use=templates">'.$this->LANG['compdesign']['designname'].'</a></li>
	<li style="background:url(/dg_system/dg_img/icons/page_white_php.png) no-repeat left center;"><a href="'._URL_.'update&tpl='.$_GET['tpl'].'" id="edit">'.$this->LANG['main']['list'].'</a></li>
	<li style="background:url(/dg_system/dg_img/icons/page_white_css.png) no-repeat left center;"><a href="'._URL_.'incl&w=css&tpl='.$_GET['tpl'].'" id="css">'.$this->LANG['main']['list'].' CSS</a></li>
	<li style="background:url(/dg_system/dg_img/icons/page_white_js.png) no-repeat left center;"><a href="'._URL_.'incl&w=js&tpl='.$_GET['tpl'].'"  id="js">'.$this->LANG['main']['list'].' JS</a></li>	
 </div>	
	
	
	';		
	
	
	if ($this->accesspassword()){
	
	
	
		
		$f=new dg_file;
        $f->clearcache('tpl');  	
		
		
			if ( file_exists(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl']) ){
				
				$f = new dg_file;
				$f->full_del_dir(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl']);
				      
					  $this->_Q->_where=" WHERE `tpl`='".$this->_Q->e($_GET['tpl'])."'";
			 	  	  $this->_Q->_table="templates__js";				 	  
		  			  $this->_Q->QD();				
			 	  	  $this->_Q->_table="templates__css";
		  			  $this->_Q->QD();				
				
			}
		
		
			
		
		
		header("Location:"._URL_."index");
		
		
	}
		
		
	}else{
			echo '<p>'.	$this->LANG['compdesign']['title_not_found'].'</p>';
		
	}	
	}
	
	
	
	
	/**
	 * 
	 * Управление CSS, JS файлами и ссылками
	 * 
	 */
	
	
	
	if ($this->_func=="incl"){//TODO:incl
		/**
		 * выводим список компонентов шблона CSS или JS
		 */
		 
		if ( file_exists(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/') ){
		
		$w = 'css';
		$wl = 'js';
		if ($_GET['w']=='js'){ $w='js'; $wl='css'; }
		$ff = new dg_file;
		
        
        
	$this->_right='
	<h3>'. strtoupper($w) .'</h3>
 <div class="showpanel">	
	<li style="background:url(/dg_system/dg_img/icons/add.png) no-repeat left center;"><a href="'._URL_.'updateinclude&tpl='.$_GET['tpl'].'&w='.$w.'">'.$this->LANG['compdesign']["title_incl_create_".$w].'</a></li>
	
 </div>	
	<div class="r"></div>
 <div class="showpanel">	
	<li style="background:url(/dg_system/dg_img/icons/palette.png) no-repeat left center;"><a href="?comp=design&use=templates">'.$this->LANG['compdesign']['designname'].'</a></li>
	<li style="background:url(/dg_system/dg_img/icons/page_white_php.png) no-repeat left center;"><a href="'._URL_.'update&tpl='.$_GET['tpl'].'" id="edit">'.$this->LANG['main']['edit'].' '.$this->LANG['compdesign']['title_tpl'].'</a></li>
	<li style="background:url(/dg_system/dg_img/icons/page_white_'.$wl.'.png) no-repeat left center;"><a href="'._URL_.'incl&w='.$wl.'&tpl='.$_GET['tpl'].'"  id="'.$wl.'">'.$this->LANG['main']['list'].' '.$wl.'</a></li>	
    <li style="background:url(/dg_system/dg_img/icons/cross.png) no-repeat left center;" ><a href="'._URL_.'remove&tpl='.$_GET['tpl'].'&re='.$_SERVER["REQUEST_URI"].'" id="remove" class="removeaccess">'.$this->LANG['main']['remove'].'</a></li>	
 </div>	
	
	
	';			
		
		
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
					
					
					$.post('<?=_URL_?>savefileorder&tpl=<?=$_GET['tpl']?>&m=<?=$_GET['m']?>',{items:total},function(data){
						
						if (data!='ok'){
							
							alert (data);
							$(".sortable").sortable( 'cancel' ); sort=false
							
						}
					})
					
			$("#saveorder,#cancelorder").attr('disabled','true');  sort=false;
		});
	
	$("a").click(function(){
		
		if (sort)	return confirm(lang_textareakey);
		
	})
		
	});
	</script> 		
		
		<h2><?=$this->LANG['compdesign']["title_incl_main_".$w]?> <?=$_GET['tpl']?></h2>
		<div class="help"><?=$help['list_'.$w]?></div><p>&nbsp;</p>
		<?
		$total='';
		$reg = array();
		$QW = $this->_Q->QW("SELECT * FROM `<||>templates__".$w."` WHERE `tpl`='".$this->_Q->e($_GET['tpl'])."' ORDER BY `order`");
		
		foreach ($QW as $i=>$row){ 
				
				$a1='<a href="'._URL_.'updateinclude&tpl='.$_GET['tpl'].'&w='.$_GET['w'].'&file='. $row['id'] .'">';
				$a2='</a>';
				
				if ( substr_count($row['dir'],'/')>0 ){ $a1=''; $a2=''; }
				
				$reg[md5($row['dir'])]=true;
				
				$total.='<li id="f_'.$row['id'].'">
				<span style="width:660px; background:url(/dg_system/dg_img/icons/page_white_'.$w.'.png) no-repeat left center;">'.$a1. substr($row['dir'],0,300) .$a2.''; 
				$o='';
				if ( $w=='css' && $row['media']!='' ){$o.='Media: '.$row['media'];}
				if ($row['ie']!=''){ if ($o!=''){ $o.=','; } $o.=' IE'.$row['ie']; }
				if ($row['show']==1){if ($o!=''){ $o.=','; } $o.=' <b>'.$this->LANG['compdesign']['title_incl_show_not_inlist'].'</b>';}
				if ($o!=''){ $total.='<br /><font class="comment">'.$o.'</font>'; }
				$total.='</span>
				<span style="width:20px;"><a href="'._URL_.'settinginclude&tpl='.$_GET['tpl'].'&file='.$row['id'].'&w='.$w.'" id="setting"><img src="/dg_system/dg_img/icons/hammer_screwdriver.png" title="'.$this->LANG['main']['setting'].'" align="absmiddle" /></a></span> 
				<span style="width:20px;"><a href="'._URL_.'removeinclude&tpl='.$_GET['tpl'].'&file='.$row['id'].'&w='.$w.'&re='.$_SERVER["REQUEST_URI"].'" id="remove" class="removeaccess"><img src="/dg_system/dg_img/icons/cross.png" title="'.$this->LANG['main']['remove'].'" align="absmiddle" /></a></span> 
									 
				</li>';
			
		}
		
		  	if ($total!=''){			
	
   ?>
   
   <div class="dg_list sortable"><?=$total?></div>
   <p>&nbsp;</p>
   <p> <input type="button" id="saveorder" disabled value="<?=$this->LANG['main']["save_order"]?>" /> 
   <input type="button" id="cancelorder" disabled value="<?=$this->LANG['main']["cancel"]?>" /> </p>
   
   <?
   }else{
   	
   	echo $this->LANG['compdesign']['title_incl_main_clear_reg'];
   	
   }
   
   $noreg='';
   $dir = opendir (_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/'.$w);
     while ( $file = readdir ($dir))
     {
       if (( $file != ".") && ($file != "..") && ( substr_count($file,$w)===1 ) && !$reg[md5($file)])
       {
         $noreg.='<li>';
		 $noreg.='<span style="width:680px; background:url(/dg_system/dg_img/icons/page_white_'.$w.'.png) no-repeat left center;">'.$file.'</span>';
		 $noreg.='<span style="width:20px;"><a href="'._URL_.'inreg&tpl='.$_GET['tpl'].'&file='.$file.'&w='.$w.'"><img src="/dg_system/dg_img/icons/add.png" title="'.$this->LANG['compdesign']['title_incl_main_add_reg'].'" /></a></span>';
		 $noreg.='</li>';
       }
     }
     closedir ($dir);
     
     if ($noreg!=''){
     	
   ?>
   <p>&nbsp;</p>
   <h3><?=$this->LANG['compdesign']['title_incl_main_find_reg']?></h3>
   <div class="dg_list"><?=$noreg?></div>
   
   <?     	
     }
   
		
		
	}else{
			echo '<p>'.	$this->LANG['compdesign']['title_not_found'].'</p>';
		
	}		
		
	}
	
	
	if ($this->_func=='inreg'){//TODO:inreg
		
		/**
		 * добавляем файл в реестр шаблона
		 */
		 
		$w = 'css';
		$wl = 'js';
		if ($_GET['w']=='js'){ $w='js'; $wl='css'; }
		
		echo $this->_Q->QN("SELECT * FROM `<||>templates__".$w."` WHERE `tpl`='".$this->_Q->e($_GET['tpl'])."' AND `dir`='".$this->_Q->e($_GET['file'])."'");		 
	 	  
		  if ( $this->_Q->QN("SELECT * FROM `<||>templates__".$w."` WHERE `tpl`='".$this->_Q->e($_GET['tpl'])."' AND `dir`='".$this->_Q->e($_GET['file'])."'")===0 ){ 
		   
		  $last = $this->_Q->QA("SELECT * FROM `<||>templates__".$w."` WHERE `tpl`='".$this->_Q->e($_GET['tpl'])."' ORDER BY `order` DESC LIMIT 1 ");
	 	  $this->_Q->_table="templates__".$w;
	 	  $this->_Q->_arr = array('tpl'=>$_GET['tpl'],
		   						  'order'=>($last['order']+1),
		   						  'dir'=>$_GET['file']
									);
		  $this->_Q->QI();		 
		  }
          $f= new dg_file;
		  $f->clearcache('tpl');  	
		  header("Location:"._URL_."incl&w=".$w."&tpl=".$_GET['tpl']);
	}
	
	
	if ($this->_func=='removeinclude'){//TODO:removeinclude
		/**
		 * Удаление файла
		 */
		$w = 'css';
		$wl = 'js';
		if ($_GET['w']=='js'){ $w='js'; $wl='css'; }
		
		
	$this->_right='
	<h3>'. strtoupper($w) .'</h3>
 <div class="showpanel">	
	<li style="background:url(/dg_system/dg_img/icons/add.png) no-repeat left center;"><a href="'._URL_.'updateinclude&tpl='.$_GET['tpl'].'&w='.$w.'">'.$this->LANG['compdesign']["title_incl_create_".$w].'</a></li>
	<li style="background:url(/dg_system/dg_img/icons/page_white_'.$w.'.png) no-repeat left center;"><a href="'._URL_.'incl&w='.$w.'&tpl='.$_GET['tpl'].'"  id="'.$w.'">'.$this->LANG['main']['list'].' '.$w.'</a></li>	
 </div>	
	<div class="r"></div>
 <div class="showpanel">	
	<li style="background:url(/dg_system/dg_img/icons/palette.png) no-repeat left center;"><a href="?comp=design&use=templates">'.$this->LANG['compdesign']['designname'].'</a></li>
	<li style="background:url(/dg_system/dg_img/icons/page_white_php.png) no-repeat left center;"><a href="'._URL_.'update&tpl='.$_GET['tpl'].'" id="edit">'.$this->LANG['main']['edit'].' '.$this->LANG['compdesign']['title_tpl'].'</a></li>
	<li style="background:url(/dg_system/dg_img/icons/page_white_'.$wl.'.png) no-repeat left center;"><a href="'._URL_.'incl&w='.$wl.'&tpl='.$_GET['tpl'].'"  id="'.$wl.'">'.$this->LANG['main']['list'].' '.$wl.'</a></li>	
    </div>	
	
	
	';			
		
		
		$inf =  $this->_Q->QA("SELECT * FROM `<||>templates__".$w."` WHERE `id`='".$this->_Q->e($_GET['file'])."' LIMIT 1");	
		
		if ($inf['id']!=''){
			
			

			
			
			if ( $this->accesspassword() ){
				
				
				
				$this->_Q->_where = " WHERE `id`=".$inf['id'];			
				$this->_Q->_table = "templates__".$w;
				$this->_Q->QD();	
                $f= new dg_file;
				$f->clearcache('tpl');  	
				
				if ( substr_count($inf['dir'],'/')===0 ){
					
					if (file_exists(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/'.$w.'/'.$inf['dir'])){
						
						unlink(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/'.$w.'/'.$inf['dir']);
						
					}
					
				}		
                $f= new dg_file;
                
			header("Location:"._URL_."incl&w=".$w."&tpl=".$_GET['tpl']);
			
				
			}
			
		
			
			
			
			
		}		
		
	}
	
	
	if ($this->_func=='settinginclude'){//TODO:settinginclude
		/**
		 * настройки отображения файла
		 */
		
		$w = 'css';
		$wl = 'js';
		if ($_GET['w']=='js'){ $w='js'; $wl='css'; }
		
		
	$this->_right='
	<h3>'. strtoupper($w) .'</h3>
 <div class="showpanel">	
	<li style="background:url(/dg_system/dg_img/icons/add.png) no-repeat left center;"><a href="'._URL_.'updateinclude&tpl='.$_GET['tpl'].'&w='.$w.'">'.$this->LANG['compdesign']["title_incl_create_".$w].'</a></li>
	<li style="background:url(/dg_system/dg_img/icons/page_white_'.$w.'.png) no-repeat left center;"><a href="'._URL_.'incl&w='.$w.'&tpl='.$_GET['tpl'].'"  id="'.$w.'">'.$this->LANG['main']['list'].' '.$w.'</a></li>	
 </div>	
	<div class="r"></div>
 <div class="showpanel">	
	<li style="background:url(/dg_system/dg_img/icons/palette.png) no-repeat left center;"><a href="?comp=design&use=templates">'.$this->LANG['compdesign']['designname'].'</a></li>
	<li style="background:url(/dg_system/dg_img/icons/page_white_php.png) no-repeat left center;"><a href="'._URL_.'update&tpl='.$_GET['tpl'].'" id="edit">'.$this->LANG['main']['edit'].' '.$this->LANG['compdesign']['title_tpl'].'</a></li>
	<li style="background:url(/dg_system/dg_img/icons/page_white_'.$wl.'.png) no-repeat left center;"><a href="'._URL_.'incl&w='.$wl.'&tpl='.$_GET['tpl'].'"  id="'.$wl.'">'.$this->LANG['main']['list'].' '.$wl.'</a></li>	
    </div>	
	
	
	';			
		
		
		$inf =  $this->_Q->QA("SELECT * FROM `<||>templates__".$w."` WHERE `id`='".$this->_Q->e($_GET['file'])."' LIMIT 1");	
		
		if ( $inf['dir']!='' ){
			
			if ( array_key_exists('save',$_POST) ){
				
				$arr['ie'] = $_POST['br'];
				$arr['show'] = $_POST['show'];
				if ($w == 'css'){
					$arr['media']=$_POST['media'];
				}
				
				$this->_Q->_arr = $arr;
				$this->_Q->_where = " WHERE `id`=".$inf['id'];
				$this->_Q->_table = "templates__".$w;
				$this->_Q->QU();
                $f= new dg_file;
                $f->clearcache('tpl');  	
				header("Location:"._URL_."incl&w=".$w."&tpl=".$_GET['tpl']);
				
			}
			
			?>
			<h2><?=$this->LANG['compdesign']['title_incl_setting'].'  '. strtoupper($w) ?></h2>
			<p class="comment"><?=$_GET['tpl'] .' &rarr; '. $inf['dir']?></p>
			<div class="help"><?=$help['file_options']?></div><p>&nbsp;</p>
			<div class="dg_form">
			<form method="post">
			 <?=$this->_security->creat_key()?>
			<p><label><input type="checkbox" name="show" value="1"<? if ($inf['show']==1){ echo ' checked="checked" '; } ?> /> <?=$this->LANG['compdesign']['title_incl_show_not']?></label></p>
				<? if ($w == 'css'){?>
	 
	<p> Media: <select name="media">
	 	<option<? if ($inf['media']=='all'){ echo ' selected="selected" '; } ?>>all</option>
	 	<option<? if ($inf['media']=='aural'){ echo ' selected="selected" '; } ?>>aural</option>
	 	<option<? if ($inf['media']=='braille'){ echo ' selected="selected" '; } ?>>braille</option>
	 	<option<? if ($inf['media']=='handheld'){ echo ' selected="selected" '; } ?>>handheld</option>
	 	<option<? if ($inf['media']=='print'){ echo ' selected="selected" '; } ?>>print</option>
	 	<option<? if ($inf['media']=='projection'){ echo ' selected="selected" '; } ?>>projection</option>
	 	<option<? if ($inf['media']=='screen'){ echo ' selected="selected" '; } ?>>screen</option>
	 	<option<? if ($inf['media']=='tty'){ echo ' selected="selected" '; } ?>>tty</option>
	 	<option<? if ($inf['media']=='tv'){ echo ' selected="selected" '; } ?>>tv</option>
	 </select> </p>

	 
	 <?} ?> 
	 
	<p><b><?=$this->LANG['compdesign']['title_incl_show_br']?></b>:
		<label> <input type="radio" name="br" value=""<? if ($inf['ie']==''){ echo ' checked="checked" '; } ?> /> <?=$this->LANG['compdesign']['title_incl_show_br_all']?> </label>
		<label>  <input type="radio" name="br" value="6"<? if ($inf['ie']=='6'){ echo ' checked="checked" '; } ?> /> Internet Explorer 6 </label>
		<label>  <input type="radio" name="br" value="7"<? if ($inf['ie']=='7'){ echo ' checked="checked" '; } ?> /> Internet Explorer 7 </label>
	</p>	
	
	<p> <input type="submit" name="save" value="<?=$this->LANG['main']["save"]?>" /> 
	</form> 
			</div>
			<?
			
		}else{
			echo '<p>'.	$this->LANG['main']['f404'].'</p>';
		}
		
	}
	
	
	if ($this->_func=='updateinclude'){//TODO:updateinclude
		/**
		 * редактируем или создаем компонент шаблона
		 */
		
		$filename='';
		
		
		
		
		if ( file_exists(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/') ){
		
		$w = 'css';
		$wl = 'js';
		if ($_GET['w']=='js'){ $w='js'; $wl='css'; }
		
		
		if ( array_key_exists('file',$_GET) ){
			
		   $inf =  $this->_Q->QA("SELECT * FROM `<||>templates__".$w."` WHERE `id`='".$this->_Q->e($_GET['file'])."' LIMIT 1");	
			
		}
		
		
	$this->_right='
	<h3>'. strtoupper($w) .'</h3>
 <div class="showpanel">	
	<li style="background:url(/dg_system/dg_img/icons/add.png) no-repeat left center;"><a href="'._URL_.'updateinclude&tpl='.$_GET['tpl'].'&w='.$w.'">'.$this->LANG['compdesign']["title_incl_create_".$w].'</a></li>
	<li style="background:url(/dg_system/dg_img/icons/page_white_'.$w.'.png) no-repeat left center;"><a href="'._URL_.'incl&w='.$w.'&tpl='.$_GET['tpl'].'"  id="'.$wl.'">'.$this->LANG['main']['list'].' '. strtoupper($w) .'</a></li>	
    
 </div>	
	<div class="r"></div>
 <div class="showpanel">	
	<li style="background:url(/dg_system/dg_img/icons/palette.png) no-repeat left center;"><a href="?comp=design&use=templates">'.$this->LANG['compdesign']['designname'].'</a></li>
	<li style="background:url(/dg_system/dg_img/icons/page_white_php.png) no-repeat left center;"><a href="'._URL_.'update&tpl='.$_GET['tpl'].'" id="edit">'.$this->LANG['main']['edit'].'</a></li>
	<li style="background:url(/dg_system/dg_img/icons/page_white_'.$wl.'.png) no-repeat left center;"><a href="'._URL_.'incl&w='.$wl.'&tpl='.$_GET['tpl'].'"  id="'.$wl.'">'.$this->LANG['main']['list'].' '. strtoupper($wl) .'</a></li>	
    </div>	
	
	
	';			
		
		
  if ($inf['id']==''){
  	/*создаем*/
	
  	?>
	
	 <h2><?=$this->LANG['compdesign']["title_incl_create_".$w]?></h2>
	 <div class="help"><?=$help['file_new_'.$w]?></div><p>&nbsp;</p>
	 <div class="dg_form">
	 <form method="post">
 <?=$this->_security->creat_key()?>
	 <p><?=$this->LANG['compdesign']['title_incl_new']?></p>
	 <p class="comment"><?=$this->LANG['compdesign']["title_incl_new_note_".$w]?></p>
	 <?
	 
	 if (array_key_exists("go",$_POST)){
	 	
	 	
	 	$error='';
	 	
	 	if ( trim($_POST['filename'])=='' ){ $error.='<li>'.$this->LANG['compdesign']['title_incl_new'].'</li>';}
	 	
	 	if ( substr_count($_POST['filename'],'/')===0 ){
	 		
	 		/* файл */
	 		
	 		if ( substr_count($_POST['filename'],'.')===0 ){ $error.='<li>'.$this->LANG['compdesign']['title_incl_new_error_type'].'</li>'; }
	 		if ( file_exists( _DR_.'/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/'.$w.'/'.$_POST['filename'] ) ){ $error.='<li>'.$this->LANG['compdesign']['title_incl_new_error_file_exists'].'</li>';  }
	 		if (!lat($_POST['filename'])){$error.='<li>'.$this->LANG['compdesign']['title_insert_new_name_note'].'</li>';}
	 	}
	 	
	 	
	 	if ($error!=''){
	 		
	 		?><div class="dg_error"><?=$error?></div><p>&nbsp;</p><?
	 		
	 		
	 	}else{
	 		
	 	  if ( substr_count($_POST['filename'],'/')===0 ){
	 	  	
	 	  	
	 	  	$f = new dg_file;
	 	  	$f->create(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/'.$w.'/'.$_POST['filename'],'/*demiurgo.cms*/');
	 	  	
	 	  }	
	 	  
	 	  /* добавляем все в базу */
	 	  
	 	  
	 	  $last = $this->_Q->QA("SELECT * FROM `<||>templates__".$w."` WHERE `tpl`='".$this->_Q->e($_GET['tpl'])."' ORDER BY `order` DESC LIMIT 1 ");
	 	  
	 	 
	 	  
	 	  $this->_Q->_table="templates__".$w;
	 	  $this->_Q->_arr = array('tpl'=>$_GET['tpl'],
		   						  'order'=>($last['order']+1),
		   						  'dir'=>$_POST['filename']
									);
		  $this->_Q->QI();
          $f2= new dg_file;
		  $f2->clearcache('tpl');  	
		  if ($this->_ajax){ echo 'ok'; exit;} else header("Location:"._URL_."incl&w=".$w."&tpl=".$_GET['tpl']);			
		  		
	 		
	 	}
	 	
	 	
	 }
	 
	 
	 ?>	 
	 <p><input type="text" name="filename" value="<?=$_POST['filename']?>" /><input type="submit" name="go" value="<?=$this->LANG['main']['next']?>" /></p>
	 </form>
	 </div>
	
	  
	<?
  	
  }else{
  	/*редактируем*/
  	if (!file_exists( _DR_.'/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/'.$w.'/'.$inf['dir'] )){
  		
  		
  		echo '<p>'.	$this->LANG['main']['f404'].'</p>';
  		
  	}else{
		if ( substr_count($inf['dir'],'/')===0 ){
			
			$f = new dg_file;
			$b = $f->read(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/'.$w.'/'.$inf['dir']);
			
			
			if (array_key_exists('source',$_POST)){
				
				$f->create(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/'.$w.'/'.$inf['dir'], htmlspecialchars_decode($_POST['source']));
				$f->clearcache('tpl');
                if ($this->_ajax){ echo 'ok'; exit;}
			}
			
			?>
			
<script type="text/javascript" src="/dg_system/dg_js/markitup/jquery.markitup.pack.js"></script>
<link rel="stylesheet" type="text/css" href="/dg_system/dg_js/markitup/skins/simple/style.css" />



<script type="text/javascript" src="/dg_system/dg_js/markitup/sets/<?=$w?>/set.js"></script>
<link rel="stylesheet" type="text/css" href="/dg_system/dg_js/markitup/sets/<?=$w?>/style.css" />		
		
		
		<script>
		
		$(document).ready(function()	{
  			$("#sourcetextarea").markItUp(mySettings);
  				})
		
		
		</script>			
			
	 <h2><?=$this->LANG['compdesign']["title_incl_edit_".$w]?> <?=$inf['dir']?></h2>
	 <div class="help"><?=$help['file_edit_'.$w]?></div><p>&nbsp;</p>

			
			<div class="dg_form">
				<form method="post" class="ajax" autocomplete="off">
                 <?=$this->_security->creat_key()?>
				 <p><b><?= strtoupper($w)?></b></p>
				 <p><textarea name="source" id="sourcetextarea"><?= htmlspecialchars($b) ?></textarea></p>
				 <p><input type="submit" name="save" value="<?=$this->LANG['main']['save']?>" /> <input type="reset" name="reset" value="<?=$this->LANG['main']['cancel']?>" /></p>
				</form>
			</div>
			<p>&nbsp;</p>
					 <div class="dg_info">
	 <h3><?=$this->LANG['main']['info']?></h3>	
		<p><?=$this->LANG['compdesign']['title_edit_info_dir']?> <b><?='/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/'?></b></p>
		<p><?=$this->LANG['compdesign']['title_edit_info_dir_css']?> <b><?='/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/css/'?></b></p>
		<p><?=$this->LANG['compdesign']['title_edit_info_dir_js']?> <b><?='/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/js/'?></b></p>
	</div>	
			<?
			
		}  	
    }
  	
  }
		
		
		
		
	}else{
			echo '<p>'.	$this->LANG['compdesign']['title_not_found'].'</p>';
		
	}			
		
	}
	
	
	if ($this->_func=='savefileorder'){//TODO:savefileorder
		/**
		 * сохраняем новый  порядок
		 */
		if ( file_exists(_DR_.'/_tpl/'.$info['info']['dir'].'/'.$_GET['tpl'].'/') ){
		
					$w = 'css';
					$wl = 'js';
					
					if ($_GET['w']=='js'){ $w='js'; $wl='css'; }		
					
					$_POST['items'] = str_replace('f_','',$_POST['items']);
					
					$ex = explode(';',$_POST['items']);
					
					$y=0;
					foreach ($ex as $i=>$v){
						if (trim($v)!=''){
							$y++;
						 	  $this->_Q->_table="templates__".$w;
						 	  $this->_Q->_arr = array('order'=>$y);
						 	  $this->_Q->_where = " WHERE `id`='" . $this->_Q->e($v) . "'";
							  $this->_Q->QU();
							  if ($this->_Q->_error!=''){ echo $this->_Q->_error; exit;}
						}
					}
					echo 'ok';
		}else{
			
			echo 'tpl not found';
		}
        $f= new dg_file;
        $f->clearcache('tpl');  	
	}
}
?>