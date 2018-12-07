<?
/**
 * @author Maltsev Vladimir
 * @copyright 2009
 * 
 */
$info = dg_source();


$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>dgses
(id int(11) NOT NULL auto_increment,
`ip` varchar(15),
`httpuseragent` varchar(300),
`t` int(16),
`u` int(16),
`key` varchar(300),
`user` int(9) DEFAULT '0',
PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();

$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>user
(id int(11) NOT NULL auto_increment,
`name` varchar(300),
`login` varchar(300),
`mail` varchar(300),
`pass` text,
`ava` text,
`admin` int(1) DEFAULT '0',
`act` int(1) DEFAULT '0',
`datereg` int(16),
`datelast` int(16),
`ipreg` varchar(15),
`iplast` varchar(15),
`groups` text,
`auth` int(16),
`auth_time` int(16),
`key` text,
PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();


$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>message
(id int(11) NOT NULL auto_increment,
`from` int(6),
`to` int(6),
`subject` text,
`text` text,
`date` int(16),
`st` int(0) DEFAULT 0,
`re` int(11),
PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();

$this->_Q->_sql="CREATE TABLE IF NOT EXISTS <||>user__groups
(id int(11) NOT NULL auto_increment,
`name` varchar(100),
PRIMARY KEY (id)) TYPE=MyISAM DEFAULT CHARSET=utf8;";
$this->_Q->Q();

$fc = new dg_file;
$fc->createdir(_DR_.'/files/'. $this->inf['info']['dir'] .'/userfiles');

if ($this->_Q->QN("SELECT * FROM `<||>user` WHERE `admin`>0")==0 && !$install){
    
    $arr['name']='Administrator';
    $arr['login']='admin';
    $arr['pass']=md5('admin');
    $arr['mail'] = 'admin@'.$_SERVER[HTTP_HOST];
    $arr['admin'] = 2;
    $arr['datereg'] = time();
    $arr['datelast'] = time();
    $arr['ipreg'] = $_SERVER["REMOTE_ADDR"]; 
    $arr['iplast'] = $_SERVER["REMOTE_ADDR"]; 
    $arr['act']=1;
    $this->_Q->_arr = $arr;
    $this->_Q->_table = 'user';
    $this->_Q->QI();
}


$comp='users';   $func='index';
if ($this->_Q->QN("SELECT * FROM <||>moders WHERE `comp`='".$comp."' AND `func`='".$func."'")==0){    $this->_Q->_arr = array('comp'=>$comp,'func'=>$func); $this->_Q->_table='moders'; $this->_Q->QI();}

$comp='users';   $func='update';
if ($this->_Q->QN("SELECT * FROM <||>moders WHERE `comp`='".$comp."' AND `func`='".$func."'")==0){    $this->_Q->_arr = array('comp'=>$comp,'func'=>$func); $this->_Q->_table='moders'; $this->_Q->QI();}

$comp='users';   $func='remove';
if ($this->_Q->QN("SELECT * FROM <||>moders WHERE `comp`='".$comp."' AND `func`='".$func."'")==0){    $this->_Q->_arr = array('comp'=>$comp,'func'=>$func); $this->_Q->_table='moders'; $this->_Q->QI();}

$comp='users';   $func='groups';
if ($this->_Q->QN("SELECT * FROM <||>moders WHERE `comp`='".$comp."' AND `func`='".$func."'")==0){    $this->_Q->_arr = array('comp'=>$comp,'func'=>$func); $this->_Q->_table='moders'; $this->_Q->QI();}

?>