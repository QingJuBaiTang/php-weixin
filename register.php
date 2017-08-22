<?php

header('Content-Type:text/html; charset=utf-8');

define('IN_XD',true);

require("include/common.inc.php");

session_start();

$sqli = "select * from tbl_config";

	$queryi = mysql_query($sqli);

	$rowi = mysql_fetch_array($queryi);

	if ($rowi) {

		$regconfig = $rowi;

	}

if($_GET['act']=='add'){

	if($_POST["pwd"]){

		if($_POST["pwd"]==$_POST["repwd"]){

			$pwd = $_POST["pwd"];

		}else{

			echo "<script type='text/javascript'>alert('两次密码不一致!');history.go(-1);</script>";

			exit;

		}

	}else{	

		$pwd = "123456";

	}

	//echo $_SESSION['code'];

	//die;

//$ver = trim($_POST['code']);

 // if ( $ver == $_SESSION['code']) {

   // echo '验证码正确';

 //} else {

//	echo "<script type='text/javascript'>alert('验证码有误!');history.go(-1);//";

//	exit;

 //}

	$sqli = "select * from tbl_user where userid = '".$_POST["userid"]."'";

	$queryi=mysql_query($sqli);

	$rowi=mysql_fetch_array($queryi);

	if($rowi){

		echo "<script type='text/javascript'>alert('该用户ID已存在!');history.go(-1);</script>";

		exit;

	}

	$sql="INSERT INTO tbl_user " .

	"VALUES(

	0,

	'".$_POST["username"]."',

	'".md5($pwd)."',

	'".$_POST["qq"]."',

	'".$regconfig['regnum']."',

	'".date('Y-m-d H:i:s')."',

	'".$_POST["userid"]."',

	'".$_POST["beizhu1"]."',

	'".$_POST["beizhu2"]."',

	'".$_POST["shuyu"]."',

	'',

	'".$regconfig['reglognum']."',

	'0',

	'".$regconfig['regadnum']."'

	)";

	mysql_query($sql);

$sql="SELECT LAST_INSERT_ID()";

$result=mysql_query($sql);

$rows=mysql_fetch_row($result);

$sqlsf = "select * from tbl_ad where systemdefault='1'";

$resultsf=mysql_query($sqlsf);

$rowuf=mysql_fetch_array($resultsf);

	//echo  mysql_affected_rows() ;

	//exit();

	if(mysql_affected_rows() == 1){

	$sqlu = "insert into tbl_ad (ad_title,ad_link,ad_img,ad_img_one,ad_img_two,userid,username,addtime,adtelnumber,adqqnumber,adlbs,erweima,quanping,ad_link2,quanping2,ad_link3,shipinpic,pmd,wechat_name,wechat_url) select ad_title,ad_link,ad_img,ad_img_one,ad_img_two,".$rows[0].",'".$_POST['userid']."',addtime,adtelnumber,adqqnumber,adlbs,erweima,quanping,ad_link2,quanping2,ad_link3,shipinpic,pmd,wechat_name,wechat_url from tbl_ad where id=".$rowuf['id'];

	mysql_query($sqlu);

		xd_close();

		echo "<script type='text/javascript'>alert('注册成功');location.href='login.php';</script>";

		exit;

	}else{

		xd_close();
		echo "<script type='text/javascript'>alert('注册失败');location.href='register.php';</script>";
		exit;

	}

}

?>

<!DOCTYPE HTML>

<html>

<head>

<meta charset="UTF-8">

<title>用户注册 - <?php echo $cfg_webname?></title>

<meta name="description" content="" />

<meta name="viewport" content="width=device-width , initial-scale=1.0 , user-scalable=0 , minimum-scale=1.0 , maximum-scale=1.0" />

<script type='text/javascript' src='js/jquery-2.0.3.min.js'></script>

<script type='text/javascript' src='js/LocalResizeIMG.js'></script>

<script type='text/javascript' src='js/patch/mobileBUGFix.mini.js'></script>

<script type="text/javascript" src="js/jquery.flexslider-min.js"></script>

<script type="text/javascript">

$(function() {

    $(".flexslider").flexslider({

		slideshowSpeed: 4000, //展示时间间隔ms

		animationSpeed: 400, //滚动时间ms

		animation: "slide",

		controlNav:true,//控制菜单

		directionNav: false,//左右控制按钮

		touch: true //是否支持触屏滑动

	});

});	

</script>

<style>

	.button_buy a p{height: 3em;overflow: hidden;}

img{

	width: 100%;

	height: auto;

	display: block;

}

</style>

<link rel="stylesheet" href="css/css.css">

<link rel="stylesheet" type="text/css" href="css/flexslider.css" /> 

</head>

<body>

<div class="apply" id="apply">

	<p>注册帐号</p>

