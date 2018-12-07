<?

/**
 * @author Maltsev Vladimir
 * @copyright 2009
 * 
 */

$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>pages
(id int(6) NOT NULL auto_increment,
`name` varchar(500),
`menu` varchar(500),
`ind` varchar(500),
`link` text,
`tpl` varchar(100),
`comp` varchar(100),
`kw` text,
`des` text,
`css` varchar(500),
`main` int(1) DEFAULT '0',
`view` int(1) DEFAULT '1',
`cache` int(1) DEFAULT '0',
`search` int(1) DEFAULT '1',
`max` int(5) DEFAULT '20',
`parent` int(6) DEFAULT '0', 
`order` int(5) DEFAULT '0',
`access` text,
`moders` text,
PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();
    
    $this->_Q->_table="pages";
    $this->_Q->AT('lastmod',"int(30)",'lastmod'); 
    
$comp='pages';   $func='index';
if ($this->_Q->QN("SELECT * FROM <||>moders WHERE `comp`='".$comp."' AND `func`='".$func."'")==0){    $this->_Q->_arr = array('comp'=>$comp,'func'=>$func); $this->_Q->_table='moders'; $this->_Q->QI();}

$comp='pages';   $func='update';
if ($this->_Q->QN("SELECT * FROM <||>moders WHERE `comp`='".$comp."' AND `func`='".$func."'")==0){    $this->_Q->_arr = array('comp'=>$comp,'func'=>$func); $this->_Q->_table='moders'; $this->_Q->QI();}

$comp='pages';   $func='remove';
if ($this->_Q->QN("SELECT * FROM <||>moders WHERE `comp`='".$comp."' AND `func`='".$func."'")==0){    $this->_Q->_arr = array('comp'=>$comp,'func'=>$func); $this->_Q->_table='moders'; $this->_Q->QI();}

$comp='pages';   $func='access';
if ($this->_Q->QN("SELECT * FROM <||>moders WHERE `comp`='".$comp."' AND `func`='".$func."'")==0){    $this->_Q->_arr = array('comp'=>$comp,'func'=>$func); $this->_Q->_table='moders'; $this->_Q->QI();}


$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>search
(id int(6) NOT NULL auto_increment,
`t` int(30),
`host` text,
`url` text,
`title` text,
`kw` text,
`text` text,
`r` int (2) DEFAULT '0',
PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();

?>