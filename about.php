<?php
error_reporting(0);
define('IN_XD', true);
session_start();
require("include/common.inc.php");
require("include/Wxjs.class.php");
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title><?php echo $cfg_webname ?></title>
    <meta name="description" content=""/>
    <meta name="viewport"
          content="width=device-width , initial-scale=1.0 , user-scalable=0 , minimum-scale=1.0 , maximum-scale=1.0"/>
    <link rel="stylesheet" href="css/css.css">
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
</head>
<body id="activity-detail" class="zh_CN " style="margin-top:10px">
<div class="rich_media ">
    <div class="rich_media_inner">
        <div id="page-content">
            <div id="img-content">
                <div class="rich_media_content" id="js_content">
                    <img src="images/about1.jpg" width="100%">
                    <iframe id="sp" name="sp" frameborder="0" width="100%" height="200"
                            src="https://imgcache.qq.com/tencentvideo_v1/playerv3/TPout.swf?max_age=86400&v=20161117&vid=v050974pygk&auto=0"
                            allowfullscreen></iframe>
                    <img src="images/hydl1.jpg" width="100%">
                    <img src="images/hydl2.jpg" width="100%">
                    <img src="images/hydl3.jpg" width="100%">
                    <img src="images/hydl4.jpg" width="100%">
                    <img src="images/hydl5.jpg" width="100%">
                    <img src="images/hydl6.jpg" width="100%">
                    <img src="images/hydl7.jpg" width="100%">
                    <img src="images/hydl8.jpg" width="100%">
                    <img src="images/a9.jpg" width="100%">
                </div>
                <br>
                <br>
                <br>
                <br>
                <br>
            </div>
        </div>
    </div>
</div>
</div>
<br>
<script>
    if (document.body.scrollWidth > 640) {
        document.all("sp").height = 640 * 280 / 495;
        document.all("sp").width = 640;
    } else {
        document.all("sp").height = (document.body.scrollWidth) * 280 / 495;
    }
</script>
<?php include('foot1.php'); ?>
</body>
</html>
