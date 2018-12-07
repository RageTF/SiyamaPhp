<?

/**
 * @author Maltsev Vladimir
 * @copyright 2009
 * 
 */
defined("_DG_") or die ("ERR");	


class dg_bd{
	
	public $ver='0.1';
	public $subver='beta';
	
	public $_settingdomainload = true; // загружать конфигурацию из домена
	
	public $_server='localhost';
	public $_base;
	public $_port='3306';
	public $_user='root';
	public $_pass='';
	public $_prefix='';
	
	public $_link;
	public $_connect=false;
	
	public $_sql;
	public $_table;
	public $_where;
	public $_arr;
	
	public $_error;
	
	public	function connect(){
					
							/**
							 * соединение с БД 
							 */
					
					
					/* пытаемся соедениться через конфигурацию домена */
					
                    
					
					if ( function_exists('dg_source') && $this->_settingdomainload ){
									
						$info = dg_source();
						$this->_server = $info['info']['host'];
						$this->_base = $info['info']['base'];
						$this->_user = $info['info']['user'];
						$this->_pass = $info['info']['pass'];
						$this->_prefix = $info['info']['prefix'];
					}
					
					
					$this->_link = @mysql_connect ($this->_server.':'.$this->_port,$this->_user,$this->_pass); $this->_error .= mysql_error();
					if ( $this->_error=='' ){
						
						@mysql_select_db($this->_base,$this->_link); $this->_error .= mysql_error();
						
						if ($this->_error=='') $this->_connect=true; else return false; 
						
						     	     
				          if (version_compare(mysql_get_server_info(), '4.1', ">=")) mysql_query("/*!40101 SET NAMES 'utf8' */");
						
					}else{
					   return false;
					}
		            $GLOBALS['connect']++;
       
		return true;
	}
	
    public function dg_table_exists($name,$use_px=true){
        $QW = $this->QW("SHOW TABLES");
        
        if ($use_px) $name=$this->_prefix.$name;
        
        foreach ($QW as $i=>$row){
            if ($row[0]==$name) return true; 
        }
        
        return false;
    }
	
	public	function e($value){
			    		 /**
			    		  * защита от инъекций
			    		  */
						 if (get_magic_quotes_gpc()) $value = stripslashes($value);
			
			        		$value =  mysql_real_escape_string($value,$this->_link);
			        		$value = str_replace('\"','"',$value);
			   		     	return $value;

			}

	
	public	function Q($SQL=''){
							/**
							 * выполняем запрос
							 */
					if ($this->_connect){
						if ($SQL!='') $this->_sql=$SQL; 
					
						if ($this->_sql==''){ 
							$this->_error = 'no sql query'; 
						}else{
							
							$this->_sql = str_replace("<||>",$this->_prefix,$this->_sql);
							
							
											
						 	$res = mysql_query($this->_sql,$this->_link);
                            $error = mysql_error($this->_link);
							if($error!=''){
							 $this->_error.=$error."\n";
                             addlog($error,'mysql'); 
                            }
						 	$GLOBALS['sql'].=$this->_sql."\n";
                            $GLOBALS['sql_error'].=$this->_sql.'  '.$error."\n";
						 	return $res;
						}
					}
	}

	public	function table_exists($value){
						/**
						 * Проверяем если таблица
						*/
					$value = str_replace("<||>",$this->_prefix,$value);
					
						$QW = $this->QW("SHOW TABLES");
						foreach ($QW as $i=>$row){
							
							if ( $value==$row[0] ) return true; 
							
						}					
					
					return false;
					
	}	
	
	public	function QA($SQL=''){
							/**
							 * результат запроса в массиве
							 */
					if ($this->_connect){
						if ($SQL!='') $this->_sql=$SQL; 		
							return mysql_fetch_array($this->Q());
					}
	}
	
	
    public	function QN($SQL=''){
					    	/**
					    	 * Кол-во строк
					    	 */
			       if ($this->_connect){
					 if ($SQL!='') $this->_sql=$SQL; 	
				     return mysql_num_rows($this->Q());
				   }  
    }

