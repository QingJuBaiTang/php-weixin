<?php
define('IN_XD', true);
session_start();
require("include/common.inc.php");
define('SCRIPT', 'fxlist');
if (!$_COOKIE['userid']) {
    echo "<script type='text/javascript'>location.href='login.php';</script>";
    exit;
}
$sqlu = "select * from tbl_user where id=" . $_COOKIE['userid'];
$queryu = mysql_query($sqlu);
$rowu = mysql_fetch_array($queryu);
$time2 = strtotime($rowu['beizhu1']);
$time1 = strtotime(date("Y-m-d H:i:s"));
$tt = ceil(($time2 - $time1) / 86400);
$sqla = "select count(*) as cc from tbl_info where userid='" . $_COOKIE['username'] . "'";
$querya = mysql_query($sqla);
$rowa = mysql_fetch_array($querya);
$sqlanum = "select count(*) as cc, sum(wcount) AS sum_list  from tbl_info where userid='" . $_COOKIE['username'] . "'";
$queryanum = mysql_query($sqlanum);
$rowanum = mysql_fetch_array($queryanum);
$sqlanumc = "select count(*) as cc, sum(acount) AS sum_list  from tbl_info where userid='" . $_COOKIE['username'] . "'";
$queryanumc = mysql_query($sqlanumc);
$rowanumc = mysql_fetch_array($queryanumc);
$s = $rowu['anums'] - $rowa['cc'];
$sa = $rowu['anums'] - 1;
if ($_GET["act"] == "del") {
    $sqlw = "delete from tbl_info where infoid=" . $_GET['infoid'];
    $sqlt = "UPDATE tbl_user SET anums='$sa' WHERE id=" . $_COOKIE["userid"];
    mysql_query($sqlw);
    mysql_query($sqlt);
    mysql_close();
    echo "<script type='text/javascript'>alert('\u6210\u529f\u5220\u9664\u0021');location.href='fxlist.php?page=" . $_GET["page"] . "';</script>";
    exit;
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>文章列表 - <?php echo $cfg_webname ?></title>
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

        .bot_main li.ico_2 {
            background: #F1901F;
        }
    </style>
</head>
<body>
<div class="apply" id="apply">
    <p>文章列表
<!--        <span style="float:right;font-size:12px;margin-right:10px">剩余文章数：--><?//= $s ?><!--&nbsp;&nbsp;剩余天数：--><?//= $tt ?><!--天</span>-->
    </p>
    <form action="?act=search" id="signupok" method="get" style="margin-top: 10px;">
        <ul class="am-avg-sm-3 am-text-center admin-content-list">
            <li class="am-text-success">
                <a href="./index.php?i=257&c=entry&do=list&m=weisrc_quickad" class="am-text-success"><span
                            class="am-icon-btn am-icon-file-text"></span><br/>
                    文章总数<br/>
                    <?= $rowa['cc'] ?>    </a>
            </li>
            <li class="am-text-warning"><span class="am-icon-btn am-icon-user-md"></span><br/>
                总访问量<br/>
                <?= $rowanum['sum_list'] ?>  </li>
            <li class="am-text-danger"><span class="am-icon-btn am-icon-recycle"></span><br/>
                总点击数<br/>
                <?= $rowanumc['sum_list'] ?>  </li>
        </ul>
    </form>
    <div class="list1" style="margin-bottom:50px;">
        <br>
        <dd>
            <div style='margin-left:8px; margin-top:-5px; margin-right:10px; font-size:14px; color:#FF0000;'>
                温馨提示：已经分享出去的内容千万不能删除，否则用户在阅读分享的文章将会消失。
            </div>
        </dd>
        <ul>
            <?
            if ($_GET['act'] = 'search') {
                if (!empty($_GET['title']) && $_GET['title'] != '') {
                    $title = $_GET['title'];
                }
                if (!empty($_GET['adid']) && $_GET['adid'] != '') {
                    $adid = $_GET['adid'];
                }
                if ($_GET['page']) {
                    $count = ($_GET['page'] - 1) * 20 + 1;
                } else {
                    $count = 1;
                }
                if ($adid != '') {
                    $page_sql = "select * from tbl_info where userid='" . $_COOKIE['username'] . "' and adid='" . $adid . "' and title like '%" . urldecode($title) . "%' order by id desc";
                } else {
                    $page_sql = "select * from tbl_info where userid='" . $_COOKIE['username'] . "' and title like '%" . urldecode($title) . "%' order by id desc";
                }
                //echo $page_sql;
                //exit();
                qy_page($page_sql, 15);
                if ($adid != '') {
                    $sql = "select * from tbl_info where userid='" . $_COOKIE['username'] . "'and adid='" . $adid . "' and title like '%" . urldecode($title) . "%' ORDER by id DESC LIMIT $_pagenum,$_pagesize";
                } else {
                    $sql = "select * from tbl_info where userid='" . $_COOKIE['username'] . "'and title like '%" . urldecode($title) . "%' ORDER by id DESC LIMIT $_pagenum,$_pagesize";
                }
                $_id = '&';
                $query = mysql_query($sql);
            }
            while ($row = mysql_fetch_array($query)) {
                ?>
                <li>
                    <div class="list_txt list_t">
                        <a class="titlelist" href="view.php?fid=<?= $row['infoid'] ?>"><?= $row['id'] ?>
                            、<?php echo urldecode($row['title']); ?></a><br>阅读:<?= $row['wcount'] ?>
                        &nbsp;&nbsp;广告点击:<?= $row['acount'] ?>&nbsp;&nbsp;点赞:<?= $row['zan'] ?>
                        <a style="float:right; padding-left:15px"
                           href="fxlist.php?infoid=<?= $row['infoid'] ?>&act=del&page=<?= $_GET['page'] ?>"
                           onClick="if (confirm('确定要删除吗？')) return true; else return false;">删除</a>
                        <a style="float:right" href="fxedit.php?fid=<?= $row['infoid'] ?>"
                           onClick="if (confirm('确定要编辑吗？')) return true; else return false;">编辑</a>
                    </div>
                </li>
                <?
                $count++;
            }
            ?>
            <li>
                <?= qy_paging3("act=search&adid=" . $adid . "&title=" . $title) ?>
            </li>
        </ul>
    </div>
</div>
<? include('foot.php'); ?>
</body>
</html>