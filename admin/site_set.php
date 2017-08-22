<?php
header('Content-Type:text/html; charset=utf-8');
define('IN_XD',true);
require("../include/common.inc.php");
require("../include/Image.class.php");
require("check.php");
$shuyu =  $_SESSION['admin_user'];
if(isset($_POST['sitename'])){
	$sitename=$_POST['sitename'];
	$kefuerweima=$_POST['kefuerweima'];
	$zfberweima=$_POST['zfberweima'];
	$wxerweima=$_POST['wxerweima'];
	$sqli = "select * from tbl_siteconfig";
	$queryi = mysql_query($sqli);
	$rowi = mysql_fetch_array($queryi);
	if(!$rowi){
		$sql="INSERT INTO tbl_siteconfig (sitename,logo,kefuerweima,zfberweima,wxerweima) VALUES ('".$sitename."', '".$logo."', '".$kefuerweima."', '".$zfberweima."', '".$wxerweima."')";
		$res = mysql_query($sql);
		echo "<script type='text/javascript'>alert('添加成功!');";
		header('Refresh:0');
	}
	else{
		$sql="UPDATE tbl_siteconfig SET sitename = '".$sitename."', logo = '".$logo."', kefuerweima = '".$kefuerweima."', zfberweima = '".$zfberweima."', wxerweima = '".$wxerweima."' WHERE id =".$rowi['id'];
		$res = mysql_query($sql);
		echo "<script type='text/javascript'>alert('修改成功!');</script>";
		header('Refresh:0');
	}
}
else {
	$sqli = "select * from tbl_siteconfig";
	$queryi = mysql_query($sqli);
	$rowi = mysql_fetch_array($queryi);
	if ($rowi) {//已存在微信配置
		$row = $rowi;
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
    <li><a href="javascript:">网站设置</a></li>
    </ul>
    </div>
    <form method="post" name="newsform">
    <div class="formtitle"><span>网站设置</span></div>
    <ul class="forminfo">
    <li><label>平台名称</label><input name="sitename" type="text" class="dfinput" value="<?=$row['sitename']?>" /></li>
   <!-- <li><label>logo</label>
	<?php if(!empty($row['logo'])){ ?>
				<img src="<?php echo $row['logo']; ?>" style="height:100px;">
				<input type="hidden" value="<?php echo $row['logo']; ?>" name="logo">
			<?php } ?>
				<input type="file" class="input_txt"   placeholder="选择上传图片图片" name="logo" style="width: 360px;height: 50px;box-sizing: border-box;padding: 14px;color: #696969;font-size: 12px;line-height: 12px;border: #e6e6e6 1px solid;background: #fff;">
	</li>
	    <li><label>客服二维码</label>
	<?php if(!empty($row['kefuerweima'])){ ?>
				<img src="<?php echo $row['kefuerweima']; ?>" style="height:100px;">
				<input type="hidden" value="<?php echo $row['kefuerweima']; ?>" name="kefuerweima">
			<?php } ?>
				<input type="file" class="input_txt"   placeholder="选择上传图片图片" name="kefuerweima" style="width: 360px;height: 50px;box-sizing: border-box;padding: 14px;color: #696969;font-size: 12px;line-height: 12px;border: #e6e6e6 1px solid;background: #fff;">
	</li>
	    <li><label>支付宝二维码</label>
	<?php if(!empty($row['zfberweima'])){ ?>
				<img src="<?php echo $row['zfberweima']; ?>" style="height:100px;">
				<input type="hidden" value="<?php echo $row['zfberweima']; ?>" name="zfberweima">
			<?php } ?>
				<input type="file" class="input_txt"   placeholder="选择上传图片图片" name="zfberweima" style="width: 360px;height: 50px;box-sizing: border-box;padding: 14px;color: #696969;font-size: 12px;line-height: 12px;border: #e6e6e6 1px solid;background: #fff;">
	</li>
		    <li><label>微信二维码</label>
	<?php if(!empty($row['wxerweima'])){ ?>
				<img src="<?php echo $row['wxerweima']; ?>" style="height:100px;">
				<input type="hidden" value="<?php echo $row['wxerweima']; ?>" name="wxerweima">
			<?php } ?>
				<input type="file" class="input_txt"   placeholder="选择上传图片图片" name="wxerweima" style="width: 360px;height: 50px;box-sizing: border-box;padding: 14px;color: #696969;font-size: 12px;line-height: 12px;border: #e6e6e6 1px solid;background: #fff;">
	</li> 
	-->
	<li><label>&nbsp;</label><input type="submit" class="btn" value="确认保存"/></li>
    </ul>
    </div>
	</form>
</body>
</html>