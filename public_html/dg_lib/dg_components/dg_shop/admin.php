<?php

/**
 * @author mrhard
 * @copyright 2010
 */

defined("ADMIN") or die ("ERR");
defined("CONTENT") or die ("ERR");
define('_TPL_','/_tpl/'.$this->inf['info']['dir'].'/'.$inf['tpl'].'/');
?>
<style>
    .noact{
        color: #ccc;
    }
    .order_group li{
    padding-left: 20px;
    list-style: none;
    padding-bottom: 10px;
}
    .order_group li.order_0{
        background: url('<?=_TPL_?>/img/error.png') left top no-repeat;
    }
    .order_group li.order_1{
        background: url('<?=_TPL_?>/img/application_form.png') left top no-repeat;
    }
    .order_group li.order_2{
        background: url('<?=_TPL_?>/img/time.png') left top no-repeat;
    }
    .order_group li.order_3{
        background: url('<?=_TPL_?>/img/accept.png') left top no-repeat;
    }
    .order_group li.order_4{
        background: url('<?=_TPL_?>/img/coins.png') left top no-repeat;
    }
    .order_group li.order_5{
        background: url('<?=_TPL_?>/img/delivery.png') left top no-repeat;
    }
    .order_group li.order_6{
        background: url('<?=_TPL_?>/img/package.png') left top no-repeat;
    }
    .order{
    font-size: 150%;
    padding-left: 35px;
    display: block;
    height: 36px;
    vertical-align: middle;
    background: url('../img/basket_add.png') left center no-repeat;
    text-decoration: none;
    text-transform: uppercase;
    padding-top: 15px;
    float: right;
    margin-top: -10px;
    color: green;
}
.orderlist{
    margin: 20px 0;
    border: solid 1px #485362;
}
.orderlist .dg_td{
    padding: 5px;
    border-bottom: solid 1px #485362;
}
.orderlist .head .dg_td{
    background: #485362;
    color: #fff;
}
.order_info{
    font-size: 120%;
    margin-bottom: 10px;
}
.warning{
    background: #ff0000;
    color: #fff;
}
    </style>
<?
if(!function_exists('price')){
function price($float){
    
    $ex = explode('.',$float);
    if ($ex[1]=='00' || $ex[1]=='' || $ex[1]==0) return $ex[0]; else return $float;
    
}
}
if (is_numeric($_GET['group'])) $group = $this->_Q->QA("SELECT * FROM <||>dg_shop__orders_group WHERE `id`=".$_GET['group']." LIMIT 1");
$GLOBALS['order_st'][0]='Не принят';
$GLOBALS['order_st'][1]='Необходимо заполнить данные';
$GLOBALS['order_st'][2]='На проверке';
$GLOBALS['order_st'][3]='Принято';
$GLOBALS['order_st'][4]='Оплачено';
$GLOBALS['order_st'][5]='Отправлено';
$GLOBALS['order_st'][6]='Доставлено';

$this->_right.= '<li style="background:url(/dg_system/dg_img/icons/server.png) no-repeat left center;"><a href='._COMP_URL_.'index>Заказы</li>';
$this->_right.= '<li style="background:url(/dg_system/dg_img/icons/server.png) no-repeat left center;"><a href='._COMP_URL_.'users>Покупатели</li>';
$this->_right.= '<li style="background:url(/dg_system/dg_img/icons/map.png) no-repeat left center;"><a href='._COMP_URL_.'stats>Статистика заказов</li>';
$this->_right.= '<div class="r"></div>';

