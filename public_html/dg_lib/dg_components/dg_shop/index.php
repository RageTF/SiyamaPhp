<?php

/**
 * @author mrhard
 * @copyright 2010
 */
defined("CONTENT") or die ("ERR");
if ($this->_func=="exportimg"){//TODO:exportimg

 
 


function resize ($filename, $size,$name,$page_name,$price1,$total1,$price2,$total2)
{
    $DIR = _DR_.'/imgexport/'. mb_convert_encoding($page_name,'windows-1251','UTF-8') .'/';
    if (!file_exists($DIR)) mkdir($DIR,0777);
$pref = $DIR.'mini_';
$img = strtolower(strrchr(basename($filename), "."));
$imgname = basename($filename);
$formats = array('.jpg', '.gif', '.png', '.bmp');
if (in_array($img, $formats))
{
list($width, $height) = getimagesize($filename);
$new_height = $height * $size;
$new_width = $new_height / $width;
$thumb = imagecreatetruecolor($size, $new_width);
switch ($img)
{
case '.jpg': $source = @imagecreatefromjpeg($filename); break;
case '.gif': $source = @imagecreatefromgif($filename); break;
case '.png': $source = @imagecreatefrompng($filename); break;
case '.bmp': $source = @imagecreatefromwbmp($filename); break;
}
$www = 100;

$curcolorW = imagecolorallocate( $thumb, 255, 255, 255);
$curcolorG = imagecolorallocate( $thumb, 100, 100, 100);
$curcolorR = imagecolorallocate( $thumb, 255, 0, 0);
$font = _DR_.'/calibri-webfont.ttf';//шрифт текста


imagecopyresized($thumb, $source, $www, $www, $www, $www, $size-($www*2), $new_width-($www*2), $width-($www*2), $height-($www*2));
imagettftext($thumb, 18, 0, $www, 50, $curcolorW, $font, $name); 
imagettftext($thumb, 16, 0, $www, 80, $curcolorG, $font, $page_name); 
$priceline='';
$t1='';
if (trim($total1)!='') $t1=' ('.$total1.')';
$priceline[] = 'Цена: '.number_format($price1,0,' ',' ').' тг.'.$t1;

$t2='';
if (trim($total2)!='') $t2=' ('.$total2.')';
if ($price2!='' AND $price2>0 AND $price2!=0) $priceline[] = ''.number_format($price2,0,' ',' ').' тг.'.$t2;
$pricelineim='';
if (is_array($priceline)) $pricelineim = implode(', ',$priceline);

imagettftext($thumb, 12, 0, $www, ($size-($www/2)), $curcolorR, $font, $pricelineim); 
#imagettftext($thumb, 14, 0, $www+($size/2-20), (50), $curcolorW, $font, ''); 
imagettftext($thumb, 12, 0, $www+($size/2-110), (80), $curcolorW, $font, 'заказ: 62-71-71 www.siyama.ru'); 







                $logoImage = ImageCreateFromPNG(_DR_._TPL_.'/img/w.png');
                $size_wm = getimagesize(_DR_._TPL_.'/img/w.png');
                imagecopyresampled ($thumb, $logoImage,0,0, 0, 0, $size, $new_width, $size_wm[0], $size_wm[1]);





switch ($img)
{
case '.jpg': imagejpeg($thumb, $pref.$imgname,100); break;
case '.gif': imagegif($thumb, $pref.$imgname); break;
case '.png': imagepng($thumb, $pref.$imgname); break;
case '.bmp': imagewbmp($thumb, $pref.$imgname); break;
}
}
else return 'Error';


@imagedestroy($thumb);
@imagedestroy($source);
return str_replace(_DR_,'',$DIR) . $imgname;
}




	    $QW = $this->_Q->QW("SELECT * FROM dg_mycomp__cat WHERE `img`<>'' LIMIT 200,50");
     foreach($QW as $i=>$row){
     	if ($row[0]!=''){
     	   
            $page = $this->_Q->QA("SELECT * FROM <||>pages WHERE `id`=".$row['sys_page']." LIMIT 1");
            echo '<img src="'.resize(_DR_.$row['img'],600,$row['name'],$page['name'],$row['price1'],$row['total1'],$row['price2'],$row['total2']).'" />';
     	}
     }

}

