<?php
$phone=0;
if(is_array($_POST)&&count($_POST)>0){ 
	if(isset($_POST["phone"])){ 
		$phone=$_POST["phone"]; 
	}else{
		echo '-1';
		exit();
	}
}else{
		echo '-1';
		exit();
}


$chars = array("0", "1", "2","3", "4", "5", "6", "7", "8", "9");   
$charsLen = count($chars) - 1;   
shuffle($chars);     
$code = "0";   
for ($i=0; $i<3; $i++)   
{   
	$code .= $chars[mt_rand(0, $charsLen)];   
}    

$statusStr = array(
		"0" => "短信发送成功",
		"-1" => "参数不全",
		"-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
		"30" => "密码错误",
		"40" => "账号不存在",
		"41" => "余额不足",
		"42" => "帐户已过期",
		"43" => "IP地址限制",
		"50" => "内容含有敏感词"
	);	
$smsapi = "http://www.smsbao.com/"; //短信网关
$user = "qq59965894"; //短信平台帐号
$pass = md5("661226"); //短信平台密码
setcookie("code", $code, time()+300);
$content="【易推】您的验证码为".$code."，在5分钟内有效。";//要发送的短信内容
$sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
$result =file_get_contents($sendurl) ;
echo $result;

?>