<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<?
define('IN_XD',true);
session_start();
require("include/common.inc.php");
header("Content-type: text/html; charset=utf-8");
if(!$_COOKIE['userid']){
	echo "<script type='text/javascript'>location.href='login.php';</script>";
	exit;
}
$sqlu = "select * from tbl_user where id=".$_COOKIE['userid'];
$queryu=mysql_query($sqlu);
$rowu=mysql_fetch_array($queryu);
$sqla = "select count(*) as cc from tbl_info where userid='".$_COOKIE['username']."'";
$querya=mysql_query($sqla);
$rowa=mysql_fetch_array($querya);
$s = $rowu['anums']-$rowa['cc'];
if($_GET['act']=='repass_do'){
	if($_POST['userpwd']!=$_POST['reuserpwd']){
		echo "<script type='text/javascript'>alert('两次密码不一致！');history.go(-1);</script>";
		exit;
	}
	$sql = "update tbl_user set userpwd = '".md5($_POST['userpwd'])."' where id = ".$_POST['id'];
	mysql_query($sql);
	echo "<script type='text/javascript'>alert('密码修改成功!');location.href='user.php';</script>";
	exit;
}
?>
<title>修改密码 - <?php echo $cfg_webname?></title>
<meta name="description" content="" />
<meta name="viewport" content="width=device-width , initial-scale=1.0 , user-scalable=0 , minimum-scale=1.0 , maximum-scale=1.0" />
<script type='text/javascript' src='js/jquery-2.0.3.min.js'></script>
<script type='text/javascript' src='js/LocalResizeIMG.js'></script>
<script type='text/javascript' src='js/patch/mobileBUGFix.mini.js'></script>
<link rel="stylesheet" href="css/css.css">   
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<div class="apply" id="apply">
	<p>修改密码<span style="float:right;font-size:12px;margin-right:10px">剩余文章数：<?=$s?></span></p>
	<div class="blank10"></div>
	<form action="?act=repass_do" id="signupok" method="post">
		<input type="hidden" name="id" value="<?=$_COOKIE['userid']?>" />
		<dl class="clearfix">
			<dd>修改密码：</dd>
			<dd><input class="input_txt" name="userpwd" type="password" placeholder="请输入修改密码"></dd>
		</dl>
		<dl class="clearfix">
			<dd>确认密码：</dd>
			<dd><input class="input_txt" name="reuserpwd" type="password" placeholder="请输入确认密码"></dd>
		</dl>
		<div class="btn_box">
			<input type="submit" name="signup" class="button" value="确认修改">
		</div>
		<div class="blank10"></div>
		<div class="btn_box">
			<input type="button" name="signup" class="button" value="退出登录"  onclick="window.location.href='logout.php'">
		</div>
	</form>
</div>
<?php include('foot.php');?>
</body>
</html>