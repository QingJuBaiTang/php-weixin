<?php
header('Content-Type:text/html; charset=utf-8');
define('IN_XD', true);
require("../include/common.inc.php");
require("check.php");
if ($_GET['act'] == 'add') {
    if ($_POST["pwd"]) {
        if ($_POST["pwd"] == $_POST["repwd"]) {
            $pwd = $_POST["pwd"];
        } else {
            echo "<script type='text/javascript'>alert('两次密码不一致!');history.go(-1);</script>";
            exit;
        }
    } else {
        $pwd = "e10adc3949ba59abbe56e057f20f883e";
    }
    $sqli = "select * from tbl_admin where username = '" . $_POST["username"] . "'";
    $queryi = mysql_query($sqli);
    $rowi = mysql_fetch_array($queryi);
    if ($rowi) {
        echo "<script type='text/javascript'>alert('该用户ID已存在!');history.go(-1);</script>";
        exit;
    }
    $sql = "INSERT INTO tbl_admin " .
        "VALUES(
	0,
	'" . $_POST["username"] . "',
	'" . md5($pwd) . "',
	'0',
	'" . date('Y-m-d H:i:s') . "',
	'" . date('Y-m-d H:i:s') . "',
	'" . date('Y-m-d H:i:s') . "',
	'211.211.211.23',
	'" . $_POST["kehushu"] . "',
	'" . $_POST["anums"] . "'
	)";
    mysql_query($sql);
    if (mysql_affected_rows() == 1) {
        xd_close();
        echo "<script type='text/javascript'>alert('添加成功!');location.href='daililist.php';</script>";
        exit;
    } else {
        xd_close();
        qy_alert_back('信息添加失败!');
    }
}
if ($_GET['act'] == 'edit') {
    if ($_POST["pwd"]) {
        if ($_POST["pwd"] == $_POST["repwd"]) {
            $pwdsql = "password = '" . md5($_POST['pwd']) . "',";
        } else {
            echo "<script type='text/javascript'>alert('两次密码不一致!');history.go(-1);</script>";
            exit;
        }
    }
    $sql = "UPDATE tbl_admin SET 
	anums='" . $_POST["anums"] . "',
	$pwdsql
	kehushu='" . $_POST["kehushu"] . "'
	WHERE id=" . $_POST["id"];
    //echo $sql;exit;
    mysql_query($sql);
    if (mysql_affected_rows() == 1) {
        xd_close();
        echo "<script>alert('编辑成功！');window.location.href='adminlist.php';</script>";
        exit;
    } else {
        xd_close();
        qy_alert_back('信息编辑失败或无修改动作!');
    }
}
$id = $_GET['id'];
$query = mysql_query("SELECT * FROM tbl_admin WHERE id='$id'");
$row = mysql_fetch_array($query);
if ($id) {
    $action = "?id=$id&act=edit";
} else {
    $action = "?act=add";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>易推</title>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <link href="css/select.css" rel="stylesheet" type="text/css"/>
    <link href="css/amazeui.datetimepicker.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/select-ui.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function (e) {
            $(".select1").uedSelect({
                width: 345
            });
            $(".select2").uedSelect({
                width: 167
            });
            $(".select3").uedSelect({
                width: 100
            });
        });
    </script>
</head>
<body>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">代理管理</a></li>
    </ul>
</div>
<form action="<?= $action ?>" method="post" name="newsform">
    <input name="id" value="<?= $id ?>" type="hidden">
    <div class="formbody">
        <div class="formtitle"><span>代理基本信息</span></div>
        <ul class="forminfo">
            <li><label>用户登录名</label><input name="username" type="text" class="dfinput"
                                           value="<?= $row['username'] ?>" <? if ($id) {
                    echo 'disabled';
                } ?>/><i>唯一，不能重复</i></li>
            <li><label>密码</label><input name="pwd" type="password" class="dfinput" value=""/><? if (!$id) {
                    echo '<i>不填写密码为默认123456</i>';
                } ?></li>
            <li><label>确认密码</label><input name="repwd" type="password" class="dfinput" value=""/></li>
            <li><label>总开户数</label><input name="kehushu" type="text" class="dfinput" value="<?= $row['kehushu'] ?>"/>
            </li>
            <li><label>总文章数</label><input name="anums" type="text" class="dfinput" value="<?= $row['anums'] ?>"/></li>
            <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
        </ul>
    </div>
</form>
</body>
</html>
