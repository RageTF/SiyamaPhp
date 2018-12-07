<?
    $GLOBALS['MINORDERPRICE'] = 2000;
    set_time_limit(0);
    class API extends application{
        
        
            function news(){
                $RETURN = array();
                
                $QW = $this->_Q->QW("SELECT * FROM `<||>dg_news` WHERE `date`<='". date('Y-m-d H:i:s') ."' AND `show`=1 ORDER BY `date` DESC");
                	if (count($QW)>0){
                	                                        
                	                                        
                		foreach($QW as $i=>$row){
                			 
                			            
                                        if ($row['img']!=''){
                                            
                                            
                                            $img = 'http://'.$_SERVER['HTTP_HOST'].img(array('src'=>$row['img'],'w'=>200,'h'=>200,'zoom'=>true,'bg'=>'000000'));
                                            
                                        }else $img=null;
                                        $datestr = explode(' ',$row['date']);
                                        $datestr2 = explode('-',$datestr[0]);
                                                        $url   =   'http://'.$_SERVER['HTTP_HOST'].'/'.implode('/',$datestr2).'/'.$row['id'].'.html';              	   
                			            $RETURN[] = array(
                                        
                                            'id'=>$row['id'],
                                            'title'=>$row['title'],
                                            'text'=>$row['text'],
                                            'image'=>$img,
                                            'date'=>strtotime($row['date']),
                                            'url'=>$url
                                        
                                        );                                          
                		 
                		}
                	                                       
                	}
                $this->_JSON['NEWS'] = $RETURN;
            }
        
            function GETMYALLORDERS($id_user){
                
                
                      
                        $ii = 0;
                        $RETURN = array();
                        $IDS = array();
                        $IIDS = array();
                        $QW = $this->_Q->QW("SELECT * FROM `<||>dg_shop__orders_group` WHERE `user_id`=". $id_user ." ORDER BY `time` DESC");
                        	if (count($QW)>0){
                        	                                        
                        	                                        
                        		foreach($QW as $i=>$row){
                        			           $IIDS[$row['id']] = $ii;  
                                               $IDS[$row['id']]=$row['id'];
                        			           $RETURN[$ii] = array(
                                               
                                                   'id'=>$row['id'],
                                                   'time'=>$row['time'],
                                                   'st'=>$row['st'],
                                                   'ITEMS'=>array(),
                                                   'total'=>0
                                               
                                               );                                    	   
                        			            $ii++;                                          
                        		 
                        		}
                                if (count($IDS)>0){
                                    
                                    
                                    
                                    $QW = $this->_Q->QW("SELECT * FROM `<||>dg_shop__orders` WHERE `group_id` IN (". implode(',',$IDS) .") ORDER BY `time`");
                                    	if (count($QW)>0){
                                    	                                        
                                    	                                        
                                    		foreach($QW as $i=>$row){
                                    			 
                                    			          $GID =   $IIDS[ $row['group_id'] ];                                   	   
                                    			          $RETURN[ $GID ]['ITEMS'][] = array(
                                                          
                                                            'item_id'=>$row['item_id'],
                                                            'name'=>$row['name'],
                                                            'price'=>$row['price'],
                                                            'total'=>$row['total']
                                                          
                                                          );                                            
                                    		              $RETURN[ $GID ]['total']+=$row['price']*$row['total'];
                                    		}
                                    	                                       
                                    	} 
                                    
                                    
                                    
                                }
                        	                                       
                        	
                        
                        
                       }
                       
                       return $RETURN;
            }
            
        
            function myBASK($id_user){
                 
                $RETURN = array();
                $QW = $this->_Q->QW("SELECT * FROM <||>dg_shop__orders WHERE `group_id`=0  AND `user_id`='".$id_user."' ");
                	if (count($QW)>0){
                	                                        
                	                                        
                		foreach($QW as $i=>$row){
                			             
                                       $PRICESALE = $GLOBALS['dgshop']->price_sale($row['price']*$row['total'],0,$id_user);  
                    			        $RETURN[] = array(
                                        
                                            'id'=>$row['id'],
                                            'id_item'=>$row['item_id'],
                                            'title'=>$row['name'],
                                            'total'=>$row['total'],
                                            'price'=>$row['price']*$row['total'],
                                            'pricef'=>number_format($row['price']*$row['total'],0,' ',' '),
                                            'sale_price'=>$PRICESALE,
                                            'sale_priced'=>number_format($PRICESALE,0,' ',' ')
                                        );                                          
                		 
                		}
                	                                       
                	} 
                return $RETURN;
            }
            function CLEARBASK(){
                
                       $SESINFO = self::getSes($_POST['USER_SES_KEY']);
                       if (is_array($SESINFO) && $SESINFO['USER']['user_id']!=''){
                        
                        $this->_Q->_table = 'dg_shop__orders';
                        $this->_Q->_where = " WHERE `group_id`=0 AND `user_id`=". $SESINFO['USER']['user_id'] ." ";
                        $this->_Q->QD();
                        $this->_JSON['BASK']= self::myBASK($SESINFO['USER']['user_id']);
                       }
                
            }
            function REMOVEITEM(){
                
                if ($_POST['id']!='' && is_numeric($_POST['id'])){
                    
                    
                       $SESINFO = self::getSes($_POST['USER_SES_KEY']);
                       if (is_array($SESINFO) && $SESINFO['USER']['user_id']!=''){
                            $this->_Q->_table = 'dg_shop__orders';
                            $this->_Q->_where =" WHERE `id`=".$_POST['id']." AND `user_id`=". $SESINFO['USER']['user_id'] ." AND `group_id`=0";
                            $this->_Q->QD();
                            $this->_JSON['BASK']= self::myBASK($SESINFO['USER']['user_id']);
                       }
                    
                }
                
            }
             
            
            function INBASK(){
                
                
                    if (
                    
                        $_POST['id_item']!='' && is_numeric($_POST['id_item'])
                        &&
                        $_POST['p']!='' && is_numeric($_POST['p']) && $_POST['p']>0 && $_POST['p']<4
                        &&
                        $_POST['total']!='' && is_numeric($_POST['total']) && $_POST['total']>0
                        &&
                        $_POST['USER_SES_KEY']!=''
                    ){
                        
                       
                       $SESINFO = self::getSes($_POST['USER_SES_KEY']);
                       if (is_array($SESINFO) && $SESINFO['USER']['user_id']!=''){
                            
                            
                            
                            
                                $ITEM = $this->_Q->QA("SELECT * FROM `<||>mycomp__cat` WHERE `sys_show`=1 AND `price1`>0 AND `id`=". $_POST['id_item'] ." LIMIT 1");
                                if ($ITEM['id']!=''){
                                    
                                    
                                    $PRICE = $ITEM['price'.$_POST['p']];
                                    $T = $ITEM['total'.$_POST['p']];
                                    if ($PRICE>0){
                                        
                                         
                                        $PAGE = $this->_Q->QA("SELECT * FROM `<||>pages` WHERE `id`=". $ITEM['sys_page'] ." LIMIT 1");
                                        
                                        $NAME[] = $PAGE['name'];
                                        $NAME[] = $ITEM['name'];
                                        if ($T!='') $NAME[] = $T;
                                         
                                        $info = $this->_Q->QA("SELECT * FROM <||>dg_shop__orders WHERE `group_id`=0 AND `item_id`=".$ITEM['id']."  AND `user_id`='".$SESINFO['USER']['user_id']."' LIMIT 1");
                                                
                                                    $arr='';
                                                    $arr['ses_id'] = 0;
                                                    $arr['user_id'] = $SESINFO['USER']['user_id'];
                                                    $arr['item_id'] = $ITEM['id'];
                                                    $arr['item_url'] = '';
                                                    $arr['item_img'] = $ITEM['img'];
                                                    $arr['item_des'] = $ITEM['des'];
                                                    $arr['name'] = implode(' / ',$NAME);
                                                    $arr['price'] = $PRICE;
                                                    $arr['time'] = time();
                                                
                                               
                                                if ($info['id']==''){
                                                    
                                                    $arr['total'] = $_POST['total'];
                                                    $this->_Q->_table = 'dg_shop__orders';
                                                    $this->_Q->_arr = $arr;
                                                    $this->_Q->QI();
                                                
                                                }else{

                                                    $arr['total'] = $info['total']+$_POST['total'];
                                                    $this->_Q->_table = 'dg_shop__orders';
                                                    $this->_Q->_arr = $arr;
                                                    $this->_Q->_where = ' WHERE `id`='.$info['id'];
                                                    $this->_Q->QU();           
                                                } 
                                                 
                                                 $this->_JSON['BASK']= self::myBASK($SESINFO['USER']['user_id']);
                                                 $this->_JSON['STATUS']='OK';
                                        
                                        
                                        
                                    }
                                    
                                    
                                }
                            
                            
                        
                        }
                    }
                
                
            }
            function REG(){
                
                if ($_POST['login']!='' && $_POST['pass']!='' && $_POST['user_name']!='' && preg_match("/[0-9a-z_\-\.]+@[0-9a-z_\-^\.]+\.[a-z]{2,3}/i", $_POST['login'])){
                    
                    if ($this->_Q->QN("SELECT `mail` FROM <||>user WHERE `mail`='".$this->_Q->e($_POST['login'])."' LIMIT 1")>0){
                        $this->_JSON['STATUS'] = 'ERROR_E';
                    }else{
                    
                        foreach($_POST as $i=>$v){
                        	$_POST[$i] = htmlspecialchars_decode($v);
                        }
                        $arr='';
                        $arr['name'] = strip_tags($_POST['user_name']);
                        $arr['login'] = strip_tags($_POST['login']);
                        $arr['mail'] = strip_tags($_POST['login']);
                        $arr['datereg'] = time();
                        $arr['act']=1;
                        $arr['pass']=md5($_POST['pass']);
                        $this->_Q->_table = 'user';
                        $this->_Q->_arr = $arr;
                        $userid = $this->_Q->QI();
                        if ($userid>0 && is_numeric($userid)){
                            
                            self::AUTH();
                            
                            
                        }else $this->_JSON['STATUS'] = 'SYSERROR';
                        
                    }
                }
            }
            
            
            
            function AUTH(){
                
                if ($_POST['login']!='' && $_POST['pass']!=''){
                    
                    
                    $INFO = $this->_Q->QA("SELECT * FROM `<||>user` WHERE `login`='".trim($this->_Q->e($_POST['login']))."' AND `pass`='".md5(trim($this->_Q->e($_POST['pass'])))."' AND `act`=1 LIMIT 1");
                    
                    if ($INFO['id']!=''){
                        
                        
                        $NEWKEY = uniqid();
                        
                        
                         $arr = '';
                         $arr['user_id'] = $INFO['id'];
                         $arr['key'] = $NEWKEY;
                         $arr['time'] = time();
                         $this->_Q->_arr = $arr;
                         $this->_Q->_table='api__ses';
                         $ID_SES = $this->_Q->QI();  
                         $this->_JSON['ID_SES'] = $ID_SES;
                         $this->_JSON['KEY'] = $NEWKEY;
                         $this->_JSON['STATUS'] = 'OK';
                         
                        
                        
                    }else{
                        $this->_JSON['STATUS'] = 'ERROR';
                    }
                    
                    
                }
                
                
                
                
            }
            
            function getSes($KEY){
                if ($KEY=='') return 'ERROR';
                $INFO_SES = $this->_Q->QA("SELECT * FROM `<||>api__ses` WHERE `key` LIKE '".$this->_Q->e($KEY)."' LIMIT 1");
                    if ($INFO_SES['id']!=''){
                        
                        
                        $INFO = $this->_Q->QA("SELECT * FROM `<||>user` WHERE `id`=". $INFO_SES['user_id'] ." AND `act`=1 LIMIT 1");
                        if ($INFO['id']!=''){
                            
                            
                             return array('SES'=>$INFO_SES['id'],
                             'USER'=>
                             array(
                             'user_id'=>$INFO['id'],
                             'user_name'=>$INFO['name'],
                             )
                             );
                             
                             
                        }else  return 'ERROR 1';
                    
                        
                    }else  return 'ERROR 2';
            }
            
            function token(){
                        $this->_JSON['TOKEN'] = 'OK';
                        if ($_POST['token']!='' && $_POST['uid']!='' && $_POST['os']!=''){
                            
                            $arr = array();
                            $arr['key'] = $_POST['token'];
                            $arr['time_update'] = time();
                            $arr['os'] = $_POST['os'];
                            $arr['uid'] = $_POST['uid'];
                            if ($_POST['user_id']!='' && is_numeric($_POST['user_id'])) $arr['user_id'] = $_POST['user_id'];
                        
                            $INFO = $this->_Q->QA("SELECT * FROM `<||>dg_user_dev_keys` WHERE `uid`='". $this->_Q->e($_POST['uid']) ."' AND `os`='". $this->_Q->e($_POST['os']) ."' LIMIT 1");
                            if ($INFO['id']==''){
                                
                                $this->_Q->_table = 'dg_user_dev_keys';
                                $this->_Q->_arr = $arr;
                                $this->_Q->QI();
                                
                            }else{
                                
                                $this->_Q->_table = 'dg_user_dev_keys';
                                $this->_Q->_arr = $arr;
                                $this->_Q->_where = "WHERE `id`=". $INFO['id'] ." LIMIT 1";
                                $this->_Q->QU();
                                
                            }
                        }
                
            }
            
            function SO(){
                
                        $SESINFO = self::getSes($_POST['USER_SES_KEY']);
                        if (is_array($SESINFO) && $SESINFO['USER']['user_id']!=''){
                         $this->_JSON['SENDORDER'] = 'OK';
                        $error = '';
                        if (trim($_POST['fio'])=='') $error.='Заполните поле Ф.И.О. получателя'."\n";
                        if (trim($_POST['address_street'])=='') $error.='Заполните поле Адрес получателя, Улица'."\n";
                        if (trim($_POST['address_home'])=='') $error.='Заполните поле Адрес получателя, Номер дома'."\n";
                        if (trim($_POST['tel'])=='') $error.='Заполните поле Телефон получателя'."\n";
                        if (!is_numeric($_POST['tel']) OR strlen($_POST['tel'])!=11 OR substr($_POST['tel'],0,1)!=7) $error.='Номер телефона заполнен не правильно'."\n";
                        if (!is_numeric($_POST['total_person'])) $error.='Укажите количество персон'."\n";
                        if (!is_array($_POST['ITEMS']) || count($_POST['ITEMS'])==0) $error.='Вы не выбрали товар'."\n";
                        if ($error!='') $this->_JSON['SENDORDER'] = $error;
                        else{
                            $ITEMS = array();
                            $TOTALPRICE = 0;
                            foreach($_POST['ITEMS'] as $PITEM){
                            	
                                    if (is_numeric($PITEM['id']) && is_numeric($PITEM['total']) && $PITEM['total']>0 && $PITEM['id']>0 && is_numeric($PITEM['price']) && $PITEM['price']>0){
                                        
                                        $ITEM = $this->_Q->QA("SELECT * FROM `<||>mycomp__cat` WHERE `sys_show`=1 AND `price1`>0 AND `id`=". $PITEM['id'] ." LIMIT 1");
                                        if ($ITEM['id']!=''){
                                                
                                                
                                                $PRICE = $ITEM['price'.$PITEM['price']];
                                                $T = $ITEM['total'.$PITEM['price']];
                                                $PAGE = $this->_Q->QA("SELECT * FROM `<||>pages` WHERE `id`=". $ITEM['sys_page'] ." LIMIT 1");
                                                    $NAME = array();
                                                    $NAME[] = $PAGE['name'];
                                                    $NAME[] = $ITEM['name'];
                                                    if ($T!='') $NAME[] = $T;
                                            
                                                    $arr='';
                                                    $arr['ses_id'] = 0;
                                                    $arr['user_id'] = $SESINFO['USER']['user_id'];
                                                    $arr['item_id'] = $ITEM['id'];
                                                    $arr['item_url'] = '';
                                                    $arr['item_img'] = $ITEM['img'];
                                                    $arr['item_des'] = $ITEM['des'];
                                                    $arr['name'] = implode(' / ',$NAME);
                                                    $arr['price'] = $PRICE;
                                                    $arr['time'] = time();
                                                    $arr['total'] = $PITEM['total'];
                                                    $TOTALPRICE+=$PRICE*$PITEM['total'];
                                                    $ITEMS[] = $arr;
                                            
                                            
                                        }
                                        
                                    }
                                
                            }
                            if (count($ITEMS)==0){
                                
                                $error.='Вы не выбрали товар'."\n";
                            }
                            elseif($TOTALPRICE<$GLOBALS['MINORDERPRICE']){
                                
                                $error.='Минимальная сумма заказа — '.$GLOBALS['MINORDERPRICE']."\n";
                                
                            }
                            
                            else{
                                
                                
                                $this->_JSON['ITEMS'] = $ITEMS;
                                $this->_JSON['TOTALPRICE'] = $TOTALPRICE;
                                
                                
                                
                                $this->_Q->_table = 'dg_shop__orders_group';
                                
                                $arr='';
                                $arr['user_id'] = $SESINFO['USER']['user_id'];
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
                                $arr['method']=2;
                                $this->_Q->_arr = $arr;
                                $ORDER_ID = $this->_Q->QI();
                                if (is_numeric($ORDER_ID) && $ORDER_ID>0){
                                    
                                    /*$this->_Q->_table = 'dg_shop__orders';
                                    $this->_Q->_arr = array("group_id"=>$ORDER_ID);          
                                    $this->_Q->_where = "WHERE `group_id`=0 AND `user_id`=". $SESINFO['USER']['user_id'] .""; 
                                    $this->_Q->QU();    
                                    */
                                    
                                    
                                    foreach($ITEMS as $ITEM_ARR){
                                    	$ITEM_ARR['group_id'] = $ORDER_ID;
                                        $this->_Q->_table = 'dg_shop__orders';
                                        $this->_Q->_arr = $ITEM_ARR;        
                                        $this->_Q->QI();      
                                    }
                                    
                                    if ($this->_Q->_error==''){
                                        
                                        $this->_JSON['SENDORDER'] = 'OK'; 
                                        $GLOBALS['dgshop']->sendmailtoadmin('Новая заявка №'.$ORDER_ID,'Необходимо проверить заявку на сайте №'.$ORDER_ID);
                                   
                                    }else{
                                        
                                        $this->_JSON['SENDORDER'] = 'Системная ошибка';
                                        $this->_Q->_table = 'dg_shop__orders_group';
                                        $this->_Q->_where = " WHERE `id`=".$ORDER_ID." LIMIT 1";
                                        $this->_Q->QD();
                                        
                                        $this->_Q->_table = 'dg_shop__orders';
                                        $this->_Q->_where = " WHERE `group_id`=".$ORDER_ID." ";
                                        $this->_Q->QD();
                                    }             
                                
                                }else{
                                    
                                    $this->_JSON['SENDORDER'] = 'Системная ошибка';
                                         
                                }
                                
                                
                                
                                
                            }
                            
                            
                        }
                        
                        
                       }else $this->_JSON['SENDORDER'] = 'Вы не авторизованы';
                
                
            } 
            
            function SENDORDER(){
                
                       $SESINFO = self::getSes($_POST['USER_SES_KEY']);
                       if (is_array($SESINFO) && $SESINFO['USER']['user_id']!=''){
                       
                        $this->_JSON['SENDORDER'] = 'OK';
                        
                        
                      
                        $error = '';
                        if (trim($_POST['fio'])=='') $error.='<li>Заполните поле Ф.И.О. получателя</li>'."\n";
                        if (trim($_POST['address_street'])=='') $error.='<li>Заполните поле Адрес получателя, Улица</li>'."\n";
                        if (trim($_POST['address_home'])=='') $error.='<li>Заполните поле Адрес получателя, Номер дома</li>'."\n";
                        if (trim($_POST['tel'])=='') $error.='<li>Заполните поле Телефон получателя</li>'."\n";
                        if (!is_numeric($_POST['tel']) OR strlen($_POST['tel'])!=11 OR substr($_POST['tel'],0,1)!=7) $error.='<li>Номер телефона заполнен не правильно</li>'."\n";
                        if (!is_numeric($_POST['total_person'])) $error.='<li>Укажите количество персон</li>'."\n";
                        if ($error!='') $this->_JSON['SENDORDER'] = $error;
                        else{
                            $error='';
                            $SUMM = 0;
                            foreach(self::myBASK($SESINFO['USER']['user_id']) as $ITEM){
                            	$SUMM+=$ITEM['price'];
                            }
                            if ($SUMM<350){
                                
                                $error.= '<li>Минимальная сумма заказа 350 руб.</li>'."\n";;
                            }
                            
                            
                            
                            if ($error!='') $this->_JSON['SENDORDER'] = $error; else{
                                
                                
                               
                                $this->_Q->_table = 'dg_shop__orders_group';
                                
                                $arr='';
                                $arr['user_id'] = $SESINFO['USER']['user_id'];
                                $arr['fio'] = strip_tags($_POST['fio']);
                                $arr['tel2']=strip_tags(htmlspecialchars_decode($_POST['tel2']));
                                $arr['city']=0;//strip_tags(htmlspecialchars_decode($_POST['city']));
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
                                $arr['method']=2;
                                $this->_Q->_arr = $arr;
                                $ORDER_ID = $this->_Q->QI();
                                if (is_numeric($ORDER_ID) && $ORDER_ID>0){
                                    
                                    $this->_Q->_table = 'dg_shop__orders';
                                    $this->_Q->_arr = array("group_id"=>$ORDER_ID);          
                                    $this->_Q->_where = "WHERE `group_id`=0 AND `user_id`=". $SESINFO['USER']['user_id'] .""; 
                                    $this->_Q->QU();       
                                    $GLOBALS['dgshop']->sendmailtoadmin('Новая заявка №'.$ORDER_ID,'Необходимо проверить заявку на сайте №'.$ORDER_ID);
                                    $this->_JSON['SENDORDER'] = 'OK';              
                                
                                }else{
                                    
                                    $this->_JSON['SENDORDER'] = 'Системная ошибка';
                                         
                                }
                               
                                
                            }
                            
                        }
                             $this->_JSON['BASK'] = self::myBASK($SESINFO['USER']['user_id']);
                       }
                
                
            }
            
             
            
            function BASK(){
                
                
                $SESINFO = self::getSes($_POST['USER_SES_KEY']);
                       if (is_array($SESINFO) && $SESINFO['USER']['user_id']!=''){
                        
                        
                        $this->_JSON['BASK'] = self::myBASK($SESINFO['USER']['user_id']);
                        
                       }
                
            }
            
            function RL(){
                
                $SESINFO = self::getSes($_POST['USER_SES_KEY']);
                       if (is_array($SESINFO) && $SESINFO['USER']['user_id']!=''){
                        
                            $this->_JSON['ORDERS'] = self::GETMYALLORDERS($STATUS['USER']['user_id']);
                        
                       }
                
            }
            
            function LOGIN(){
                if ($_POST['AUTH_KEY']!=''){
                    
                    $STATUS = self::getSes($_POST['AUTH_KEY']);
                    if (is_array($STATUS)){
                        
                        $this->_JSON['STATUS'] = 'OK';
                        $this->_JSON['KEY'] = $_POST['AUTH_KEY'];
                        $this->_JSON['USER'] = $STATUS['USER'];
                        //$this->_JSON['BASK'] = self::myBASK($STATUS['USER']['user_id']);
                        $this->_JSON['MYSALE'] = $GLOBALS['dgshop']->getMySale($STATUS['USER']['user_id']); 
                        $this->_JSON['LASTORDER'] = $this->_Q->QA("SELECT * FROM <||>dg_shop__orders_group WHERE `user_id`='".$STATUS['USER']['user_id']."' AND `st`=6 ORDER BY `id` DESC LIMIT 1");
                        $this->_JSON['MINORDER'] =  $GLOBALS['MINORDERPRICE'];    
                        $this->_JSON['ORDERS'] = self::GETMYALLORDERS($STATUS['USER']['user_id']);
                        
                    }else $this->_JSON['STATUS'] = 'ERROR';
                    
                    //$this->_JSON['STATUS'] = (is_numeric($STATUS) && $STATUS>0)?'OK':$STATUS;
                    
                    
                }else  $this->_JSON['STATUS'] = 'ERROR 3';
            }
            function SAVEIMAGE($SRC,$KEY){
                
                $FILE = _DR_.'/appimage/'.$KEY.'.jpg';
                if (!file_exists($FILE)) file_put_contents($FILE,file_get_contents($SRC));
                 
                
            }
            function MAIN(){
                
                
                $ING=array(
                
                    'l'=>array('title'=>'Лосось','img'=>'/files/nioki/R_0547.jpg'),
                    't'=>array('title'=>'Тунец','img'=>'/files/nioki/R_0530.jpg'),
                    'kl'=>array('title'=>'Копченый лосось','img'=>'/files/nioki/R_0533.jpg'),
                    'ku'=>array('title'=>'Копченый угорь','img'=>'/files/nioki/R_0608.jpg'),
                    'o'=>array('title'=>'Осьминог','img'=>'/files/nioki/R_0574.jpg'),
                    'k'=>array('title'=>'Краб','img'=>'/files/nioki/R_0561.jpg'),
                    'g'=>array('title'=>'Гребешок','img'=>'/files/nioki/R_0590.jpg'),
                    'ka'=>array('title'=>'Кальмар','img'=>'/files/nioki/R_0543.jpg'),
                    'kr'=>array('title'=>'Креветка','img'=>'/files/nioki/R_0536.jpg'),
                    'kur'=>array('title'=>'Курица','img'=>'/files/nioki/R_0900.jpg'),
                    'ug'=>array('title'=>'Утиная грудка','img'=>'/files/nioki/R_1035.jpg'),
                    'go'=>array('title'=>'Говядина','img'=>'/files/nioki/R_0954.jpg'),
                    's'=>array('title'=>'Свинина','img'=>'/files/nioki/R_0966.jpg'),
                    'gy'=>array('title'=>'Говяжий язык','img'=>'/files/nioki/R_0963.jpg'),
                    'hot'=>array('title'=>'Острые','img'=>'/files/nioki/img/hot.jpg'),
                    'veg'=>array('title'=>'Вегетарианские','img'=>'/files/nioki/img/veg.jpg'),
                
                );
                
                foreach($ING as $ind=>$data){
                	
                    
                    $this->_JSON['DATA']['ING'][$ind]['title'] = $data['title'];
                    $this->_JSON['DATA']['ING'][$ind]['image'] = 'http://'.$_SERVER['HTTP_HOST'].img(array('src'=>$data['img'],'w'=>200,'h'=>200,'zoom'=>true,'bg'=>'000000','t'=>time()));                            
                    $this->_JSON['DATA']['ING'][$ind]['image_key'] = md5_file($this->_JSON['DATA']['ING'][$ind]['image']);
                    
                    
                }
                
                
                $this->_JSON['DATA']['CAT']=array();
                
                
                $this->_JSON['DATA']['TEXTS']['ABOUT']='<p>Компания «Сияма» рада предложить Вам большой выбор блюд японской кухни с бесплатной доставкой по городу Атырау: суши, роллы.</p>
                                    <p>Вы можете заказать:</p>
                                    <p>1) позвонив по многоканальному телефону, <a href="tel:+77010255025">+7(701)025-5-025</a> в единый call-center.<br />

2)заполнив на сайте форму on-line заказа.<br />

