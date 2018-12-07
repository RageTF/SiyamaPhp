<?php

/**
 * @author mrhard
 * @copyright 2010
 */

defined("ADMIN") or die ("ERR");
defined("CONTENT") or die ("ERR");
if ($this->_Q->dg_table_exists('texts')){
    
    if ($this->_Q->QN("SELECT * FROM <||>texts WHERE `page`='".$inf['id']."'")==0){
        
        $arr['page']=$inf['id'];
        $this->_Q->_arr = $arr;
        $this->_Q->_table="texts";
        $this->_Q->QI();
        
    }
    
}

$text = $this->_Q->QA("SELECT * FROM <||>texts WHERE `page`='".$inf[id]."'");

if ( array_key_exists('text',$_POST) ){
    $arr='';
    $arr['text'] = htmlspecialchars_decode($_POST['text']);
    $this->_Q->_arr = $arr;
    $this->_Q->_table="texts";
    $this->_Q->_where = " WHERE `page`='".$inf['id']."'";
    $this->_Q->QU();
     $fc = new dg_file;
     $fc->clearcache('page'); 
     lastmod();

    if (!$this->_ajax){header("Location:"._COMP_URL_.'index&c='.rand());} else{ echo 'ok'; exit; }
}

	 



?>
<form method="post" autocomplete="off"  >
<div class="dg_form">
    <p><textarea class="wwg" name="text"><?= htmlspecialchars($text['text']) ?></textarea></p>
    <p><input type="submit" name="save" value="<?=$this->LANG['main']['save']?>" /></p>
    <?=$this->_security->creat_key()?>
</div> 
</form>
<?
$this->plugin('wysiwyg');
?>