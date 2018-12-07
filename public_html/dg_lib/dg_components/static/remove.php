<?php

/**
 * @author mrhard
 * @copyright 2010
 */

if ($this->_Q->dg_table_exists('texts')){
    

        $this->_Q->_table="texts";
        $this->_Q->_where=" WHERE `page`='".$this->_id."'";
        $this->_Q->QD();
        

    
}


?>