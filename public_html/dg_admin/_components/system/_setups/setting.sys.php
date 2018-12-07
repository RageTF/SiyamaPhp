<?php

/**
 * @author mrhard
 * @copyright 2010
 */

$comp='settings';   $func='access';
if ($this->_Q->QN("SELECT * FROM <||>moders WHERE `comp`='".$comp."' AND `func`='".$func."'")==0){    $this->_Q->_arr = array('comp'=>$comp,'func'=>$func); $this->_Q->_table='moders'; $this->_Q->QI();}

$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>dg_security
(id int(6) NOT NULL auto_increment,
`key` varchar(6),
`ses`  int(6),
`ref` text,
`m` varchar(10),
`date` int(30),
PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();

?>