if ($this->_func=="index"){//TODO:index

	?>
    <h1>Ваша корзина</h1>    <?
    
    
    
    ?><form method="post" id="dgshop_order_form" ><?
    
    
    $group = 0;
    if ($this->_infoUSER['id']!=''){
    if (is_numeric($_GET['group'])){
        
        $g = $this->_Q->QA("SELECT * FROM <||>dg_shop__orders_group WHERE `id`=".$_GET['group']." AND `user_id`=".$this->_infoUSER['id']);
        if ($g['id']!=''){
            
            
            $group = $g['id'];
            
            echo '<h2>';
            echo 'Заявка № '.$group;
            if ($g['time']!='') echo ' от '.date("d.m.Y",$g['time']);
            echo '</h2><p>Стаус: <strong>'.$GLOBALS['order_st'][$g['st']].'</strong></p>';
            
            if ($g['st']==1){
                
                
                if (array_key_exists('dgshop_togroup',$_POST)){
                    
                    foreach($_POST as $i=>$v){
                    	$_POST[$i] = htmlspecialchars_decode($v);
                    }
                    
                    if (trim($_POST['fio'])=='') $error.='<li>Заполните поле Ф.И.О. получателя</li>'."\n";
                    if (trim($_POST['address_street'])=='') $error.='<li>Заполните поле Адрес получателя, Улица</li>'."\n";
                    if (trim($_POST['address_home'])=='') $error.='<li>Заполните поле Адрес получателя, Номер дома</li>'."\n";
                    if (trim($_POST['tel'])=='') $error.='<li>Заполните поле Телефон получателя</li>'."\n";
                    //if (!is_numeric($_POST['tel']) OR strlen($_POST['tel'])!=11 OR substr($_POST['tel'],0,1)!=7) $error.='<li>Номер телефона заполнен не правильно</li>'."\n";
                    if (!is_numeric($_POST['total_person'])) $error.='<li>Укажите количество персон</li>'."\n";
                    
                }
                
                ?>
                <script>
                $(document).ready(function()	{
                    var send = false;
                	$("#dgshop_order_form").submit(function(){
                	   send = true;
                       if ($("#fio").val()=='') { alert ("Заполните Ф.И.О. получателя"); $("#fio").focus(); return false;}
                       if ($("#address_street").val()=='') { alert ("Заполните Адрес получателя, Улица"); $("#address_street").focus(); return false;}
                       if ($("#address_home").val()=='') { alert ("Заполните Адрес получателя, Номер дома"); $("#address_home").focus(); return false;}
                       if ($("#total_person").val()=='' OR $("#total_person").val()!=parseInt($("#total_person").val())) { alert ("Укажите количество персон"); $("#total_person").focus(); return false;}
                       if ($("#tel").val()=='' OR $("#tel").val()!=parseInt($("#tel").val())) { alert ("Заполните Телефон получателя"); $("#tel").focus(); return false;}
                	});
                    $(window).bind('beforeunload', function(){
                                if (!send) return 'Вы не отправили данные о заказе';
                    });
                				})
                </script>
                <h3>Для продолжения оформления заявки нам необходимы следующие данные: </h3>
                
                <div class="dg_shop_reg_form"><? if ($error!='') echo '<ul class="error">'.$error.'</ul>'; ?>
                    <p>Ф.И.О. получателя <span class="red">*</span><br /><input required="required" class="w20" type="text" name="fio" id="fio"  value="<? if ($_POST['fio']=='') echo htmlspecialchars($this->_infoUSER['name']); else echo htmlspecialchars($_POST['fio']);  ?>" /></p>
                     
                    
                    <div class="dg_table w100">
                    	<div class="dg_tr">
                    		<div class="dg_td w50"><p>Улица <span class="red">*</span><br /><input required="required" type="text" id="address_street" name="address_street" value="<? if ($_POST['address_street']=='') echo htmlspecialchars($this->_infoUSER['address_street']); else echo htmlspecialchars($_POST['address_street']);  ?>" /></p>
                    <p>Номер дома <span class="red">*</span><br /><input required="required" type="text" id="address_home" name="address_home" value="<? if ($_POST['address_home']=='') echo htmlspecialchars($this->_infoUSER['address_home']); else echo htmlspecialchars($_POST['address_home']);  ?>" size="5" /></p>
                    <p>Корпус<br /><input type="text" name="address_k" value="<? if ($_POST['address_k']=='') echo htmlspecialchars($this->_infoUSER['address_k']); else echo htmlspecialchars($_POST['address_k']);  ?>"  size="5" /></p>
                    <p>Подъезд<br /><input type="text" name="address_p" value="<? if ($_POST['address_p']=='') echo htmlspecialchars($this->_infoUSER['address_p']); else echo htmlspecialchars($_POST['address_p']);  ?>"  size="5" /></p>
                    </div>
                    		<div class="dg_td w50">
                    <p>Код домофона<br /><input type="text" name="address_kp" value="<? if ($_POST['address_kp']=='') echo htmlspecialchars($this->_infoUSER['address_kp']); else echo htmlspecialchars($_POST['address_kp']);  ?>"  size="5" /></p>
                    <p>Этаж<br /><input type="text" name="address_e" value="<? if ($_POST['address_e']=='') echo htmlspecialchars($this->_infoUSER['address_e']); else echo htmlspecialchars($_POST['address_e']);  ?>"  size="5" /></p>
                    <p>Номер квартиры<br /><input type="text" name="address_kv" value="<? if ($_POST['address_kv']=='') echo htmlspecialchars($this->_infoUSER['address_kv']); else echo htmlspecialchars($_POST['address_kv']);  ?>"  size="5" /></p>
                     </div>
                    	</div>
                    </div> 
                     
                     
                    <p>Телефон получателя <span class="red">*</span> (Введите номер телефона , пример 79012345678 : 11 символов, начиная с семерки)<br />+<input required="required" type="text" name="tel" id="tel" value="<? if ($_POST['tel']=='') echo htmlspecialchars($this->_infoUSER['tel']); else echo htmlspecialchars($_POST['tel']);  ?>" /></p>
                    <p>Второй телефон <br /><input  type="text" name="tel2" id="tel2" value="<? if ($_POST['tel2']=='') echo htmlspecialchars($this->_infoUSER['tel2']); else echo htmlspecialchars($_POST['tel2']);  ?>" /></p>
                     
                    <p>Укажите количество персон <span class="red">*</span><br /><input required="required" type="text" size="5" name="total_person" id="total_person" value="<? if ($_POST['total_person']=='') echo htmlspecialchars($this->_infoUSER['total_person']); else echo htmlspecialchars($_POST['total_person']);  ?>" /></p>
                    
                    <p>Комментарий<br /><textarea name="info"><?= htmlspecialchars($_POST['info'])?></textarea></p>
                    
                    <p><strong>Способ оплаты</strong>:<br />
                    <label> <input type="radio" name="money" value="0" <? if ($_POST['money']==0 || $_POST['money']==''){ echo ' checked '; } ?> /> Наличными</label><br />
                    <label> <input type="radio" name="money" value="1" <? if ($_POST['money']==1 ){ echo ' checked '; } ?>/> Оплата пластиковой картой, через курьера</label>
                    </p>
                   
                    
                    <span class="red">*</span> - обязательно для заполнения
                </div>
                
                <?
                
            }
            
            
            
            if ($g['st']==3){
                
                ?>
                <h3>Оплата</h3>
                <?
                
            }
            
            
            
            
            
            
        }
    }
    }
    if ($this->_mobile){
        
        echo '<ul id="orderlist">';
    }else{
    ?>
 
    <table class="w100 orderlist">
    	<tr class="head">
             
    		<td class="w45">Наименование</td>
    		<td class="w25">Кол-во</td>
            <td class="w10">Цена</td>
            <td class="w10">Итого</td>
            <td class="w10">&nbsp;</td>
    	</tr>
    
     <?
}

$total=0;
$price=0;
        $w = "`ses_id`='".$this->_USER->_ses."'";
        if ($this->_infoUSER['id']!='') $w = "`user_id`='".$this->_infoUSER['id']."'";
        
        if (is_numeric($_GET['remove']) && $g['st']<2){
            $this->_Q->_table = 'dg_shop__orders';
            $this->_Q->_where = " WHERE `id`='".$_GET['remove']."' AND (".$w.") ";
            $this->_Q->QD();
            header("Location:"._URL_);
        }

	    $QW = $this->_Q->QW("SELECT * FROM <||>dg_shop__orders WHERE `group_id`=".$group." AND (".$w.")");
         foreach($QW as $i=>$row){
         	if ($row[0]!=''){
         	    if (is_numeric($row['item_id'])) $item = $this->_Q->QA("SELECT * FROM <||>dg_shop__orders_items WHERE `item_id`=".$row['item_id']." LIMIT 1");
                //if ($item['id']!='' || $row['name']!=''){
                    
                    if ($_POST['item_'.$row['id']]==1){
                        $items[]=' `id`='.$row['id'].' ';
                    }
                    $total = $total+$row['total'];
                    $price = $price+$row['total']*$row['price'];
                    $name = '<a href="'.$item['item_url'].'"><strong>'.$row['name'].'</strong></a>';
                    if ($item['id']=='') $name = '<strong><em>'.$row['name'].'</em></strong>';
                    if ($item['item_url']=='') $name = '<strong>'.$row['name'].'</strong><br /><em class="comment">Добавлено администратором</em>';
                if ($this->_mobile){
                    
                    ?>
                    
                        <li class="basket_item"><input type="hidden" value="1" name="item_<?=$row['id']?>"  /><strong><?=strip_tags($name)?></strong>  <br /><?=$row['total']?> шт.  (<?=$GLOBALS['dgshop']->price($row['total']*$row['price'])?> тг.)<? if ($g['st']<2){ ?> <a href="<?=_URL_?>?remove=<?=$row['id']?>" class="remove" >убрать</a><?}?></li>
                    
                    <?
                    
                    
                }else{
                ?>
                
                    <tr class="">
                        
                		<td class=" w45"><?=$name?></td>
                		<td class=" w25"><? if ($g['id']==''){ ?><div name="<?=$row['id']?>"><input type="hidden" value="1" name="item_<?=$row['id']?>"  /><input type="number" class="w30 order_total" value="<?=$row['total']?>" title="<?=$row['total']?>"  /> <span></span></div><?}else echo $row['total'];?></td>
                        <td class=" w10"><span id="price_<?=$row['id']?>"><?=$GLOBALS['dgshop']->price($row['price'])?></span> тг.</td>
                        <td class=" w10"><span id="totalprice_<?=$row['id']?>"><?=$GLOBALS['dgshop']->price($row['total']*$row['price'])?></span> тг.</td>
                        <td class=" w10 center"><? if ($g['st']<2){ ?> <a href="<?=_URL_?>?remove=<?=$row['id']?>" class="remove" onclick="return confirm('Убрать товар из корзины?')">убрать</a><?}?></td>
                        
                	</tr>
                
                <?
                }
               //} 
         	}
         }
         
         if (is_array($items)){
            
            
            
            if ($price<2000) header("Location:"._URL_.'?func=index'); else{
            
            $where = implode(" OR ",$items);
            
                
                if ($g['id']==''){
                
                $this->_Q->_arr='';
                if ($this->_infoUSER['id']!=''){
                $this->_Q->_table = 'dg_shop__orders_group';
                $this->_Q->_arr['user_id']=$this->_infoUSER['id'];
                $ID = $this->_Q->QI();
                $this->_Q->_arr='';
                if (is_numeric($ID) AND $ID!=0){
                    $this->_Q->_table = 'dg_shop__orders';
                    $this->_Q->_arr['group_id'] = $ID;
                    $this->_Q->_where = " WHERE ".$where;
                    $this->_Q->QU();
                    header("Location:"._URL_.'?func=index&group='.$ID);
                }
                }
            
            }
            
           } 
            
         }
         
         if ($g['st']<2 && $error=='' && array_key_exists('dgshop_togroup',$_POST) && $g['id']!=''){
             if ($price<2000)  header("Location:"._URL_.'?func=index');
                    
                                $this->_Q->_table = 'dg_shop__orders_group';
                                $this->_Q->_where = " WHERE `id`=".$g['id'];
                                $arr='';
                                $arr['fio'] = strip_tags($_POST['fio']);
                                $arr['tel2']=strip_tags(htmlspecialchars_decode($_POST['tel2']));
                                $arr['address_street']=strip_tags(htmlspecialchars_decode($_POST['address_street']));
                                $arr['address_home']=strip_tags(htmlspecialchars_decode($_POST['address_home']));
                                $arr['address_k']=strip_tags(htmlspecialchars_decode($_POST['address_k']));
                                $arr['address_p']=strip_tags(htmlspecialchars_decode($_POST['address_p']));
                                $arr['address_kp']=strip_tags(htmlspecialchars_decode($_POST['address_kp']));
                                $arr['address_e']=strip_tags(htmlspecialchars_decode($_POST['address_e']));
                                $arr['address_kv']=strip_tags(htmlspecialchars_decode($_POST['address_kv']));
                                $arr['total_person']=strip_tags(htmlspecialchars_decode($_POST['total_person']));
                                $arr['tel'] = strip_tags($_POST['tel']);
                                $arr['st']=2;
                                $arr['time']=time();
                                $arr['info']=strip_tags($_POST['info']);
                                $arr['money']=strip_tags($_POST['money']);
                                $this->_Q->_arr = $arr;
                                $this->_Q->QU();
                                
                                
                               /* $ArDe = new AD($this->_Q);
                                $ArDe->_host = 'http://'.$this->_regedit->read('dgshop_IPARCHIDELIVERY','89.179.72.52:5858').'/';
                                $ArDe->NEWORDER();*/
                                
                                
                                //echo $this->_Q->_sql;
                                //TODO:sendmail to admin
                                $GLOBALS['dgshop']->sendmailtoadmin('Новая заявка №'.$g['id'],'Необходимо проверить заявку на сайте №'.$g['id']);
                                header("Location:"._URL_.'?func=index');
                    
                }
    if ($this->_mobile){
        
        echo '</ul>';
        
    }else{
    ?>
    </table>
    <?}?>
    <div class="order_info">Итого товаров: <strong class="totalitems"><?=$total?></strong> на сумму: <strong class="totalprices"><?=$GLOBALS['dgshop']->price($price)?></strong> тг.</div>
    <? 
    
    if ($g['method']==2){
        
        	?><div class="order_info_sale">С учетом скидки: <strong class="totalprices_sale"><?=$GLOBALS['dgshop']->price($price-$price*0.1)?></strong> руб.</div><?
        
    }else{
    
    $sale_summ = $GLOBALS['dgshop']->price($price-$GLOBALS['dgshop']->price_sale($price));
    if ($g['id']!='' AND $g['st']>1) $sale_summ = $GLOBALS['dgshop']->price($price-$GLOBALS['dgshop']->price_sale($price,date("G",$g['time'])));
    
    if ($GLOBALS['dgshop']->price_sale($price)>0){ ?><div class="order_info_sale">С учетом скидки: <strong class="totalprices_sale"><?=$sale_summ?></strong> тг.</div><?}?>
    
    
    <? 
    }
    if ($total<=0 AND $g['id']!=''){
        $this->_Q->_table = 'dg_shop__orders_group';
        $this->_Q->_where = " WHERE `id`=".$g['id'];
        $this->_Q->QD();
        header("Location:"._URL_);
    }
    
    
    if ($price<2000){
        echo ' <p>МИНИМАЛЬНАЯ СУММА ЗАКАЗА 2000 ТГ.</p> ';
    }else{
    if ($this->_infoUSER['id']!=''){ if ($g['id']=='' OR $g['st']<2){ ?><input type="submit" class="order_button" name="dgshop_togroup" value="Оформить заявку" /><?}}else{ ?> <p><strong>Для оформления заявки Вам необходимо <a href="<?=_URL_?>?func=reg&re=<?=urlencode($_SERVER["REQUEST_URI"])?>">зарегистрироваться</a> или <a href="<?=_URL_?>?func=auth&re=<?=urlencode($_SERVER["REQUEST_URI"])?>">авторизоваться</a></strong></p> <? }?>
    
    <?} ?>
    
    </form>
    <div class="r"></div>
    <?
    
    if ($this->_infoUSER['id']!=''){
        ?>
            <h2>Заявки</h2>
            <ul class="order_group">
        <?
        
            $QW = $this->_Q->QW("SELECT * FROM <||>dg_shop__orders_group WHERE `user_id`=".$this->_infoUSER['id']." ORDER BY `st`,`id` DESC LIMIT 10");
            foreach($QW as $i=>$row){
            	if ($row[0]!=''){
            	   
                   ?>
                    <li class="order_<?=$row['st']?>"><a href="<?=_URL_?>?func=index&group=<?=$row['id']?>">Заявка № <?=$row['id']?><? if ($row['time']!='' AND $row['time']!=0) echo ' от '.date('d.m.Y',$row['time']) ?></a><br /><?=$GLOBALS['order_st'][$row['st']]?><br /><em><?=htmlspecialchars($row['admin_info'])?></em></li>
                   <?
                   
            	}
            }
        ?></ul><?
    }
    

}

