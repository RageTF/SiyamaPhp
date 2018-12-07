<?php

/**
 * @author mrhard
 * @copyright 2010
 */

if ($this->access('blockmodules','access')){
define(_URL_,'/dg_admin/?comp=design&use=blockmodules&func=');

$this->_right='
<li style="background:url(/dg_system/dg_img/icons/add.png) no-repeat left center;"><a href="'._URL_.'update">'.$this->LANG['compdesign']['blockmodules_add'].'</a></li>
';
 
 
 if ($this->_func=='index'){
    echo '<h2>'.$this->LANG['compdesign']['blockmodulesname'].'</h2>';
    
    ?>
    <div class="help"><?=$help['index']?></div><p>&nbsp;</p>
    <div class="dg_form dg_table dg_list w95">
    
    
                      <div class="dg_tr head">
                        <div class="dg_td w40"><?=$this->LANG['blockmodules']['tbl_ind']?></div>
                        <div class="dg_td w35"><?=$this->LANG['blockmodules']['tbl_des']?></div>
                        <div class="dg_td w15"><?=$this->LANG['blockmodules']['tbl_mod']?></div>
                        <div class="dg_td w5">&nbsp;</div>
                       </div>
    
    <?
    
    $QW = $this->_Q->QW("SELECT * FROM <||>mods");
    foreach($QW as $i=>$row){
    	if ($row[0]!=''){
    	   
              $infoxml = _DR_.'/dg_lib/dg_modules/'.$row['mod'].'/info.xml';
              if (file_exists($infoxml) && file_exists(_DR_.'/dg_lib/dg_modules/'.$row['mod'].'/admin.php')){
                $c = simplexml_load_file($infoxml);
                foreach($c as $e=>$p){ $param[$e]=$p;}
                $modinfo = $param['original'];
                if ( array_key_exists($this->LANGLOAD->_def,$param) ){ $modinfo = $param[$this->LANGLOAD->_def]; }  
           
                	   ?>
                       
                       <div class="dg_tr">
                        <div class="dg_td w40"><a href="<?=_URL_?>setting&id=<?=$row['id']?>"><?=$row['name']?></a></div>
                        <div class="dg_td w35 comment"><?=$row['des']?></div>
                        <div class="dg_td w15"><a href="<?=_URL_?>update&id=<?=$row['id']?>"><?=$modinfo?></a></div>
                        <div class="dg_td w5"><a href="<?=_URL_?>remove&id=<?=$row['id']?>&re=<?=urlencode($_SERVER["REQUEST_URI"])?>" class="removeaccess"><img src="/dg_system/dg_img/icons/cross.png" title="<?=$this->LANG['main']['remove']?>" align="absmiddle" /></a></div>
                       </div>
                       
                       <?
           
           }
    	}
    }
    
    ?>
    </div>
    
    
    <?
    
 }
 
 
 
 if ($this->_func=='update'){//TODO:update
 
 if (array_key_exists('id',$_GET) && is_numeric($_GET['id'])){
    $inf = $this->_Q->QA("SELECT * FROM <||>mods WHERE `id`='".$this->_Q->e($_GET['id'])."'");
 }
 
 if ($inf['id']==''){
    echo '<h2>'. $this->LANG['compdesign']['blockmodules_add'].'</h2>';
 }else{
    echo '<h2>'. $this->LANG['compdesign']['blockmodules_edit'].'</h2>';
 }
 
  if ( array_key_exists('go',$_POST) ){
  	$error='';
    
    if (trim($_POST['name'])==''){ $error.='<li>'.$this->LANG['blockmodules']['inp_ind'].'</li>'."\n"; }else{
        if ($this->_Q->QN("SELECT `name` FROM <||>mods WHERE `name`='".$this->_Q->e( htmlspecialchars_decode($_POST['name']) )."'")>0 && htmlspecialchars_decode($_POST['name'])!=$inf['name']){
            $error.='<li>'.$this->LANG['blockmodules']['inp_ind_error'].'</li>'."\n";
        }
    }
    
    
    if ($error==''){
        
        
        $this->_Q->_table="mods";
        $this->_Q->_arr = array('name'=>htmlspecialchars_decode($_POST['name']),'mod'=>$_POST['mod'],'des'=>htmlspecialchars_decode($_POST['des']));
        if ($inf['name']==''){
            $inf['id'] = $this->_Q->QI();
        }else{
            $this->_Q->_where=" WHERE `id`=".$inf['id'];
            $this->_Q->QU();
        }
        header("Location:"._URL_.'setting&id='.$inf['id']);
    }
    
  }

    
    ?>
    <div class="help"><?=$help['update']?></div><p>&nbsp;</p>
    <form method="post">
     <?=$this->_security->creat_key()?>
        <div class="dg_form">
        <?if ($error!=''){?>  <div class="dg_error"><?=$error?></div><p>&nbsp;</p> <?}?>
        <p><?=$this->LANG['blockmodules']['inp_ind']?><br /><input type="text" name="name" value="<?=htmlspecialchars($inf['name'])?>" required /></p>
        <p><?=$this->LANG['blockmodules']['inp_select']?><br /><select name="mod">
        <?
        
        $dir = opendir (_DR_.'/dg_lib/dg_modules/');
          while ( $file = readdir ($dir))
          {
            if (( $file != ".") && ($file != "..") && is_dir(_DR_.'/dg_lib/dg_modules/'.$file) && substr_count($file,'.sample')==0 && $file!='.svn')
            {
              $infoxml = _DR_.'/dg_lib/dg_modules/'.$file.'/info.xml';
              if (file_exists($infoxml) && file_exists(_DR_.'/dg_lib/dg_modules/'.$file.'/admin.php')){
                $c = simplexml_load_file($infoxml);
                foreach($c as $e=>$p){ $param[$e]=$p;}
                $modinfo = $param['original'];
                if ( array_key_exists($this->LANGLOAD->_def,$param) ){ $modinfo = $param[$this->LANGLOAD->_def]; }              
                $sel=''; if ($inf['mod']==$file){
                    $sel=' selected ';
                }
                echo '<option value="'.$file.'" '.$sel.'>'.$modinfo.'</option>';
                
              }
            }
          }
          closedir ($dir);
        
        
        ?></select></p>
        <p><?=$this->LANG['blockmodules']['inp_des']?><br /><textarea  name="des"><?=htmlspecialchars($inf['des'])?></textarea></p>
        <p><input type="submit" name="go" value="<?=$this->LANG['main']['next']?>" /></p>
        </div>
    </form>
    
    
    <?
    
 }
 
 
  if ($this->_func=='setting'){//TODO:setting
 
     if (array_key_exists('id',$_GET) && is_numeric($_GET['id'])){
        $inf = $this->_Q->QA("SELECT * FROM <||>mods WHERE `id`='".$this->_Q->e($_GET['id'])."'");
        $infoxml = _DR_.'/dg_lib/dg_modules/'.$inf['mod'].'/info.xml';
        
 
        
        if ( file_exists(_DR_.'/dg_lib/dg_modules/'.$inf['mod'].'/admin.php') && file_exists($infoxml) ){
            
                $c = simplexml_load_file($infoxml);
                foreach($c as $e=>$p){ $param[$e]=$p;}
                $modinfo = $param['original'];
                if ( array_key_exists($this->LANGLOAD->_def,$param) ){ $modinfo = $param[$this->LANGLOAD->_def]; }  
                $this->LANGLOAD->load('mod',$inf['mod']);
                $this->LANG = $this->LANGLOAD->LANG;
                ?> <h2><?=$modinfo?> &rarr; <?=$inf['name']?></h2> <?   
            
            include_once  _DR_.'/dg_lib/dg_modules/'.$inf['mod'].'/admin.php';
        }
        
     }
 
 }
 
 if ($this->_func=='remove'){
      if (array_key_exists('id',$_GET) && is_numeric($_GET['id'])){
        $inf = $this->_Q->QA("SELECT * FROM <||>mods WHERE `id`='".$this->_Q->e($_GET['id'])."'");
        
        if ($this->accesspassword()){
            $this->_Q->_table = 'mods';
            $this->_Q->_where=" WHERE `id`=".$inf['id'];
            $this->_Q->QD();
            header("Location:"._URL_.'index');
        }
        
        }   
 }
 
 if ($this->_func!='index'){
    
    $this->_right.='<li style="background:url(/dg_system/dg_img/icons/layout.png) no-repeat left center;"><a href="'._URL_.'index">'.$this->LANG['compdesign']['blockmodulesnamelist'].'</a></li>';
    
    $fc = new dg_file;
    $fc->clearcache('mod');
    
 }
}
?>