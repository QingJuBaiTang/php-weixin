<?php
error_reporting(0);
define('IN_XD', true);
session_start();
require("include/common.inc.php");
define('SCRIPT', 'ad_list');
if (!$_COOKIE['userid']) {
    echo "<script type='text/javascript'>location.href='login.php';</script>";
    exit;
}
if ($_GET["act"] == "del") {
    $sql = "delete from tbl_ad where id=" . $_GET['id'];
    mysql_query($sql);
    mysql_close();
    echo "<script type='text/javascript'>alert('\u6210\u529f\u5220\u9664\u0021');location.href='ad_list.php?page=" . $_GET["page"] . "';</script>";
    exit;
}
$sqlu = "select * from tbl_user where id=" . $_COOKIE['userid'];
$queryu = mysql_query($sqlu);
$rowu = mysql_fetch_array($queryu);
$sqla = "select count(*) as cc from tbl_info where userid='" . $_COOKIE['username'] . "'";
$querya = mysql_query($sqla);
$rowa = mysql_fetch_array($querya);
$sqlan = "select count(*) as dd from tbl_ad where userid='" . $_COOKIE['userid'] . "'";
$querya = mysql_query($sqlan);
$rowan = mysql_fetch_array($querya);
$s = $rowu['anums'] - $rowa['cc'];
$adnums = $rowu['adnums'] - $rowan['dd'];
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>广告列表 - <?php echo $cfg_webname ?></title>
    <meta name="description" content=""/>
    <meta name="viewport"
          content="width=device-width , initial-scale=1.0 , user-scalable=0 , minimum-scale=1.0 , maximum-scale=1.0"/>
    <script type='text/javascript' src='js/jquery-2.0.3.min.js'></script>
    <script type='text/javascript' src='js/LocalResizeIMG.js'></script>
    <script type='text/javascript' src='js/patch/mobileBUGFix.mini.js'></script>
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
            max-width: 60%;
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

        .bot_main li.ico_3 {
            background: #F1901F;
        }
    </style>
</head>
<body>
<div class="apply" id="apply">
    <p>广告列表<span style="float:right;font-size:12px;margin-right:10px"></p>
    <div class="list1">
        <ul>
            <?
            if ($_GET['page']) {
                $count = ($_GET['page'] - 1) * 20 + 1;
            } else {
                $count = 1;
            }
            $page_sql = "select * from tbl_ad where userid='" . $_COOKIE['userid'] . "' order by id desc";
            qy_page($page_sql, 20);
            $sql = "select * from tbl_ad where userid='" . $_COOKIE['userid'] . "' ORDER by id DESC LIMIT $_pagenum,$_pagesize";
            $_id = '&';
            $query = mysql_query($sql);
            while ($row = mysql_fetch_array($query)) {
                $ad_img = explode(',', $row['ad_img']);
                foreach ($ad_img as $key => $vo) {
                    $ad_img[$key] = explode('|', $vo);
                }
                ?>
                <li style="height: 20px;">
                    <div class="list_txt" style="vertical-align:middle;">
                        <?= $row['ad_title'] ?>
                        <span style="float:right;font-size:1.1em;margin-right:10px;margin-top:-5px; line-height:30px">
                            <a style="height: 24px;line-height: 24px;padding: 0 11px;background: #09B1B9;border: 1px #26bbdb solid;border-radius: 3px;display: inline-block;text-decoration: none;font-size: 14px;outline: none; color:#fff" href="ad_edit.php?id=<?= $row['id'] ?>&act=updata">修改</a>
                            <a style="height: 24px;line-height: 24px;padding: 0 11px;background: #09B1B9;border: 1px #26bbdb solid;border-radius: 3px;display: inline-block;text-decoration: none;font-size: 14px;outline: none; color:#fff" href="ad_list.php?id=<?= $row['id'] ?>&act=del&page=<?= $_GET['page'] ?>"
                               onClick="if (confirm('删除后不可恢复，请谨慎选择!\r\n确定要删除吗？')) return true; else return false;">删除</a>
                        </span>
                    </div>
                </li>
                <?
                $count++;
            }
            // TODO
                ?>
<!--            <li>-->
<!--                --><?//= qy_paging3() ?>
<!--            </li>-->
            <div style="height: 10px;"></div>
        </ul>
        <div class="btn_box" style="text-align:center">
            <input type="button" name="signup" class="button" value="添加广告" onClick="window.open('ad_edit.php');"
                   style="width:32%;height:30px;line-height:30px; background-color:#09B1B9"><br><br>
            <font color="#F54355">温馨提示:可用剩余广告数：<?= $adnums ?></font>
        </div>
    </div>
</div>
<? include('foot.php'); ?>
</body>
</html>