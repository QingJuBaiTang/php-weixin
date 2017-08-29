<?
header('Content-Type:text/html; charset=utf-8');
define('IN_XD', true);
require('../include/common.inc.php');
define('SCRIPT', 'complain');
require("check.php");
session_start();
//删除
if ($_GET["act"] == "del") {
    $sql = "delete from tbl_info where infoid=" . $_GET['fid'];
    mysql_query($sql);
    mysql_close();
    echo "<script type='text/javascript'>alert('成功删除!');location.href='complain.php';</script>";
    exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>易推</title>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script language="javascript">
        $(function () {
            //导航切换
            $(".imglist li").click(function () {
                $(".imglist li.selected").removeClass("selected")
                $(this).addClass("selected");
            })
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".click").click(function () {
                $(".tip").fadeIn(200);
            });
            $(".tiptop a").click(function () {
                $(".tip").fadeOut(200);
            });
            $(".sure").click(function () {
                $(".tip").fadeOut(100);
            });
            $(".cancel").click(function () {
                $(".tip").fadeOut(100);
            });
        });
    </script>
</head>
<body>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="main.php">首页</a></li>
        <li><a href="#">投诉列表</a></li>
    </ul>
</div>
<div class="rightinfo">
    <table class="imgtable">
        <thead>
        <tr>
            <th>ID</th>
            <th>文章id</th>
            <th>被投诉文章标题</th>
            <th>被投诉时间</th>
            <th>被投诉原因</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?
        $page_sql = "select * from tbl_complain " . $where;
        qy_page($page_sql, 20);
        $sql = "select * from tbl_complain " . $where . " ORDER by id DESC LIMIT $_pagenum,$_pagesize";
        $query = mysql_query($sql);
        while ($row = mysql_fetch_array($query)) {
            ?>
            <tr height="35px">
                <td><?= $row['Id'] ?></td>
                <td><?= $row['fid'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['time'] ?></td>
                <td><?= $row['reson'] ?></td>
                <td>
                    <a href="../view.php?fid=<?= $row['fid'] ?>" target="_blank">查看文章</a>
                </td>
            </tr>
            <?
        }
        ?>
        </tbody>
    </table>
    <div class="pagin">
        <?= qy_paginga() ?>
    </div>
</div>
<script type="text/javascript">
    $('.imgtable tbody tr:odd').addClass('odd');
</script>
</body>
</html>
