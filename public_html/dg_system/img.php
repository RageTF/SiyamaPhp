<?
/**
 * @author Maltsev Vladimir
 * @copyright 2009
 * 
 */
defined("_DG_") or die ("ERR");	

$paramfile =  dg_file::read(_DR_.'/cache/img/imginfo.'.$exfile[0].'.ch');
$ex = explode("\n",$paramfile);
foreach($ex as $i=>$v){
	if (trim($v)!=''){
	   $paramex = explode('=',$v);
	   $param[$paramex[0]]=$paramex[1];
	}
}
    if ($param['src']!='' && substr($param['src'],0,7)=='/files/') $param['src']=_DR_.$param['src'];
    if($param['src']=='' || !file_exists($param['src'])){
            	header("HTTP/1.1 404 Not Found");
            	header("Status: 404 Not Found");        
    }else{

       $size = getimagesize($param['src']);



      if ($param['zoom']=='false'){
        if ($size[0]<=$param['w']) {
            $oldw=$param['w'];
            $param['w']=$size[0];
            
        }
        
        if ($size[1]<=$param['h']) {
            $oldh=$param['h'];
            $param['h']=$size[1];
            
        }
        
      }  
      
      if ($param['h']=='auto') {
            $wk = $size[0]/$param['w'];
            $param['h'] = $size[1]/$wk;
            if (is_numeric($param['hmax'])){
                if ($param['h']>$param['hmax']){
                    $param['h'] = $param['hmax'];
                }
            }
      }
      if ($param['w']=='auto') {
            $hk = $size[1]/$param['h'];
            $param['w'] = $size[0]/$hk;
              if (is_numeric($param['wmax'])){
                        if ($param['w']>$param['wmax']){
                            $param['w'] = $param['wmax'];
                        }
                    }
      
      }
      
      
      
      
        
      if ($param['bg']=='') $param['bg']='ffffff';  
      if ($param['q']=='') $param['q']=100;  
      if ($param['tpbg']=='') $param['tpbg']=true;  
      if ($param['xpos']=='') $param['xpos']='center';  
      if ($param['ypos']=='') $param['ypos']='center';   


     
     $kw=$size[0]/$param['w'];
     $kh=$size[1]/$param['h'];

     if (!$param['enlarge']){
        if ($size[0]<$param['w'] || $size[1]<$param['h']){
            $kw=1; $kh=1;
        }
     }

           
      if ($param['far']=='w') $param['h'] = $size[1]/$kw;
      if ($param['far']=='h') $param['w'] = $size[0]/$kh;
      
       
      

             if ($param['tpbg'] && strtolower($exfile[1])=='png'){
                
                $image =  imagecreate($param['w'], $param['h']);
                imagesavealpha ($image, true);
                $transbgcolor =  imagecolorallocate($image, 255, 255, 255);
                imagecolortransparent ($image,$transbgcolor); 
                
                
             }else{ 
                $image  =  imagecreatetruecolor($param['w'], $param['h']);              
                $mainbg =  imagecolorallocate($image, hexdec(substr($param['bg'], 0, 2)), hexdec(substr($param['bg'], 2, 2)), hexdec(substr($param['bg'], 4, 2)));
                           imagefilledrectangle($image, 0, 0, $param['w'], $param['h'], $mainbg);              
            }
             
        		   $topPos = ($param['h']/2)-(($size[1]/$kw)/2);
        		   $leftPos = ($param['w']/2)-(($size[0]/$kh)/2);
                   
                   if ($param['xpos']=='left') $leftPos = 0;
                   if ($param['xpos']=='right') $leftPos = $param['w']-$size[0]/$kh;
                   if ($param['ypos']=='top') $topPos = 0;
                   if ($param['ypos']=='bottom') $topPos = $param['h']-$size[1]/$kw;
                   
                   
                
             
             
                        if (strtolower($exfile[1])=='jpg' || strtolower($exfile[1])=='jpeg') $original = @imagecreatefromjpeg($param['src']);                                              
                        if (strtolower($exfile[1])=='png') $original = @imagecreatefrompng($param['src']);                                                                   
                        if (strtolower($exfile[1])=='gif') $original = @imagecreatefromgif($param['src']);                          
                  
 
             
       
             if ($kw>$kh){
                    imagecopyresampled ($image, $original,0,$topPos, 0, 0, $param['w'], $size[1]/$kw, $size[0], $size[1]);
             }else{
                 if ($kw!=$kh){
                    imagecopyresampled ($image, $original,$leftPos,0, 0, 0,$size[0]/$kh, $param['h'], $size[0], $size[1]);
                 }else{
                    imagecopyresampled ($image, $original,$leftPos,$topPos, 0, 0,$size[0]/$kh, $size[1]/$kw, $size[0], $size[1]);
                 }
             }
             
             if ($param['wm']!='' ){
                
                //imageline ($image, 0, 0, 100, 100, imagecolorallocate($image, 255, 255, 255));
                
                $logoImage = ImageCreateFromPNG(_DR_.$param['wm']);
                $size_wm = getimagesize(_DR_.$param['wm']);
                if ($kw>$kh){
                        imagecopyresampled ($image, $logoImage,0,0, 0, 0, $param['w'], $size[1]/$kw, $size_wm[0], $size_wm[1]);
                 }else{
                     if ($kw!=$kh){
                        imagecopyresampled ($image, $logoImage,$leftPos,0, 0, 0,$size[0]/$kh, $param['h'], $size_wm[0], $size_wm[1]);
                     }else{
                        imagecopyresampled ($image, $logoImage,$leftPos,$topPos, 0, 0,$size[0]/$kh, $size[1]/$kw, $size_wm[0], $size_wm[1]);
                     }
                 }
                 
                
             }


   
                if (strtolower($exfile[1])=='jpg' || strtolower($exfile[1])=='jpeg'){
                      header("Content-type: " .image_type_to_mime_type(IMAGETYPE_JPEG)); imagejpeg($image,_DR_.'/cache/img/'.$file,$param['q']);  imagejpeg($image,'',100);                     
                 }
                if (strtolower($exfile[1])=='png'){
                      header("Content-type: " .image_type_to_mime_type(IMAGETYPE_PNG));  imagepng($image,_DR_.'/cache/img/'.$file);             imagepng($image);                   
                 }                
                if (strtolower($exfile[1])=='gif'){
                      header("Content-type: " .image_type_to_mime_type(IMAGETYPE_GIF));  imagegif($image,_DR_.'/cache/img/'.$file);             imagegif($image);        
                 }

            
    }
?>