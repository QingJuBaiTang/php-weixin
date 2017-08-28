<script src="/music_autoplay.js"></script>
<?php
header("Content-Type: text/html; charset=UTF-8");
define('IN_XD', true);
session_start();
require("include/common.inc.php");
require('include/functions.php');
require('include/QueryList.class.php');
//require("include/Image.class.php");
//include 'phpQuery/phpQuery.php'; 
if (!$_COOKIE['userid']) {
    echo "<script type='text/javascript'>location.href='login.php';</script>";
    exit;
}
if ($_GET['catid']) {
    $sql = "select * from tbl_music where cat_id='" . (int)$_GET['catid'] . "' ORDER by id DESC";
    $query = mysql_query($sql);
    while ($row = mysql_fetch_array($query)) {
        $str .= '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
    }
    echo $str;
    exit;
}
$sqlu = "select * from tbl_user where id=" . $_COOKIE['userid'];
$queryu = mysql_query($sqlu);
$rowu = mysql_fetch_array($queryu);
$time2 = strtotime($rowu['beizhu1']);
$time1 = strtotime(date("Y-m-d H:i:s"));
$tt = ceil(($time2 - $time1) / 86400);
$daili = $rowu['shuyu'];
$sqla = "select count(*) as cc from tbl_info where userid='" . $_COOKIE['username'] . "'";
$querya = mysql_query($sqla);
$rowa = mysql_fetch_array($querya);
$s = $rowu['anums'] - $rowa['cc'];
if ($_GET['act'] == 'add') {
    if ($s < 1) {
        echo "<script type='text/javascript'>alert('您发布的文章已经达到上限，请充值！');location.href='/vip.php';</script>";
        exit;
    }
    if ($tt < 0) {
        echo "<script type='text/javascript'>alert('您的会员时间已经到期，请充值！');location.href='/vip.php';</script>";
        exit;
    }
    if (is_uploaded_file($_FILES['upfile']['tmp_name'])) {
        $upfile = $_FILES["upfile"];
        $string = strrev($_FILES['upfile']['name']);
        $array = explode('.', $string);
        $type = $upfile["type"];//上传文件的类型
        $size = $upfile["size"];//上传文件的大小
        $tmp_name = $upfile["tmp_name"];//上传文件的临时存放路径
        $base_path = 'upload/' . date('Ymd');
        if (!is_dir($base_path)) {
            mkdir($base_path);
        }
        $name = $base_path . '/' . time() . 'a.' . strrev($array[0]);
        //判断是否为图片
        switch ($type) {
            case 'image/pjpeg':
                $okType = true;
                break;
            case 'image/jpeg':
                $okType = true;
                break;
            case 'image/gif':
                $okType = true;
                break;
            case 'image/png':
                $okType = true;
                break;
        }
        if ($okType) {
            $error = $upfile["error"];//上传后系统返回的值
            //把上传的临时文件移动到up目录下面
            move_uploaded_file($tmp_name, $name);
            if (Image::getImageInfo($name) == false) {
                @unlink($name);
                qy_alert_back('上传失败：非正常图片');
            }
            $share_pic = $name;
        } else {
            qy_alert_back('\u8bf7\u4e0a\u4f20\u006a\u0070\u0067\u002c\u0067\u0069\u0066\u002c\u0070\u006e\u0067\u7b49\u683c\u5f0f\u7684\u56fe\u7247\uff01');
        }
    } else {
        $share_pic = trim($_POST['share_pic']);
    }
    $share_desc = trim($_POST['share_desc']);
    $telno = trim($_POST['telnumber']);
    $ifadtop = trim($_POST['adweizhi']);
    $infoid = trim($_POST['artid']);
    $qqno = trim($_POST['qqnumber']);
    $adquanping = trim($_POST['adquanping']);
    $gongzhonghao = trim($_POST['gongzhonghao']);
    $is_quanping2 = trim($_POST['is_quanping2']);
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $ispl = trim($_POST['ispl']);
    $ywyuedu = $arr[0]['ywyuedu'];
    $sqlad = "select * from tbl_ad where id = " . $_POST['adid'];
    $queryad = mysql_query($sqlad);
    $rowad = mysql_fetch_array($queryad);
    $ifPublicNumber = trim($_POST['ifgongzhonghao']);
    $gzurl = trim($_POST['gzurl']);
    $vid = cut($content, 'vid=', '&');//获取视频ID
    $content = preg_replace("/<(\/?i?frame.*?)>/si", "", $content); //过滤frame标签
    if ($vid !== '') {
        $content = "<p id='shipin'><iframe id='aaa' height=300 width=100% src=\"http://v.qq.com/iframe/player.html?vid={$vid}&auto=0\" frameborder=0 allowfullscreen></iframe></p>" . $content;
    }
    //$ywyuedu='qq';
    //$sql = "insert into tbl_info values (0,'".$title."','".addslashes($content)."','".$rowad['ad_img']."','".$rowad['ad_link']."','".$_COOKIE['username']."',0,0,'".date('Y-m-d H:i:s')."')";
//	$sql = "insert into tbl_info values (0,'".$title."','".addslashes($content)."','".$rowad['ad_img']."','".$rowad['ad_img_one']."','".$rowad['ad_img_two']."','".$rowad['ad_link']."','".$_COOKIE['username']."',0,0,'".date('Y-m-d')."','".$rowad['adtelnumber']."','".$rowad['adqqnumber']."','".$ifadtop."','".$gongzhonghao."','".$ifPublicNumber."','".$rowad['erweima']."','".$ywyuedu."','".$infoid."','".$daili."','".$sharepic."','','".$adquanping."','".(int)$_POST['adid']."','".(int)$_POST['music']."','".(int)$_POST['autoplay']."')";
    $sql = "insert into tbl_info values (0,'" . $title . "','" . addslashes($content) . "','" . $rowad['ad_img'] . "','" . $rowad['ad_img_one'] . "','" . $rowad['ad_img_two'] . "','" . $rowad['ad_link'] . "','" . $_COOKIE['username'] . "',0,0,'" . date('Y-m-d') . "','" . $rowad['adtelnumber'] . "','" . $rowad['adqqnumber'] . "','" . $ifadtop . "','" . $gongzhonghao . "','" . $ifPublicNumber . "','" . $rowad['erweima'] . "','" . $ywyuedu . "','" . $infoid . "','" . $daili . "','" . $sharepic . "','" . $sharedesc . "','" . $adquanping . "','" . (int)$_POST['adid'] . "','" . (int)$_POST['music'] . "','" . (int)$_POST['autoplay'] . "','" . $gzurl . "','0','3','','" . $ispl . "','" . $is_quanping2 . "',0)";
    mysql_query($sql);
    echo "<script type='text/javascript'>alert('\u53d1\u5e03\u6210\u529f\uff01');location.href='view.php?fid=" . $infoid . "';</script>";
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title>发布文章 -<?php echo $cfg_webname ?></title>
    <link rel="stylesheet" type="text/css" href="/css/css_view.css">
    <link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.0/css/amazeui.min.css"/>
    <script type="text/javascript" src="/js/jquery-2.0.3.min.js"></script>
    <script>
        $(function () {
            var pattern = /^http:\/\/mmbiz/;
            var prefix = 'http://<? echo $_SERVER['SERVER_NAME']; ?>/image_proxy.php?1=1&siteid=1&url=';
            $("img").each(function () {
                var src = $(this).attr('src');
                if (pattern.test(src)) {
                    var newsrc = prefix + src;
                    $(this).attr('src', newsrc);
                }
                //$('#js_content').autoIMG();
            });
        });
    </script>
    <script type='text/javascript'>
        setInterval(function () {
            var dd = document.getElementById('topad').style.display;
            if (dd == "none") {
                document.getElementById('topad').style.display = 'block';
            }
        }, 40000);//界面加载四十秒后执行弹出。
        //
        setInterval(function () {
            var dd = document.getElementById('bannerDowm').style.display;
            if (dd == "none") {
                document.getElementById('bannerDowm').style.display = 'block';
            }
        }, 40000);//界面加载四十秒后执行弹出。
    </script>
    <script type="text/javascript">
        function menuFixed(id) {
            var obj = document.getElementById(id);
            var _getHeight = obj.offsetTop;
            window.onscroll = function () {
                changePos(id, _getHeight);
            }
        }

        function changePos(id, height) {
            var obj = document.getElementById(id);
            var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
            if (scrollTop < height) {
                obj.style.position = 'relative';
            } else {
                obj.style.position = 'fixed';
                obj.style.top = '0';
            }
        }
    </script>
    <script type="text/javascript">
        window.onload = function () {
            menuFixed('topad');
        }
        $(function () {
            $(".rich_media_meta_list span:first").css("display", "none");
        });
    </script>
    <link rel="stylesheet" href="/css/add.css">
    <link rel="stylesheet" href="/css/css.css">
</head>
<body>
<form action="?act=add" id="signupok" method="post" name="addform" enctype="multipart/form-data"
      onSubmit="return check()">
    <div id="quanping2">
        <div class="rich_media ">
            <input type="hidden" name="artid" value="<?php echo time() . rand(10, 1000); ?>"/>
            <div class="rich_media_inner"><font color="#DC3462">温馨提示:直接编辑文章发布建议在PC端进行操作!</font> <br>
                标题：
                <input name="title" class="input_txt" type="text" value="<?php echo urldecode($row['title']); ?>"
                       size="48" style="width: 98%;"/>
                <br>
                公众号：
                <input name="gongzhonghao" class="input_txt" type="text" value="<?php echo $row['gongzhonghao'] ?>"
                       size="48" style="width: 98%;"/>
                <br>
                时间：
                <input name="addtime" class="input_txt" type="text" value="<?php echo $row['addtime'] ?>" size="48"
                       style="width: 98%;"/>
                公众号关注链接：（需要http://选填）
                <input name="gzurl" type="text" class="input_txt" value="<?php echo $row['gzurl'] ?>" size="48"
                       style="width: 98%;"/>
                <br>
                <dl class="clearfix">
                    <dd>
                        <select class="input_txt sel" name="adid" style="width:100%">
                            <option value="">请选择广告</option>
                            <?php
                            $sql = "select * from tbl_ad where userid = '" . $_COOKIE['userid'] . "' ORDER by id DESC";
                            $query = mysql_query($sql);
                            while ($row = mysql_fetch_array($query)) {
                                ?>
                                <option value="<?= $row['id'] ?>">
                                    <?= $row['ad_title'] ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </dd>
                </dl>
                <dl class="clearfix">
                    <dd>
                        <select class="input_txt" id="musiccat" name="musiccat"
                                style="width:49%;border: #99CC33 1px solid;">
                            <option value="">选择音乐分类</option>
                            <?
                            $sql = "select * from tbl_music_cat";
                            $query = mysql_query($sql);
                            while ($row = mysql_fetch_array($query)) {
                                ?>
                                <option value="<?= $row['id'] ?>">
                                    <?= $row['name'] ?>
                                </option>
                                <?
                            }
                            ?>
                        </select>
                        <select class="input_txt" name="music" id="music" style="width:49%;border: #99CC33 1px solid;"
                                onChange="showUser(this.value)">
                            <option value="">选择音乐分类</option>
                        </select>
                    </dd>
                </dl>
                <dl class="clearfix">
                    <dd>广告位置：<br>
                        <input class="rad" type="radio" name="adweizhi" value="0" data-labelauty="顶部悬浮"/>
                        <input class="rad" name="adweizhi" type="radio" value="1" data-labelauty="底部悬浮"/>
                        <input class="rad" name="adweizhi" type="radio" value="4" data-labelauty="顶底悬浮"/><br>
                        <input class="rad" name="adweizhi" type="radio" value="5" data-labelauty="顶部固定"/>
                        <input class="rad" name="adweizhi" type="radio" value="2" data-labelauty="底部固定"/>
                        <input class="rad" name="adweizhi" type="radio" value="6" data-labelauty="顶底固定"/><br>
                        <input class="rad" name="adweizhi" type="radio" value="8" data-labelauty="跑马灯[顶]"/>
                        <input class="rad" name="adweizhi" type="radio" value="3" data-labelauty="跑马灯[底]"/><br>
                        <input class="rad" name="adweizhi" type="radio" id="adweizhibtm" value="7" checked="CHECKED"
                               data-labelauty="顶部固定、底部悬浮"/>
                    </dd>
                    <dd><span style=" color:#f00; float:left">全屏广告：</span> <input onClick="qpShow();" class="rad"
                                                                                  type="radio" name="adquanping"
                                                                                  value="1" id="adquanping"
                                                                                  class="radioItem"
                                                                                  data-labelauty="显示"/>
                        <input onClick="qpHide();" class="rad" name="adquanping" type="radio" id="adquanping2" value="0"
                               checked="CHECKED" class="radioItem" data-labelauty="隐藏"/>
                    </dd>
                    <dd class="quanpingtime" style="display:none; padding-left:20px;"><span
                                style=" color:#f00; float:left">全屏时间：</span>
                        <input class="rad" type="radio" name="qptime" value="3" id="qptime" class="radioItem"
                               data-labelauty="3秒"/>
                        <input class="rad" name="qptime" type="radio" value="5" checked="CHECKED" class="radioItem"
                               data-labelauty="5秒"/>
                        <input class="rad" name="qptime" type="radio" value="7" class="radioItem" data-labelauty="7秒"/>
                    </dd>
                    <dd class="is_quanping2" style="display:none; padding-left:20px"><span
                                style=" color:#f00; float:left">全屏后顶部广告：</span>
                        <input class="rad" name="is_quanping2" type="radio" value="1" class="radioItem"
                               data-labelauty="显示"/>
                        <input class="rad" name="is_quanping2" type="radio" value="0" checked="CHECKED"
                               class="radioItem" data-labelauty="隐藏"/>
                    </dd>
                    <o id='morexx'>
                        <dd>
                            <font color="#f00" style="float:left">背景音乐：</font>
                            <input class="rad" name="autoplay" type="radio" value="1" data-labelauty="自动播"/>
                            <input class="rad" name="autoplay" type="radio" value="0" checked="CHECKED"
                                   data-labelauty="手动播"/>
                        </dd>
                        <dd><span style=" color:#F00; float:left">公众号：</span>
                            <input class="rad" type="radio" name="ifgongzhonghao" value="1" checked="CHECKED"
                                   data-labelauty="显示"/>
                            <input class="rad" name="ifgongzhonghao" type="radio" value="0" data-labelauty="隐藏"/>
                        </dd>
                        <dd><span style="color:#F00; float:left">文章太长折叠：</span>
                            <input class="rad" type="radio" name="zhedie" value="1" data-labelauty="开启"/>
                            <input class="rad" name="zhedie" type="radio" value="0" checked="CHECKED"
                                   data-labelauty="关闭"/>
                        </dd>
                        <dd><span style="color:#F00; float:left">开启文章评论：</span>
                            <input class="rad" type="radio" name="ispl" value="1" data-labelauty="开启"/>
                            <input class="rad" name="ispl" type="radio" value="0" checked="CHECKED"
                                   data-labelauty="关闭"/>
                        </dd>
                    </o>
                    <script src="/js/jquery-labelauty.js"></script>
                    <link rel="stylesheet" href="/css/jquery-labelauty.css">
                    <div class="blank10"></div>
                    <dd style="color:#F1901F; font-size:12px;line-height:30px;  margin-top:6px; height:30px; border-top:#ccc 1px solid;">
                        声明：禁止发布黄赌毒以及违反任何国家相关法律法规的信息
                    </dd>
                </dl>
                <div id="page-content">
                    <div id="img-content"> 内容：
                        <div class="rich_media_content" id="js_content">

                            <input type="hidden" name="fid" value="<?php echo $infoid; ?>"/>


                            <!-- 加载编辑器的容器 -->
                            <script id="content" name="content" type="text/plain" style="width:100%;height:400px;">
                                <?php $html_content = str_replace('http://mmbiz', 'image_proxy.php?1=1&url=http://mmbiz', $row['content']);
                                echo $html_content; ?>
                            </script>
                            <!-- 配置文件 -->
                            <
                            script
                            type = "text/javascript"
                            src = "/ueditor/ueditor.config.js" ></script>
                            <!-- 编辑器源码文件 -->
                            <script type="text/javascript" src="/ueditor/ueditor.all.js"></script>
                            <!-- 实例化编辑器 -->
                            <script type="text/javascript">
                                var ue = UE.getEditor('content');
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
    <div class="footermenu" id="11" style="margin-bottom:100px; z-index:9999">
        <table width="100%" border="0">
            <tr>
                <td width="50%" align="center"><input name="" type="submit" value="保存文章" class="submit"
                                                      style="background-color:#09B1B9"/></td>
                <td width="50%"><a href="/edit.php" class="submit">放弃保存</a></td>
            </tr>
        </table>
    </div>
    <br>
</form>
</div>
</div>
<? include('foot.php'); ?>
<script type="text/javascript">
    //实例化编辑器
    var um = UM.getEditor('content',
        {
            autoHeightEnabled: true,
            autoFloatEnabled: true
        });
    um.addListener('blur', function () {
        $('#focush2').html('编辑器失去焦点了')
    });
    um.addListener('focus', function () {
        $('#focush2').html('')
    });
</script>
<script language="javascript">
    document.getElementById('content').style.width = document.body.clientWidth - 9 + 'px';//设置宽度//设置宽度
    $(function () {
        $(':input').labelauty();
    });
    $(window).load(function () {
        $("img").each(function () {
            var maxwidth = document.body.clientWidth - 9;
            if ($(this).width() > maxwidth) {
                $(this).width(maxwidth);
            }
        });
    });
</script>
<script type="text/javascript">
    $("#musiccat").change(function () {
        var id = $("#musiccat").val();
        if (id != '') {
            $('#music').html('<option value="">请选择音乐</option>');
            $.ajax({
                url: location.href,
                data: {catid: id},
                type: 'get',
                async: true,
                success: function (res) {
                    $('#music').append(res);
                }
            });
        }
    });
</script>
</body>
</html>
