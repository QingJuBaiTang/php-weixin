<?php
header("Content-type: text/html; charset=utf-8");
error_reporting(0);
define('IN_XD', true);
session_start();
require("include/common.inc.php");
require("include/Wxjs.class.php");
if ($_COOKIE['userid'] != '') {
    echo "<script type='text/javascript'>location.href='index.php';</script>";
}
if ($_GET['act'] == 'login') {
    $sql = "select * from tbl_user where userid ='" . $_POST['userid'] . "' and userpwd ='" . md5($_POST['userpwd']) . "'";
    $query = mysql_query($sql);
    $row = mysql_fetch_array($query);
    if ($row) {
        setcookie("username", $_POST['userid'], time() + (3600 * 24 * 365 * 10));
        setcookie("userid", $row['id'], time() + (3600 * 24 * 365 * 10));
        echo "<script type='text/javascript'>location.href='index.php';</script>";
        exit;
    } else {
        echo "<script type='text/javascript'>alert('\u7528\u6237\u540d\u6216\u5bc6\u7801\u4e0d\u6b63\u786e\u0021');location.href='login.php';</script>";
        exit;
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>用户登录 - <?php echo $cfg_webname ?></title>
    <meta name="description" content=""/>
    <meta name="viewport"
          content="width=device-width , initial-scale=1.0 , user-scalable=0 , minimum-scale=1.0 , maximum-scale=1.0"/>
    <script type='text/javascript' src='js/jquery-2.0.3.min.js'></script>
    <script type='text/javascript' src='js/LocalResizeIMG.js'></script>
    <script type='text/javascript' src='js/patch/mobileBUGFix.mini.js'></script>
    <script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
    <script type="text/javascript">
        $(function () {
            $(".flexslider").flexslider({
                slideshowSpeed: 4000, //展示时间间隔ms
                animationSpeed: 400, //滚动时间ms
                animation: "slide",
                controlNav: true,//控制菜单
                directionNav: false,//左右控制按钮
                touch: true //是否支持触屏滑动
            });
        });
    </script>
    <style>
        .button_buy a p {
            height: 3em;
            overflow: hidden;
        }

        img {
            width: 100%;
            height: auto;
            display: block;
        }
    </style>
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" type="text/css" href="css/flexslider.css"/>
</head>
<body>
<div class="apply" id="apply">
    <p>用户登录</p>
    <div class="padding:0px;">
        <div class="topshow" id="topshow">
            <div class="flexslider">
                <ul class="slides">
                    <li><img src="images/646600057.jpg"/></li>
                    <li><img src="images/1166880384.jpg"/></li>
                    <li><img src="images/1661071530.jpg"/></li>
                </ul>
            </div>
        </div>
        <div class="blank10"></div>
        <form action="?act=login" id="signupok" method="post">
            <input type="hidden" name="formhash" value="850dee3b"/>
            <input type="hidden" name="vid" value="1"/>
            <dl class="clearfix">
                <dd>账号：</dd>
                <dd><input name="userid" type="text" class="input_txt" id="userid" placeholder="请输入用户名" value=""></dd>
            </dl>
            <dl class="clearfix">
                <dd>密码：</dd>
                <dd><input type="password" class="input_txt" id="userpwd" value="" name="userpwd" placeholder="请输入密码">
                </dd>
            </dl>
            <div class="btn_box">
                <input type="submit" name="signup" class="button" value="立即登录">
            </div>
            <div class="blank10" style="margin-bottom:10px;"></div>
        </form>
    </div>
    <?php include('foot2.php'); ?>
    <script>
        window.shareData = {
            "imgUrl": "<?=$cfg_wx_pic;?>",
            "timeLineLink": window.location.href,
            "sendFriendLink": window.location.href,
            "weiboLink": window.location.href,
            "tTitle": "<?=$cfg_wx_title;?>",
            "tContent": "<?=$cfg_wx_desc;?>",
            "fTitle": "<?=$cfg_wx_title;?>",
        };
    </script>
    <?php
    $sql = "select * from tbl_param_config limit 0,1";
    $res = mysql_query($sql);
    $data = mysql_fetch_assoc($res);
    $Wxjs = new Wxjs($data['appid'], $data['appsecret']);
    $shareScript = $Wxjs->getShareScript();
    echo $shareScript;
    ?>
</body>
</html>
