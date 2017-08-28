<?php 
define('IN_XD',true);
require("include/common.inc.php");

if (!$_COOKIE['userid']) {
	echo "0";
	exit;
}

$title=$_REQUEST['q_tit'];
$html=$_REQUEST['q_body'];
$infoid=$_REQUEST['q_infoid'];
$sql = "update tbl_info set content = '".addslashes($html)."' ,title = '".$title."'   where infoid = ".$infoid;
mysql_query($sql);
mysql_close();
echo "1";
exit;
?>