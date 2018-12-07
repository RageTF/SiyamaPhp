<?php

/**
 * @author mrhard
 * @copyright 2010
 */

defined("CONTENT") or die ("ERR1");

if ($param[0]==-1){ $param[0] = $this->_infoPAGE['id']; }

$cf = new dg_file;
$cachefilename = _DR_.'/cache/mod.'.$this->_infoSource['info']['prefix'].'_navigation_'.$inf['id'].'_'.$this->_infoPAGE['id'].'.ch';
if (!file_exists($cachefilename)){
    $this->_PAGE->navigation($param[0],$param[1],$this->_infoPAGE['id']);
    $navclass='';
    if ($param[2]!='') $navclass=' class="'.$param[2].'"'; 
    $cf->create($cachefilename,"\n<nav".$navclass.">\n   <ul id=\"parent_".$param[0]."\">".$this->_PAGE->navigationtext."\n   </ul>\n</nav>\n"); 
}
if (file_exists($cachefilename)) $modcontent = $cf->read($cachefilename);
$this->_PAGE->navigationtext='';
?>