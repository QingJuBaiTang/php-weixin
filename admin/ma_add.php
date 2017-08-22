<?php
header('Content-Type:text/html; charset=utf-8');
define('IN_XD',true);
require("../include/common.inc.php");
require("../include/functions.php");
require("check.php");
$shuyu =  $_SESSION['admin_user'];
if($_POST['add']=='添加'){
	$num=(int)$_POST['num'];
	$tnum=$_POST['tnum'];
	$wnum=$_POST['wnum'];
	if($tnum==""){
		$tnum=30;
	}
	if($wnum==""){
		$wnum=100;
	}
	for($i=0;$i<$num;$i++){
		$ma=create_guid();
		$sql = "INSERT INTO tbl_jihuoma (ma,status,add_time,uid,name,tnum,wnum) value ('".$ma."',0,'".time()."',0,'',".$tnum.",".$wnum.")";
		mysql_query($sql);
		$ma_arr.=$ma."\r\n";
	}
	xd_close();
}
function create_guid($namespace = null) {  
    static $guid = '';  
    $uid = uniqid ( "", true );  
    $data = $namespace;  
    $data .= $_SERVER ['REQUEST_TIME'];     // 请求那一刻的时间戳  
    $data .= $_SERVER ['HTTP_USER_AGENT'];  // 获取访问者在用什么操作系统  
    $data .= $_SERVER ['SERVER_ADDR'];      // 服务器IP  
    $data .= $_SERVER ['SERVER_PORT'];      // 端口号  
    $data .= $_SERVER ['REMOTE_ADDR'];      // 远程IP  
    $data .= $_SERVER ['REMOTE_PORT'];      // 端口信息  
    $hash = strtoupper ( hash ( 'ripemd128', $uid . $guid . md5 ( $data ) ) );  
    $guid = substr ( $hash, 0, 4 ) . '-' . substr ( $hash, 4, 4 ) . '-' . substr ( $hash, 8, 4 ) . '-' . substr ( $hash, 12, 4 ) . '-' . substr ( $hash, 16, 4 );  
    return $guid;  
}  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title></title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/select-ui.min.js"></script>
	</head>
	<body>
		<div class="place">
		    <span>位置：</span>
		    <ul class="placeul">
			    <li><a href="main.php">首页</a></li>
			    <li><a href="#">激活码管理</a></li>
		    </ul>
	    </div>
	    <form action="" method="post" name="newsform"  enctype="multipart/form-data">
		    <div class="formbody">
		    <div class="formtitle"><span>生成激活码</span></div>
		    <ul class="forminfo">
            <?php if($ma_arr){?>
            <li><label>生成的激活码</label><textarea  class="textinput" disabled="disabled"><?=$ma_arr?></textarea><i></i></li>
            <?php }?>
                <li><label>生成数量</label>
				<select class="dfinput" name="num">
	            	<option value="1" >1</option>
					<option value="2" >2</option>
					<option value="3" >3</option>
					<option value="4" >4</option>
					<option value="5" >5</option>
					<option value="10" >10</option>
				</select>
				</li>
				<li><label>包含时间</label><input type="text" class="dfinput" name="tnum" style="width:80px" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/>&nbsp;&nbsp;天&nbsp;(不填写默认为30天)</li>
				 <li><label>包含文章</label><input type="text" class="dfinput" name="wnum" style="width:80px" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/>&nbsp;&nbsp;篇&nbsp;(不填写默认为100篇)</li>
			    <li><label>&nbsp;</label><input name="add" type="submit" class="btn" value="添加"/></li>
		    </ul>
		    </div>
		</form>
	</body>
</html>
