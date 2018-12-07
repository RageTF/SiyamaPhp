<?
set_error_handler('addsyslog');

/**
 * @author Maltsev Vladimir
 * @copyright 2009
 * 
 */
 date_default_timezone_set("Asia/Oral");
 		 
define('_DG_',true);
$GLOBALS['getindex']=0;
function tl($name='none'){
    
    $GLOBALS['tlt'][]=microtime();
    $GLOBALS['tln'][]=$name;
    
}
tl('start sys');


    if (!file_exists(_DR_.'/cache/')){ mkdir(_DR_.'/cache/'); }
    if (!file_exists(_DR_.'/cache/img/')){ mkdir(_DR_.'/cache/img/'); }
    
    $U = explode('?',$_SERVER['REQUEST_URI']);
    $_GET['getinfo'] = urldecode(implode('/',explode('/',trim($U[0],'/'))));
    
    		
    
		  if (substr_count($_SERVER['REQUEST_URI'],'?')>0){
                
                		  $dpGet  = explode('?',$_SERVER['REQUEST_URI']);
                          $dpGet2 = explode('&',$dpGet[1]);
                		  $dpQGet = explode('=',$dpGet2[0]);                
                		   foreach($dpGet2 as $index => $val)
                   		   {
                        		    $exval='';
                        		    $exval = explode('=',$val);
                                    $exval1 = $exval[0];
                        		    $_GET[$exval1]=rawurldecode($exval[1]);
                   		   }                
                		   $dpQGet1 = $dpQGet[0];
                           $dpQGet2 = $dpQGet[1];
                		   $_GET[$dpQGet1]=rawurldecode($dpQGet2);
	      }
   
          
          if ( substr($_SERVER['REQUEST_URI'],0,7)=='/image/' ){
            $file=substr($_SERVER['REQUEST_URI'],7);
            $exfile = explode('.',$file);

            if (file_exists(_DR_.'/cache/img/'.$file)){
                
                if (strtolower($exfile[1])=='jpg'){
                      $img = imagecreatefromjpeg(_DR_.'/cache/img/'.$file);
                      if ($img){header("Content-type: " .image_type_to_mime_type(IMAGETYPE_JPEG)); imagejpeg($img,'',100);}                      
                 }
                if (strtolower($exfile[1])=='png'){
                      $img = imagecreatefrompng(_DR_.'/cache/img/'.$file);
                      if ($img){header("Content-type: " .image_type_to_mime_type(IMAGETYPE_PNG)); imagepng($img);}                      
                 }                
                if (strtolower($exfile[1])=='gif'){
                      $img = imagecreatefromgif(_DR_.'/cache/img/'.$file);
                      if ($img){header("Content-type: " .image_type_to_mime_type(IMAGETYPE_GIF)); imagegif($img);}                      
                 }                   
                exit;
            }


            if ( file_exists(_DR_.'/cache/img/imginfo.'.$exfile[0].'.ch') ){
                
                include_once _DR_.'/dg_system/dg_classes/file.php';
                include_once _DR_.'/dg_system/img.php';
                
                
            }else{
            	header("HTTP/1.1 404 Not Found");
            	header("Status: 404 Not Found");
            }
            
            exit;
          }


/*загружаем  классы*/

