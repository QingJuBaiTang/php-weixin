<?php
header('Content-Type:text/html; charset=utf-8');
define('IN_XD',true);
require("../include/common.inc.php");
require("check.php");
$shuyu =  $_SESSION['admin_user'];
if(isset($_POST['regtime'])){
	$regtime=$_POST['regtime'];
	$regnum=$_POST['regnum'];
	$regadnum=$_POST['regadnum'];
	$reglognum=$_POST['reglognum'];
	$sqli = "select * from tbl_config";
	$queryi = mysql_query($sqli);
	$rowi = mysql_fetch_array($queryi);
	if(!$rowi){
		$sql="INSERT INTO tbl_config (regtime,regnum,regadnum,reglognum) VALUES ('".$regtime."', '".$regnum."', '".$regadnum."', '".$reglognum."')";
		$res = mysql_query($sql);
		echo "<script type='text/javascript'>alert('添加成功!');";
		header('Refresh:0');
	}
	else{
		$sql="UPDATE tbl_config SET regtime = '".$regtime."', regnum = '".$regnum."', regadnum = '".$regadnum."', reglognum = '".$reglognum."' WHERE id =".$rowi['id'];
		$res = mysql_query($sql);
		echo "<script type='text/javascript'>alert('修改成功!');</script>";
		header('Refresh:0');
	}
}
else {
	$sqli = "select * from tbl_config";
	$queryi = mysql_query($sqli);
	$rowi = mysql_fetch_array($queryi);
	if ($rowi) {//已存在微信配置
		$regconfig = $rowi;
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
    <li><a href="javascript:">初始参数设置</a></li>
    </ul>
    </div>
    <form method="post" name="newsform">
    <div class="formtitle"><span>初始参数设置</span></div>
    <ul class="forminfo">
    <li><label>注册天数</label><input name="regtime" type="text" class="dfinput" value="<?=$regconfig['regtime']?>" /><i>填数字</i></li>
	<li><label>注册文章条数</label><input name="regnum" type="text" class="dfinput" value="<?=$regconfig['regnum']?>" /><i>填数字</i></li>
    <li><label>注册广告条数</label><input name="regadnum" type="text" class="dfinput" value="<?=$regconfig['regadnum']?>" /><i>填数字</i></li>
	<li><label>注册登陆设备</label><input name="reglognum" type="text" class="dfinput" value="<?=$regconfig['reglognum']?>" /><i>填数字</i></li>
	<li><label>&nbsp;</label><input type="submit" class="btn" value="确认保存"/></li>
    </ul>
    </div>
	</form>
</body>
</html>