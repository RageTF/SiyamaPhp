<?php

/**
 * @author mrhard
 * @copyright 2010
 */
defined("_DG_") or die ("ERR");

if (array_key_exists('TESTAAA',$_GET)){
        
        $AD = new AD;
        $AD->_host = 'http://'.$this->_regedit->read('dgshop_IPARCHIDELIVERY','89.179.72.52:5858').'/';
        if ($AD->PING()){
            
            $AD->NEWORDER();
            
        }  
        
        exit;
    }

$GLOBALS['order_st'][0]='Не принят';
$GLOBALS['order_st'][1]='Необходимо заполнить данные';
$GLOBALS['order_st'][2]='На проверке';
$GLOBALS['order_st'][3]='Принято';
$GLOBALS['order_st'][4]='Оплачено';
$GLOBALS['order_st'][5]='Отправлено';
$GLOBALS['order_st'][6]='Доставлено';

    if (!class_exists('dg_shop')){
        class dg_shop{
            
            public $_Q;
            public $_page_url;
            public $_regedit;
            public $_USER;
            public $_infoUSER;
            public $_keyitems;
            public $_order_total=0;
            public $_order_price=0;
            public $_page;
            public $_sale=false;
            public $_sale_old=0;
            public $_sale_info='';
            public $_sale_type=0;
            
            function __construct($Q,$PAGE){
                if (!is_object($Q)){ 
                    $this->_Q = new dg_bd;
                    $this->_Q->connect();
                }else{
                    $this->_Q=$Q; 
                }
            $this->_app = $app;
            $this->inf = dg_source();
                        $this->_page = $PAGE;
                        $this->_USER =       new dg_user($this->_Q);
                        $this->_regedit =    new dg_regedit($this->_Q);
                        $this->_infoUSER = $this->_USER->_userinfo;
                        
                        
                        if ($this->_infoUSER['id']!=''){
    
                            $this->_Q->_table = 'dg_shop__orders';
                            $this->_Q->_arr=array('user_id'=>$this->_infoUSER['id'],'ses_id'=>0);
                            $this->_Q->_where = " WHERE `ses_id`=".$this->_USER->_ses;
                            $this->_Q->QU();
                        
                        }
                        
                            $QW = $this->_Q->QW("SELECT * FROM <||>dg_shop__orders_items");
                            foreach($QW as $i=>$row){
                            	if ($row[0]!=''){
                            	   
                                   $this->_keyitems[$row['key']] = $row;
                                   
                            	}
                            }
                                $QW = $this->_Q->QW("SELECT * FROM <||>pages WHERE `comp`='system:dg_shop'");
                                foreach($QW as $i=>$row){
                                	if ($row[0]!=''){
                                	   
                                       $this->_page_url = $this->_page->url($row['id']);
                                	}
                                }
                                
                                if (array_key_exists('loadminibas',$_GET) && array_key_exists('ajax',$_GET)) { $this->minibasket(); exit;}
                                
                                if (array_key_exists('ro',$_POST)){
                                    
                                    $w = "`ses_id`='".$this->_USER->_ses."'";
                                    if ($this->_infoUSER['id']!='') $w = "`user_id`='".$this->_infoUSER['id']."'";
                                        $QW = $this->_Q->QW("SELECT * FROM <||>dg_shop__orders WHERE `group_id`=0 AND (".$w.")");
                                         foreach($QW as $i=>$row){
                                         	if ($row[0]!=''){
                                         	  
                                         	  if (is_numeric($_POST['total_'.$row['id']]) AND $_POST['total_'.$row['id']]>0){
                                         	       
                                         	      $this->_Q->_table = 'dg_shop__orders';
                                                  $this->_Q->_arr = array('total'=>$_POST['total_'.$row['id']]);
                                                  $this->_Q->_where = 'WHERE `id`='.$row['id'];
                                                  $this->_Q->QU();
                                         	  }
                                         	}
                                        }
                                        header("Location:".$this->_page_url.'?fromminibask');
                                }
                                
                            
                            
                            
                            if (array_key_exists('dg_item_add',$_POST)){ 
                                $key = explode('item_',$_POST['dg_item_add']);
                                if ($key[1]!='' AND array_key_exists($key[1],$this->_keyitems) AND is_numeric($_POST['total']) AND $_POST['total']>0){
 
                                            
                                            
                                            
                                            $arr='';
                                            if ($this->_keyitems[$key[1]]['id']){
                                            $info = $this->_Q->QA("SELECT * FROM <||>dg_shop__orders WHERE `group_id`=0 AND `item_id`=".$this->_keyitems[$key[1]]['item_id']." AND `name`='".$this->_Q->e($this->_keyitems[$key[1]]['item_name'])."' AND ((`user_id`='".$this->_infoUSER['id']."' AND `user_id`<>0) OR `ses_id`='".$this->_USER->_ses."') LIMIT 1");
                                                if ($info['id']==''){
                                                    $arr='';
                                                    $arr['ses_id'] = $this->_USER->_ses;
                                                    $arr['user_id'] = $this->_infoUSER['id'];
                                                    $arr['item_id'] = $this->_keyitems[$key[1]]['item_id'];
                                                    $arr['item_url'] = $this->_keyitems[$key[1]]['item_url'];
                                                    $arr['item_img'] = $this->_keyitems[$key[1]]['item_img'];
                                                    $arr['item_des'] = $this->_keyitems[$key[1]]['item_des'];
                                                    $arr['name'] = $this->_keyitems[$key[1]]['item_name'];
                                                    $arr['price'] = $this->_keyitems[$key[1]]['price'];
                                                    $arr['time'] = time();
                                                    $arr['total'] = $_POST['total'];
                                                    $this->_Q->_table = 'dg_shop__orders';
                                                    $this->_Q->_arr = $arr;
                                                    $this->_Q->QI();
                                                }else{
                                                    $arr='';
                                                    $arr['ses_id'] = $this->_USER->_ses;
                                                    $arr['user_id'] = $this->_infoUSER['id'];
                                                    $arr['item_id'] = $this->_keyitems[$key[1]]['item_id'];
                                                    $arr['item_url'] = $this->_keyitems[$key[1]]['item_url'];
                                                    $arr['item_img'] = $this->_keyitems[$key[1]]['item_img'];
                                                    $arr['item_des'] = $this->_keyitems[$key[1]]['item_des'];
                                                    $arr['name'] = $this->_keyitems[$key[1]]['item_name'];
                                                    $arr['price'] = $this->_keyitems[$key[1]]['price'];
                                                    $arr['time'] = time();
                                                    $arr['total'] = $info['total']+$_POST['total'];
                                                    $this->_Q->_table = 'dg_shop__orders';
                                                    $this->_Q->_arr = $arr;
                                                    $this->_Q->_where = ' WHERE `id`='.$info['id'];
                                                    $this->_Q->QU();           
                                                }   
                                                    
                                                if (array_key_exists('ajax',$_GET) AND $this->_Q->_error!='') echo $this->_Q->_error;    
                                                    $this->orders_total();
                                                    if (array_key_exists('ajax',$_GET)) {
                                                        if ($this->_Q->_error!='') echo $this->_Q->_error; else echo $this->_order_total;
                                                    }
                                                
                                             }else{
                                                if (array_key_exists('ajax',$_GET)) echo 'Error! Item not Found!';
                                             }
                                             
                                         
                                            
                                 if (array_key_exists('ajax',$_GET)) exit;    else header("Location:".$this->_page_url);       
                                }else{
                                    if (array_key_exists('ajax',$_GET)) echo 'Error! Key not Found!';
                                }
                            }
                            
                            
                            
                            
                            
                            
                            
                            if (array_key_exists('dgshop_reorder',$_GET) && is_numeric($_GET['ids']) && is_numeric($_GET['total']) && $_GET['total']>0){
    
    
                                $info = $this->_Q->QA("SELECT * FROM <||>dg_shop__orders WHERE `id`=".$_GET['ids']." AND ((`user_id`='".$this->_infoUSER['id']."' AND `user_id`<>0) OR `ses_id`='".$this->_USER->_ses."') LIMIT 1");
                                
                                if ($info['group']!=0 AND $info['group']!='' AND $this->_infoUSER['id']!=''){
                                    $g = $this->_Q->QA("SELECT * FROM <||>dg_shop__orders_group WHERE `id`=".$info['group']." AND `user_id`=".$this->_infoUSER['id']);
                                    if ($g['id']=='' || $g['st']>1) exit;
                                }
                                
                                $arr='';
                            
                                        $arr['time'] = time();
                                        $arr['total'] = $_GET['total'];
                                        $this->_Q->_table = 'dg_shop__orders';
                                        $this->_Q->_arr = $arr;
                                        $this->_Q->_where = ' WHERE `id`='.$info['id'];
                                        $this->_Q->QU();
                                        $this->orders_total(); 
                                        echo '{';
                                        if ($this->_Q->_error=='') echo '"error":"0",'; else echo '"error":"1",';
                                        echo '"items":"'.$this->_order_total.'",';
                                        echo '"skl":"'.$this->total_skl($this->_order_total).'",';
                                        echo '"summ":"'.$this->price($this->_order_price).'",';
                                        echo '"totalprice":"'.$this->price($info['price']*$_GET['total']).'",';
                                        echo '"summ_sale":"'.$this->price(($this->_order_price)-($this->price_sale($this->_order_price))).'"';
                                        echo '}';
                                  exit;     
                            }
                            
                            if (array_key_exists('gettotalinfo',$_GET)){
                                $this->orders_total(); 
                                echo '{';
                                        if ($this->_Q->_error=='') echo '"error":"0",'; else echo '"error":"1",';
                                        echo '"items":"'.$this->_order_total.'",';
                                        echo '"skl":"'.$this->total_skl($this->_order_total).'",';
                                        echo '"summ":"'.$this->price($this->_order_price).'",';
                                        echo '"totalprice":"'.$this->price($info['price']*$_GET['total']).'",';
                                        echo '"summ_sale":"'.$this->price(($this->_order_price)-($this->price_sale($this->_order_price))).'"';
                                        echo '}';
                                         exit;  
                            }
                            
                            
                            
            }
            
     
             function orders_total(){
                                       $total = 0;
                                       $price = 0;
                                       $w = "`ses_id`='".$this->_USER->_ses."'";
                                       if ($this->_infoUSER['id']!='') $w = "`user_id`='".$this->_infoUSER['id']."'";
                                       $QW = $this->_Q->QW("SELECT * FROM <||>dg_shop__orders WHERE `group_id`=0 AND (".$w.")");
                                       foreach($QW as $i=>$row){
                                       	if ($row[0]!=''){
                                       	   $total=$total+$row['total'];
                                           $price=$price+$row['price']*$row['total'];   
                                       	}
                                       }
                                        $this->_order_total = $total;
                                        $this->_order_price = $price;
                                       
            }
            function total_skl($number){
                        
                        /*$t_str = 'товаров';
                        $last_num = substr($total,strlen($total)-1,1);
                        $last_num2 = substr($total,strlen($total)-2,2);
                        if ($last_num>1 AND $last_num<5) $t_str = 'товара';
                        if ($last_num==1 AND $last_num2!=11) $t_str = 'товар';
                        return $t_str;*/
                        
                        $suffix = array("товар", "товара", "товаров");  
                        $keys = array(2, 0, 1, 1, 1, 2);
                        $mod = $number % 100;
                        $suffix_key = ($mod > 7 && $mod < 20) ? 2: $keys[min($mod % 10, 5)];
                        return $suffix[$suffix_key];
            }
            
            function basket_info(){
                        $this->orders_total();
                        $re = '&re='.urlencode($_SERVER["REQUEST_URI"]);
                        if ( substr_count($_SERVER["REQUEST_URI"],'?func=auth')==1 || substr_count($_SERVER["REQUEST_URI"],'?func=reg')==1) $re='';
                        //$user = '<a href="'.$this->_page_url.'?func=auth'.$re.'">Вход</a> | <a href="'.$this->_page_url.'?func=reg'.$re.'">Регистрация</a> | ';
                        //if ($this->_infoUSER['id']!='') $user='<a href="'.$this->_page_url.'?func=profile">'.$this->_infoUSER['login'].'</a> (<a href="'.$this->_page_url.'?func=logout">выход</a>). ';
                        
                        $star = '';
                        if ($this->price_sale($this->_order_price)!=0) $star='<span title="С учетом скидки">*</span> ';
                        return '<span id="basket_info">'.$user.'В вашей <a href="'.$this->_page_url.'">корзине</a> <strong>'.$this->_order_total.'</strong> <span class="dgshopskl">'.$this->total_skl($this->_order_total).'</span> на сумму: <span class="totalprices">'.$this->price($this->_order_price-$this->price_sale($this->_order_price)).'</span> тг.'.$star.'</span>';
                
            }
            
            function minibasket(){
                 $tt=0;
                 echo '<h2>Оформить заказ</h2><form method="post" id="dgshop_order_form_mini" action="'.$this->_page_url.'"><ul>';
                 $w = "`ses_id`='".$this->_USER->_ses."'";
                 if ($this->_infoUSER['id']!='') $w = "`user_id`='".$this->_infoUSER['id']."'";
                
        	    $QW = $this->_Q->QW("SELECT * FROM <||>dg_shop__orders WHERE `group_id`=0 AND (".$w.")");
                 foreach($QW as $i=>$row){
                 	if ($row[0]!=''){
                 	    if (is_numeric($row['item_id'])) $item = $this->_Q->QA("SELECT * FROM <||>dg_shop__orders_items WHERE `item_id`=".$row['item_id']." LIMIT 1");
                         
                            $total = $total+$row['total'];
                            $price = $price+$row['total']*$row['price'];
                            $name = '<a href="'.$item['item_url'].'"><strong>'.$row['name'].'</strong></a>';
                             if ($item['item_url']=='') $name = '<strong>'.$row['name'].'</strong><br /><em class="comment">Добавлено администратором</em>';
                             $tt++;
                        ?>
                            <li>
                                <div><strong><?=$name?></strong><input name="edit_item_<?=$row['id']?>" value="1" type="hidden" /></div><div class="clear"></div>
                                <span><input type="number" value="<?=$row['total']?>" name="total_<?=$row['id']?>" class="total"  /></span>
                                <span><?=$this->price($row['price'])?> тг.</span>
                                <span><?=$this->price($row['total']*$row['price'])?> тг.</span>
                            </li>
                        
                        <?
                       
                 	}
                 }
                 echo '</ul>';
                 if ($tt>0) echo '<input type="submit" value="Продолжить" name="ro" class="button" >'; else echo ' В корзине нет товаров ';
                 echo '</form>';
            }
            function getMySale($user_id){
                
                $total = $this->_Q->QN("SELECT * FROM <||>dg_shop__orders_group WHERE `user_id`=".$user_id." AND `st`>3");
                if ($total>15) return 15;    
                if ($total>10) return 10;  
                if ($total>5) return 5;  
                return 0;
                
            }
            function price_sale($price,$h=0,$user_id=0){
                if ($user_id==0 AND $this->_infoUSER['id']!='') $user_id = $this->_infoUSER['id'];
                /*if ($h==0) $h = date("G");
                if ($h>=1 AND $h<5){ $this->_sale=true; $this->_sale_old=$price;    $this->_sale_info=20;   $this->_sale_type=1;   return ($price*0.2);  }
                if ($h>=8 AND $h<10){ $this->_sale=true; $this->_sale_old=$price;   $this->_sale_info=20;   $this->_sale_type=1;   return ($price*0.2); }
                if ($h>=13 AND $h<17){ $this->_sale=true; $this->_sale_old=$price;  $this->_sale_info=15;   $this->_sale_type=1;   return ($price*0.15); }
                */
                if ($user_id!='' AND $user_id!=0){
                    
                    $total = $this->_Q->QN("SELECT * FROM <||>dg_shop__orders_group WHERE `user_id`=".$user_id." AND `st`>3");
                    //echo $total;
                    
                    if ($total>15){ $this->_sale=true; $this->_sale_old=$price; $this->_sale_info=10;   $this->_sale_type=2; return ($price*0.10); }
                    if ($total>10){ $this->_sale=true; $this->_sale_old=$price; $this->_sale_info=7;   $this->_sale_type=2; return ($price*0.07); }
                    if ($total>5){ $this->_sale=true; $this->_sale_old=$price;  $this->_sale_info=5;   $this->_sale_type=2; return ($price*0.05); }
                    
                }
                
                return 0;
            }
            
            function add_in_shop($id,$name,$price,$url='',$des='',$img='',$title='в корзину'){
                
                    $key = md5($id.$name.$price.$url.$info.$img);
                    if (!array_key_exists($key,$this->_keyitems)){
                        
                        $this->_Q->_table = 'dg_shop__orders_items';
                        $this->_Q->_arr = array(
                                'item_id'=>strip_tags($id),
                                'item_url'=>strip_tags($url),
                                'item_img'=>strip_tags($img),
                                'item_des'=>strip_tags($des),
                                'price'=>strip_tags($price),
                                'item_name'=>strip_tags($name),
                                'key'=>$key,
                                );
                        if (!is_numeric($this->_Q->QI()))        return ''; else $this->_keyitems[$key]=$this->_Q->_arr;
                        
                    }
                    
                    return '<a href="#" id="item_'.$key.'" class="dg_in_basket" onclick="return dg_in_basket($(this))" title="'. htmlspecialchars($name) .'">'.$title.'</a>';
                
            }
            
            function add_in_shop_mini($id,$name,$price,$url='',$des='',$img='',$title='в корзину'){
                
                    $key = md5($id.$name.$price.$url.$info.$img);
                    if (!array_key_exists($key,$this->_keyitems)){
                        
                        $this->_Q->_table = 'dg_shop__orders_items';
                        $this->_Q->_arr = array(
                                'item_id'=>strip_tags($id),
                                'item_url'=>strip_tags($url),
                                'item_img'=>strip_tags($img),
                                'item_des'=>strip_tags($des),
                                'price'=>strip_tags($price),
                                'item_name'=>strip_tags($name),
                                'key'=>$key,
                                );
                        if (!is_numeric($this->_Q->QI()))        return ''; else $this->_keyitems[$key]=$this->_Q->_arr;
                        
                    }
                    
                    return '<a href="#" id="item_'.$key.'" class="dg_in_basket_mini" title="'. htmlspecialchars($name) .'">'.$title.'</a>';
                
            }
         function price($float){
            $float = number_format($float,2,'.',' ');
            $ex = explode('.',$float);
            if ($ex[1]=='00' || $ex[1]=='' || $ex[1]==0) return $ex[0]; else return $float;
            
        }
 
        
        function sendmailtoadmin($subj,$info){
                 send_mail('robot@'.$_SERVER["HTTP_HOST"],$_SERVER["HTTP_HOST"],$this->_regedit->read('dgshop_adminmail','admin@'.$_SERVER["HTTP_HOST"]),$subj,$info);
                 
               
                    /*$Login = 'siyama';
                    $Password = 's654fdd';
                    $Msg = array(                
                        'Phone' => $this->_regedit->read('dgshop_adminsms','79624489567'),
                        'From'=>'siyama.ru',
                        'Text' => $subj               
                    );

    

                    $Sms = new SMSClass($Login, $Password);
                    $Result = $Sms->SendSMS(array($Msg));
                    if ($Result['Error']) {
                        send_mail('robot@'.$_SERVER["HTTP_HOST"],$_SERVER["HTTP_HOST"],$this->_regedit->read('dgshop_adminmail','admin@'.$_SERVER["HTTP_HOST"]),'Ошибка отправки SMS',$Result['Error']);
                        send_mail('robot@'.$_SERVER["HTTP_HOST"],$_SERVER["HTTP_HOST"],'stavweb@yandex.ru','Ошибка отправки SMS',$Result['Error']);
                        }

*/
        
                 
        
           
        }
        
        function __destruct(){
                
            }
    }
    }
    $GLOBALS['dgshop'] = new dg_shop($this->_Q,$this->_PAGE);
    $this->_headlink_fin[]='          <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>';
    $this->_headlink[]='          <link charset="utf-8" rel="stylesheet" media="all" href="/_tpl/nioki/nioki/ui/ui/jquery-ui-1.8.23.custom.css" />';
    $this->_headlink_fin[]='          <script type="text/javascript" src="/dg_lib/dg_components/dg_shop/_tpl/dgshop.js?c='. time() .'"></script>';
    $this->_headlink_fin[]='          <script> var dg_shop_url = "'. $GLOBALS['dgshop']->_page_url .'";</script>';
?>