<?

/**
 * @author Maltsev Vladimir
 * @copyright 2009
 * 
 */

defined("_DG_") or die ("ERR");	
	
	
	function dg_source($key=''){
		
		if ($_SERVER[HTTP_HOST]!=''){
    		$array = array();		
    		$array['hostinfo'] = parse_url($_SERVER[HTTP_HOST]);		
    		$exhostinfo	= explode('.',$array['hostinfo']['path']);
    		$sub = 'www';		
    		if ( ( count($exhostinfo)-1)==2 ){			
    			if ($exhostinfo[0]!='www') $sub=$exhostinfo[0]; 	
    		}
    		
    		$array['sub']=$sub;
    		$array['configdomain'] = _DR_.'/_domains/'. $array['hostinfo']['path'] .'.ini';
        }
        
        
        
		if (!file_exists($array['configdomain']))  $array['configdomain'] = _DR_.'/_domains/all.ini'; 
		
		$file = new dg_file;
		$file ->createdir('/_domains/');
		
		if (!file_exists($array['configdomain'])) {
			echo 'error 001'; exit;
			}else{
			
	    $array['info'] = parse_ini_file($array['configdomain']);		
        
        if(!file_exists(_DR_.'/files')) mkdir(_DR_.'/files/',_CHMOD_DIR_);	
        
        if ($array['info']['dir']!='' && !file_exists(_DR_.'/files/'.$array['info']['dir']))	mkdir(_DR_.'/files/'.$array['info']['dir'],_CHMOD_DIR_);		
			
    		}
		
		
		if ($key=='' || !array_key_exists($key,$array))return $array; else return $array[$key]; 
	}
	
	

 
?>