<div class="padding:0px;">

	<div class="topshow" id="topshow">

	<div class="flexslider">

  		<ul class="slides">

    		<li><img src="images/ss1.jpg" /></li>

    		<li><img src="images/ss2.jpg" /></li>

            <li><img src="images/ss3.jpg" /></li>

  		</ul>

   </div>

</div>	

	<div class="blank10"></div>

<script type="text/javascript">

function beforeSubmit(form){

if(form.userid.value==''){

alert('用户名不能为空！');

form.userid.focus();

return false;

}

if(form.pwd.value==''){

alert('密码不能为空！');

form.pwd.focus();

return false;

}

if(form.pwd.value.length<6){

alert('密码至少为6位，请重新输入！');

form.pwd.focus();

return false;

}

if(form.qq.value==''){

alert('请输入您的QQ号码！');

form.qq.focus();

return false;

}

if(form.qq.value.length<5){

alert('请输入您的真实QQ号码！');

form.qq.focus();

return false;

}

if(form.xieyi.checked==false){

alert('请阅读并接受用户注册协议！');

form.xieyi.focus();

return false;

}

return true;

}

</script> 

 <form action="?act=add" method="post"  class="registerform"  name="newsform"onSubmit="return beforeSubmit(this);">

		<input name="id" value="" type="hidden">

	<dl class="clearfix">

			<dd>账户：</dd>

			<dd><input type="text" class="input_txt" id="userid" value="" name="userid"   placeholder="建议手机号" datatype="m" errormsg="请输入您的手机号码！">

		</dd>

		</dl>

		<dl class="clearfix">

			<dd>密码：</dd>

			<dd><input type="password" class="input_txt" id="userpwd" value="" name="pwd" placeholder="请输入密码" datatype="*6-16" nullmsg="请设置密码！" errormsg="密码范围在6~16位之间！"></dd>

					<dd><div class="Validform_checktip"></div></dd>

</dl>

        <dl class="clearfix">

			<dd>密码：</dd>

			<dd><input type="password" class="input_txt" id="repwd" value="" name="repwd" placeholder="请再次输入密码" datatype="*6-16" nullmsg="请设置密码！" errormsg="密码范围在6~16位之间！"></dd>

					<dd><div class="Validform_checktip"></div></dd>

</dl>

        <dl class="clearfix">

			<dd>Q Q：</dd>

			<dd><input type="text" class="input_txt" id="qq" value="" name="qq" placeholder="用于密码找回" datatype="*2-12" nullmsg="请设置QQ！" errormsg="请设置QQ！"></dd>

					<dd><div class="Validform_checktip"></div></dd>

</dl>

<dl class="clearfix">

			<dd>代理人id：</dd>

			<dd><input name="shuyu" type="text" class="input_txt" id="shuyu" placeholder="填写您的上级ID" value="admin" ></dd>

					<dd><div class="Validform_checktip"></div></dd>

</dl>

<dl class="clearfix" style="text-align:center">

			<dd><input name="xieyi" type="checkbox" id="xieyi"   value="1" > 我已阅读并同意<a href="xieyi.php">《用户注册协议》</a></dd>

</dl>

		<div class="btn_boxx">

			<input type="submit" name="signup" class="button" value="注册帐号">

		</div>

        <div class="blank10" style="margin-bottom:50px;"></div>

				<input name="username" type="hidden" class="dfinput"  value="自助注册" />

				<input name="beizhu1" type="hidden" class="dfinput"  value="<?php echo $showtime=date("Y-m-d H:i:s",time() + $regconfig['regtime']*86400);?>" />

				<input name="beizhu2" type="hidden" class="dfinput"  value="自助注册" />

	</form>

</div>

<?php include('foot1.php');?>

<script type="text/javascript">

var daojs =60;

$(function(){

	$('#send_code').click(function(){

		var phone = $('#userid').val();

		if(phone==''){

			alert('请输入您的手机号码！')

		}else if(!phone.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[012356789]|18[0-9]|14[57])[0-9]{8}$/)){

            alert('请输入正确的手机号码！')

        }else{

			$.ajax({

			type: "POST",

			url: "send_code.php",

			data: {phone:phone},

			dataType: "json",

			success: function (data) {

				if (data.status) {

					var code=data.msg;

					$('#new_code').val(code);

					setTimeout('daoJiShi()',1000);

				} else {

					alert(data.msg);

				}

			}

			});

		}

	});

})

function daoJiShi(){

	if(daojs>0){

		$('#send_code').val("正在发送("+daojs+")");

		daojs--;

		setTimeout('daoJiShi()',1000);

		$('#send_code').attr("disabled","disabled")

	}else{

		$('#send_code').val('重新发送');

		 $("#send_code").removeAttr("disabled");

		 return daojs=60;

	}

	return false;

}

</script>

</body>

</html>