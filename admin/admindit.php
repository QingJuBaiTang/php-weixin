<?php
header('Content-Type:text/html; charset=utf-8');
define('IN_XD',true);
require("../include/common.inc.php");
require("../include/functions.php");
require("check.php");
$shuyu =  $_SESSION['admin_user'];
if($_GET['act']=='add'){
	if($_POST["pwd"]){
		if($_POST["pwd"]==$_POST["repwd"]){
			$pwd = $_POST["pwd"];
		}else{
			echo "<script type='text/javascript'>alert('两次密码不一致!');history.go(-1);</script>";
			exit;
		}
	}else{	
		echo "<script type='text/javascript'>alert('未知错误!');history.go(-1);</script>";
			exit;
	}
	$sqli = "select * from tbl_admin where userid = '".$_POST["userid"]."'";
	$queryi=mysql_query($sqli);
	$rowi=mysql_fetch_array($queryi);
	if($rowi){
		echo "<script type='text/javascript'>alert('该用户ID已存在!');history.go(-1);</script>";
		exit;
	}
$bl='yitui';
	$password=md5(md5($_POST['pwd'].$bl));
	$sql="INSERT INTO `tbl_admin` VALUES (0, '".$_POST["username"]."', '".$password."', 0, '2017-02-27 10:46:01', '2017-02-27 10:45:04', 0, '0.0.0.0', 1, 0, 0, 0, 0, 0, '0', 0, 0, 0, ".$_POST["kehushu"].", ".$_POST["anums"].")";
	mysql_query($sql);
	if(mysql_affected_rows() == 1){
		xd_close();
		echo "<script type='text/javascript'>alert('添加成功!');location.href='adminlist.php';</script>";
		exit;
	}else{
		xd_close();
		qy_alert_back('信息添加失败!');
	}
}
if($_GET['act']=='edit'){
	if($_POST["pwd"]){
		if($_POST["pwd"]==$_POST["repwd"]){
			$pwdsql = "userpwd = '".$_POST["pwd"]."',";
		}else{
			echo "<script type='text/javascript'>alert('两次密码不一致!');history.go(-1);</script>";
			exit;
		}
	}
	$bl='yitui';
	$password=md5(md5($_POST['pwd'].$bl));
	
	$sql="UPDATE tbl_admin SET 
	username='".$_POST["username"]."',anums='".$_POST["anums"]."',password='".$password."',beizhu1='".$_POST["beizhu1"]."',beizhu2='".$_POST["beizhu2"]."',shuyu='".$_POST["shuyu"]."',kehushu='".$_POST["kehushu"]."', qq='".$_POST["qq"]."' WHERE id=".$_POST["id"];
	//echo $sql;exit;
	mysql_query($sql);
	if(mysql_affected_rows() == 1){
		xd_close();
		echo "<script>alert('编辑成功！');window.location.href='userlist.php';</script>";
		exit;
	}else{
		xd_close();
		qy_alert_back('信息编辑失败或无修改动作!');
	}
}
$id=$_GET['id'];
$query=mysql_query("SELECT * FROM tbl_user WHERE id='$id'");
$row=mysql_fetch_array($query);
if($id){
	$action = "?id=$id&act=edit";
}else{
	$action = "?act=add";
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
    <li><a href="main.php">首页</a></li>
    <li><a href="#">用户管理</a></li>
    </ul>
    </div>
<?
	if(empty($row['shuyu'])){
		$shuyu2 = $shuyu;
	}else {
		$shuyu2 = $row['shuyu'];
	}
?>
    <form action="<?=$action?>" method="post" name="newsform">
	<input name="id" value="<?=$id?>" type="hidden">
    <div class="formbody">
    <div class="formtitle"><span>基本信息</span></div>
    <ul class="forminfo">
    <li><label>登录ID</label><input name="username" type="text" class="dfinput" value="<?=$row['userid']?>" <? if ($id){echo 'disabled';}?>/><i>唯一，不能重复</i></li>
	<li><label>密码</label><input name="pwd" type="password" class="dfinput" value="" /></li>
	<li><label>确认密码</label><input name="repwd" type="password" class="dfinput" value="" /></li>
	<li><label>总开户数</label><input name="kehushu" type="text" class="dfinput"  value="<?=$row['kehushu']?>" /></li>
	<li><label>会员文章上限</label><input name="anums" type="text" class="dfinput"  value="<?=$row['anums']?>" /><i>代理开户时，每个会员最大文章数</i></li>
    <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
    </ul>
    </div>
	</form>
</body>
</html>
