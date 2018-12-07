<?php

/**
 * @author mrhard
 * @copyright 2010
 */
defined("ADMIN") or die ("ERR");

$timesones="UTC-12:Pacific/Kwajalein;
UTC-11:Pacific/Samoa;
UTC-10:US/Hawaii;
UTC-9:US/Alaska;
UTC-8:US/Pacific;
UTC-7:US/Arizona;
UTC-6:America/Mexico_City;
UTC-5:US/East-Indiana;
UTC-4:America/Santiago;
UTC-3:America/Buenos_Aires;
UTC-2:Brazil/DeNoronha;
UTC-1:Atlantic/Cape_Verde;
UTC-2:Europe/London;
UTC+1:Europe/Berlin;
UTC+2:Europe/Kiev;
UTC+3:Europe/Moscow;
UTC+4:Europe/Samara;
UTC+5:Asia/Yekaterinburg;
UTC+6:Asia/Novosibirsk;
UTC+7:Asia/Krasnoyarsk;
UTC+8:Asia/Irkutsk;
UTC+9:Asia/Yakutsk;
UTC+10:Asia/Vladivostok;
UTC+11:Asia/Magadan;
UTC+12:Asia/Kamchatka;
UTC+13:Pacific/Tongatapu;
UTC+14:Pacific/Kiritimati";


if ( array_key_exists('saveother',$_POST)){
    
    $this->_regedit->edit('timezone',strip_tags($_POST['datetime_timezone']));
    $this->_regedit->edit('formatdate',strip_tags($_POST['datetime_date']));
    $this->_regedit->edit('formattime',strip_tags($_POST['datetime_time']));
    $this->_regedit->edit('formatdatetime',strip_tags($_POST['datetime_datetime']));
    
}

?>
<p><?=$this->LANG['inclsetting']['datetime_timezone']?>:<br /> <select name="datetime_timezone">
    <?
    
    $ex=explode(";",$timesones);
    foreach($ex as $i=>$v){
    	if (trim($v)!=''){
    	   $v = str_replace("\n",'',$v);
           $v = str_replace("\r",'',$v);
    	   $inex = explode(':',$v);
           $sel = '';
           if ($this->_regedit->read("timezone","Europe/Moscow")==$inex[1]) $sel=' selected ';
           
           echo '<option value="'.$inex[1].'"'.$sel.'>'.$inex[0].' ('.$inex[1].')</option>';
    	}
    }
    
    ?>
</select></p>

<p><?=$this->LANG['inclsetting']['datetime_dateformat']?>:<br /> <input type="text" name="datetime_date" value="<?=$this->_regedit->read("formatdate","d.m.Y")?>" /></p>
<p><?=$this->LANG['inclsetting']['datetime_timeformat']?>:<br /> <input type="text" name="datetime_time" value="<?=$this->_regedit->read("formattime","H:i")?>" /></p>
<p><?=$this->LANG['inclsetting']['datetime_datetimeformat']?>:<br /> <input type="text" name="datetime_datetime" value="<?=$this->_regedit->read("formatdatetime","d.m.Y (H:i)")?>" /></p>
<div class="r"></div>