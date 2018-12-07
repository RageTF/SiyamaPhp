<?php

/**
 * @author mrhard
 * @copyright 2010
 */



defined("_DG_") or die ("ERR");
define("_CNAME_",$this->_component[1]);
define("_CLOC_",_DR_.'/dg_lib/dg_components/'._CNAME_);
define("_CDIR_",'/dg_lib/dg_components/'._CNAME_);
define("_URL_",$this->_infoPAGE['url']); 
define("_LDIR_",_CLOC_.'/_langs/'.$this->LANGLOAD->_def); 

        $GLOBALS['admpageid']=$this->_infoPAGE['id'];
        $GLOBALS['admpageq']=$this->_Q;


                function lastmod(){
                    if (is_object($GLOBALS['admpageq']) && is_numeric($GLOBALS['admpageid'])){
                        $GLOBALS['admpageq']->_table='pages';
                        $GLOBALS['admpageq']->_where='WHERE `id`='.$GLOBALS['admpageid'];
                        $GLOBALS['admpageq']->_arr = array('lastmod'=>time());
                        $GLOBALS['admpageq']->QU();
                    }
                }

if (file_exists(_LDIR_)){
    if (is_dir(_LDIR_)){
    $dir = opendir (_LDIR_);
      while ( $file = readdir ($dir))
      {
        if (( $file != ".") && ($file != "..") && (is_file(_LDIR_.'/'.$file)))
        {
          include _LDIR_.'/'.$file;
        }
      }
      closedir ($dir);
    }
}
if (file_exists(_CLOC_.'/index.php')){
    if (file_exists(_CLOC_.'/setting.php')){
       include_once _CLOC_.'/setting.php';  
    }
    include_once _CLOC_.'/index.php';
}else{
    echo 'connection error component';
}

?>
