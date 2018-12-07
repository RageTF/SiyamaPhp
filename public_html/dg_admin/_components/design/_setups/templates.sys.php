<?

/**
 * @author Maltsev Vladimir
 * @copyright 2009
 * 
 */

$info = dg_source();
$tpl_f = new dg_file;
$tpl_f->createdir(_DR_.'/_tpl/'.$info['info']['dir'].'/');



$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>templates__css
(id int(6) NOT NULL auto_increment,
`tpl` varchar(128),
`dir` text,
`order` int(6) DEFAULT '0',
`media` varchar(50) DEFAULT 'all',
`ie`	varchar(2),
`show` int(1) DEFAULT '0',
PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();

$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>templates__js
(id int(6) NOT NULL auto_increment,
`tpl` varchar(128),
`dir` text,
`order` int(6) DEFAULT '0',
`ie`	varchar(2),
`show` int(1) DEFAULT '0',
PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();

$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>templates__block
(`name` varchar(128),
`param` text,
PRIMARY KEY (name)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();



$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>mods
(
id int(6) NOT NULL auto_increment,
`name` varchar(128),
`param` text,
`mod` varchar(300),
`des` text,
PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();


$comp='templates';   $func='access';
if ($this->_Q->QN("SELECT * FROM <||>moders WHERE `comp`='".$comp."' AND `func`='".$func."'")==0){    $this->_Q->_arr = array('comp'=>$comp,'func'=>$func); $this->_Q->_table='moders'; $this->_Q->QI();}

$comp='blockmodules';   $func='access';
if ($this->_Q->QN("SELECT * FROM <||>moders WHERE `comp`='".$comp."' AND `func`='".$func."'")==0){    $this->_Q->_arr = array('comp'=>$comp,'func'=>$func); $this->_Q->_table='moders'; $this->_Q->QI();}

?>