3)Быстро. Вы можете сделать предварительный заказ по телефону и забрать блюда  в удобное время, по дороге домой или в офис.</p>
                                <h3>Наши адреса</h3>
                                <p>ул. Махамбета Утемисова, 116а у входа гипермаркет IDEAL (Рахат-Насиха)</p>
                                <p>мкр. Авангард-2, д-1 (гипермаркет IDEAl)</p>
                                <p>мкр. Привокзальный-5, д-28 (гипермаркет IDEAl)</p>
                                
                                <p>К каждому заказу суши или роллов прилагаются:<br />
соевый соус, горчица Васаби, маринованный имбирь, одноразовые палочки.</p>
<p>Лозунг «Всегда Есть!» — отражает не только безупречное качество продукции, но и большое разнообразие блюд, представляющих различные направления и способных удовлетворить самого прихотливого покупателя. Мы постоянно совершенствуемся, придумываем новые интересные рецепты, расширяем ассортимент. Мы ценим наших клиентов и всегда учитываем их мнение при составлении меню.</p>
                                    <p style="text-align: center;"><a class="btn" href="tel:+77010255025">+7(701)025-5-025</a></p>
                                ';
                $this->_JSON['DATA']['TEXTS']['USLOVIA']=' <p>Мы рады предложить Вам услуги по Доставке японской кухни в г.Атырау.</p>
                                    <p>Заказы принимаются с 10:00 до 22:00</p>
                                    <p>Минимальная сумма заказа 2000т.</p>
                                    <p>Для отдаленных районов г. Атырау 5000т.</p>
                                    <p>К каждому заказу бесплатно прилагаются палочки, имбирь, васаби, соевый соус.</p>
                                    <p>
                                    Оформить заказ Вы можете по телефону  <a href="tel:+77010255025">+7(701)025-5-025</a>.
                                    </p>
                                    <h3>Способы оплаты</h3>
                                    <p>
 

