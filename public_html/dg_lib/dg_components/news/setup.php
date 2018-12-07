<?php

/**
 * @author mrhard
 * @copyright 2010
 */


 $this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>dg_news
    (id int(6) NOT NULL auto_increment,
    `date` datetime,
    `time_insert` int(16),
    `time_update` int(16),
    `user_insert` int(6),
    `user_update` int(6),
    `seo_kw` varchar(255),
    `seo_des` varchar(255),
    `title` varchar(255),
    `anons` text,
    `text` text,
    `img` text,
    `url` varchar(255),
    `page_id` int(6),
    `show` int(1) DEFAULT '1',
    PRIMARY KEY (id)) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
    $this->_Q->Q();

$this->_Q->_table="dg_news";
$this->_Q->AT('send_push',"int(1) DEFAULT '0'",'');


 $this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>dg_news_sends
    ( 
    
    `id_news` int(6),
    `id_token` int(6),
    `time` int(10),
    `result` text,
  
    UNIQUE KEY `id_news` (`id_news`,`id_token`)
    
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
    $this->_Q->Q();

?>