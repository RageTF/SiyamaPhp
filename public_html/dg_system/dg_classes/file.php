<?

/**
 * @author Maltsev Vladimir
 * @copyright 2009
 * 
 */
defined("_DG_") or die ("ERR");	

class dg_file{
	/**
	 * класс для работы с файлами
	 */
	 
    public $ver='0.1';
	public $subver='beta';
	
	public	function access($filedir){
		 
						/**
						 * Проверка доступа к файлу
						 */
					
					if ( substr_count( basename($filedir),'.sys.' )===1 ){ return false; }else{ return true; }		
	}
	
	public	function chmod($source,$attr=_CHMOD_OTHER_){
		
		
				@chmod($source,$attr);
		
		
	}
	
	public	function createdir($source,$attr=_CHMOD_DIR_){
					
					/**
					 * Создаем директории
					 * */
					
					if (!file_exists($source)){
						
						$source = str_replace('//','/',$source);			
						$source = str_replace(_DR_,'',$source);
						$source = str_replace(strtolower(_DR_),'',$source);
						
						$ex = explode('/',$source);
					    
						$s = _DR_;
						
						foreach($ex as $i=>$v){
						if ($v!=''){
						 if ( substr_count($v,'.')===0 ){
						 	
							 $s.='/'.$v;
							 if ( !file_exists($s) ){mkdir($s,$attr);}
				        
						 }else{
						 	
						 	return false;
						 	
						 }
					   }
						}
						
					}
		
	}
	
	
	
	public	function read($filedir){
							/**
							 * читаем содержимое файла
							 */
					 
						 if (file_exists($filedir)){
						 	
						  $file = fopen($filedir,"r");
						  
						  $GLOBALS['usedir'].='read - '.$filedir."\n";
                          return fread($file,filesize($filedir)+1);
						 	
						 }else{
						 	return false;
						 }				
	}
	
	 
	 
	 
	public	function create($filedir,$content){
						 /**
						  * создаем или редактируем файл
						  */ 
						   
			   			 if (get_magic_quotes_gpc()) $content = stripslashes($content);
						   
							$this->createdir($filedir);
							$create=false;
							if ( file_exists($filedir) ){
								/**
								 * если файл существует переписываем chmod
								 */
								 
								 $this->chmod($filedir);
								 
							}else{								
								$create=true;								
							}
							
			  				$file = fopen ($filedir,"w");
			    			fputs ( $file,$content);
							fclose ($file);	
							if ($create){
								
								/**
								 * если файл только что создали
								 */
								$this->chmod($filedir); 
							}	
							
	}
	
	
	public	function type($filedir){
					/**
					 * тип файла (по расширению)
					 */ 
				
					$ex = explode('.',basename($filedir));
					return $ex[(count($ex)-1)];
					
	}
	
	public	function incl($filedir,$one=false){
					/**
					 * include, для учета
					 */
				 
					if ( file_exists($filedir) ){
						 $GLOBALS['usedir'].='include - '.$filedir."\n";	
						 if ($one) include_once $filedir; else include $filedir; 
					}
	}
	
	
	public	function full_del_dir ($directory){
				  	/**
				  	 * удаляем директорию полностью
				  	 */
			  				$dir = opendir($directory);
			  				while(($file = readdir($dir))){
			    					if ( is_file ($directory."/".$file)) {
			     						  $this->chmod($directory."/".$file,0777);
                                          unlink ($directory."/".$file);
			    					}  else if ( is_dir ($directory."/".$file) && ($file != ".") && ($file != "..")){
			      								$this->full_del_dir($directory."/".$file);  
			    						}
			  						}
			  				closedir ($dir);
                            $this->chmod($directory,0777);
                            rmdir ($directory);
                            
  	 }
  

	 public	function clearcache($w=''){
 
                          $dir = opendir (_DR_."/cache");
                          while ( $file = readdir ($dir))
                          {
                            if (( $file != ".") && ($file != "..") && (is_file(_DR_."/cache/".$file)))
                            {
                              $ex = explode('.',$file);
                              if ($ex[0]==$w || $w==''){
                               
                                $this->chmod(_DR_.'/cache/'.$file,0777);
                                unlink(_DR_.'/cache/'.$file);
                              }
                            }
                          }
                          closedir ($dir);
                          
        }
        
   
      
	
}

?>