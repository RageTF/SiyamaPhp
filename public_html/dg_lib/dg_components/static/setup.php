<?php

/**
 * @author mrhard
 * @copyright 2010
 */

$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>texts
(id int(6) NOT NULL auto_increment,
`page` int(6),
`text` text,
PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();

if ($this->_Q->dg_table_exists('texts')){
    
    if ($this->_Q->QN("SELECT * FROM <||>texts WHERE `page`='".$this->_id."'")==0){
        
        $arr['page']=$this->_id;
        $this->_Q->_arr = $arr;
        $this->_Q->_table="texts";
        $this->_Q->QI();
        
    }
    
}

?>