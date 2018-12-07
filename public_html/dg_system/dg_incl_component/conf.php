<?php

/**
 * @author mrhard
 * @copyright 2010
 */



defined("_DG_") or die ("ERR");


$this->_sefaccess = 1;

   
    
    
    $comp = new mycomp($this->_Q,$this);
    $comp->_comp = $this->_component[1];
    $comp->_tpl = $this->_component[2];
    $comp->_page = $this->_infoPAGE['id'];
    
     if ($_GET['L0']!=''){
        $ex = explode('.',$_GET['L0']);
        if ( $ex[1]=='' || substr_count($comp->_objecttype,','.$ex[1])==0 ){
            $this->_sefaccess_p = false;
        }
     }
     if ($this->_sefaccess_p) $comp->connect();
    
    
    


?>

