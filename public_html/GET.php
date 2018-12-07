<?
if ($_GET['url']!=''){
    $u =  urldecode($_GET['url']);
    $us = explode('address=',$u);
    if ($us[1]!=''){
        $us2 = explode('&',$us[1]);
        $u =  $us[0].'address='.urlencode($us2[0]).'&'.$us2[1];
        echo file_get_contents(($u));
    } else echo file_get_contents(urldecode($_GET['url']));
    //
}

?>