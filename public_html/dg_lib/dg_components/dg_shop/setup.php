<?php

/**
 * @author mrhard
 * @copyright 2010
 */


$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>dg_shop__orders
(id int(6) NOT NULL auto_increment,
`ses_id` int(6),
`user_id` int(6),
`name` varchar(250),
`key` varchar(100),
`item_id` int(6),
`item_url` text,
`item_img` text,
`item_des` text,
`price` float(10,2),
`group_id` int(6) DEFAULT '0',
`time` int(16),
`total` int(4) DEFAULT '1',
`info` text,
PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();

$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>dg_shop__orders_group
(id int(6) NOT NULL auto_increment,
`user_id` int(6),
`key` varchar(100),
`time` int(16),
`st` int(1) DEFAULT '1',
`info` text,
`admin_info` text,
`fio` varchar(250),
`address` text,
`tel` varchar(255),
PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();

$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>dg_shop__orders_items
(id int(6) NOT NULL auto_increment,
`item_id` int(6),
`item_url` text,
`item_img` text,
`item_des` text,
`item_name` text,
`price` float(10,2),
`key` varchar(255),
PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();

$this->_Q->_table="user";
    $this->_Q->AT('social',"varchar(100)",'');
    $this->_Q->AT('tel',"text",'');
    $this->_Q->AT('tel2',"text",'');
    $this->_Q->AT('address',"text",'');
    $this->_Q->AT('tel_send',"int(1) DEFAULT '0'",'');
    $this->_Q->AT('address_street',"text",'');
    $this->_Q->AT('address_home',"text",'');
    $this->_Q->AT('address_kv',"text",'');
    $this->_Q->AT('address_e',"text",'');
    $this->_Q->AT('address_k',"text",'');
    $this->_Q->AT('address_p',"text",'');
    $this->_Q->AT('address_kp',"text",'');

$this->_Q->_table="dg_shop__orders_group";
    $this->_Q->AT('address_street',"text",'');
    $this->_Q->AT('tel2',"text",'');
    $this->_Q->AT('address_home',"text",'');
    $this->_Q->AT('address_kv',"text",'');
    $this->_Q->AT('address_e',"text",'');
    $this->_Q->AT('address_k',"text",'');
    $this->_Q->AT('address_p',"text",'');
    $this->_Q->AT('address_kp',"text",'');
    $this->_Q->AT('total_person',"int(2) DEFAULT '1'",'');
    $this->_Q->AT('money',"int(1) DEFAULT '0'",'');
    
?>