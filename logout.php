<?php 
define('IN_XD',true);
session_start();
require("include/common.inc.php");
	$sql="update tbl_user set duankouyong=duankouyong-1 where userid='".$_COOKIE['username']."'";
	mysql_query($sql);
setcookie("username",'',time()-1);
setcookie("userid",'',time()-1);
setcookie("usertype",'',time()-1);	
header("location: login.php");
exit;
?>