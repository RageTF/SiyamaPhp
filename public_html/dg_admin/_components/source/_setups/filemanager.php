<?

/**
 * @author Maltsev Vladimir
 * @copyright 2009
 * 
 */



$comp='filemanager';   $func='index';
if ($this->_Q->QN("SELECT * FROM <||>moders WHERE `comp`='".$comp."' AND `func`='".$func."'")==0){    $this->_Q->_arr = array('comp'=>$comp,'func'=>$func); $this->_Q->_table='moders'; $this->_Q->QI();}

$comp='filemanager';   $func='copyfile';
if ($this->_Q->QN("SELECT * FROM <||>moders WHERE `comp`='".$comp."' AND `func`='".$func."'")==0){    $this->_Q->_arr = array('comp'=>$comp,'func'=>$func); $this->_Q->_table='moders'; $this->_Q->QI();}

$comp='filemanager';   $func='upload';
if ($this->_Q->QN("SELECT * FROM <||>moders WHERE `comp`='".$comp."' AND `func`='".$func."'")==0){    $this->_Q->_arr = array('comp'=>$comp,'func'=>$func); $this->_Q->_table='moders'; $this->_Q->QI();}

$comp='filemanager';   $func='edit';
if ($this->_Q->QN("SELECT * FROM <||>moders WHERE `comp`='".$comp."' AND `func`='".$func."'")==0){    $this->_Q->_arr = array('comp'=>$comp,'func'=>$func); $this->_Q->_table='moders'; $this->_Q->QI();}

$comp='filemanager';   $func='remove';
if ($this->_Q->QN("SELECT * FROM <||>moders WHERE `comp`='".$comp."' AND `func`='".$func."'")==0){    $this->_Q->_arr = array('comp'=>$comp,'func'=>$func); $this->_Q->_table='moders'; $this->_Q->QI();}

$comp='filemanager';   $func='backup';
if ($this->_Q->QN("SELECT * FROM <||>moders WHERE `comp`='".$comp."' AND `func`='".$func."'")==0){    $this->_Q->_arr = array('comp'=>$comp,'func'=>$func); $this->_Q->_table='moders'; $this->_Q->QI();}

?>