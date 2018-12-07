<?

/**
 * @author Maltsev Vladimir
 * @copyright 2009
 * 
 */
date_default_timezone_set("Asia/Tashkent");
ob_start();
include_once '../config.php';
include _DR_.'/dg_system/dg.sys.php';
$admin = new dg_admin();
$admin->load();
?>