<?php
header('Content-Type:text/html; charset=utf-8');
define('IN_XD',true);
require("../include/common.inc.php");
require("../include/functions.php");
require("check.php");
$shuyu =  $_SESSION['admin_user'];
if(isset($_POST['appid'])){
	$appid=$_POST['appid'];
	$appsecret=$_POST['appsecret'];
	$sqli = "select * from tbl_param_config";
	$queryi = mysql_query($sqli);
	$rowi = mysql_fetch_array($queryi);
	if(!$rowi){
		$sql="INSERT INTO tbl_param_config (appid,appsecret) VALUES ('".$appid."', '".$appsecret."')";
		$res = mysql_query($sql);
		echo "<script type='text/javascript'>alert('添加成功!');location.href='wx_config.php';</script>";
		header('Refresh:0');
	}
	else{
		$sql="UPDATE tbl_param_config SET appid = '".$appid."', appsecret = '".$appsecret."' WHERE id =".$rowi['id'];
		$res = mysql_query($sql);
		echo "<script type='text/javascript'>alert('修改成功!');location.href='wx_config.php';</script>";
		header('Refresh:0');
	}
}
else {
	$sqli = "select * from tbl_param_config";
	$queryi = mysql_query($sqli);
	$rowi = mysql_fetch_array($queryi);
	if ($rowi) {//已存在微信配置
		$wxconfig = $rowi;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>易推</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/select.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/select-ui.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
    $(".select1").uedSelect({
		width : 345			  
	});
	$(".select2").uedSelect({
		width : 167  
	});
	$(".select3").uedSelect({
		width : 100
	});
});
</script>
</head>
<body>
	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="javascript:">系统配置</a></li>
    <li><a href="javascript:">微信号配置</a></li>
    </ul>
    </div>
    <form method="post" name="newsform">
    <div class="formtitle"><span>微信参数配置</span></div>
    <ul class="forminfo">
    <li><label>appid</label><input name="appid" type="text" class="dfinput" value="<?=$wxconfig['appid']?>" /></li>
	<li><label>appsecret</label><input name="appsecret" type="text" class="dfinput" value="<?=$wxconfig['appsecret']?>" /></li>
    <li><label>&nbsp;</label><input type="submit" class="btn" value="确认保存"/></li>
    </ul>
    </div>
	</form>
</body>
</html>