if ($this->_func=="reg" && $this->_infoUSER['id']==''){//TODO:reg

     if ( array_key_exists('go',$_POST) ){
        
        foreach($_POST as $i=>$v){
        	$_POST[$i] = htmlspecialchars_decode($v);
        }
        
     	$error='';
        if (trim($_POST['name'])=='') $error.='<li>Вы не ввели Ф.И.О.</li>'."\n";

        if (trim($_POST['mail'])=='') $error.='<li>Вы не заполнили поле: <strong>Email</strong></li>'."\n"; else {
                if (!preg_match("/[0-9a-z_\-\.]+@[0-9a-z_\-^\.]+\.[a-z]{2,3}/i", $_POST['mail'])){
                         	  $error.='<li>Вы не верно ввели Email</li>'."\n";
                         	}else{
                         	  
                              if ($this->_Q->QN("SELECT `mail` FROM <||>user WHERE `mail`='".$this->_Q->e($_POST['mail'])."'")>0) $error.='<li>Email уже присутствует в базе</li>'."\n";
                              
                         	}
                }
        if (trim($_POST['pass'])=='') $error.='<li>Вы не ввели Пароль</li>'."\n"; else {
            if (strlen(trim($_POST['pass']))<6) $error.='<li>Вы ввели слишком короткий пароль</li>'."\n";
        }
        if ($error==''){
            
            
            $arr='';
            $arr['name'] = strip_tags($_POST['name']);
            $arr['login'] = strip_tags($_POST['mail']);
            $arr['mail'] = strip_tags($_POST['mail']);
            $arr['datereg'] = time();
            $arr['act']=1;
            $arr['pass']=md5($_POST['pass']);
            $this->_Q->_table = 'user';
            $this->_Q->_arr = $arr;
            $userid = $this->_Q->QI();
            
            if ($this->_USER->login($_POST['mail'],$_POST['pass'])){
         	    $re = $_GET['re'];
                if ($re=='') $re = '/';
                if ( substr_count($re,'?func=auth')==1 || substr_count($re,'?func=reg')==1) $re='/';
                header("Location:".urldecode($re));
            }else{
                $error='<li>Упс! Что-то пошло не так</li>';
            }
            
        }
     }

?>
    
    <form method="post">
    
        <div class="reg_form">
            <h1>Регистрация</h1>
            <? if ($error!='') echo '<ul class="error">'.$error.'</ul>'; ?>
            <p>Ф.И.О<br /><input type="text" name="name" value="<?=htmlspecialchars($_POST['name'])?>"  /></p>
            <p>E-mail<br /><input type="email" name="mail" value="<?=htmlspecialchars($_POST['mail'])?>"  /></p>
            <p>Пароль<br /><input type="password" name="pass"  /></p>
            <p><input type="submit" name="go" value="регистрация" /></p>
        </div>
    
    </form>

<?
	

}
if ($this->_func=="repass" && $this->_infoUSER['id']==''){//TODO:repass
?>
 <h1>Забыли пароль?</h1>
<?
if ($_GET['key']!=''){
    
    $inf = $this->_Q->QA("SELECT * FROM <||>user WHERE `key`='".$this->_Q->e($_GET['key'])."'");
    if ($inf['id']!=''){

 	            $pass = substr(md5(rand()),0,6);
                $this->_Q->_arr = array('pass'=>md5($pass),'key'=>'');
                $this->_Q->_table = 'user';
                $this->_Q->_where = "WHERE `mail`='".$this->_Q->e($inf['mail'])."'";
                $this->_Q->QU();            
                
                $mess = ' <p>Вы или кто-то другой сменили пароль на сайте <a href="http://'.$_SERVER['HTTP_HOST']._URL_.'">'. $_SERVER['HTTP_HOST'] .'</a></p>
            <p>Ваш email: <strong>'.$inf['mail'].'</strong><br />Ваш новый пароль: <strong>'.$pass.'</strong></p>';    
            
                send_mail(MAIL_FROM,$_SERVER['HTTP_HOST'],$this->_infoUSER['mail'],"Новый пароль",$GLOBALS['px_mail'].$mess.$GLOBALS['sx_mail']);
                header("Location:"._URL_."?func=repass&truesend");

   
    }else{
        echo ' <p>Ошибка!</p> ';
    }
    
}else{

 if ( array_key_exists('go',$_POST) ){
    
    
                if ($this->_Q->QN("SELECT `mail` FROM <||>user WHERE `mail`='".$this->_Q->e($_POST['mail'])."'")==1){
 	            $key = md5(rand());
                $this->_Q->_arr['key'] = $key;
                $this->_Q->_table = 'user';
                $this->_Q->_where = "WHERE `mail`='".$this->_Q->e($_POST['mail'])."'";
                $this->_Q->QU();            
                
                $mess = ' <p>Вы или кто-то другой запросил смену пароля на сайте <a href="http://'.$_SERVER['HTTP_HOST']._URL_.'">'. $_SERVER['HTTP_HOST'] .'</a></p>
                <p>Если Вы этого не делали, рекомендуем авторизоваться на сайте и сменить пароль!</p>
                <p>Для восстановления пароля перейдите по ссылке: <a href="http://'.$_SERVER['HTTP_HOST']._URL_.'?func=repass&key='.$key.'">http://'.$_SERVER['HTTP_HOST']._URL_.'?func=repass&key='.$key.'</a></p>';    
            
                send_mail(MAIL_FROM,$_SERVER['HTTP_HOST'],$this->_infoUSER['mail'],"Восстановление пароля ",$GLOBALS['px_mail'].$mess.$GLOBALS['sx_mail']);
                header("Location:"._URL_."?func=repass&truesend");
                }else{
                    echo '<p>Такого e-mail нет в базе</p>';
                }
 }

?>
   
        <div class="reg_form">
            <form method="post"><?
            if (array_key_exists('truesend',$_GET)) echo ' <p>Инструкция отправлена на e-mail</p> ';
            ?>
            <p>e-mail<br /><input type="email" name="mail" /> <input type="submit" name="go" value="восстановить" /></p>
            </form>
        </div>        
<?
}
}
if ($this->_func=="auth" ){//TODO:auth
         if ( array_key_exists('go',$_POST) ){
         	if (!$this->_USER->login($_POST['mail'],$_POST['pass'])) $error.='<li>Вы не верно ввели логин или пароль</li>'."\n"; else{
         	    $re = $_GET['re'];
                if ($re=='') $re = '/';
                if ( substr_count($re,'?func=auth')==1 || substr_count($re,'?func=reg')==1) $re='/';
                header("Location:".urldecode($re));
         	}
         }
	?>
        
        <div class="auth_form">
            <h1>Авторизация</h1>
            <form method="post">
            <p>e-mail<br /><input type="email" name="mail" /></p>
            <p>Пароль (<a href="<?=_URL_?>?func=repass">забыли?</a>)<br /><input type="password" name="pass" /></p>
            <p><input type="submit" name="go" value="вход" /> <label> <input type="checkbox" name="maxtime" value="1" /> запомнить меня</label> </p>
            </form>
        </div>
    
    <?
}