    public	function QI(){
						/**
						 * Выполняем INSERT
						 * @example $arr[row1]=1;
						 * 			$arr[row2]=2;
						 * 			$Q = new dg_bd;
						 * 			$Q->connect();
						 * 			$Q->_table='mytable'; // указываем без префикса
						 * 			$Q->_arr = $arr;
						 * 			$last_id = $Q->QI();
						 * @return mysql_insert_id
						 */
				    if ($this->_connect){ 
					 if (!is_array($this->_arr)) return false; 
			    	 $SQL = "INSERT INTO <||>".$this->_table;
				     $r='';
			   	     
						foreach($this->_arr as $index => $val)
			  	      			{
			    	  			if (trim($index)!='')
								  {  	      				
			     	            	$r.=',`'.$index.'` ';
			     	               }	
			   	      			}
			
			   	      $SQL.=' ('.substr($r,1).') VALUES ';
			
			       	   $values='';
			   	       foreach($this->_arr as $index => $val)
			   	       			{
			    	  			if (trim($index)!='')
								  {
									$values.=", '".$this->e($val)."'";
								  }	
			   	       			}
			
			   	       $SQL.='('.substr($values,1).') ';
			   	       $this->_sql=$SQL;
			   	       $this->Q();
			   	       return mysql_insert_id($this->_link);
			     }
	}

 	public	function QU(){
						/**
						 * Выполняем UPDATE
						 * @example $arr[row1]=1;
						 * 			$arr[row2]=2;
						 * 			$Q = new dg_bd;
						 * 			$Q->connect();
						 * 			$Q->_table='mytable'; // указываем без префикса
						 * 			$Q->_where = "WHERE `id`='" . $Q->e($_GET[id]) . "'";
						 * 			$Q->_arr = $arr;
						 * 			$Q->QU();
						 */
			 	   if ($this->_connect){	
			        if (!is_array($this->_arr)) return false; 
						$SQL = "UPDATE <||>".$this->_table;
						$r='';
			
				   		foreach($this->_arr as $index => $val)
			   	 			{
			    	  			if (trim($index)!='')
								  {
								   $r.=",`".$index."` = '". $this->e($val) ."' ";
			   	  			      }
							}
			
			   	 		 $SQL.=" SET ".substr($r,1)." ".$this->_where;
			   	         $this->_sql=$SQL;
			   	       	 $this->Q();
				   }
	}

	public	function QD(){
						/**
						 * Выполняем DELETE
						 * @example $Q = new dg_bd;
						 * 			$Q->connect();
						 * 			$Q->_table='mytable'; // указываем без префикса
						 * 			$Q->_where = "WHERE `id`='" . $Q->e($_GET[id]) . "'";
						 * 			$Q->QD();
						 */
					if ($this->_connect){
				 		$SQL="DELETE FROM <||>".$this->_table." ".$this->_where;
			   	    	$this->_sql=$SQL;
			   	    	$this->Q();
			   	    }
    }
    
    public	function QW($SQL=''){
						/**
						 * Выполняем обход строк
						 * @example $Q = new dg_bd;
						 * 			$Q->connect();
						 * 			$QW = $Q->QW("SELECT * FROM <||>mytable"); 
						 * 			foreach ($QW as $i=>$row){
						 * 					echo $row[id]."<br/>";
						 * 			}		
						 */
						if ($this->_connect){
				        		if ($SQL!='') $this->_sql=$SQL;
									 
						
			   					$result = $this->Q();
								$arr = array();			   			
						   		while ($row = mysql_fetch_array( $result )) {
				  			      		$arr[$i] = $row; $i++;
			    				}			
						   		mysql_free_result($result);
			      				return $arr;
			      		}
	}
    
    public	function AT($name,$type,$comment=''){
        /**
        *добавляем поле в таблицу
        */
	   $arrTotalF = array();

	   $QW = $this->QW("SHOW FIELDS  FROM <||>".$this->_table);
       foreach($QW as $i=>$row){
       	if ($row[0]!=''){
       	    $n = $row[0]; 
               $arrTotalF[$n]=true;
        }
       }

	   if (!array_key_exists($name,$arrTotalF))
	      {
	      	if ($comment!='') $comments = " COMMENT '".$comment."'"; 
	        $this->Q("ALTER TABLE <||>".$this->_table." ADD `".$name."` ".$type.$comments.";");
	      }

    }
	
	
	
}

?>