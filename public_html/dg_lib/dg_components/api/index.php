<?
    $this->_ajax = true;
    header('Content-Type: application/json');
    //header('Access-Control-Allow-Origin: *');  
    
    //if ($_POST['KEYAPP']=='dfg46d5f4g9w8e5c2s1qdwe54qw51xc32vx1c3x5cg4d'){
        
        unset($_GET['getinfo']);
        $API_FUNC = 'MAIN';
        
        if ($_GET['L0']!=''){
            
            if (method_exists('API',$_GET['L0'])) $API_FUNC = $_GET['L0'];
        }
        API::$API_FUNC();
        
       
        $this->_JSON['API'] = array(
        'FUNC'=>$API_FUNC,
        'DATA'=>array('POST'=>$_POST,'GET'=>$_GET,'FILES'=>$_FILES),
        'SERVERTIME'=>time(),
        'SALETYPE'=>$GLOBALS['dgshop']->_sale_type,
        'SALETIME'=>array(0=>'8:10:20:Счастливых часов',1=>'13:17:15:Счастливых часов',2=>'1:5:20:Ночной скидки')
        );
        
        
            
        
        
        echo json_encode($this->_JSON);
    
    //}
?>