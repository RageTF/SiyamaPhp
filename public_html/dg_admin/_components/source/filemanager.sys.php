<?php

/**
 * @author mrhard
 * @copyright 2010
 */
           $aj='';
          if ($this->_ajax) $aj='&ajax';
 

 
if ($this->access('filemanager','index')){
define(_URL_,'/dg_admin/?comp=source&use=filemanager&to='.$_GET['to'].'&ft='.$_GET['ft'].'&func='); 
$DIR = '/';

$dgfile = new dg_file;
$dirlist=$dgfile->read(_DR_.'/files/'.$this->inf['info']['dir'].'.dg');


        function folderexistsname($dir,$i=''){
            
            if (!file_exists($dir.$i)){ return $dir.$i; }else{
               $GLOBALS['dirnumb']++; return folderexistsname($dir,'_'.($GLOBALS['dirnumb']));
            }
            
        }
        
        function fileexistsname($file){            
            if (!file_exists($file)){ return $file; }else{              
               $GLOBALS['filenumb']++;
               $ex = explode('.',$file);               
               $ex[count($ex)-2]=$ex[count($ex)-2].'_'.$GLOBALS['filenumb'];                              
               return fileexistsname(implode('.',$ex));              
            }            
        }



$SYSDIR=_DR_.'/files/'.$this->inf['info']['dir'];
$DIR=$SYSDIR.$DIR;

$dw[md5($SYSDIR.'/')]=$SYSDIR.'/';

 
    $ex = explode("\n",$dirlist);
    foreach($ex as $i=>$v){
    	if(trim($v)!=''){
    	   
    	   $exin = explode('*',$v);
          
           if ($exin[0]==$_GET['dir'] && array_key_exists('dir',$_GET) && $_GET['dir']!=''){ $DIR=$exin[1]; } $dw[$exin[0]]=$exin[1];
        }
    }
 

$bex = explode("/",$DIR);
$back='';
for ($i=0;($i<=count($bex)-2);$i++) {$back.=$bex[$i].'/'; $backex[$back]=$bex[$i];}



if ( file_exists($DIR) && is_dir($DIR) && substr_count($DIR,'.svn')==0){
    
    
  if ($this->_func=='index') {  //TODO:index

  
  /**
  * отображаем все файлы и папки
  */
  
if ($this->_ajax){       
        $ld = $this->_regedit->read('FM{'.$this->_user->_userinfo['id'].'}last_dir','');
        if ($ld!=md5('') && $ld!=md5($DIR) && $ld!='' && !array_key_exists('hl',$_GET) && substr_count($_SERVER["HTTP_REFERER"],'use=filemanager')==0){
            header("Location:"._URL_.'index&ajax&hl&dir='.$ld); 
        }  
    }
    
    
    if ( array_key_exists('folder_add',$_POST) ){
        

        
        $folder = $DIR.$_POST['name'];
        if (lat($_POST['name'])){
           mkdir(folderexistsname($folder),_CHMOD_DIR_);
        }
        
        header("Location:"._URL_."index&dir=".$_GET['dir'].$aj);
        
    }
    
    
    ?>
    <? if (!$this->_ajax){ ?>
        <h2><?=$this->LANG['compsource']['filemanagername']?></h2>
        <div class="help"><?=$help['index']?></div><p>&nbsp;</p>
    <?}else{
        echo '<title>'.$this->LANG['compsource']['filemanagername'].'</title>';
        $this->head(true);
    }?>
    
    <div id="filemanager" <? if ($this->_ajax){ ?> class="w95" style="margin: 0 auto; padding: 10px;" <? } ?>>
    
    <?

     if ($this->_ajax){
        echo '<p><strong>'.$this->LANG['compsource']['filemanager_select'].'</strong></p>';
     }
    if (is_array($backex)){
        ?>
        


      <ul class="dir_navig">
        <?
         
        foreach($backex as $i=>$v){
            if( strlen($i)>=strlen($SYSDIR.'/') ){echo '<li class="dir" name="'.md5($i).'"><a href="'._URL_.'index&dir='.md5($i).$aj.'">'.$v.'</a></li>&#9658;';}
        }
        
        ?>
        </ul>      
        <?
    }

    ?>   
    <p>&nbsp;</p>
    
     <?if ($this->access('filemanager','upload',false)){
        
        $error='';
        
         if ( array_key_exists('upload',$_POST) ){
         	
            foreach($_FILES['files']['name'] as $i=>$v){
             
 
             
             if (!move_uploaded_file($_FILES['files']['tmp_name'][$i], fileexistsname($DIR . basename($_FILES['files']['name'][$i])))){
                $error.='<li>Файл '.$_FILES['files']['name'].' не был загружен</li>'."\n";
             }
                
            }
            
            /*        $uploaddir = $DIR;
        $uploadfile = fileexistsname($uploaddir . basename($_FILES['Filedata']['name']));
        if (move_uploaded_file($_FILES['Filedata']['tmp_name'], $uploadfile)) echo 'ok';*/
            
            if ($error!='') echo '<ul class="error">'.$error.'</ul>'; else header("Location:"._URL_."index&dir=".md5($DIR).$aj);      
            
         }
        
        
        
        ?> <div id="">
             <form method="post" class="dg_form" enctype="multipart/form-data">
              <?=$this->_security->creat_key()?>
                <input type="file" name="files[]" multiple="multiple" required="required" title="Выберете файлы" /> <input type="submit" name="upload" value="загрузить" />
             </form>
        </div><?}?>
    <p>&nbsp;</p>
    <div id="fmpanel"> 
       
         <?if ($this->access('filemanager','edit',false)){?><div><img src="/dg_system/dg_img/fm/folder_add.png" id="folder_add" title="<?=$this->LANG['compsource']['filemanager_add_folder']?>" /></div>
         <?if ($this->access('filemanager','remove',false)){?><? if ($DIR!=$SYSDIR.'/'){?><div><a href="<?=_URL_?>folder_remove&dir=<?=md5($DIR)?>&re=<?=urlencode($_SERVER["REQUEST_URI"])?>" class="removeaccess"><img src="/dg_system/dg_img/fm/folder_delete.png" id="folder_delete" title="<?=$this->LANG['compsource']['filemanager_delete_folder']?>" /></a></div><?}?><?}?>
        
        <div><a href="<?=_URL_?>file_update&dir=<?=md5($DIR)?>" ><img src="/dg_system/dg_img/fm/page_add.png" id="page_add" title="<?=$this->LANG['compsource']['filemanager_add_file']?>" /></a></div>
        <div class="fileop page_edit"><a href="#" id="page_add_u"><img src="/dg_system/dg_img/fm/page_edit.png"  id="page_edit"  title="<?=$this->LANG['compsource']['filemanager_edit_file']?>" /></a></div>
        <?if ($this->access('filemanager','remove',false)){?><div class="fileop"><a href="#" id="page_add_r" class="removeaccess"><img src="/dg_system/dg_img/fm/page_delete.png"  id="page_delete"  title="<?=$this->LANG['compsource']['filemanager_delete_file']?>" /></a></div><?}?>
        <?}?>
     <input type="text" id="search" class="fearchform" />
   </div> 
   
   <div class="modal folder_add" title="<?=$this->LANG['compsource']['filemanager_add_folder']?>">
       <form method="post">
        <?=$this->_security->creat_key()?>
        <p><?=$this->LANG['compsource']['filemanager_name_folder']?><br /><input type="text" name="name" /></p>
        <p><input type="submit" name="folder_add" value="<?=$this->LANG['main']['next']?>" /></p>
       </form>
   </div>
   





<div id="progressbar"></div>

   <ul class="dir_list dg_form" id="filebox">
    <?
    
    $diropen = opendir ($DIR);
      while ( $file = readdir ($diropen))
      {
        if (( $file != ".") && ($file != "..") && (is_dir($DIR.'/'.$file)) && $file!='.svn')
        {
          
          if ( substr_count($dirlist,md5($DIR.$file.'/'))==0 ){ $dirarr[]=md5($DIR.$file.'/').'*'.$DIR.$file.'/'; }

          ?>
          
          <li class="dir" name="<?=md5($DIR.$file.'/')?>"><div>
            <a href="<?=_URL_?>index&dir=<?=md5($DIR.$file.'/').$aj?>"><img src="/dg_system/dg_img/fm/folder.png" /></a><br />
            <a href="<?=_URL_?>index&dir=<?=md5($DIR.$file.'/').$aj?>"><?=$file?></a>
           </div>
          </li>
          
          <?
        }
      }
      closedir ($diropen);
      
      
    $diropen = opendir ($DIR);
      while ( $file = readdir ($diropen))
      {
        if (( $file != ".") && ($file != "..") && (is_file($DIR.'/'.$file)))
        {
          
          $filearr[$file]=$file;
          
        }
      }
      closedir ($diropen);
      
      if (is_array($filearr)){
        
        ksort($filearr,SORT_NUMERIC);
        
        foreach($filearr as $i=>$file){
        	$img='/dg_system/dg_img/fm/default.png';
          
          $exx = explode('.',$file);
         
          $t=strtolower($exx[count($exx)-1]);
          if (file_exists(_DR_.'/dg_system/dg_img/fm/'.$t.'.png')) $img='/dg_system/dg_img/fm/'.$t.'.png';
          $pv='';
          if ($t=='jpg' || $t=='png' || $t=='gif'){
          if ($_GET['to']=='') $pv=' class="imgpw" ';  
            $img = img(array('src'=>$DIR.$file,'w'=>100,'h'=>50,'bg'=>'F3F1E9','enlarge'=>false));
          }
          $edit=false;
          if ($t=='htm' || $t=='html' || $t=='txt' || $t=='css' || $t=='php' || $t=='xml'){
            
            $edit=true;
          }
          
          ?>
          
          <li class="file" name="<?=$file?>" <?if($edit){echo 'type="edit"';}?> title="<?=str_replace(_DR_,'',$DIR).$file?>">
           <div>
            <? if ($pv!='') echo '<a href="'.img(array('src'=>$DIR.$file,'w'=>600,'h'=>450,'bg'=>'ffffff','enlarge'=>false)).'">'; ?><img src="<?=$img?>"<?=$pv?>/><? if ($pv!='') echo '</a>'; ?><br />
            <input type="text" value="<?=$file?>" class="fname" readonly="on" autocomplete="off" name="<?=str_replace(_DR_,'',$DIR)?>" title="<?=$file?>" alt="" /><br />
            <span class="comment"><?
            if ((filesize($DIR.$file)/1024)<1024){
                echo number_format((filesize($DIR.$file)/1024),1,'.',' ').' Kb';
            }else{
                echo number_format((filesize($DIR.$file)/1024/1024),1,'.',' ').' Mb';
            }
            ?></span>
           </div>
          </li>
          
          <?
        }
        
        
      }
    
     if ($this->_ajax) $this->_regedit->edit('FM{'.$this->_user->_userinfo['id'].'}last_dir',md5($DIR));
    ?>
    </ul>
    <div style="clear: both;"></div>
    <script>
    

    
    $(document).ready(function()	{
        $("#search").focus().keyup(function(){
            searchres = 0;
            s = $(this).val();
            $("li.file").each(function(){
               n = $(this).attr('name');   
               
               if ((n.toLocaleLowerCase().indexOf(s.toLocaleLowerCase()) + 1)>0){
                searchres++;
                $(this).css('display','inline-block');
               }else{
                $(this).css('display','none');
               }
               
                 
            });
            if (searchres==0) {
                    $('li.file').css('display','inline-block');
                    $("#search").addClass('redinput');
                }else{
                    $("#search").removeClass('redinput');
                }
            
        });
        var file='';
    	$(".file")<? if ($this->access('filemanager','copyfile',false)){ ?>.draggable({stop: function(event, ui) { $(".file").css('left',0).css('top',0).css('opacity',1); },drag:function(event, ui){file=$(this).attr('name'); $(this).css('opacity',.3);}})<?}?>.click(function(){ 
    	   
            file=$(this).attr('name'); 
            $(".file").removeClass('selfile');
            $(this).addClass('selfile');
            $('.fileop').css('display','inline-block');
            
            if ($(this).attr('type')!='edit'){
                $('.page_edit').css('display','none');
            }else{
                $('#page_add_u').attr('href','<?=_URL_?>file_update&dir=<?=md5($DIR)?>&file='+file);
                
            }
            $('#page_add_r').attr('href','<?=_URL_?>file_remove&dir=<?=md5($DIR)?>&file='+file+'&re=<?=urlencode($_SERVER["REQUEST_URI"])?>');
           });
           
           <?
           if ($this->_ajax){
            ?>
            
            $(".file").dblclick(function(){
                
                //opener.$("#<?=$_GET['to']?>").val($(this).attr('title')).select();
                
                opener.document.getElementById("<?=$_GET['to']?>").value=$(this).attr('title')
                close();
                
            });
            
            <?
           }
           ?>
        <? if ($this->access('filemanager','copyfile',false)){ ?>   
        $(".dir").droppable({
			drop: function(event, ui) {
			if((confirm('<?=$this->LANG['main']['confirm_dandd']?>')) && (file!='')){	
			 $(".file").css('left',0).css('top',0);
			 
                var tod = $(this).attr('name');
                $.post('<?=_URL_?>copyfile&dir='+tod,{from:'<?=md5($DIR)?>',f:file},function(data){
                   if(data=='ok'){
                    window.location.href='<?=_URL_?>index<? if ($this->_ajax) echo '&ajax'; ?>&dir='+tod;
                   }else{
                    alert(data);
                   }
                });
               
             
             }else{
			 $(".file").css('left',0).css('top',0);
             $(this).removeClass('seldir');
			}
			},
            over: function(event, ui) { $(this).addClass('seldir'); },out: function(event, ui) { $(this).removeClass('seldir');  }


		});
        <?}?>

    
        $(".fname").click(function(){
            if($(this).attr('alt')==''){$(this).val($(this).attr('name')+$(this).val()); $(this).attr('alt',' ');}
            this.select();
        });
        $(".fname").blur(function(){
            $(this).val($(this).attr('title'));
            $(this).attr('alt','');
        });
        $(".filecontent").css('opacity',0.9);


        $("#folder_add").click(function(){
            
            $('.folder_add').dialog({modal: true,draggable: false});

            
        });

    				});
    </script>
    
    
    <?
    	
       if(is_array($dirarr)) $dgfile->create(_DR_.'/files/'.$this->inf['info']['dir'].'.dg',$dirlist."\n".implode("\n",$dirarr));
    ?></div><?
   
    }
    
    if($this->_func=='copyfile'){//TODO:copyfile
    /**
    *копируем файл
    */
    if ($this->access('filemanager','copyfile')){
        if ($dw[$_POST['from']]!=''){
        if ($dw[$_POST['from']]==$DIR){ echo 'ok'; exit; }
                if ( file_exists($dw[$_POST['from']].$_POST['f']) && file_exists($DIR) ){
                    if(copy(($dw[$_POST['from']].$_POST['f']),fileexistsname($DIR.$_POST['f']))){
                        unlink($dw[$_POST['from']].$_POST['f']);
                        echo 'ok'; exit;
                    }
                }else{
                    echo 'error copy file ('.$dw[$_POST['from']].$_POST['f'].' to '.$DIR.$_POST['f'].')';
                }
        }else{
            echo $dw[$_POST['from']].' not found';
        }        
      }
    }
    


    

    
    if ($this->_func=='folder_remove'){//TODO:folder_remove
    /**
    *удаляем папку
    */
   if ($this->access('filemanager','edit') && $this->access('filemanager','remove')){
        if ($DIR!=$SYSDIR.'/'){
             echo '<h2>'.$this->LANG['compsource']['filemanager_delete_folder'].'</h2>';
        
            if($this->accesspassword()){
                $dfolder = new dg_file;
                $dfolder->full_del_dir($DIR);
                header("Location:"._URL_."index".$aj);
                
            }
        
        }
      }  
    }
    
    
    if ($this->_func=='file_update'){//TODO:file_update
    /**
    *редактируем,создаем файл
    */
    if ($this->access('filemanager','edit')){
        $edit=false;
        
        if ( array_key_exists('file',$_GET) && file_exists($DIR.urldecode($_GET['file'])) ){
            $buff = dg_file::read($DIR.urldecode($_GET['file']));
            $edit=true;
        }
        
        
        if ( array_key_exists('go',$_POST) ){
            
            $error='';
            
            if (!$edit){
                if (trim($_POST['name'])==''){ $error.='<li>'.$this->LANG['compsource']['filemanager_name_file'].'</li>'; }else{
                    if (!lat($_POST['name'])){$error.='<li>'.$this->LANG['compsource']['filemanager_name_file_error1'].'</li>';}else{
                        if (file_exists($DIR.$_POST['name'])){$error.='<li>'.$this->LANG['compsource']['filemanager_name_file_error2'].'</li>';}
                    }
                }
            }
            
            if ($error==''){
                
               $f=new  dg_file;
               $f->create($DIR.$_POST['name'],htmlspecialchars_decode($_POST['content']));
               header("Location:"._URL_.'index&dir='.md5($DIR).$aj); 
            }else{
                
                $buff=htmlspecialchars_decode($_POST['content']);
                
            }
            
        }
        //TODO:file_update:form
        ?>
<script type="text/javascript" src="/dg_system/dg_js/markitup/jquery.markitup.pack.js"></script>
<link rel="stylesheet" type="text/css" href="/dg_system/dg_js/markitup/skins/simple/style.css" />		 			 
<script type="text/javascript" src="/dg_system/dg_js/markitup/sets/default/set.js"></script>
<link rel="stylesheet" type="text/css" href="/dg_system/dg_js/markitup/sets/default/style.css" />				 			 
		 			 
		 			 
	<script type="text/javascript">
	$(function() {
		$("#filecontent").markItUp(mySettings);
		
	});
	</script>        
     <h2><?if(!$edit){ echo $this->LANG['compsource']['filemanager_add_file']; }else{ echo $this->LANG['compsource']['filemanager_edit_file']; }?></h2>
        <form method="post">
         <?=$this->_security->creat_key()?>
            <div class="dg_form">
                <? if ($error!=''){?><div class="dg_error"><?=$error?></div><p>&nbsp;</p><?}  ?>
                <?if(!$edit){?><p><?=$this->LANG['compsource']['filemanager_name_file']?><br /><input type="text" name="name" value="<?=$_POST['name']?>" /></p><?}else{?>
                                <p><?=str_replace(_DR_,'',$DIR.urldecode($_GET['file']))?></p>
                                <input type="hidden" name="name" value="<?=urldecode($_GET['file'])?>" />
                <?}?>
                <p><?=$this->LANG['compsource']['filemanager_content_file']?><br />
                    <textarea name="content" id="filecontent"><?=htmlspecialchars($buff)?></textarea>
                </p>
                <p><input type="submit" name="go" value="<?=$this->LANG['main']['next']?>" /></p>
            </div>
        </form>
        
        <?
     }   
    }
    
    if ($this->_func=='file_remove'){//TODO:file_remove
    /**
    *удаляем файл
    */
    if ($this->access('filemanager','edit') && $this->access('filemanager','remove')){
        echo '<h2>'.$this->LANG['compsource']['filemanager_delete_file'].'</h2>';
            if($this->accesspassword()){
             
             if(file_exists($DIR.$_GET['file']) && is_file($DIR.$_GET['file']) && $_GET['file']!=''){
                dg_file::chmod($DIR.$_GET['file'],0777);
                unlink($DIR.$_GET['file']);
             }
             
                header("Location:"._URL_."index&dir=".md5($DIR).$aj);                
            }        
     }
    }
    
    if($this->_func=='clearcache'){//TODO:clearcache
    /**
    *чистим кэш, и временную папку
    */
        echo '<h2>'.$this->LANG['compsource']['filemanager_clear'].'</h2>';
            if($this->accesspassword()){
                $f = new dg_file;
                $f->full_del_dir(_DR_.'/cache'); mkdir(_DR_.'/cache',_CHMOD_DIR_);
                $f->full_del_dir(_DR_.'/temp');  mkdir(_DR_.'/temp',_CHMOD_DIR_);
                header("Location:"._URL_."index".$aj);   
            }        
    }
    
    if ($this->_func=='backup'){//TODO:backup
    /**
    *резервная копия
    */
    if ($this->access('filemanager','backup')){    
        if ( array_key_exists('step',$_GET) ){

            if ($_GET['step']=='search'){
                
                
                function searchdir($d){

                        if ( $d{(strlen($d)-1)}!='/' ){ $d=$d.'/'; }
                        
                        $str="------".$d."\n";
                        
                    ?>
                    
                    <script>$("#progress").progressbar({value: 0}).text('scan: <?=str_replace(_DR_,'',$d)?>');</script>
                
                    
                    <?                    
                         $dir = opendir ($d);
                          while ( $file = readdir ($dir))
                          {
                            if (( $file != ".") && ($file != ".."))
                            {
                              if (is_dir($d.$file) && $file!='.svn'){
                              $str.=  searchdir($d.$file);
                              }                               
                              if (is_file($d.$file)){
                                $str.=$d.$file."\n";
                              }
                             
                            }
                          }
                          closedir ($dir);
                         return $str;
                }
                

                
                ?>
                
                <script>$("#progress").progressbar({value: 0}).text('<?=$this->LANG['compsource']['filemanager_backup_scan']?>');</script>
                
   <?
  
   $key = md5(rand());

    $f = new dg_file;            
    $f->create(_DR_.'/temp/d___'.$key.'.txt',searchdir($DIR));           
   
   ?>             
                
                <script>$("#progress").progressbar({value: 100}).text('load...');</script>
                <script>
                
                $(document).ready(function()	{
                	$("#res").load('<?=_URL_?>backup&step=createdirs&key=<?=$key?>&start=1');
                				})
                
                </script>
                <?
                
            }
            
        if ($_GET['step']=='createdirs'){
            
            if (!is_numeric($_GET['start']) || $_GET['start']==''){ $_GET['start']=0; }
            
            $buff = dg_file::read(_DR_.'/temp/d___'.$_GET['key'].'.txt');
            $ex = explode('------',$buff);
            
            if ($_GET['start']<=(count($ex)+1)){
                
                $zip = new ZipArchive;
                if ($zip->open(_DR_.'/temp/d___'.$_GET['key'].'.zip', ZIPARCHIVE::CREATE) === TRUE) {
                
                $inex=explode("\n",$ex[$_GET['start']]);
                $m=0;
                $dname='';
                foreach($inex as $i=>$v){
                	if (trim($v)!=''){
                	   
                	   
                       if ($m==0){
                        ?>
                        <script>$("#progress").progressbar({value: <?=($m*100/count($ex))?>}).text('<?=str_replace($SYSDIR,'',$v)?>');</script>
                        <?
                        
                        
                            
                                $dname = str_replace(_DR_.'/files/','',$v);
                                if($zip->addEmptyDir($dname)) {
                                    
                                    
                                    ?>
                                    <script>$("#progress").text('<?=$dname?> ok');</script>
                                    <?
                        
                                } else {
                                    ?>
                                    <script>$("#progress").text('<?=$dname?> error');</script>
                                    <?
                                    exit;
                                }
                                
                            

                        
                       }else{
                        
                              if ($zip->addFile($v,str_replace(_DR_.'/files/','',$v))){

                                    
                                    ?>
                                    <script>$("#progress").text('<?=str_replace(_DR_.'/files/','',$v)?> ok');</script>
                                    <?
                       
                                } else {
                                    ?>
                                    <script>$("#progress").text('<?=str_replace(_DR_.'/files/','',$v)?> error');</script>
                                    <?
                                    exit;
                                }
                        
                       }
                       
                       $m++;
                       
                	}
                }
                
                $zip->close();
                
                }else{
                                    ?>
                                    <script>$("#progress").text('error open zip file');</script>
                                    <?                    
                }
                ?>
                <script>
                
                $(document).ready(function()	{
                	$("#res").load('<?=_URL_?>backup&step=createdirs&key=<?=$_GET['key']?>&start=<?=$_GET['start']+1?>');
                				})
                
                </script>                
                <?
                
            }else{
                
                                                    ?>
                                    <script>
                                        $("#progress").html('<a href="/temp/d___<?=$_GET['key']?>.zip"><?=$this->LANG['main']['download']?></a>');
                                        $("#go").css('display','block');
                                        </script>
                                    
                                    <?
            }
            
        }    


        }else{
        
     
        ?>
        
        <script>
        $(document).ready(function()	{
        	$("#go").click(function(){
        	   $("#progress").progressbar({value: 0}).text('<?=$this->LANG['compsource']['filemanager_backup_scan']?>');
        	   $("#res").load('<?=_URL_?>backup&step=search');
               $("#go").css('display','none');
        	});
        				})
        </script>
        <h2><?=$this->LANG['compsource']['filemanager_backup']?></h2>
        
        <div class="dg_form">
         <div id="progress"><p><?=$this->LANG['compsource']['filemanager_backup_info']?></p></div>
         <p><input type="button" id="go" value="<?=$this->LANG['main']['next']?>" /></p>
        </div>
        <div id="res"></div>
        <?
        }
      }  
    }
    
    
    
    $this->_right='
        <h2>'.$this->LANG['compsource']['filemanagername'].'</h2>
        <li style="background:url(/dg_system/dg_img/icons/site_backup_and_restore.png) no-repeat left center;"><a href="'._URL_.'backup">'.$this->LANG['compsource']['filemanager_backup'].'</a></li>
        <li style="background:url(/dg_system/dg_img/icons/wait.png) no-repeat left center;"><a href="'._URL_.'clearcache">'.$this->LANG['compsource']['filemanager_clear'].'</a></li>
        <div class="r"></div>
    ';
        
    }
}
?>