<?php

/**
 * @author mrhard
 * @copyright 2010
 */

class dg_user{
    
    private $_Q;
    
    public $_key;
    public $_ses;
    public $_sesinfo;
    
    public $_userauth=false;
    public $_userinfo;
    
    public $k;
    
    public $_botlist='bot,yandex,google,yahoo,mail,rambler,nigma,msn,ia_archiver,igdespyder,spider,yahoo,voyager,twitterbot';
    public $_bot = false;
    function __construct($Q=''){
        
      
        
        if ( trim($_SERVER['HTTP_USER_AGENT'])=='' ){
            return false;
        }
        
        $botex = explode(',',$this->_botlist);
        foreach($botex as $i=>$v){
        	if ( substr_count(strtolower($_SERVER['HTTP_USER_AGENT']),$v)>0 || strlen($_SERVER['HTTP_USER_AGENT'])<20) $this->_bot = true; 
        }
       
        
        $start=false;
        if (!is_object($Q)){ 
            $this->_Q = new dg_bd;
            $this->_Q->connect();
        }else{
            $this->_Q=$Q;
        }
        
        
        $this->k=$_COOKIE[_COOPX_.'user'];
        
        
       
        if (trim($this->k)!=''){ $start=false; }else{ $start=true; }      
        
        if (!$start){           
            $y = $this->_Q->QA("SELECT * FROM `<||>dgses` WHERE `key`='".  $this->_Q->e($this->k)  ."'");
        }
        if (!$start && $y['key']!=''){ $start=false; }else{$start=true; }
        
        if (!$this->_bot){
                if ( $start ){
                    
                   $this->_ses = $this->create();
                    
                    
                }else{
                    
                    $this->_sesinfo = $y;
                    if ($this->_sesinfo['id']!=''){
                         $this->_ses = $this->_sesinfo['id'];
                         if ($this->_sesinfo['user']!=0){
                            
                            $this->_userinfo =  $this->_Q->QA("SELECT * FROM `<||>user` WHERE `id`='".$this->_sesinfo['user']."' AND `act`=1");
                            if ($this->_userinfo['id']!=''){
                                
                                        $uarr['datelast'] = time();
                                        $uarr['iplast'] = $_SERVER["REMOTE_ADDR"];
                                        $this->_Q->_arr=$uarr;
                                        $this->_Q->_table='user';
                                        $this->_Q->_where="WHERE `id`=".$this->_userinfo['id'];
                                        $this->_Q->QU();                         
                               
                                 
                                $this->_userauth = true;
                            }
                            
                         }                                             
                    }
                    
                }   
            }else{
                $this->_ses = -1;
            }
             
        
    }
    
   public function coohost(){
            $h = $_SERVER['HTTP_HOST'];
            $ex = explode('.',$h);
            if ($ex[0]!='www' && count($ex)==2){
                return '.'.$ex[0].'.'.$ex[1];
            }	
            if ($ex[0]=='www'){
                $t='';
                for ($i=1; $i<=count($ex); $i++){
                    if  ($ex[$i]!='') $t.='.'.$ex[$i];
                }
                return $t;
            }else{
                $t='';
                for ($i=0; $i<=count($ex); $i++){
                    if  ($ex[$i]!='') $t.='.'.$ex[$i];
                }  
                return $t;      
            }
    }
    
   private function newkey(){
         if ($this->_bot) return false;
         $key = md5(rand()*rand());
         if ($this->_Q->QN("SELECT `key` FROM `<||>dgses` WHERE `key`='".$key."'")>0){ return  $this->newkey(); }else{ return $key; }
    }
    
    
   public function create(){
        if ($this->_bot) return false;
        $key =  $this->newkey();
            
           if( setcookie(_COOPX_.'user',$key,time()+32140800,'/',$this->coohost())){
        
          
                $this->_key=$key;
                $arr['ip']=$_SERVER["REMOTE_ADDR"];
                $arr['key']=$key;
                $arr['t']=time();
                $arr['u']=time();
                $arr['httpuseragent'] = $_SERVER["HTTP_USER_AGENT"];
                $this->_Q->_arr = $arr;
                $this->_Q->_table='dgses';
                return $this->_Q->QI();
           
           }     
  
    } 
    
    public function login($l,$p,$admin=false){
        if ($this->_bot) return false;
        $w='';
        if ($admin){
            $w = " AND `admin`>0 ";
        }
        
        $this->_userinfo = $this->_Q->QA("SELECT * FROM `<||>user` WHERE `login`='".trim($this->_Q->e($l))."' AND `pass`='".md5(trim($this->_Q->e($p)))."' AND `act`=1".$w);
        if ( $this->_userinfo['id']!='' ){

            

            $time = 0;
            if (array_key_exists('maxtime',$_POST)){
                $time = time()+30758400;
            }
            
                 $key = $this->newkey();
                 
               if (setcookie(_COOPX_.'user',$key,$time,'/',$this->coohost())){  
                 $arr['user'] = $this->_userinfo['id'];
                 $arr['key'] = $key;
                 $arr['u'] = time();
                 $this->_Q->_arr = $arr;
                 $this->_Q->_table='dgses';
                 $this->_Q->_where = "WHERE `id`=".$this->_sesinfo['id'];
                 $this->_Q->QU();  
                 $this->_sesinfo['user']=$arr['user'];  
                 
                 $arr='';
                 $arr['auth']=time();
                 $arr['auth_time']=$time;
                 $this->_Q->_arr=$arr;
                 $this->_Q->_table='user';
                 $this->_Q->_where="WHERE `id`=".$this->_userinfo['id'];  
                 $this->_Q->QU();
                }else{
                    return false;
                }
                
                    
            $this->_userauth = true;
            return true;
        }
        
        return false;
    }
    
     public function logout(){
            if ($this->_bot) return false;
                 $arr['user'] = 0;
                 $this->_Q->_arr = $arr;
                 $this->_Q->_table='dgses';
                 $this->_Q->_where = "WHERE `id`=".$this->_sesinfo['id'];
                 $this->_Q->QU();  
                 $this->_sesinfo['user']=$arr['user'];        
    }
    

    

}

?>