<?php

/**
 * @author mrhard
 * @copyright 2010
 */

defined("ADMIN") or die ("ERR");
$param = explode(';',$inf['param']);

 if ( array_key_exists('cancel',$_POST) ){
 	header("Location:"._URL_.'index');
 }
 if ( is_numeric($_POST['page_id']) ){
 	
    $row = $this->_Q->QA("SELECT * FROM <||>pages WHERE `id`='".$this->_Q->e($_POST['page_id'])."'");
    $ex = explode(':',$row['comp']);
    
     if ( trim($_POST['tpl'])!=''){
     	if (!is_numeric($_POST['total'])) $_POST['total']=5;
        $p=$row['id'].';'.$ex[1].';'.$_POST['tpl'].';'.$_POST['total'];
        
            $this->_Q->_table="mods";
            $this->_Q->_arr = array('param'=>$p);
            $this->_Q->_where="WHERE `id`=".$inf['id'];
            $this->_Q->QU();
            header("Location:"._URL_.'index');
        
     }
   ?>
  
   <form method="post" class="dg_form">
   <?=$this->_security->creat_key()?>
   <h2><?=$this->LANG['mod_configurationcomponent']['pageuse'].': '.$row['name']?></h2>
   <p><?=$this->LANG['mod_configurationcomponent']['tpluse']?><br /><select name="tpl"><?
   
  $d =  _DR_.'/_comp/'.$this->inf['info']['dir'].'/'.$ex[1].'/_tpl/';
             		if (file_exists($d)){	 
                          $opendir = opendir ($d);
            		      while ( $file = readdir ($opendir))
            		      {
            		        if (( $file != ".") && ($file != "..") && (is_dir($d.$file)) && $file!='.svn')
            		        {
                                   if ($param[0]==$row['id'] && $param[1]==$ex[1] && $param[2]==$file) $sel=' selected ';  
                                  echo '<option value="'.$file.'"'.$sel.'>'.$file.'</option>';  

            		        }
            		      }
            		      closedir ($opendir);
                       }
   
   ?></select></p>
   <p><?=$this->LANG['mod_configurationcomponent']['totaluse']?><br /><input type="text" size="5" name="total" value="<?=$param[3]?>" /></p>
   <input type="hidden" name="page_id" value="<?=$row['id']?>" />
   <p><input type="submit" name="go" value="<?=$this->LANG['main']['next']?>" /> <input type="submit" name="cancel" value="<?=$this->LANG['main']['cancel']?>" /></p>
   </form>
   <?
    
    
    
 }else{
?>
<form method="post" class="dg_form">
    <p>
        <?=$this->LANG['mod_configurationcomponent']['pageuse']?><br />
        <select name="page_id">
        <?
            $QW = $this->_Q->QW("SELECT * FROM <||>pages WHERE `comp` LIKE 'conf:%'");
            foreach($QW as $i=>$row){
            	if ($row[0]!=''){
            	   $ex = explode(':',$row['comp']);
                   $sel='';
                   if ($param[0]==$row['id']) $sel=' selected ';
                   echo '<option value="'.$row['id'].'"'.$sel.'>'.$row['name'].'</option>';
                   
            	}
            }
        ?>
        </select>
    </p>
    <p><input type="submit" name="s2" value="<?=$this->LANG['main']['next']?>" /> <input type="submit" name="cancel" value="<?=$this->LANG['main']['cancel']?>" /></p>
</form>
<?}?>