Самый простой и привычный способ - наличные курьеру. Если Вам потребуется сдача, скажите об этом оператору при оформлении заказа. При получении заказа, оплатите его в соответствии с накладной, затем примите заказ, проверьте комплектность , и только убедившись, что все в порядке, отпускайте курьера.
</p>
<p>Почему вкусно заказывать в «Сияма»?
Каждый заказ готовится индивидуально под строгим наблюдением шеф-повара и упаковывается непосредственно перед отправкой.
Благодаря использованию технологии termobox при доставке, вы получаете свежие блюда высокого качества.
</p>
<p>Удобный способ заказа, быстрая доставка, вкусная еда — и жизнь становится немного лучше!

</p><p style="text-align: center;"><a class="btn" href="tel:+77010255025">+7(701)025-5-025</a></p>';
                $this->_JSON['DATA']['TEXTS']['SOCBTNS']='';
                
                
                $IMAGES = array();
                $IMAGESKEY = array();
                $QW = $this->_Q->QW("SELECT * FROM `<||>mycomp__rubr`");
                	if (count($QW)>0){
                	                                        
                	                                        
                		foreach($QW as $i=>$row){
                			 
                			                                               	   
                			       $IMAGES[$row['link']] = 'http://'.$_SERVER['HTTP_HOST'].img(array('src'=>$row['img'],'w'=>200,'h'=>200,'zoom'=>true,'bg'=>'000000','t'=>time()));                                               
                		           $IMAGESKEY[$row['link']] = md5_file(_DR_.$row['img']);
                                   //self::SAVEIMAGE($IMAGES[$row['link']],$IMAGESKEY[$row['link']]);
                		}
                	                                       
                	}
                $QW = $this->_Q->QW("SELECT * FROM `<||>pages` WHERE `comp` LIKE 'conf:cat:%' AND `view`=1 ORDER BY `order`");
                	if (count($QW)>0){
                	                                        
                	                                        
                		foreach($QW as $i=>$row){
                			 
                			          $URL = $this->_PAGE->url($row['id']);                                     	   
                			          $this->_JSON['DATA']['CAT'][$row['id']] = array(
                                         
                                        'title'=>$row['name'],
                                        'image'=>$IMAGES[$URL],
                                        'image_key'=>$IMAGESKEY[$URL]
                                      );                                            
                		 
                		}
                	                                       
                	}
                    
                 $QW = $this->_Q->QW("SELECT * FROM `<||>mycomp__cat` WHERE `sys_show`=1 AND `price1`>0");
                 	if (count($QW)>0){
                 	                                        
                 	                                        
                 		foreach($QW as $i=>$row){
                 			 
                 			           if (is_array($this->_JSON['DATA']['CAT'][ $row['sys_page'] ])){                                    	   
                     			           $this->_JSON['DATA']['CAT'][ $row['sys_page'] ]['ITEMS'][ $row['id'] ] = array(
                                            'id'=>$row['id'],
                                            'title'=>$row['name'],
                                            'img'=>($row['img']!='')?'http://'.$_SERVER['HTTP_HOST'].img(array('src'=>$row['img'],'w'=>150,'h'=>'auto','bg'=>'000000','zoom'=>true,'t'=>time())):'',
                                             'img2'=>($row['img']!='')?'http://'.$_SERVER['HTTP_HOST'].img(array('src'=>$row['img'],'w'=>400,'h'=>'auto','bg'=>'000000','zoom'=>false)):'',
                                           
                                            'img_key'=>($row['img']!='')?md5_file(_DR_.$row['img']):'',
                                            'k'=>($row['kk']!='')?$row['kk']:'-',
                                            'des'=>$row['des'],
                                            'PRICE1'=>array('total'=>$row['total1'],'price'=>$row['price1'],'pricef'=>number_format($row['price1'],0,' ',' ')),
                                            'PRICE2'=>array('total'=>$row['total2'],'price'=>$row['price2'],'pricef'=>number_format($row['price2'],0,' ',' ')),
                                            'PRICE3'=>array('total'=>$row['total3'],'price'=>$row['price3'],'pricef'=>number_format($row['price3'],0,' ',' ')), 
                                            'url'=> 'http://'.$_SERVER['HTTP_HOST'].$this->_PAGE->url($row['sys_page']).$row['id'].'.html'
                                            );     
                                                    
                                            if ($row['img']!='') self::SAVEIMAGE(
                                                $this->_JSON['DATA']['CAT'][ $row['sys_page'] ]['ITEMS'][ $row['id'] ]['img'],
                                                $this->_JSON['DATA']['CAT'][ $row['sys_page'] ]['ITEMS'][ $row['id'] ]['img_key']
                                            );    
                                            
                                            
                                            foreach($ING as $ind=>$v){
                                            	
                                                $this->_JSON['DATA']['CAT'][ $row['sys_page'] ]['ITEMS'][ $row['id'] ]['ing'][ $ind ] = ($row[$ind]==1)?true:false;
                                                
                                                
                                            }
                                                                      
                 		               }
                 		}
                 	                                       
                 	}  
                
            }
        
        
    }

?>