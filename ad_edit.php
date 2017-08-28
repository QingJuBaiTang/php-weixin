<?php
error_reporting(0);
define('IN_XD', true);
session_start();
require("include/common.inc.php");
if (!$_COOKIE['userid']) {
    echo "<script type='text/javascript'>location.href='login.php';</script>";
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
$id = trim($_GET['id']);
$sql = "select * from tbl_ad where id = " . $id;
$query = mysql_query($sql);
$row = mysql_fetch_array($query);
if ($_GET['act'] == 'add') {
    if ($adnums < 1) {
        header("Content-type:text/html;charset=utf-8");
        echo "<script type='text/javascript' >alert('\u60a8\u7684\u53ef\u521b\u5efa\u5e7f\u544a\u6570\u5df2\u8fbe\u4e0a\u9650\uff0c\u8bf7\u8054\u7cfb\u5ba2\u670d\uff01');location.href='index.php';</script>";
        exit;
    }
    $ad_img = trim($_POST['ad_img']);
    $ad_img_one = trim($_POST['ad_img_one']);
    $ad_img_two = trim($_POST['ad_img_two']);
    $erweima = trim($_POST['erweima']);
    $quanping = trim($_POST['quanping']);
    $quanping2 = trim($_POST['quanping2']);
    $shipinpic = trim($_POST['shipinpic']);
    $adtelnumber = trim($_POST['adtelno']);
    $adqqnumber = trim($_POST['adqqno']);
    $adlbs = trim($_POST['adlbslink']);
    $pmd = trim($_POST['pmd']);
    $wechat_name = trim($_POST['wechat_name']);
    $wechat_url = trim($_POST['wechat_url']);
    $sql = "insert into tbl_ad values (0,'" . $_POST['adtitle'] . "','" . $_POST['adlink'] . "','" . $ad_img . "','" . $ad_img_one . "','" . $ad_img_two . "','" . $_COOKIE['userid'] . "','" . $_COOKIE['username'] . "','" . date('Y-m-d H:i:s') . "','" . $adtelnumber . "','" . $adqqnumber . "','" . $adlbs . "','" . $erweima . "','" . $quanping . "','" . $_POST['adlink2'] . "','" . $quanping2 . "','" . $_POST['adlink3'] . "','" . $shipinpic . "','" . $pmd . "','0','$wechat_name','$wechat_url')";
    //$sql = "insert into tbl_ad values (0,'".$_POST['adtitle']."','".$_POST['adlink']."','".$name."','".$_COOKIE['userid']."','".$_COOKIE['username']."','".date('Y-m-d H:i:s')."','".$adtelnumber."','".$ewname."','".$quanpingt."','".$_POST['adlink2']."','".$quanpingt2."','".$_POST['adlink3']."')";
    mysql_query($sql);
    echo "<script>alert('\u63d0\u4ea4\u6210\u529f\uff01');window.location.href='ad_list.php';</script>";
}
if ($_GET['act'] == 'update') {
    $ad_id = trim($_POST['ad_id']);
    $ad_title = trim($_POST['adtitle']);
    $ad_link = trim($_POST['adlink']);
    $ad_link2 = trim($_POST['adlink2']);
    $ad_link3 = trim($_POST['adlink3']);
    $pmd = trim($_POST['pmd']);
    $wechat_name = trim($_POST['wechat_name']);
    $wechat_url = trim($_POST['wechat_url']);
    $userid = $_COOKIE['userid'];
    $username = $_COOKIE['username'];
    $addtime = date("Y-m-d H:i:s", time());
    $adtelnumber = trim($_POST['adtelno']);
    $adqqnumber = trim($_POST['adqqno']);
    $adlbs = trim($_POST['adlbslink']);
    $pmd = trim($_POST['pmd']);
    $ad_img = trim($_POST['ad_img']);
    $ad_img_one = trim($_POST['ad_img_one']);
    $ad_img_two = trim($_POST['ad_img_two']);
    $erweima = trim($_POST['erweima']);
    $quanping = trim($_POST['quanping']);
    $quanping2 = trim($_POST['quanping2']);
    $shipinpic = trim($_POST['shipinpic']);
    $sqlt = "UPDATE tbl_ad SET ad_title='$ad_title',ad_link='$ad_link',ad_img='$ad_img',ad_img_one='$ad_img_one',ad_img_two='$ad_img_two',userid='$userid',username='$username',addtime='$addtime',adtelnumber='$adtelnumber',adqqnumber='$adqqnumber',adlbs='$adlbs',erweima='$erweima',quanping=' $quanping ',ad_link2='$ad_link2',quanping2='$quanping2',ad_link3='$ad_link3',shipinpic='$shipinpic',pmd='$pmd',wechat_name='$wechat_name',wechat_url='$wechat_url' WHERE id=" . $ad_id;
    mysql_query($sqlt);
    mysql_close();
    echo "<script type='text/javascript'>alert('编辑成功');location.href='ad_list.php';</script>";
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>
        <?php if (is_array($_GET)) echo '修改广告 - '; else echo '添加广告 - '; ?>
        <?php echo $cfg_webname ?></title>
    <meta name="description" content=""/>
    <meta name="viewport"
          content="width=device-width , initial-scale=1.0 , user-scalable=0 , minimum-scale=1.0 , maximum-scale=1.0"/>
    <script type='text/javascript' src='/js/jquery-2.0.3.min.js'></script>
    <script type="text/javascript" src="/js/jquery.form.js"></script>
    <script type="text/javascript" src="/js/up.js" charset="GBK"></script>
    <link rel="stylesheet" href="css/css.css">
</head>
<body>
<style>
    .add_pic {
        display: inline-block;
        position: relative;
    }

    .add_pic .delete {
        position: absolute;
        top: 0px;
        right: 0px;
        width: 20px;
        height: 20px;
    }
</style>
<div class="apply" id="apply">
    <p>广告管理</p>
    <div class="blank10"></div>
    <form action="<?php if (empty($row['id'])) { ?>?act=add<?php } else { ?>?act=update<?php } ?>" id="signupok"
          method="post" name="addform">
        <input type="hidden" name="ad_id" value="<?php echo $row['id'] ?>"/>
        <dl class="clearfix">
            <dd>广告标题：</dd>
            <dd>
                <input type="text" class="input_txt" value="<?php if (!empty($row['ad_title'])) {
                    echo $row['ad_title'];
                } ?>" name="adtitle" id="adtitle" placeholder="请输入广告标题" style="height:50px;">
            </dd>
        </dl>
        <dd>
            <div style='margin-left:8px; margin-top:-5px; margin-right:10px; font-size:13px; color:#FF7F00;'>
                说明：此标题不会在前台显示，仅用做自己区分广告内容。
            </div>
        </dd>
        <dl class="clearfix">
            <dd>广告链接：（必须包含：http://）</dd>
            <dd>
                <input type="text" class="input_txt" value="<?php if (!empty($row['ad_link'])) {
                    echo $row['ad_link'];
                } else { ?>#<?php } ?>" name="adlink" id="adlink" style="height:50px;">
            </dd>
        </dl>
        <dl class="clearfix">
            <dd>联系电话：</dd>
            <dd>
                <input type="tel" class="input_txt" value="<?php if (!empty($row['adtelnumber'])) {
                    echo $row['adtelnumber'];
                } ?>" name="adtelno" id="adtelno" placeholder="请输入联系电话" style="height:50px;">
            </dd>
        </dl>
        <dl class="clearfix">
            <dd>联系Q Q：</dd>
            <dd>
                <input type="qq" class="input_txt" value="<?php if (!empty($row['adqqnumber'])) {
                    echo $row['adqqnumber'];
                } ?>" name="adqqno" id="adqqno" placeholder="请输入qq号" style="height:50px;">
            </dd>
        </dl>
        <dl class="clearfix">
            <dd>一键导航：<a href="help_nav.php" style="font-size:12px">如何获取导航链接?</a></dd>
            <dd>
                <input type="qq" class="input_txt" value="<?php if (!empty($row['adlbs'])) {
                    echo $row['adlbs'];
                } ?>" name="adlbslink" id="adlbslink" placeholder="请输入导航链接" style="height:50px;">
            </dd>
        </dl>
        <dd></dd>
        <dd></dd>
        <dl class="clearfix">
            <dd>广告图片： <span style="font-size:13px; color:#666;">(尺寸：最大宽度740px;宽高比7:2)</span></dd>
            <!-- 广告图片一 -->
            <div class="add_upload">
                <dd>
                    <div class="updiv"> 广告一:
                        <div class="btn"><span id="#btn_ad_img">添加图片</span>
                            <div>
                                <input id="fileupload_ad_img" type="file" name="mypic" onChange="uploadPic('ad_img')">
                            </div>
                        </div>
                        <span class="files" id="files_ad_img">
            <?
            if ($row['ad_img'] != "") {
                ?>
                <a class='delimg' flag='ad_img' onclick='delPic(this);' rel='<?php echo $row['ad_img'] ?>'>删除</a>
                <?
            }
            ?>
            </span>
                        <input type="hidden" value="<?php echo $row['ad_img'] ?>" name="ad_img" id="ad_img">
                        <div id="showimg_ad_img">
                            <?
                            if ($row['ad_img'] != "") {
                                ?>
                                <img src="<?php echo $row['ad_img'] ?>" width="100%" style="max-height:200px">
                                <?
                            }
                            ?>
                        </div>
                    </div>
                <dd>
            </div>
            <!-- 广告图片一 -->
            <!-- 广告图片二 -->
            <div class="add_upload">
                <dd>
                    <div class="updiv"> 广告二:
                        <div class="btn"><span id="#btn_ad_img_one">添加图片</span>
                            <div>
                                <input id="fileupload_ad_img_one" type="file" name="mypic"
                                       onChange="uploadPic('ad_img_one')">
                            </div>
                        </div>
                        <span class="files" id="files_ad_img_one">
            <?
            if ($row['ad_img_one'] != "") {
                ?>
                <a class='delimg' flag='ad_img_one' onclick='delPic(this);'
                   rel='<?php echo $row['ad_img_one'] ?>'>删除</a>
                <?
            }
            ?>
            </span>
                        <input type="hidden" value="<?php echo $row['ad_img_one'] ?>" name="ad_img_one" id="ad_img_one">
                        <div id="showimg_ad_img_one">
                            <?
                            if ($row['ad_img_one'] != "") {
                                ?>
                                <img src="<?php echo $row['ad_img_one'] ?>" width="100%" style="max-height:200px">
                                <?
                            }
                            ?>
                        </div>
                    </div>
                <dd>
            </div>
            <!-- 广告图片二 -->
            <!-- 广告图片三 -->
            <div class="add_upload">
                <dd>
                    <div class="updiv"> 广告三:
                        <div class="btn"><span id="#btn_ad_img_two">添加图片</span>
                            <div>
                                <input id="fileupload_ad_img_two" type="file" name="mypic"
                                       onChange="uploadPic('ad_img_two')">
                            </div>
                        </div>
                        <span class="files" id="files_ad_img_two">
            <?
            if ($row['ad_img_two'] != "") {
                ?>
                <a class='delimg' flag='ad_img_two' onclick='delPic(this);'
                   rel='<?php echo $row['ad_img_two'] ?>'>删除</a>
                <?
            }
            ?>
            </span>
                        <input type="hidden" value="<?php echo $row['ad_img_two'] ?>" name="ad_img_two" id="ad_img_two">
                        <div id="showimg_ad_img_two">
                            <?
                            if ($row['ad_img_two'] != "") {
                                ?>
                                <img src="<?php echo $row['ad_img_two'] ?>" width="100%" style="max-height:200px">
                                <?
                            }
                            ?>
                        </div>
                    </div>
                <dd>
            </div>
            <!-- 广告图片三 -->
            <br>
            <span style='margin-left:8px; margin-top:-10px; margin-right:10px;  font-size:13px; color:#FF0000;'> 说明：建议电脑端设计广告图片，广告图片的质量直接影响广告投放效果，注意图片尺寸。</span>
            </dd>
            <dl class="clearfix">
                <dd>二维码：<span style="font-size:13px; color:#666;">(尺寸：最大宽度250px;宽高比1:1)</span></dd>
                <dd>
                    <div class="add_upload">
                <dd>
                    <div class="updiv">
                        <div class="btn"><span id="#btn_erweima">添加图片</span>
                            <div>
                                <input id="fileupload_erweima" type="file" name="mypic"
                                       onChange="uploadPicErweima('erweima')">
                            </div>
                        </div>
                        <span class="files" id="files_erweima">
            <?
            if ($row['erweima'] != "") {
                ?>
                <a class='delimg' flag='erweima' onclick='delPic(this);' rel='<?php echo $row['erweima'] ?>'>删除</a>
                <?
            }
            ?>
            </span>
                        <input type="hidden" value="<?php echo $row['erweima'] ?>" name="erweima" id="erweima">
                        <div id="showimg_erweima">
                            <?
                            if ($row['erweima'] != "") {
                                ?>
                                <img src="<?php echo $row['erweima'] ?>" style="max-width:250px">
                                <?
                            }
                            ?>
                        </div>
                    </div>
                <dd>
                </dd>
            </dl>
            <dl class="clearfix">
                <dd>全屏图(全屏显示3秒)：<span style="font-size:13px; color:#666;">(尺寸：480像素*800像素)</span></dd>
                <div class="add_upload">
                    <dd>
                        <div class="updiv">
                            <div class="btn"><span id="#btn_quanping">添加图片</span>
                                <div>
                                    <input id="fileupload_quanping" type="file" name="mypic"
                                           onChange="uploadPicQuan('quanping')">
                                </div>
                            </div>
                            <span class="files" id="files_quanping">
            <?
            if ($row['quanping'] != "") {
                ?>
                <a class='delimg' flag='quanping' onclick='delPic(this);' rel='<?php echo $row['quanping'] ?>'>删除</a>
                <?
            }
            ?>
            </span>
                            <input type="hidden" value="<?php echo $row['quanping'] ?>" name="quanping" id="quanping">
                            <div id="showimg_quanping">
                                <?
                                if ($row['quanping'] != "") {
                                    ?>
                                    <img src="<?php echo $row['quanping'] ?>" width="100%" style="max-width:400px">
                                    <?
                                }
                                ?>
                            </div>
                        </div>
                    <dd>
                </div>
                </dd>
            </dl>
            <dl class="clearfix">
                <dd>全屏后顶部广告 <span style="font-size:13px; color:#666;">(尺寸：最大宽度740px;宽高比7:2)</span></dd>
                <div class="add_upload">
                    <dd>
                        <div class="updiv">
                            <div class="btn"><span id="#btn_quanping2">添加图片</span>
                                <div>
                                    <input id="fileupload_quanping2" type="file" name="mypic"
                                           onChange="uploadPic('quanping2')">
                                </div>
                            </div>
                            <span class="files" id="files_quanping2">
            <?
            if ($row['quanping2'] != "") {
                ?>
                <a class='delimg' flag='quanping2' onclick='delPic(this);' rel='<?php echo $row['quanping2'] ?>'>删除</a>
                <?
            }
            ?>
            </span>
                            <input type="hidden" value="<?php echo $row['quanping2'] ?>" name="quanping2"
                                   id="quanping2">
                            <div id="showimg_quanping2">
                                <?
                                if ($row['quanping2'] != "") {
                                    ?>
                                    <img src="<?php echo $row['quanping2'] ?>" width="100%" style="max-height:200px">
                                    <?
                                }
                                ?>
                            </div>
                        </div>
                    <dd>
                </div>
                </dd>
            </dl>
            <dl class="clearfix">
                <dd>全屏广告链接：</dd>
                <dd>
                    <input type="text" class="input_txt" value="<?php if (!empty($row['ad_link2'])) {
                        echo $row['ad_link2'];
                    } ?>" name="adlink2" id="adlink2" placeholder="请输入广告链接（包含：http://）" style="height:50px;">
                </dd>
            </dl>
            <dl class="clearfix">
                <dd>视频广告图： <span style="font-size:13px; color:#666;">(尺寸：最大宽度740px;宽高比1.33:1)</span></dd>
                <div class="add_upload">
                    <dd>
                        <div class="updiv">
                            <div class="btn"><span id="#btn_shipinpic">添加图片</span>
                                <div>
                                    <input id="fileupload_shipinpic" type="file" name="mypic"
                                           onChange="uploadPicQuan('shipinpic')">
                                </div>
                            </div>
                            <span class="files" id="files_shipinpic">
            <?
            if ($row['shipinpic'] != "") {
                ?>
                <a class='delimg' flag='shipinpic' onclick='delPic(this);' rel='<?php echo $row['shipinpic'] ?>'>删除</a>
                <?
            }
            ?>
            </span>
                            <input type="hidden" value="<?php echo $row['shipinpic'] ?>" name="shipinpic"
                                   id="shipinpic">
                            <div id="showimg_shipinpic">
                                <?
                                if ($row['shipinpic'] != "") {
                                    ?>
                                    <img src="<?php echo $row['shipinpic'] ?>" width="100%" style="max-width:400px">
                                    <?
                                }
                                ?>
                            </div>
                        </div>
                    <dd>
                </div>
            </dl>
            <dl class="clearfix">
                <dd>视频广告链接：</dd>
                <dd>
                    <input type="text" class="input_txt" value="<?php if (!empty($row['ad_link3'])) {
                        echo $row['ad_link3'];
                    } ?>" name="adlink3" id="adlink3" placeholder="请输入广告链接（包含：http://）" style="height:50px;">
                </dd>
            </dl>
            <dl class="clearfix">
                <dd>跑马灯内容:</dd>
                <dd>
                    <input type="text" class="input_txt" value="<?php if (!empty($row['pmd'])) {
                        echo $row['pmd'];
                    } ?>" name="pmd" id="pmd" placeholder="输入跑马灯内容" style="height:50px;">
                </dd>
            </dl>
            <dl class="clearfix">
                <dd>公众号名称:</dd>
                <dd>
                    <input type="text" class="input_txt" value="<?php if (!empty($row['wechat_name'])) {
                        echo $row['wechat_name'];
                    } ?>" name="wechat_name" id="wechat_name" placeholder="输入公众号名称" style="height:50px;">
                </dd>
            </dl>
            <dl class="clearfix">
                <dd>公众号链接:</dd>
                <dd>
                    <input type="text" class="input_txt" value="<?php if (!empty($row['wechat_url'])) {
                        echo $row['wechat_url'];
                    } ?>" name="wechat_url" id="wechat_url" placeholder="输入公众号关注链接" style="height:50px;">
                </dd>
            </dl>
            <div class="blank10" style="margin-bottom:15px;"></div>
            <div class="btn_box" style="margin-bottom:50px;">
                <input type="name" name="signup" class="button" value="确认提交" style="background-color:#09B1B9"
                       onClick="return postcheck();">
            </div>
            <div class="blank10"></div>
    </form>
