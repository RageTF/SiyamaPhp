<?


class security{
    public $_Q ='';
    public $_key;
    public $_ses;
    
    function __construct($ses,$Q){/*
        $this->_ses = $ses;
        if (!is_object($Q)){ 
            $this->_Q = new dg_bd;
            $this->_Q->connect();
        }else{
            $this->_Q=$Q;
        }
        if ($this->_Q->dg_table_exists('dg_security') && $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest' && ( !array_key_exists('accesspassword',$_POST) &&  !array_key_exists('goaccess',$_POST) && count($_POST)!=2)){      
            if (count($_POST)>0){
                if (!array_key_exists('postkey',$_POST) || trim($_POST['postkey'])=='' || $this->_Q->QN("SELECT * FROM <||>dg_security WHERE `key`='".$this->_Q->e($_POST['postkey'])."' AND `ref`='".$this->_Q->e($_SERVER["HTTP_REFERER"])."' AND `ses`='". $this->_ses ."' LIMIT 1")==0){
                    die("Error: POST key is invalid!");
                }
                
            }
            
            $this->_Q->_table = 'dg_security';
            $this->_Q->_where = "WHERE `date`<".(time()-3600);
            $this->_Q->QD();
        } 

        */
    }
    
    function creat_key($m='POST'){/*
        
        $this->_key = substr(md5(rand()),0,6);

                $http='http://';
                if ($_SERVER['HTTPS']=='on') $http='https://';
                $url = $http.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                $o = $this->_Q->QA("SELECT * FROM <||>dg_security WHERE `key`='".$this->_Q->e($this->_key)."' AND `ref`='".$this->_Q->e($url)."' AND `ses`='". $this->_ses ."' LIMIT 1");
                $this->_Q->_table = 'dg_security';
                $this->_Q->_arr = array('key'=>$this->_key,'ref'=>$url,'ses'=>$this->_ses,'date'=>time(),'m'=>$m);
                $this->_Q->QI();

        return "\n".'<input type="hidden" name="postkey" value="'.$this->_key.'" />'."\n";
    */
    }
    
    
}


?>