if ($this->_act=="users"){//TODO:users

?>
<h2>Покупатели</h2>
<ul class="order_group dg_form">
<?
            $total=0;
            $price = 0;
            $QW = $this->_Q->QW("SELECT * FROM <||>user WHERE `id` IN  (SELECT `user_id` FROM <||>dg_shop__orders_group WHERE `st`=6)");
            foreach($QW as $i=>$row){
            	if ($row[0]!=''){
            	   
                   $totalclearorder = $this->_Q->QN("SELECT `user_id`,`st` FROM <||>dg_shop__orders_group WHERE `st`=6 AND `user_id`=".$row['id']);
            	   $totalclearorder_price = $this->_Q->QA("SELECT SUM(`price`*`total`) FROM `dg_dg_shop__orders` WHERE `user_id`=".$row['id']." AND `group_id`<>0 AND group_id IN (SELECT `id` FROM <||>dg_shop__orders_group WHERE `st`=6 AND `user_id`=".$row['id'].")") 
                   ?>
                    <li class="order_<?=$row['st']?>"><a href="<?=_COMP_URL_?>index&user=<?=$row['id']?>"><?=$row['name']?></a> Всего заказов: <?=$totalclearorder ?> На сумму <?=$totalclearorder_price[0]?></li>
                   <?
                   $total=$total+$totalclearorder;
                   $price = $price+$totalclearorder_price[0];
            	}
            }
        ?></ul>
        <p>Итого заказов: <?=$total?> на общую сумму <?=$price?></p>
<?
	

}


if ($this->_act=="index"){//TODO:index
 if ( array_key_exists('go',$_POST) ){
 	$this->_regedit->edit('dgshop_adminmail',$_POST['adminmail']);
    $this->_regedit->edit('dgshop_adminsms',$_POST['adminsms']);
    $this->_regedit->edit('dgshop_IPARCHIDELIVERY',$_POST['dgshop_IPARCHIDELIVERY']);
    
    header("Location:"._COMP_URL_.'index');
 }
	?>
    
    <form class="dg_form" method="post">
    <p>e-mail администратора<br /><input type="text" name="adminmail" value="<?=$this->_regedit->read('dgshop_adminmail','admin@'.$_SERVER["HTTP_HOST"])?>" /></p>
    <p>SMS (например 79012345678)<br /><input type="text" name="adminsms" value="<?=$this->_regedit->read('dgshop_adminsms','79624489567')?>" /></p>
    <p>IP Сервера Archi Delivery<br /><input type="text" name="dgshop_IPARCHIDELIVERY" value="<?=$this->_regedit->read('dgshop_IPARCHIDELIVERY','89.179.72.52:5858')?>" /></p>
    
    <p><input type="submit" name="go" value="Сохранить" /></p>
    </form>
    <p>&nbsp;</p>
    <h2>Заказы</h2><?
    

    ?>
    <form method="get" class="dg_form">
        <input type="hidden" name="comp" value="<?=$_GET['comp']?>" />
        <input type="hidden" name="use" value="<?=$_GET['use']?>" />
        <input type="hidden" name="func" value="<?=$_GET['func']?>" />
        <input type="hidden" name="source" value="<?=$_GET['source']?>" />
        <input type="hidden" name="pages" value="<?=$_GET['pages']?>" />
        <input type="hidden" name="func" value="<?=$_GET['func']?>" />
        <input type="hidden" name="id" value="<?=$_GET['id']?>" />
        <input type="hidden" name="index" value="<?=$_GET['index']?>" />
        <p>Показать заказы: от <input type="text" class="date" name="date1" value="<?=$_GET['date1']?>" /> до <input type="text" class="date" name="date2" value="<?=$_GET['date2']?>" />
         <select name="st">
            <option value="">статус заказа</option>
            <?
            
            foreach($GLOBALS['order_st'] as $ii=>$vv){
                $sel='';
                if ($ii==$_GET['st'] AND $_GET['st']!='') $sel = ' selected ';
            	echo '<option value="'.$ii.'"'.$sel.'>'.$vv.'</option>';
            }
            
            ?>
        </select> 
        <input type="submit" value="показать" />
        </p>
    </form>
    <p>&nbsp;</p><?
    
                    $w = '';
                if (is_numeric($_GET['user'])) $w.= " AND `user_id`=".$_GET['user'];
                if ($_GET['date1']!='') $w.= " AND `time`>".strtotime($_GET['date1'].'00:00:00');
                if ($_GET['date2']!='') $w.= " AND `time`<".strtotime($_GET['date2'].'00:00:00');
                if (is_numeric($_GET['st'])) $w.= " AND `st`=".$_GET['st']; else $w.= " AND `st`>1";
            
                if ($w==" AND `st`>1") {
                    $w2 = " AND `time`>".strtotime(date("Y-m-").'01 00:00:00');
                    echo ' <p><strong>Заказы за текущий месяц</strong></p> ';
                    }else{
                        
                    }
                $QW = $this->_Q->QW("SELECT * FROM <||>dg_shop__orders_group WHERE `id`<>0  ".$w.$w2." ORDER BY `st`,`id` DESC");
    
    ?>
<ul class="order_group dg_form">
        <?

            
            
            foreach($QW as $i=>$row){
            	if ($row[0]!=''){
            	   $usr = $this->_Q->QA("SELECT * FROM <||>user WHERE `id`=".$row['user_id']);
                   ?>
                    <li class="order_<?=$row['st']?>"><a href="<?=_COMP_URL_?>order&group=<?=$row['id']?>">Заявка № <?=$row['id']?><? if ($row['time']!='' AND $row['time']!=0) echo ' от '.date('d.m.Y',$row['time']) ?></a> <?=$row['fio']?><? if ($row['method']==2) echo ' <strong style="color:red">приложение</strong>'; ?><br /><?=$GLOBALS['order_st'][$row['st']]?></li>
                   <?
                   
            	}
            }
        ?></ul><?
        if ($w!=' AND `st`>1') echo ' <p><a href="'._COMP_URL_.'index">показать все активные заказы</a></p> ';
         
}

