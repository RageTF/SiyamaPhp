<?

/**
 * @author Maltsev Vladimir
 * @copyright 2009
 * 
 */
 
defined("_DG_") or die ("ERR");	


	class dg_lang{
		
			public $ver='1.1';
			public $subver='beta';
		
		public $_def = 'ru';
		public $LANG = array();
	
		function __construct(){
			 include_once _DR_.'/dg_system/dg_lang/lang.php';
		}
		
		
		public	function load($group='general',$info=''){

			if ($_COOKIE['user_lang']!=''){ 	$this->_def = $_COOKIE['user_lang']; 	}
			
			
			if ($group=='general'){
			 if (file_exists(_DR_.'/dg_system/dg_lang/'.$this->_def.'/')){					
 				$dir = opendir (_DR_.'/dg_system/dg_lang/'.$this->_def.'/');
  						while ( $file = readdir ($dir))
  						{
    						if (( $file != ".") && ($file != "..") && (is_file(_DR_.'/dg_system/dg_lang/'.$this->_def.'/'.$file))) include_once _DR_.'/dg_system/dg_lang/'.$this->_def.'/'.$file;
  						}
  				closedir ($dir);				
			 }					
			}
            
            if ($group=='app'){ include_once _DR_.'/dg_system/dg_lang/'.$this->_def.'/main.php'; }
            
            if($group=='mod' && $info!=''){
                $d = _DR_.'/dg_lib/dg_modules/'.$info.'/_langs/'.$this->_def.'/main.php';
                if (file_exists($d)) include_once $d;    
            }
            
			
			
			
		}
	

	
	}

?>