include_once _DR_. '/sms.class.php';

 $dir = opendir (_DR_.'/dg_system/dg_classes/');
  while ( $file = readdir ($dir))
  {
    if (( $file != ".") && ($file != "..") && is_file(_DR_.'/dg_system/dg_classes/'.$file)) include_once (_DR_.'/dg_system/dg_classes/'.$file);      
  }
  closedir ($dir);


 function lat($text){
	 $l = 'qwertyuiopasdfghjklzxcvbnm0123456789_-.~';

	 for ($i=0; $i<=(strlen($text)-1); $i++){
	     $s='';
	     $s= strtolower( substr ($text,$i,1) );
	     if ( substr_count($l,$s) === 0){return false; exit;}
	 }

	return true;
}


 

    function img($param){
        /**
         * w - ширина
         * h - высота
         * src - путь
         * bg - фон
         * tpbg - прозрачный фон
         * q - качество
         * enlarge - увеличить если изображение меньше назначеного
         * far - назначить пропорциональный вывод
         */ 
        
        if(is_array($param)){
            $param['src'] = str_replace(_DR_,'',$param['src']);
            
            $key=substr(md5_file(_DR_.$param['src']).md5(implode('&',$param)),26,15);
            
            $ex = explode('.',$param['src']);
            if(!file_exists(_DR_.'/cache/img/imginfo.'.$key.'.ch')){
                $str='';
                foreach($param as $i=>$v){
                	$str.="$i=$v\n";
                }
 			  				$file = fopen (_DR_.'/cache/img/imginfo.'.$key.'.ch',"w");
			    			fputs ( $file,$str);
							fclose ($file);	               
            }
            return '/image/'.$key.'.'.$ex[count($ex)-1];
        }
    } 
    
        function req_replace($str='',$param){
        if(!is_array($param)){ return $str; }
        $exadres = explode("?",$str);
        $exparam = explode("&",$exadres[1]);
        foreach($exparam as $i=>$v){
        	$p=explode('=',$v);
            $strarr[$p[0]]=$p[1];
        }
        foreach($param as $i=>$v){
                 $strarr[$i]=$v;
        }
        $newstr='';
        $m=0;
        foreach($strarr as $i=>$v){
          if ($v!='REMOVEPARAM'){	
            if(trim($v)!=''){
        	   if ($m==0 && substr_count($str,'?')==0) $r='?'; else $r='&';
        	   $m++;
        	   $newstr.=$r.$i.'='.$v;
        	}
          }else{
        	   $newstr.=$r.$i;
        	}  
        } 
        
        if ($newstr!=''){
            return $exadres[0].'?'.substr($newstr,1);
        }
    
    }
 
 function limit_parse($limit=20,$cont='page'){
    if (!is_numeric($_GET[$cont]) || $_GET[$cont]<1){ return " LIMIT 0,".$limit; }
    return " LIMIT ".(($_GET[$cont]-1)*$limit).','.$limit;
 }
 
 function page_parse($limit=20,$max=0,$items=4,$cont='page',$afterurl=''){
    if (ceil($max/$limit)<=1 ) return ''; 
    $total='';
    $start=0;
  
    if($_GET[$cont]!='' && is_numeric($_GET[$cont])){
        $start=$_GET[$cont]-3;
    }
    
    if ( $_GET[$cont]<4 ){ $start=0; }
  
    $stop=$start+$items;
    
    if($stop>(ceil($max/$limit)-1)){ 
        $stop=ceil($max/$limit)-1;
    }
    $start = $start-($items-($stop-$start));
    if($start<0){$start=0;}
    
    $total.="\n".'      <nav><ul class="parseNavigation inline">'."\n";
    for($i=$start; $i<=$stop; $i++){
        $s='';
        if($_GET[$cont]==($i+1) || ($_GET[$cont]=='' && ($i+1)==1)){ $s=' class="act"'; }
     $total.='          <li'.$s.'><a href="'.req_replace($_SERVER["REQUEST_URI"],array($cont=>$i+1)).$afterurl.'">'.($i+1).'</a></li>'."\n";   
    }
    $total.='      </ul></nav>'."\n";
    return $total;
    
 }
 

 function send_mail($from, $from_name, $to, $subject, $content, $replier=false){

    ini_set("sendmail_from", $from);
    $headers = "MIME-Version: 1.0\n";
    $headers .= "Reply-To: $from\n";
    $headers .= "X-Sender: $from_name<$from>\n";
    $headers .= "X-Mailer: demiurgo.cms Mailer\n";
    $headers .= "X-Priority: 3\n";
    if ($replier){$headers .= "Return-Path: <$replier>\n";}
    $headers .= "From: $from_name<$from>\n";
    $headers .= "Content-Type: text/html;charset=utf-8\n";
    $res =  mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $content, $headers);
    ini_restore("sendmail_from");
    return $res;
} 
function addsyslog($errno, $errmsg, $file, $line){
         if ($errno!=8) addlog( $errmsg.' ('.$file.':'.$line.')','error_'.$errno);
}
  function addlog($mess,$type="sys"){   
        $mess = time().'$$'.$type.'$$http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"].'$$'.$_SERVER["HTTP_USER_AGENT"].'('.$_SERVER["REMOTE_ADDR"].')'.'$$'.htmlspecialchars($mess)." end;\n";
        if (!file_exists(_DR_.'/cache')) mkdir(_DR_.'/cache',0777);
        $file = fopen (_DR_.'/cache/log.chl',"a+");
		fputs ( $file,$mess);
		fclose ($file);	    
  
  }
 if ( file_exists(_DR_.'/install.php') ){ include_once _DR_.'/install.php'; exit;}


?>