<?php 
define('IN_XD',true);
require("../include/common.inc.php");
//$str = var_dump($_POST);
$reson=$_POST["data"]['reson'];
$aid=$_POST["data"]["aid"];
$uid=$_POST["data"]["uid"];
//取广告信息
$sqla = "select id from tbl_report where userid = ".$uid ." and wzid = ".$aid;
$querya = mysql_query($sqla);
$rowa = mysql_fetch_array($querya);
if($rowa)
{
	echo "您已经举报过该文章，不需要重复举报。";
	}
else
{
	$sql = "insert into tbl_report values (0,'".$reson."',".$uid.",'".date('Y-m-d H:i:s')."',".$aid.")";
	//echo $sql;
	//exit;
	mysql_query($sql);
	echo "感谢您的反馈，我们会尽快进行核实处理！";
	}
?>