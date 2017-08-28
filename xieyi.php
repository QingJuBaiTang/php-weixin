<?php
error_reporting(0);
define('IN_XD', true);
session_start();
require("include/common.inc.php");
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title>联系客服 - <?php echo $cfg_webname ?></title>
    <meta name="description" content=""/>
    <meta name="viewport"
          content="width=device-width , initial-scale=1.0 , user-scalable=0 , minimum-scale=1.0 , maximum-scale=1.0"/>
    <link rel="stylesheet" href="css/css.css">
    <style type="text/css">
        .bot_main li.ico_1 {
            background: #F1901F;
        }
    </style>
</head>
<body id="activity-detail" class="zh_CN " style="margin-top:10px">
<div class="rich_media ">
    <div class="rich_media_inner">
        <h2 class="rich_media_title" id="activity-name">用户协议-<?php echo $cfg_webname ?></h2>
        <div id="page-content">
            协议内容
            <br><br><br><br>
        </div>
    </div>
</div>
</div>
<br>
<?php include('foot1.php'); ?>
</body>
</html>