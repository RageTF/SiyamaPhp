<?
    header('Content-Type: application/json');
    //header('Access-Control-Allow-Origin: *');  
    $DATA = array('v'=>2,'Android'=>'http://ya.ru','iOS'=>'http://google.com');
    echo json_encode($DATA);

?>