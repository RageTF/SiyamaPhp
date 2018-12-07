<?php

/**
 * @author mrhard
 * @copyright 2010
 */
defined("CONTENT") or die ("ERR");
$usedb = true;

if ($this->_infoPAGE['cache']==1){
    $cachedir = _DR_.'/cache/page.'.$this->_infoSource['info']['prefix'].'.content.'.$this->_infoPAGE['id'].'.ch';    
    if (!file_exists($cachedir) || (filemtime($cachedir)+$this->_regedit->read('COMP_'._CNAME_.'{'.$this->_infoPAGE['id'].'}cachecontent',3600))<time()){
        $inf = $this->_Q->QA("SELECT * FROM `<||>texts` WHERE `page`='".$this->_infoPAGE['id']."'"); 
                $file = new dg_file;
                $file->create($cachedir,$inf['text']);
                echo $inf['text'];
    }else{
        include_once $cachedir;
    }
}else{
    $inf = $this->_Q->QA("SELECT * FROM `<||>texts` WHERE `page`='".$this->_infoPAGE['id']."'");
    echo $inf['text'];   
}
?>