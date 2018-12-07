<?

/**
 * @author Maltsev Vladimir
 * @copyright 2009
 * 
 */
 
defined("_DG_") or die ("ERR");	

class dg_regedit{
    
    public $_Q ='';
    public $_regedit='';
    
    function __construct($Q=''){
        
        if (!is_object($Q)){ 
            $this->_Q = new dg_bd;
            $this->_Q->connect();
        }else{
            $this->_Q=$Q;
        }
        
        $QW = $this->_Q->QW("SELECT * FROM `<||>dg_regedit`");
        foreach ($QW as $i=>$row){
            $this->_regedit[$row['name']] = $row['val'];
        }
        
    }
    
    
   public function read($name,$def=''){
        
        if ( is_array($this->_regedit) ){
            
            if (array_key_exists($name,$this->_regedit)){ return $this->_regedit[$name]; }else{
               return $this->edit($name,$def);
            }
            
        }
        
        return $def;
    }
    
   public function edit($name,$val=''){
        
        $arr['name'] = $name;
        $arr['val'] = $val;
        
        $this->_Q->_table = 'dg_regedit';
        $this->_Q->_arr = $arr;
        $this->_Q->_where = " WHERE `name`='". $this->_Q->e($name) ."'";
        
        if ( $this->_Q->QN("SELECT `name` FROM <||>dg_regedit WHERE `name`='". $this->_Q->e($name) ."'")==0 ){
            $this->_Q->QI();
        }else{
            $this->_Q->QU();
        }
        $QW = $this->_Q->QW("SELECT * FROM `<||>dg_regedit`");
        foreach ($QW as $i=>$row){
            $this->_regedit[$row['name']] = $row['val'];
        }
        return $val;
        
    }
    
}

?>