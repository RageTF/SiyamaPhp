<?php

/**
 * @author mrhard
 * @copyright 2010
 */

defined("ADMIN") or die ("ERR");
defined("CONTENT") or die ("ERR");
 if ( array_key_exists('go',$_POST) ){
 	$this->_regedit->edit('sendadminmailto'.$inf['id'],$_POST['mail']);
 }
  
?>
<form method="post" class="dg_form">
    <p>e-mail to <input type="e-mail" name="mail" value="<?= $this->_regedit->read("sendadminmailto".$inf['id'],'admin@'.$_SERVER['HTTP_HOST'])?>" /> <input type="submit" name="go" value="Сохранить" /></p>
</form>