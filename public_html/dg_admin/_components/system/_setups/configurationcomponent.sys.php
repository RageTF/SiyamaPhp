<?

/**
 * @author Maltsev Vladimir
 * @copyright 2009
 * 
 */

$info = dg_source();
$fc = new dg_file;
 $fc->createdir(_DR_.'/_comp/'.$info['info']['dir'].'/');



$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>dgcomponent__regedit
(id int(6) NOT NULL auto_increment,
`name` varchar(300),
`ind`  varchar(300),
`des` text,
`ico` text,
PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();

$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>dgcomponent__fields
(id int(6) NOT NULL auto_increment,
`comp` int(9),
`name` varchar(300),
`ind`  varchar(300),
`des` text,
`type` varchar(100),
`def` text,
`format` text,
`order` int(9) DEFAULT '0',
`show` int(1) DEFAULT '0',
`main` int(1) DEFAULT '0',
PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();



$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>dgcomponent__imglist
(id int(6) NOT NULL auto_increment,
`fields_id` int(9),
`name` text,
`des` text,
`dir` text,
`order` int(9) DEFAULT '0',
`show` int(1) DEFAULT '0',
PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();

$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>dgcomponent__texts
(id int(6) NOT NULL auto_increment,
`page_id` int(9),
`prefix` text,
`sufix` text,
`showmodule` int(1) DEFAULT '0',
PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();

$comp='configurationcomponent';   $func='access';
if ($this->_Q->QN("SELECT * FROM <||>moders WHERE `comp`='".$comp."' AND `func`='".$func."'")==0){    $this->_Q->_arr = array('comp'=>$comp,'func'=>$func); $this->_Q->_table='moders'; $this->_Q->QI();}


?>