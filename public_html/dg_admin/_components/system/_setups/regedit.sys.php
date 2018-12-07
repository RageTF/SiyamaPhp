<?

/**
 * @author Maltsev Vladimir
 * @copyright 2009
 * 
 */


$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>dg_regedit
(id int(6) NOT NULL auto_increment,
`name` varchar(300),
`val`  text,
PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();


?>