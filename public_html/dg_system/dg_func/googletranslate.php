<?php

/**
 * @author mrhard
 * @copyright 2010
 */



if ($_POST['lang']=='') $_POST['lang'] = 'ru';
if ($_POST['tolang']=='') $_POST['tolang'] = 'en';

$t='';

$_POST['q'] = str_replace('.','{{.',$_POST['q']);
$_POST['q'] = str_replace('!','{{!',$_POST['q']);
$_POST['q'] = str_replace('?','{{?',$_POST['q']);
$_POST['q'] = str_replace(':','{{:',$_POST['q']);
$_POST['q'] = str_replace(';','{{;',$_POST['q']);
$ex = explode('{{',$_POST['q']);
foreach($ex as $i=>$v){
	$r = json_decode(file_get_contents('http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q='. rawurlencode($v) .'&langpair='.$_POST['lang'].'|'.$_POST['tolang']));
    $t.= trim($r->responseData->translatedText);
}











if (array_key_exists('forurl',$_POST)){
    $urlt='';
    for ($i=0; $i<=mb_strlen($t,'UTF-8');$i++){
        if ($t{$i}!=''){
            if ( substr_count('qwertyuiopasdfghjklzxcvbnm0123456789',strtolower($t{$i}))==0 ){
                $urlt.='-';
            }else{
                $urlt.=$t{$i};
            }
        }
    }
    $t = strtolower($urlt);
    $t = str_replace('--','',$t);
}
echo htmlspecialchars_decode(trim($t,'-'));
?>