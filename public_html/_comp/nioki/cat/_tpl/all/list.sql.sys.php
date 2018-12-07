<? 
$a = 'l,t,kl,ku,o,k,g,ka,kr,kur,ug,go,s,gy,hot,veg,';
if ($_GET['w']!='' AND substr_count($a,$_GET['w'].',')>0) $wh = " AND `".$_GET['w']."`=1 ";
$sql = "SELECT * FROM `".$table."` WHERE `sys_show`=1 ".$wh." ORDER BY `sys_page`,`sys_order` ";
//echo $sql;
 ?>