<?

/**
 * @author Maltsev Vladimir
 * @copyright 2009
 * 
 * pre
 */
 
    
 
    //header('Access-Control-Allow-Origin: *');  
    date_default_timezone_set("Asia/Tashkent");
    
    if ($_SERVER["REQUEST_URI"]=='/lastmod.json'){
        
        echo file_get_contents('lastmod2.json');
    
    exit;}
    
    ob_start();
    include_once 'config.php';
    include_once  _DR_.'/dg_system/dg.sys.php';
    $application = new application;
    exit;
?>