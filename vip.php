<?php 
define('IN_XD',true);
session_start();
require("include/common.inc.php");
require('include/functions.php');
require('include/QueryList.class.php');
//include 'phpQuery/phpQuery.php'; 
header("Content-type: text/html; charset=utf-8");
if(!$_COOKIE['userid']){
	echo "<script type='text/javascript'>location.href='login.php';</script>";
	exit;
}
if($_GET['act']=='add'){
	$sql = "select * from tbl_jihuoma where ma = '".mysql_real_escape_string($_POST['jihuoma'])."'";
	$query=mysql_query($sql);
	$tbl_jihuoma=mysql_fetch_array($query);
	if($tbl_jihuoma['uid']){
		echo "<script type='text/javascript'>location.href='vip.php';alert('充值卡已经被使用!')</script>";
	exit;
	}
	if(empty($tbl_jihuoma)){
		echo "<script type='text/javascript'>location.href='vip.php';alert('没有这个充值卡!')</script>";
	exit;
	}
	$sql = "select * from tbl_user where id = '".$_COOKIE['userid']."'";
	$query=mysql_query($sql);
	$tbl_user=mysql_fetch_array($query);
	$sql="update tbl_jihuoma set uid=".$tbl_user['id'].",name='".$tbl_user['username']."',status=1 where id=".$tbl_jihuoma['id'];
	mysql_query($sql);
	//echo mysql_error();
	$beizhu1=strtotime($tbl_user['beizhu1']);
	if($beizhu1<time()){
		$beizhu1=time();
	}
	$beizhu1=date('Y-m-d H:i:s',$beizhu1+ $tbl_jihuoma['tnum']*86400);
	$anums=$tbl_user['anums']+$tbl_jihuoma['wnum'];
	$sql="update tbl_user set anums=".$anums.",beizhu1='".$beizhu1."' where id=".$_COOKIE['userid'];
	mysql_query($sql);
	$sql="INSERT INTO `tbl_cz_log` (`id`, `qudao`, `wnum`, `tnum`, `jiage`, `dingdan`, `userid`,`shijian`) VALUES (NULL, '充值卡充值', ".$tbl_jihuoma['wnum'].", ".$tbl_jihuoma['tnum'].", 0 ,'".time()."', ".$_COOKIE['userid'].",now())";
	mysql_query($sql);
	echo "<script type='text/javascript'>alert('充值成功!');location.href='index.php';</script>";
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>在线充值</title>
<meta name="description" content="" />
<meta name="viewport" content="width=device-width , initial-scale=1.0 , user-scalable=0 , minimum-scale=1.0 , maximum-scale=1.0" />
<link rel="stylesheet" href="css/css.css">
<script type='text/javascript' src='js/jquery-2.0.3.min.js'></script>
<script type='text/javascript' src='js/patch/mobileBUGFix.mini.js'></script>
</head>
<body>
<div class="apply" id="apply">
  <p>在线充值</p>
 <font>方式一:充值卡充值</font>
  <form action="?act=add" id="signupok" method="post" name="addform"  enctype="multipart/form-data">
    <dl class="clearfix" style="width:100%; padding:5px 0 5px 0 ">
      <dd class="inptmain"><span class="link_inpt">
        <input type="text" style="width:calc(100% - 80px); padding:0"  id="jihuoma" value="" name="jihuoma" placeholder="请输入充值卡">
        </span><span class="btnss">
        <input type="button" name="signup" style="width:80px"  value="充值"  onclick="return postcheck();">
        </span></dd>
    </dl>
    <div class="blank10"></div>
  </form>
<font>方式二:微信在线充值</font>
   <dl class="clearfix"  style="width:100%; padding:5px 0 5px 0 ">
 <dd class="inptmain"><span class="link_inpt">
       <select id="p"  name="p" style="width:calc(100% - 80px); padding:0; height:40px" >
	   <option value="">选择充值金额</option>
	   <?php
		foreach($cfg_pay as $list=>$things){  if(is_array($things)){   
		?>
		<option value="<?php echo $list?>"><?php echo  $things[0].'条'.'|'.$things[1].'天'.'|'.$things[2].'元'; ?></option>
		<?php
		}  }
		?>	
		</select>
                </span><span class="btnss">
       <input type="button" name="signup"  value="充值" style="width:80px"  onclick="pay();">
        </span></dd>
    </dl>
</div>
<? include('foot.php');?>
<script type="text/javascript">
function pay(){
	if($("#p option:selected").val()==''){
		alert('请选择充值金额');
	}else{
	alert('充值功能暂未添加，购买请咨询客服!');
	}
}
function postcheck(){
	if (document.addform.jihuoma.value=="" ){
		alert('请输入充值卡！');
		document.addform.jihuoma.focus();
		return false;
	}
	document.addform.submit();
	return true;	
}
</script>
<style>
.bot_main li.ico_4 {
    background: #F1901F;
}
</style>
</body>
</html>
