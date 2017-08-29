<?php
error_reporting(0);
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>易推</title>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <script language="JavaScript" src="js/jquery.js"></script>
    <script type="text/javascript">
        $(function () {
            //导航切换
            $(".menuson li").click(function () {
                $(".menuson li.active").removeClass("active")
                $(this).addClass("active");
            });
            $('.title').click(function () {
                var $ul = $(this).next('ul');
                $('dd').find('ul').slideUp();
                if ($ul.is(':visible')) {
                    $(this).next('ul').slideUp();
                } else {
                    $(this).next('ul').slideDown();
                }
            });
        })
    </script>
</head>
<body style="background:#f0f9fd;">
<div class="lefttop"><span></span>系统菜单</div>
<dl class="leftmenu">
    <dd>
        <div class="title"><span><img src="images/leftico01.png"/></span>用户管理</div>
        <ul class="menuson">
            <li class="active"><cite></cite><a href="useredit.php" target="rightFrame">添加用户</a><i></i></li>
            <li><cite></cite><a href="userlist.php" target="rightFrame">旗下用户列表</a><i></i></li>
            <li><cite></cite><a href="artile.php" target="rightFrame">文章列表</a><i></i></li>
        </ul>
    </dd>
    <?
    if ($_SESSION['admin_user'] == "admin") {
        echo '<dd><div class="title"><span><img src="images/leftico01.png" /></span>代理管理</div><ul class="menuson"><li><cite></cite><a href="admindit.php" target="rightFrame">添加代理</a><i></i></li> <li><cite></cite><a href="adminlist.php" target="rightFrame">代理列表</a><i></i></li>
		 <li><cite></cite><a href="guserlist.php" target="rightFrame">总用户列表</a><i></i></li> <li><cite></cite><a href="gartile.php" target="rightFrame">总文章列表</a><i></i></li></ul></dd>';
        echo '<dd><div class="title"><span><img src="images/leftico01.png" /></span>音乐管理</div>
		<ul class="menuson"><li><cite></cite><a href="music_add.php" target="rightFrame">添加音乐</a><i></i></li> 
		<li><cite></cite><a href="music_list.php" target="rightFrame">音乐列表</a><i></i></li>
		<li><cite></cite><a href="music_cat_add.php" target="rightFrame">音乐分类添加</a><i></i></li>
		<li><cite></cite><a href="music_cat_list.php" target="rightFrame">音乐分类列表</a><i></i></li>
		 </ul></dd>';
        echo '<dd><div class="title"><span><img src="images/leftico01.png" /></span>激活码库</div>
		<ul class="menuson"><li><cite></cite><a href="ma_add.php" target="rightFrame">生成激活码</a><i></i></li> 
		<li><cite></cite><a href="ma_list.php?status=1" target="rightFrame">已使用</a><i></i></li>
		<li><cite></cite><a href="ma_list.php?status=2" target="rightFrame">未使用</a><i></i></li>
		 </ul></dd>';
    }
    ?>
    <?
    if ($_SESSION['admin_user'] == "admin") {
        echo '<dd>
			<div class="title">
				<span><img src="images/leftico01.png" /></span>微信配置
			</div>
			<ul class="menuson">
				<li>
					<cite></cite><a href="wx_config.php" target="rightFrame">分享配置</a>
				</li>
			</ul>
		</dd>';
    }
    ?>
    <?
    if ($_SESSION['admin_user'] == "admin") {
        echo '<dd>
			<div class="title">
				<span><img src="images/leftico01.png" /></span>投诉管理
			</div>
			<ul class="menuson">
				<li>
					<cite></cite><a href="complain.php" target="rightFrame">投诉列表</a>
				</li>
			</ul>
		</dd>';
    }
    ?>

    <?
    if ($_SESSION['admin_user'] == "admin") {
        echo '<dd>
			<div class="title">
				<span><img src="images/leftico01.png" /></span>广告管理
			</div>
			<ul class="menuson">
				<li>
					<cite></cite><a href="adverlist.php" target="rightFrame">广告列表</a>
				</li>
			</ul>
		</dd>';
    }
    ?>
    <?
    if ($_SESSION['admin_user'] == "admin") {
        echo '<dd>
			<div class="title">
				<span><img src="images/leftico01.png" /></span>系统设置
			</div>
			<ul class="menuson">
				<li>
					<cite></cite><a href="default_set.php" target="rightFrame">初始参数设置</a>
				</li>
			</ul>
		</dd>';
    }
    ?>
</dl>
</body>
</html>
