<?

    class AD{
        public $_Q;
        
        public $_host='http://89.179.72.52:5858/';
        
        
        function __construct($Q=''){
            
            ini_set('max_execution_time', 0);
            ini_set("memory_limit", "200M");
            
            if (!is_object($Q)){ 
            $this->_Q = new dg_bd;
            $this->_Q->connect();
            }else{
                $this->_Q=$Q;
            }
            
            
            
            
            if (array_key_exists('unload2AD',$_GET)){
                if ($this->PING()) {
                    //send_mail('robor@siyama.ru','siyama.ru','stavweb@yandex.ru','text','');
                    
                    // Получаем пользователей
                    
                    
                    $this->NEWORDER();
                    $this->getorderdata();
                    
                    //$this->GETALLMENU();
                    
                    
                     
                    
                }else echo 'Server Not Ping';
            }
            
        }
        
        
        public function tel($tel){
            $otel = $tel;
            
            if (($tel{0}==7 || $tel{0}==8) && strlen($tel)==11){
                $tel = substr($tel,1);
            } 
            if (strlen($tel)==10)
            return '8('.$tel{0}.$tel{1}.$tel{2}.') '.$tel{3}.$tel{4}.$tel{5}.'-'.$tel{6}.$tel{7}.'-'.$tel{8}.$tel{9};
            else return $otel;
            
            
            
        }
        
        public function user_name($fio){
            $fio = str_replace('  ',' ',$fio);
            $fio = str_replace('  ',' ',$fio);
            $fio = trim($fio);
            $exfio = explode(' ',$fio);
           
            		 
            if (count($exfio)>=3){
                
                
                return array('surname'=>$exfio[0],'name'=>$exfio[1],'fathername'=>$exfio[2]);
                
                
            }elseif(count($exfio)==2){
                
                return array('surname'=>$exfio[0],'name'=>$exfio[1]);
                
            }else{
                
                return array('name'=>$exfio[0]);
            }
            
        }
        
        public function arr2get($array, $start='?'){
            
            
                 return $start.urldecode(http_build_query($array));
                /*foreach($array as $i=>$v){
                	
                        $p[] = $i.'='.urlencode($v);
                    
                }
            
                if (is_array( $p )) return $start.implode('&',$p);*/
            
        }
        
        public function jSon($json){
            
            $json = explode('DATA={',$json);
            
            $jsondata = '{'.$json[1];
            
            	 
            
            return json_decode($jsondata,true);
        }
        
        
        public function xMl($xml){
            
            
 
 
$arr = array();

            
            $sxe = simplexml_load_string($xml);
            
            foreach ($sxe as $p) {
                foreach ($p as $property => $value) {
                    $arr[$property][] = (string) $value;
                }
            }
            
            return $arr;
            
            
        }
        
        public function get($url){
             
            return file_get_contents($url);
            
            /*$ch = curl_init();
        
        	curl_setopt($ch, CURLOPT_HEADER, 0);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Устанавливаем параметр, чтобы curl возвращал данные, вместо того, чтобы выводить их в браузер.
        	curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // следовать за редиректами
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);// таймаут4
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// просто отключаем проверку сертификата
            curl_setopt($ch, CURLOPT_COOKIEJAR, _DR_.'/cookie.txt'); // сохранять куки в файл 
            curl_setopt($ch, CURLOPT_COOKIEFILE,  _DR_.'/cookie.txt');
            curl_setopt($ch,  CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        	$data = curl_exec($ch);
        	curl_close($ch);
        
        	return $data;*/
            
        }
        
        public function PING(){
            
               

                $content = $this->get($this->_host.'ping');
                	 
                if (substr_count(strtolower($content),'archidelivery')>0) return true; else return false; 
            
        }
        
        
        public function U2U(){
            
            
            $QW = $this->_Q->QW("SELECT * FROM <||>user WHERE `AD_id` IS NULL AND `id` IN (SELECT `user_id` FROM <||>dg_shop__orders_group WHERE `tel` IS NOT NULL) LIMIT 1");
            	if (count($QW)>0){
            	                                        
            	                                        
            		foreach($QW as $i=>$row){
            			if ($row[0]!=''){
            			             
                                     $info = $this->_Q->QA("SELECT * FROM <||>dg_shop__orders_group WHERE `tel` IS NOT NULL AND `user_id`=".$row['id']." LIMIT 1"); 
                                     
                                     $URL = $this->_host.'getclientbyphone?phone='.$this->tel($info['tel']);
                                    // echo $URL.'<br />';
                                     $userData = $this->get($URL);            
                                     $json = $this->jSon($userData);
                                     if (is_array($json[1]) && is_numeric($json[1]['ID'])){
                                        
                                        
                                        $this->_Q->_table = 'user';
                                        $this->_Q->_arr = array('AD_id'=>$json[1]['ID']);
                                        $this->_Q->_where = 'WHERE `id`='.$row['id'];
                                        $this->_Q->QU();
                                        
                                        
                                     }	else{
                                        
                                         $username = $this->user_name($row['name']);
                                         
                                         $p='';
                                         
                                         $p['phone'] = $this->tel($info['tel']);
                                         $p['login'] = $row['login'];
                                         $p['surname'] = $username['surname'];
                                         $p['name'] = $username['name'];
                                         $p['fathername'] = $username['fathername'];
                                         $p['email'] = $row['mail'];
                                        $p['street'] =substr($info['address_street'],0,19);
                                         $p['house'] = substr($info['address_home'],0,19);
                                         $p['flat'] =  substr($info['address_kv'],0,19);
                                         $p['storey'] = substr($info['address_e'],0,19);
                                         $p['entrance'] = substr($info['address_p'],0,19);
                                         
                                         
                                         $userData = $this->get($this->_host.'newclient'.$this->arr2get($p));     
                                         $json = $this->jSon($userData);
                                         		echo '<pre>';
                                         		print_r($json);
                                         		echo '</pre>';
                                                
                                         if (is_numeric($json['ClientID'])){
                                            echo $json['ClientID'].'<br />';
                                            $this->_Q->_table = 'user';
                                            $this->_Q->_arr = array('AD_id'=>$json['ClientID']);
                                            $this->_Q->_where = 'WHERE `id`='.$row['id'];
                                            $this->_Q->QU();
                                            
                                         }else{
                                            
                                            $row['id'].' not add';
                                         }       
                                                
                                        
                                     }	 
                                   		           	   
            			                                                      
            			}
            		}
            	                                       
            	}else{
            	                                        
            	}
            
            
        }
        
        public function GETALLUSER(){
            
                $json = $this->get($this->_host.'getallusers');
                echo $json;
                $data = json_decode($json,true);
                
                
                 
                        
            
        }
        
        
        public function GETALLMENU(){
            
            
                $data = $this->get($this->_host.'getallmenu');
                $json = $this->jSon($data);
                		/*echo '<pre>';
                		print_r($json);
                		echo '</pre>';*/
                        
                        $CSV = '';
                        foreach($json as $i=>$v){
                        	$CSV[] = '"'.$v['MGNAME'].'";"'.$v['NAME'].'";"'.$v['ID'].'";';
                        }
                    
                        $l = implode("\n",$CSV);
                        		/*echo '<pre>';
                        		print_r($l);
                        		echo '</pre>';*/
                
                
        }
        
        public function NEWORDER(){
            
                $this->U2U();
            
            /**
             *  type= I – режим передачи клиента (0 – ФИО, 1 - Id) с v1.0.0.8
                clientid = S – ID клиента(в режиме 1) с v1.0.0.8
                cityname = S – название города или населенного пункта с v1.0.0.8
                client = S - ФИО клиента
                phone = S - телефон
                street = S - улица
                home = S - дом
                corps = S - корпус
                room = S - квартира
                frontdoor = S - подъезд
                level = S - этаж
                doorphone = B - наличие домофона
                flatwarecount = I - кол-во персон
                mail = S - эл.почта (строка)
                comment = S - комментарий (строка до 200 символов)
                database = S - путь к БД (если необходима запись в конкретную БД)
                time = S – строка с временем, в которое заказ должен быть доставлен (необязательный, 
                формат: «2013-04-22 12:04:17» (без кавычек))
                ispayment = оплачен ли заказ(1.0.0.2)
                paymenttype = тип оплаты(1.0.0.2)
                
                
                GET: http://192.168.0.33:5858/neworder?client=%C8%E2%E0%ED%EE%E2+%C8%E2%E0%ED+%C8%E2%E0%ED%FB%F7&phone=79201324567&street=%CC%E5%F2%E0%EB%EB%E8%F1%F2%EE%E2&home=7%E0&room=16&office=&email=example%40mlsit.ru&frontdoor=null&level=3-%E9+%FD%F2%E0%E6&doorphone=1&flatwarecount=4&comment=Hello&order=3%235%2C13%233&database=
                
*/
            
            //return false;
            $ORDER='';                  
            
            $QW = $this->_Q->QW("SELECT * FROM <||>dg_shop__orders_group WHERE (`ad`=0 OR `ad` IS NULL) AND `st` = 2 ORDER BY `id` DESC");
            	if (count($QW)>0){
            	   
            	                    $ORDER='';                    
            	                                        
            		foreach($QW as $i=>$row){
            			if ($row[0]!=''){
            			 $ORDER='';              
                        // echo $row['id'].'<br />';
                         
                            $QW2 = $this->_Q->QW("SELECT * FROM <||>dg_shop__orders WHERE `group_id`=". $row['id'] ."");  
                            	if (count($QW2)>0){
                            	                                        
                            	                                        
                            		foreach($QW2 as $i2=>$item){
                            			if ($item[0]!=''){
                            			                                               	   
                            			          		 
                                                  $name = explode('/',$item['name']);
                                                  $Size = trim($name[count($name)-1]);
                                                  //if ($Size!=''){
                                                 		 
                                                  	 
                                                  $object = $this->_Q->QA("SELECT * FROM <||>mycomp__cat WHERE `id`=".$item['item_id']." LIMIT 1");
                                                  		
                                                  $BID = '';
                                                   if ($Size!=''){
                                                  for ($s=1; $s<=10; $s++){
                                                       
                                                        if (trim($object['total'.$s])==$Size) $BID = $object['AD_id_'.$s];
                                                         
                                                    
                                                  }}else $BID = $object['AD_id_1'];
                                                        if ($BID!=''){ 
                                                  		     
                                                            
                                                            $ORDER[] = $BID.'#'.$item['total'];
                                                            
                                                        }
                                            //}                                                  
                            			}
                            		}
                            	                                       
                            	}else{
                            	                                
                            	}
                         if (is_array($ORDER)){
                            		/*echo '<pre>ORDER';
                            		print_r($ORDER);
                            		echo '</pre>';*/
            			 
                         $p='';
                         $userInfo = $this->_Q->QA("SELECT * FROM <||>user WHERE `id`=".$row['user_id']." LIMIT 1");
                         
                         if (is_numeric($userInfo['AD_id'])){
                            //$p['type'] = 1;
                            $p['clientid'] = $userInfo['AD_id'];
                         }else{
                            
                            //$p['type'] = 0;
                            
                         }
                         
                         $p['cityname'] = 'Атырау';
                         $p['client'] = $row['fio'];
                         $p['phone'] = $this->tel($row['tel']);
                         $p['street'] = $row['address_street'];
                         $p['home'] = $row['address_home'];
                         $p['corps'] = $row['address_k'];
                         $p['room'] = $row['address_kv'];
                         $p['frontdoor'] = $row['address_p'];
                         $p['level'] = $row['address_e'];
                         
                         if (trim($row['address_kv'])!=''){
                            $p['doorphone'] = 1;
                         }else{
                            $p['doorphone'] = 0;
                         }
                         $p['flatwarecount'] = $row['total_person'];
                         $p['mail'] = $userInfo['mail'];
                         $p['comment'] = mb_substr($row['info'],0,199);
                         $p['order'] = implode(',',$ORDER);
                         
                         $p['phonekind'] = 1;
                         $p['email'] = $userInfo['mail'];
                         $p['ismain'] = 1;
                         $p['smsok'] = 1;
                         $p['office'] = '';
                         $p['database'] = '';
                         
                         
                         		echo 'SEND DATA <pre>';
                         		print_r($p);
                         		echo '</pre>';
                                
                                echo $this->_host.'neworder'.$this->arr2get($p);
                                $data = $this->get($this->_host.'neworder'.$this->arr2get($p));
                                
                                //send_mail('robor@siyama.ru','siyama.ru','stavweb@yandex.ru','test',$data);
                                
                                
                                
                                
                                		echo '<pre>';
                                		print_r($data);
                                		echo '</pre>';
                                $xml = $this->xMl($data);
                                		echo 'GET DATA <pre>';
                                		print_r($xml);
                                		echo '</pre>';
                                
                                if (is_numeric($xml['OrderId'][0])){
                                    
                                    $this->_Q->_table = 'dg_shop__orders_group';
                                    $this->_Q->_arr = array('ad'=>$xml['OrderId'][0]);
                                    $this->_Q->_where = 'WHERE `id`='.$row['id'];
                                    $this->_Q->QU();
                                    
                                }else{
                                    
                                    $this->_Q->_table = 'dg_shop__orders_group';
                                    $this->_Q->_arr = array('ad'=>-1,'data'=>$this->_host.'neworder'.$this->arr2get($p)."\n".$data);
                                    $this->_Q->_where = 'WHERE `id`='.$row['id'];
                                    $this->_Q->QU();
                                    
                                    //send_mail('robor@siyama.ru','siyama.ru','stavweb@yandex.ru','ERROR',$data."\n\n".$this->arr2get($p)."\n\n".$row['id']);
                                    /*$f = new dg_file;
                                    $f->create(_DR_.'/adLog/'.date('Y-m-d-H-i-s').'.txt',$data."\n\n".$this->arr2get($p));
                                    
                                    */
                                }
                                	 
                                
            			                                               	   
            			   }    	                                   
            			}
            		}
            	                                       
            	} 
                
               
                
                 
            
            
        }
        
        public function getorderdata(){
            
            /**
                 * OCSTATUS = 4 В работе => 3
                 *            5 Собран
                 *            12 с сайта
                 *            6 - доставляется => 5
                 *            9 - доставлен  
                 *            7 - доставлен => 6
                 */ 
                $QW = $this->_Q->QW("SELECT * FROM <||>dg_shop__orders_group WHERE (`ad`>0) AND `st` <> 6 ORDER BY `id`");
                	if (count($QW)>0){
                	                                        
                	                                        
                		foreach($QW as $i=>$row){
                			if ($row[0]!=''){
                			                                               	   
                			    /*echo '<pre>';
                           		print_r($row);
                           		echo '</pre>';*/
                                   $data =    $this->get($this->_host.'getorderdata?OrderId='.$row['ad']);     
                                   		$json = $this->jSon($data);                 
                                        $st='';
                                        
                                        
                                        if ( $json[1]['ORDERSTATUS']==4 ) $st = 3;  
                                        if ( $json[1]['ORDERSTATUS']==6 ) $st = 5;
                                        if ( $json[1]['ORDERSTATUS']==7 ) $st = 6;  
                                        
                                        
                                        if ($st!='')  {
                                            
                                            $this->_Q->_table = 'dg_shop__orders_group';
                                            $this->_Q->_arr = array('st'=>$st);
                                            $this->_Q->_where = 'WHERE `id`='.$row['id'];
                                            $this->_Q->QU();
                                            
                                        } 		
                                                   
                                                   
                                                          
                			}
                		}
                	                                       
                	}
            
            
        }
        
    }
    
    
    
    
    

?>