if ($this->_func=="logout" && $this->_infoUSER['id']!=''){//TODO:logout

	$this->_USER->logout();
    header("Location:/");

}

if ($this->_func=="profile" && $this->_infoUSER['id']!=''){//TODO:profile
    
     
    
	?>
     
    <div class="reg_form">
    <form method="post" autocomplete="off">
    <?
    
    if (array_key_exists('saveinfo',$_POST)){
        
        if ($this->_infoUSER['pass']==md5($_POST['pass']) || $this->_infoUSER['social']!=''){
            
            if ( strip_tags(htmlspecialchars_decode($_POST['mail']))!=$this->_infoUSER['mail'] AND $this->_Q->QN("SELECT `mail` FROM <||>user WHERE `mail`='".$this->_Q->e(strip_tags(htmlspecialchars_decode($_POST['mail'])))."'")>0){
                
                echo '<div class="error">такой email уже есть в базе</div>';
                
            }else{
                if ((is_numeric($_POST['tel']) AND strlen($_POST['tel'])==11 AND substr($_POST['tel'],0,1)==7) OR  $_POST['tel']==''){
                $arr['name']=strip_tags(htmlspecialchars_decode($_POST['name']));
                if ($this->_infoUSER['social']=='') $arr['login']=strip_tags(htmlspecialchars_decode($_POST['mail']));
                $arr['mail']=strip_tags(htmlspecialchars_decode($_POST['mail']));
                $arr['tel']=strip_tags(htmlspecialchars_decode($_POST['tel']));
                $arr['tel2']=strip_tags(htmlspecialchars_decode($_POST['tel2']));
                $arr['address_street']=strip_tags(htmlspecialchars_decode($_POST['address_street']));
                $arr['address_home']=strip_tags(htmlspecialchars_decode($_POST['address_home']));
                $arr['address_k']=strip_tags(htmlspecialchars_decode($_POST['address_k']));
                $arr['address_p']=strip_tags(htmlspecialchars_decode($_POST['address_p']));
                $arr['address_kp']=strip_tags(htmlspecialchars_decode($_POST['address_kp']));
                $arr['address_e']=strip_tags(htmlspecialchars_decode($_POST['address_e']));
                $arr['address_kv']=strip_tags(htmlspecialchars_decode($_POST['address_kv']));
                $this->_Q->_arr = $arr;
                $this->_Q->_table = 'user';
                $this->_Q->_where = "WHERE `id`=".$this->_infoUSER['id'];
                $this->_Q->QU();            
                
                //send_mail(MAIL_FROM,"MATTE.CRM",$_POST['mail'],"Изменение информации в MATTE.CRM",$GLOBALS['px_mail'].''.$GLOBALS['sx_mail']);
                
                header("Location:"._URL_.'?func=profile&truesaveinfo');
                }else{
                    /*if (!is_numeric($_POST['tel'])) echo 1;
                    if (strlen($_POST['tel'])!=11) echo '2-'.strlen($_POST['tel']);
                    if (substr($_POST['tel'],0,1)==7) echo 3;*/
                    echo '<div class="error">Вы не правильно ввели номер мобильного телефона</div>';
                }
            }
        }else{
            echo '<div class="error">не правильный пароль</div>';
        }
        
    }
    
    ?>
        <h1>Моя информация</h1><?
        if (array_key_exists('truesaveinfo',$_GET)) echo ' <p><strong>Данные успешно сохранены</strong></p> ';
        ?>
        <p>Имя<br /><input type="text" name="name" required="required" value="<?= htmlspecialchars($this->_infoUSER['name'])?>" />*</p>
        <p>e-mail<br /><input type="email" name="mail" required="required" value="<?= htmlspecialchars($this->_infoUSER['mail'])?>" />*</p>
        <p>Контактный телефон (Введите номер телефона, пример 79012345678 : 11 символов, начиная с семерки)<br />+<input type="text" name="tel" value="<?= htmlspecialchars($this->_infoUSER['tel'])?>" /></p>
        <p>Второй контактный телефон<br /><input type="text" name="tel2" value="<?= htmlspecialchars($this->_infoUSER['tel2'])?>" /></p>
        <p><strong>Основной адрес доставки</strong></p>
        
        <div class="dg_table w100">
        	<div class="dg_tr">
        		<div class="dg_td w50"><p>Улица<br /><input type="text" name="address_street" value="<?= htmlspecialchars($this->_infoUSER['address_street'])?>" /></p>
        <p>Номер дома<br /><input type="text" name="address_home" value="<?= htmlspecialchars($this->_infoUSER['address_home'])?>" size="5" /></p>
        <p>Корпус<br /><input type="text" name="address_k" value="<?= htmlspecialchars($this->_infoUSER['address_k'])?>"  size="5" /></p>
        <p>Подъезд<br /><input type="text" name="address_p" value="<?= htmlspecialchars($this->_infoUSER['address_p'])?>"  size="5" /></p></div>
        		<div class="dg_td w50"><p>Код домофона<br /><input type="text" name="address_kp" value="<?= htmlspecialchars($this->_infoUSER['address_kp'])?>"  size="5" /></p>
        <p>Этаж<br /><input type="text" name="address_e" value="<?= htmlspecialchars($this->_infoUSER['address_e'])?>"  size="5" /></p>
        <p>Номер квартиры<br /><input type="text" name="address_kv" value="<?= htmlspecialchars($this->_infoUSER['address_kv'])?>"  size="5" /></p></div>
        	</div>
        </div>
        
        
        
        
        <? if ($this->_infoUSER['social']==''){ ?><p>Пароль<br /><input type="password" name="pass" required="required" /></p><?}?>
        <p><input type="submit" name="saveinfo" value="сохранить" /></p>
    </form>
    
    <form method="post">    <?
    
    if (array_key_exists('savepass',$_POST) && $this->_infoUSER['social']==''){
        
        if ($this->_infoUSER['pass']==md5($_POST['pass3']) ){
            
            if ( $_POST['pass']!=$_POST['pass2'] ){
                
                echo '<div class="error">Новые пароли не совпадают</div>';
                
            }else{
                
                if (strlen($_POST['pass'])<6) echo '<div class="error">Новый пароль короткий (минимум 6-ть символов)</div>'; else{
                $pass = strip_tags($_POST['pass']);
                $arr['pass']=md5($pass);
                
                $this->_Q->_arr = $arr;
                $this->_Q->_table = 'user';
                $this->_Q->_where = "WHERE `id`=".$this->_infoUSER['id'];
                $this->_Q->QU();            
                
                $mess = ' <p>Вы или кто-то другой сменили пароль  на сайте <a href="http://'.$_SERVER['HTTP_HOST']._URL_.'">'. $_SERVER['HTTP_HOST'] .'</a></p>
            <p>Ваш email: <strong>'.$this->_infoUSER['mail'].'</strong><br />Ваш новый пароль: <strong>'.$pass.'</strong></p>';    
            
                send_mail(MAIL_FROM,$_SERVER['HTTP_HOST'],$this->_infoUSER['mail'],"Новый пароль",$GLOBALS['px_mail'].$mess.$GLOBALS['sx_mail']);
                
                header("Location:"._URL_.'?func=profile&truesaveinfopass');
                }
            }
        }else{
            echo '<div class="error">не правильный пароль</div>';
        }
        
    }
    if ($this->_infoUSER['social']==''){
    ?>
    <h2>Смена пароля</h2><?
        if (array_key_exists('truesaveinfopass',$_GET)) echo ' <p><strong>Данные успешно сохранены</strong></p> ';
        ?>
        <p>Новый пароль<br /><input type="password" name="pass" required="required" /></p>
        <p>Еще раз новый пароль<br /><input type="password" name="pass2" required="required" /></p>
        <p>Старый пароль<br /><input type="password" name="pass3" required="required" /></p>
         <p><input type="submit" name="savepass" value="изменить" /></p>
    </form>
    </div>
    <?
    }
}

?>