if ($this->_act=="order" AND $group['id']!=''){//TODO:order
echo '<p><a href="'._COMP_URL_.'index">К списку</a></p>';
$user = $this->_Q->QA("SELECT * FROM <||>user WHERE `id`=".$group['user_id']);
?>

    <h2>Заявка № <?=$group['id']?><? if ($group['time']!='' AND $group['time']!=0) echo ' от '.date('d.m.Y',$group['time']) ?></h2>
    <div class="dg_form">
        <p>Заявка поступила: <strong><?=date('d.m.Y H:i',$group['time'])?></strong></p>
        <p>Ф.И.О: <strong><?=$group['fio']?></strong></p>
        <p><strong>Адрес</strong></p>
        
        <p>Улица: <strong><?=$group['address_street']?></strong></p>
        <p>Номер дома: <strong><?=$group['address_home']?></strong></p>
        <p>Корпус: <strong><?=$group['address_k']?></strong></p>
        <p>Подъезд: <strong><?=$group['address_p']?></strong></p>
        <p>Код домофона: <strong><?=$group['address_kp']?></strong></p>
        <p>Этаж: <strong><?=$group['address_e']?></strong></p>
        <p>Номер квартиры: <strong><?=$group['address_kv']?></strong></p>
        
        <p>Тел: <strong><?=$group['tel']?></strong></p>
        <p>Тел 2: <strong><?=$group['tel2']?></strong></p>
        
        <p>Кол-во персон: <strong><?=$group['total_person']?></strong></p>
        <p><strong>Комментарий</strong>: <?=$group['info']?></p>
        <p>Оплата: <strong><?
        
        if ($group['money']==0 || $group['money']=='') echo 'Наличными';
        if ($group['money']==1) echo 'Оплата пластиковой картой, через курьера';
        
        ?></strong></p>
        <?
        
            if ($group['method']==2){ echo '<p><strong>ЗАКАЗ ИЗ ПРИЛОЖЕНИЯ</strong></p>'; }
        
        ?>
    </div>
    <h3>Товары</h3>
    <?if (!array_key_exists('print',$_GET)){?><p><a href="#" class="add" onclick="$('#addnew').css('display','block')">добавить позицию</a></p>
    <form method="post" id="addnew" style="display: none;" class="dg_form">
    
        <p>Наименование<br /><input type="text" name="name" required="required" /></p>
        <p>Цена<br /><input type="number" name="price" required="required" /></p>
        <p>Кол-во<br /><input type="number" name="total" required="required" /></p>
        <p><input type="submit" name="go" value="Добавить" /></p>
    </form><?
    }
     if ( array_key_exists('go',$_POST) AND $_POST['name']!='' AND is_numeric($_POST['price']) AND is_numeric($_POST['total'])){
     	$this->_Q->_table = 'dg_shop__orders';
        $this->_Q->_arr = array('name'=>$_POST['name'],'price'=>$_POST['price'],'total'=>$_POST['total'],'time'=>time(),'group_id'=>$group['id'],'user_id'=>$group['user_id']);
        $this->_Q->QI();
        header("Location:"._COMP_URL_.'order&group='.$group['id']);
     }
    
    ?>
    <form method="post">
     <div class="dg_table w100 orderlist">
    	<div class="dg_tr head">
            <div class="dg_td w5"></div>
    		<div class="dg_td w40">Наименование</div>
    		<div class="dg_td w25">Кол-во</div>
            <div class="dg_td w10">Цена</div>
            <div class="dg_td w10">Итого</div>
            <div class="dg_td w10"></div>
    	</div>
            
<?		    
        $price = 0;
        $total = 0;
$QW = $this->_Q->QW("SELECT * FROM <||>dg_shop__orders WHERE `group_id`=".$group['id']." ");
         foreach($QW as $i=>$row){
         	if ($row[0]!=''){
         	    $item = $this->_Q->QA("SELECT * FROM <||>dg_shop__items WHERE `id`=".$row['item_id']." LIMIT 1");
                if ($item['id']!='' || $row['name']!=''){
                    
                    if ($_POST['item_'.$row['id']]==1){
                        $items[]=' `id`='.$row['id'].' ';
                    }
                    
                    if (array_key_exists('save',$_POST) AND is_numeric($_POST['total_item_'.$row['id']]) AND is_numeric($_POST['price_item_'.$row['id']])){
                        $_POST['price_item_'.$row['id']] = str_replace(',','.',$_POST['price_item_'.$row['id']]);
                        $this->_Q->_table = 'dg_shop__orders';
                        $this->_Q->_arr = array('total'=>$_POST['total_item_'.$row['id']],'price'=>$_POST['price_item_'.$row['id']]);
                        $this->_Q->_where = " WHERE `id`=".$row['id'];
                        $this->_Q->QU();
                    }
                    
                    $total = $total+$row['total'];
                    $price = $price+price($row['total']*$row['price']);
                ?>
                
                    <div class="dg_tr">
                        <div class="dg_td w5"><input type="checkbox" value="1" name="item_<?=$row['id']?>" <? if ($g['id']!='') echo ' checked '; ?> /></div>
                		<div class="dg_td w40"><? if ($row['name']=='') {?><a href="<?=_URL_.$item['id']?>/"><strong><?=$item['name']?></strong></a><?}else{ echo $row['name'];} ?></div>
                		<div class="dg_td w25"><div name="<?=$row['id']?>"><input type="number" class="order_total" value="<?=$row['total']?>" name="total_item_<?=$row['id']?>"  /> <span></span></div></div>
                        <div class="dg_td w10"><input type="text" class=" order_total" value="<?=$row['price']?>" title="<?=$row['price']?>" name="price_item_<?=$row['id']?>" /> тг.</div>
                        <div class="dg_td w10"><span id="totalprice_<?=$row['id']?>"><?=price($row['total']*$row['price'])?></span> тг.</div>
                        <div class="dg_td w10"></div>
                	</div>
                
                <?
               } 
         	}
         } 
         
         if (array_key_exists('save',$_POST)) {
            
            $this->_Q->_table = 'dg_shop__orders_group';
            $arr='';
            $arr['st']=$_POST['st'];
            $arr['admin_info']=htmlspecialchars_decode($_POST['admin_info']);
            $this->_Q->_arr=$arr;
            $this->_Q->_where = " WHERE `id`=".$group['id'];
            $this->_Q->QU();
          
          
          
            if ($arr['st']!=$group['st']){
                
            $mess = ' <p>Заявка №'.$group['id'].' от '.date('d.m.Y',$group['time']).'  на сайте <a href="http://'.$_SERVER['HTTP_HOST'].'">'. $_SERVER['HTTP_HOST'] .'</a> изменила статус 
             на <strong>'.$GLOBALS['order_st'][$arr['st']].'</strong>
            </p>
            ';    
            if (trim($arr['admin_info'])!='' AND $arr['admin_info']!=$group['admin_info']) $mess.='<p>Коментарий администратора: <em>'.$arr['admin_info'].'</em></p>';
            
                
                /*send_mail('robot@'.str_replace('www.','',$_SERVER["HTTP_HOST"]),$_SERVER['HTTP_HOST'],$user['mail'],"Новый статус заявки",$GLOBALS['px_mail'].$mess.$GLOBALS['sx_mail']);
                
                if (is_numeric($group['tel']) AND strlen($user['tel'])==11 AND substr($user['tel'],0,1)==7){
                    $Login = 'nioki';
                    $Password = 'stavropol777';
                    $Msg = array(                
                        'Phone' => $group['tel'],
                        'From'=>'nioki',
                        'Text' => 'Новый статус заявки №'.$group['id'].': '.$GLOBALS['order_st'][$arr['st']]    
                    );

    

                    $Sms = new SMSClass($Login, $Password);
                    $Result = $Sms->SendSMS(array($Msg));
                    if ($Result['Error']) {send_mail('robot@'.str_replace('www.','',$_SERVER["HTTP_HOST"]),$_SERVER["HTTP_HOST"],$this->_regedit->read('dgshop_adminmail','admin@'.$_SERVER["HTTP_HOST"]),'Ошибка отправки SMS',$Result['Error']);}
                }    
                */
                
            }
          
          
            header("Location:"._COMP_URL_.'order&group='.$group['id']);
            
            
            }
         
         if (is_array($items) AND array_key_exists('remove',$_POST)){
            
            $where = implode(" OR ",$items);
            if (array_key_exists('remove',$_POST) AND $g['id']==''){
                $this->_Q->_table = 'dg_shop__orders';
                $this->_Q->_where = " WHERE ".$where;
                $this->_Q->QD();
                header("Location:"._COMP_URL_.'order&group='.$group['id']);
            }
            }
 
         ?>
            </div> 
            
            <p>Итого товаров: <strong><?=$total?></strong> на сумму <strong><?=$price?> тг.</strong></p>
            <p>Скидка <?
            
                $sale = 0;
                $saleinfo = '';
                /*if (date("G",$group['time'])>=1 AND date("G",$group['time'])<=5 AND $sale==0){ $this->_sale=true; $this->_sale_old=$price; $sale = ($price*0.2); $saleinfo='20% — с 1 до 5';}
                if (date("G",$group['time'])>=8 AND date("G",$group['time'])<=10 AND $sale==0){ $this->_sale=true; $this->_sale_old=$price; $sale = ($price*0.2); $saleinfo='20% — с 8 до 10'; }
                if (date("G",$group['time'])>=17 AND date("G",$group['time'])<=15 AND $sale==0){ $this->_sale=true; $this->_sale_old=$price; $sale = ($price*0.15); $saleinfo='15% — с 13 до 17'; }
                */
                 if ($group['method']==2){
                    
                    $this->_sale=true; $this->_sale_old=$price; $sale = ($price*0.1); $saleinfo='10% с приложения'; 
                    
                }
                
                echo ' <strong>'.$sale.' тг.</strong> ('.$saleinfo.') С учетом скидки <strong>'.($price-$sale).' тг.</strong>';
            
            ?></p>
            <?if (!array_key_exists('print',$_GET)){?>
            
            <p><a href="<?=_COMP_URL_?>order&group=<?=$group['id']?>&ajax&print" target="_blank"><strong>распечатать</strong></a></p>
            <p>Статус: <select name="st"><?
            
            foreach($GLOBALS['order_st'] as $ii=>$vv){
                $sel='';
                if ($ii==$group['st']) $sel = ' selected ';
            	echo '<option value="'.$ii.'"'.$sel.'>'.$vv.'</option>';
            }
            
            ?></select></p>
            <p>Комментарий:<br /><textarea name="admin_info"><?=htmlspecialchars($group['admin_info'])?></textarea></p>
            <input type="submit" name="save" value="сохранить" />
            <input type="submit" name="remove" value="удалить" />
            </form>
         <?}

}
if ($this->_act=="import"){//TODO:import
 if ( array_key_exists('go',$_POST) ){
 	if ($_POST['text']!=''){
 	  $order=0;
       $line = explode("\r",$_POST['text']);
       foreach($line as $i=>$v){
        $arr='';
        $im='';
        
        if ($i!=0 AND trim($v)!=''){
       	//echo '<li>'.$v.'</li>';
        $val = explode(';',$v);
        if (count($val)==7){
            
            $arr['name']=str_replace("\n",'',$val[0]);
            $arr['name']=str_replace("\r",'',$arr['name']);
            if ($val[1]!=''){
                $img = explode(',',$val[1]);
                foreach($img as $ii=>$vv){
                	if (trim($vv)!=''){
                	   if (file_exists('/var/local/www/nioki/public_html/files/nioki/R_'.$vv.'.jpg')){
                	       $im[]='/files/nioki/R_'.$vv.'.jpg';
                	   }
                	}
                }
                if ($im[0]!='') $arr['img'] = $im[0];
                if ($im[1]!='') $arr['img2'] = $im[1];
                if ($im[2]!='') $arr['img3'] = $im[2];
            }
            $arr['total1'] = $val[2];
            $price1 = $val[3];
            $price1 = str_replace(' ','',$price1);
            $price1 = str_replace(',','.',$price1);
            $arr['price1'] = $price1;
            
            $arr['total2'] = $val[4];
            $price2 = $val[5];
            $price2 = str_replace(' ','',$price2);
            $price2 = str_replace(',','.',$price2);
            $arr['price2'] = $price2;
            $des = $val[6];
            $des = str_replace('""','"',$des);
            $des = trim($des,'"');
            $des = trim($des,'(');
            $des = trim($des,')');
            $arr['des']=$des;
            $arr['sys_page'] = $_POST['id'];
            $arr['sys_order'] = $order;
            $arr['sys_show'] = 1;
            $order++;
        		 
                echo '<pre>';
        		print_r($arr);
        		echo '</pre>';
                $this->_Q->_table = 'mycomp__cat';
                $this->_Q->_arr = $arr;
                $this->_Q->QI();
                }
        }
       }
      
 	}
 }
?>
    <form method="post">
        <textarea name="text" style="height: 400px; width: 100%;"></textarea><br />
        id <input type="text" name="id" /> <input type="submit" name="go" />
    </form>
<?
	

}
if ($this->_act=="stats"){//TODO: 	ACT stats



?>
 <form method="get" class="dg_form">
        <input type="hidden" name="comp" value="<?=$_GET['comp']?>" />
        <input type="hidden" name="use" value="<?=$_GET['use']?>" />
        <input type="hidden" name="func" value="<?=$_GET['func']?>" />
        <input type="hidden" name="source" value="<?=$_GET['source']?>" />
        <input type="hidden" name="pages" value="<?=$_GET['pages']?>" />
        <input type="hidden" name="func" value="<?=$_GET['func']?>" />
        <input type="hidden" name="id" value="<?=$_GET['id']?>" />
        <input type="hidden" name="act" value="stats" />
        <p>Показать заказы: от <input type="text" class="date" name="date1" value="<?=$_GET['date1']?>" /> до <input type="text" class="date" name="date2" value="<?=$_GET['date2']?>" />
          
        <input type="submit" value="показать" />
        </p>
    </form>

<?

    $d1 = strtotime(date('Y').'-01-01 00:00:00');
    $d2 = strtotime(date('Y').'-'.date('m').'-'.date('d').' 23:59:59');
    
    
    if ($_GET['date1']!='')  $d1 = strtotime(date($_GET['date1']).' 00:00:00');
    if ($_GET['date2']!='')  $d2 = strtotime(date($_GET['date2']).' 23:59:59');
    

    $TOTALORDERS='';
    $TOTALPRICES;


    for ($y=date('Y',$d1); $y<=date('Y',$d2); $y++){
        
        
        $stopm = 12;
        
        if (date('Ym')<=date('Y',$d2).date('m',$d2)) $stopm = date('m',$d2);
        
        
        $startm = 1;
        
        if ($y==date('Y',$d1)) $startm = date('m',$d1);
        if ($y==date('Y',$d2)) $stopm = date('m',$d2);
        
        
        for ($m=$startm; $m<=$stopm;$m++){
            
            
            $mm = $m;
            if ($m<10 && $m{0}!='0') $mm='0'.$m;
            
            $stopd = date('t',strtotime($y.'-'.$mm));
            if (date('Ymd')<=date('Y',$d2).date('m',$d2).date('d',$d2)) $stopd = date('d',$d2);
            
            
            $startd = 1;
            if ($y.$m==date('Ym',$d1)) $startd = date('d',$d1);
            if ($y.$mm==date('Ym',$d2)) $stopd = date('d',$d2);
            
            for ($d=$startd; $d<=$stopd;$d++){
                
                $dd = $d;
                if ($d<10 && $d{0}!='0') $dd='0'.$d;
                
                $TOTALORDERS[$y][$mm][$dd] = 0;
                $TOTALPRICES[$y][$mm][$dd] = 0;
                
            }
            
            
        }
        
    }

	$QW = $this->_Q->QW("SELECT * FROM <||>dg_shop__orders_group WHERE `st`=6 AND `time`>=".$d1." AND `time`<=".$d2." ORDER BY `id` ");
 	if (count($QW)>0){
 	                                        
 	                                        
 		foreach($QW as $i=>$row){
 			if ($row[0]!=''){
 			    
                $yy = date('Y',$row['time']);
                $mm = date('m',$row['time']);
                $dd = date('d',$row['time']);
                
                 
                
                $row['_date_y'] = $yy;
                $row['_date_m'] = $mm;
                $row['_date_d'] = $dd;
                
               
                
                $row['_total_summ'] = 0;
                
                if (date('Ym')<=$row['_date_y'].$row['_date_m']){
                    
                    
                    //$infoCache = $this->_Q->QA("SELECT * FROM <||>dg_shop__orders_STATS WHERE `y`=".$row['_date_y']." AND `m`=".$row['_date_m']." AND `d`=".$row['_date_d']." LIMIT 1");
                    
                    //if ($infoCache['id']==''){
                        
                        $TOTALORDERS[$row['_date_y']][$row['_date_m']][$row['_date_d']]++;
                        $totalclearorder_price = $this->_Q->QA("SELECT SUM(`price`*`total`) FROM `dg_dg_shop__orders` WHERE  `group_id`=".$row['id']) ;
                        $TOTALPRICES[$row['_date_y']][$row['_date_m']][$row['_date_d']]+=$totalclearorder_price[0];  
                        
                   // }
                    
                    
                     
                    
                    
                    
                }else{
                    $TOTALORDERS[$row['_date_y']][$row['_date_m']][$row['_date_d']]++;
                    $totalclearorder_price = $this->_Q->QA("SELECT SUM(`price`*`total`) FROM `dg_dg_shop__orders` WHERE  `group_id`=".$row['id']) ;
                    $TOTALPRICES[$row['_date_y']][$row['_date_m']][$row['_date_d']]+=$totalclearorder_price[0];     
                }
                
 			                                               	   
 			                                                
 			}
 		}
 	                                       
 	} 
    	/*	echo '<pre>';
    		print_r($TOTALORDERS);
    		echo '</pre>';
            		echo '<pre>';
            		print_r($TOTALPRICES);
            		echo '</pre>';*/
                    
                    ?>
                    <div id="chart_div" style="width: 90%; height: 500px;"></div>
                    <div id="chart_div2" style="width: 90%; height: 500px;"></div>
                    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      google.setOnLoadCallback(drawChart2);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Дата','Заказов'],
          <?
          
          foreach($TOTALORDERS as $y=>$dataMD){
          	
            foreach($dataMD as $m=>$dataD){
            	
                foreach($dataD as $d=>$total){
                    ?>
                        ['<?=$d?>.<?=$m?>.<?=$y?>',<?=$total?>],
                    <?
                	
                }
                
            }
            
          }
          
          ?>
           
        ]);

        var options = {
          title: 'Заказы'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      
      function drawChart2() {
        var data = google.visualization.arrayToDataTable([
          ['Дата','Сумма'],
          <?
          
          foreach($TOTALPRICES as $y=>$dataMD){
          	
            foreach($dataMD as $m=>$dataD){
            	
                foreach($dataD as $d=>$total){
                    ?>
                        ['<?=$d?>.<?=$m?>.<?=$y?>',<?=$total?>],
                    <?
                	
                }
                
            }
            
          }
          
          ?>
           
        ]);

        var options = {
          title: 'Финансы'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
      
      
    </script>
                    
                    <?

}
?>