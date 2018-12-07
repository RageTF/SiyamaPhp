<?php

/**
 * @author mrhard
 * @copyright 2010
 */

$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>dg_user_dev_keys
(id int(6) NOT NULL auto_increment,
`user_id` int(6),
`uid` varchar(255),
`os` varchar(100),
`key` text(100),
`time_update` int(10),
PRIMARY KEY (id)) engine=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();

$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>api__ses
(id int(6) NOT NULL auto_increment,
`user_id` int(6),
`key` varchar(32),
`time` int(10),
PRIMARY KEY (id)) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();

$this->_Q->_table="dg_shop__orders_group";
$this->_Q->AT('method',"int(1) DEFAULT '1'",'');
?>