</div>
<? include('foot.php'); ?>
<script type="text/javascript">
    function postcheck() {
        if (document.addform.adtitle.value == "") {
            alert('请填写广告标题！');
            document.addform.adtitle.focus();
            return false;
        }
        if (document.addform.adlink.value == "") {
            alert('请填写广告链接！');
            document.addform.adlink.focus();
            return false;
        }
        if (document.addform.ad_img.value == "") {
            alert('广告一图片为必须上传!');
            document.addform.ad_img.focus();
            return false;
        } else {
            if (document.addform.ad_img_one.value == "" && document.addform.ad_img_two.value != "") {
                alert('请上传广告二图片!');
                document.addform.ad_img_one.focus();
                return false;
            }
        }
        document.addform.submit();
        return true;
    }
</script>
<style type="text/css">
    .btn {
        position: relative;
        overflow: hidden;
        margin-right: 4px;
        display: inline-block;
        *display: inline;
        padding: 4px 10px 4px;
        font-size: 14px;
        line-height: 18px;
        *line-height: 20px;
        color: #fff;
        text-align: center;
        vertical-align: middle;
        cursor: pointer;
        background-color: #09B1B9;
        border: 1px solid #cccccc;
        border-color: #e6e6e6 #e6e6e6 #bfbfbf;
        border-bottom-color: #b3b3b3;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }

    .btn input {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        border: solid transparent;
        opacity: 0;
        filter: alpha(opacity=0);
        cursor: pointer;
    }

    .progress {
        position: relative;
        margin-left: 100px;
        margin-top: -24px;
        width: 200px;
        padding: 1px;
        border-radius: 3px;
        display: none
    }

    .bar {
        background-color: green;
        display: block;
        width: 0%;
        height: 20px;
        border-radius: 3px;
    }

    .percent {
        position: absolute;
        height: 20px;
        display: inline-block;
        top: 3px;
        left: 2%;
        color: #fff
    }

    .files {
        height: 22px;
        line-height: 22px;
        margin: 10px 0
    }

    .delimg {
        margin-left: 20px;
        cursor: pointer;
        padding: 4px 10px 4px;
        font-size: 14px;
        line-height: 18px;
        *line-height: 20px;
        color: #fff;
        text-align: center;
        vertical-align: middle;
        cursor: pointer;
        background-color: #FA3F6D;
        border: 1px solid #cccccc;
        border-color: #e6e6e6 #e6e6e6 #bfbfbf;
        border-bottom-color: #b3b3b3;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }

    .updiv {
        style = "border:1px solid #000000;
        min-height: 50px;
        width: 100%;
    }
</style>
</body>
</html>
