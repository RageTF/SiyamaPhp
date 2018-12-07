<?php
define('MAIL_FROM','robot@'.$_SERVER['HTTP_HOST']);
define('MAIL_TO',$this->_regedit->read("sendadminmailto".$this->_infoPAGE['id'],'admin@'.$_SERVER['HTTP_HOST']));
define('MAIL_SUBLECT',$this->_infoPAGE['name'].' Новое сообщение');
/**
 * @author mrhard
 * @copyright 2010
 */
defined("CONTENT") or die ("ERR");


?>
<form method="post">
    <div class="sendmailform main">
    <h1><?=$this->_infoPAGE['name']?></h1><?
     if ( array_key_exists('go',$_POST) ){
 	$error='';
    if (trim($_POST['name'])==''){ $error.='<li>Заполните поле: Имя</li>'."\n"; }
    if (trim($_POST['contact'])==''){ $error.='<li>Заполните поле: Контакты</li>'."\n"; }
    //if (trim($_POST['e-mail'])==''){ $error.='<li>Заполните поле: e-mail</li>'."\n"; }
    //if (trim($_POST['org'])==''){ $error.='<li>Заполните поле: Организация</li>'."\n"; }
    //if (trim($_POST['inn'])==''){ $error.='<li>Заполните поле: ИНН</li>'."\n"; }
    //if (trim($_POST['kpp'])==''){ $error.='<li>Заполните поле: КПП</li>'."\n"; }
    //if (trim($_POST['ogrn'])==''){ $error.='<li>Заполните поле: ОГРН(-ИП)</li>'."\n"; }
    if ($error!=''){
        echo '<div class="error">Ошибка отправки<ul>'.$error.'</ul></div>';
    }else{
        $message='';
        $message.='Имя :'.strip_tags($_POST['name']).'<br/>';
        $message.='Контакты :'.strip_tags($_POST['contact']).'<br/>';
       // $message.='e-mail :'.strip_tags($_POST['e-mail']).'<br/>';
       // $message.='Организация :'.strip_tags($_POST['org']).'<br/>';
       // $message.='ИНН :'.strip_tags($_POST['inn']).'<br/>';
      //  $message.='КПП :'.strip_tags($_POST['kpp']).'<br/>';
       // $message.='ОГРН(-ИП) :'.strip_tags($_POST['ogrn']).'<br/>';
        send_mail(MAIL_FROM,MAIL_FROM,MAIL_TO,MAIL_SUBLECT,$message);
        header("Location:"._URL_.'?truesend');
    }
 }
 if (array_key_exists('truesend',$_GET)) echo '<h3>Спасибо! Ваша заявка будет обработана в ближайшее время</h3><meta http-equiv="Refresh" content="7; url='._URL_.'" />';
    ?>
        <p>Ваше имя<br /><input type="text" name="name" required /></p>
        <p>Контакты<br /><input type="text" name="contact" required  /></p>
        <p><input type="submit" name="go" value="отправить" /></p>
    </div>
</form>