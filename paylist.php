<?php
define('IN_XD', true);
session_start();
require("include/common.inc.php");
define('SCRIPT', 'list');

if (!$_COOKIE['userid']) {
    echo "<script type='text/javascript'>location.href='login.php';</script>";
    exit;
}

$sql = "select * from tbl_cz_log where userid='" . $_COOKIE['userid'] . "'";
$query = mysql_query($sql);
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>交易记录 - <?php echo $cfg_webname ?></title>
    <meta name="description" content=""/>
    <meta name="viewport"
          content="width=device-width , initial-scale=1.0 , user-scalable=0 , minimum-scale=1.0 , maximum-scale=1.0"/>
    <script type='text/javascript' src='js/jquery-2.0.3.min.js'></script>
    <script type='text/javascript' src='js/LocalResizeIMG.js'></script>
    <script type='text/javascript' src='js/patch/mobileBUGFix.mini.js'></script>
    <link rel="stylesheet" type="text/css" href="css/amazeui.min.css"/>
    <link rel="stylesheet" href="css/css.css">
    <style>
        .list1 ul li {
            background: #f7f7f7 url(images/dotline.jpg) repeat-x top;
            padding: 10px;
            height: auto;
            overflow: hidden;
            zoom: 1;
        }

        .list1 ul li .pic {
            max-width: 30%;
        }

        .list1 ul li .pic img {
            width: 50px;
            height: 50px
        }

        .list_txt h6 {
            padding-left: 10px;
            max-width: 90%;
            color: #333;
            font-size: 14px;
            padding-top: 5px;
            line-height: 16px;
            height: 24px;
            overflow: hidden;
        }

        .list1 ul li a {
            color: #333;
        }

        .bot_main li.ico_5 {
            background: #F1901F;
        }
    </style>
</head>
<body>
<div class="apply" id="apply">
    <p>交易记录</p>
    <div class="list1" style="margin-bottom:50px;">
        <ul>
            <?php while ($row = mysql_fetch_array($query)) { ?>
                <li>
                    <div class="list_txt list_t" style="line-height:30px">
                        <a class="titlelist">订单号<?php echo $row['dingdan']; ?></a>
                        文章:<?php echo $row['wnum']; ?>条&nbsp;&nbsp;包含时间:<?= $row['tnum'] ?>
                        天&nbsp;&nbsp;金额:<?= $row['jiage'] ?> <br>
                        渠道:<?php echo $row['qudao']; ?>&nbsp;&nbsp;交易时间:<?php echo $row['shijian']; ?>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<? include('foot.php'); ?>
</body>
</html>