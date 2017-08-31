<script src="music_autoplay.js"></script>
<?php
define('IN_XD', true);
session_start();
require("include/common.inc.php");
require("include/Wxjs.class.php");
require('include/functions.php');
require('include/QueryList.class.php');
//include 'phpQuery/phpQuery.php';

function date_to_unixtime($date, $timezone = 'PRC') {
    $datetime = new DateTime($date, new DateTimeZone($timezone));
    return $datetime->format('U');
}

if (!$_COOKIE['userid']) {
    echo "<script type='text/javascript' >location.href='login.php';</script>";
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
$time1 = strtotime(date("Y-m-d H:i:s"));
$time2 = date_to_unixtime($rowu['beizhu1']);
$tt = ceil(($time2 - $time1) / 86400);
$daili = $rowu['shuyu'];
$sqla = "select count(*) as cc from tbl_info where userid='" . $_COOKIE['username'] . "'";
$querya = mysql_query($sqla);
$rowa = mysql_fetch_array($querya);
$sql = "select id from tbl_jihuoma where uid = '" . $_COOKIE['userid'] . "'";
$query = mysql_query($sql);
$maiguo = mysql_fetch_array($query);
$s = $rowu['anums'] - $rowa['cc'];
if ($_GET['act'] == 'add') {
    if ($s < 1) {
        header("Content-type:text/html;charset=utf-8");
        echo "<script type='text/javascript'  >alert('\u60a8\u53d1\u5e03\u7684\u6587\u7ae0\u5df2\u7ecf\u8fbe\u5230\u4e0a\u9650\uff0c\u8bf7\u5145\u503c\u8d2d\u4e70\uff01');location.href='vip.php';</script>";
        exit;
    }
    if ($tt < 0) {
        header("Content-type:text/html;charset=utf-8");
        echo "<script type='text/javascript' >alert('\u60a8\u7684\u4f1a\u5458\u65f6\u95f4\u5df2\u7ecf\u5230\u671f\uff0c\u8bf7\u8054\u7cfb\u5ba2\u670d\uff01');location.href='vip.php';</script>";
        exit;
    }
    $long = guolv(trim($_POST['wxlink']));
    //$telno='134843204';
    $telno = trim($_POST['telnumber']);
    $qqno = trim($_POST['qqnumber']);
    //$ifadtop='1';
    $ifadtop = trim($_POST['adweizhi']);
    $infoid = trim($_POST['artid']);
    $sharepic = trim($_POST['sharepic']);
    $html = get_contents($long);
    //处理头条地址
    if (stristr($long, "toutiao.com")) {
        $long = str_replace('m.toutiao.com', 'www.toutiao.com', $long);
    }
    //$telno='134843204';
    $telno = trim($_POST['telnumber']);
    //$ifadtop='1';
    $ifadtop = trim($_POST['adweizhi']);
    $infoid = trim($_POST['artid']);;
    $html = get_contents($long);
    if (stristr($long, "mp.weixin.qq.com")) {
        $html = str_replace('<head>', '<head><meta http-equiv=Content-Type content="text/html;charset=utf-8">', $html);
    }
    //处理凤凰内容
    if (stristr($long, "inews.ifeng.com")) {
        $html = str_replace('<!--acTxtPics-->', '<div id=icontent>', $html);
        $html = str_replace('<!--acTxtVids-->', '</div>', $html);
    }
    //处理腾讯内容
    if (stristr($long, "xw.qq.com/")) {
        $html = str_replace('<head>', '<head><meta http-equiv=Content-Type content="text/html;charset=utf-8">', $html);
        $html = str_replace('<!-- content/S -->', '<div id=icontent>', $html);
        $html = str_replace(' <!-- content/E -->', '</div>', $html);
    }
    $html = str_replace('data-src', 'src', $html);
    $vid = cut($html, 'vid=', '&'); //获取视频ID
    //$vid=substr($vid,0,11);
    //echo $vid;
    //	die;
    if (stristr($long, "mp.weixin.qq.com")) {
        $caiji = array("title" => array(".rich_media_title:first", "text"), "content" => array("#js_content", "html"), "body" => array("body", "html"), "gongzhonghao" => array(".rich_media_meta_link", "text"), "ywyuedu" => array("#js_toobar3", "html"),);
    } elseif (stristr($long, "toutiao.com")) {
        $caiji = array("title" => array(".article-title", "text"), "content" => array(".article-content", "html"), "gongzhonghao" => '今日头条', "ywyuedu" => 10000,);
    } elseif (stristr($long, "zh.wikiomni.com")) {
        $rules = array("title" => array(".article-title", "text"), "content" => array(".contents", "html"),);
    } elseif (stristr($long, "inews.ifeng.com")) {
        $caiji = array("title" => array(".acTxtTit h1", "text"), "content" => array(".acTx", "html"), "gongzhonghao" => "手机凤凰", "ywyuedu" => 10000,);
        $html = str_replace('data-original', 'src', $html);
    } elseif (stristr($long, "view.inews.qq.com")) {
        $caiji = array("title" => array(".title:first", "text"), "content" => array("#content", "html"), "gongzhonghao" => "腾讯娱乐", "ywyuedu" => 10000,);
    } elseif (stristr($long, "xw.qq.com/")) {
        $caiji = array("title" => array(".title:first", "text"), "content" => array("#icontent", "html"), "gongzhonghao" => "腾讯新闻", "ywyuedu" => 10000,);
    } else {
        $caiji = array("title" => array("title", "text"), "content" => array("body", "html"), "gongzhonghao" => "精选", "ywyuedu" => 10000,);
    }
    if (stristr($long, "zh.wikiomni.com")) {
        function getHtml($url)
        {
            $UserAgent = 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Mobile/9B176 MicroMessenger/4.3.2';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, 0); //0表示不输出Header，1表示输出
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_ENCODING, '');
            curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            $contents = curl_exec($curl);
            curl_close($curl);
            return $contents;
        }

        $html = getHtml($long);
        $hj = QueryList::Query($html, $rules);
        $arr = $hj->jsonArr;
        $title = urlencode($arr[0]['title']);
        $content = preg_replace("/<(\/?i?frame.*?)>/si", "", $arr[0]['content']); //过滤frame标签
        $content = str_replace('https', 'http', $arr[0]['content']); //过滤frame标签
        $sqlad = "select * from tbl_ad where id = " . $_POST['adid'];
        $queryad = mysql_query($sqlad);
        $rowad = mysql_fetch_array($queryad);
        $ifPublicNumber = trim($_POST['ifgongzhonghao']);
        $adquanping = trim($_POST['adquanping']);
        $zhedie = trim($_POST['zhedie']);
        $qptime = trim($_POST['qptime']);
        $ispl = trim($_POST['ispl']);
        if ($rowad['wechat_url'] != "") {
            $long = $rowad['wechat_url'];
        }
        if ($rowad['wechat_name'] != "") {
            $gongzhonghao = $rowad['wechat_name'];
        }
        $sql = "insert into tbl_info values (0,'" . urldecode($title) . "','" . addslashes($content) . "','" . $rowad['ad_img'] . "','" . $rowad['ad_img_one'] . "','" . $rowad['ad_img_two'] . "','" . $rowad['ad_link'] . "','" . $_COOKIE['username'] . "',0,0,'" . date('Y-m-d') . "','" . $rowad['adtelnumber'] . "','" . $rowad['adqqnumber'] . "','" . $ifadtop . "','" . $gongzhonghao . "','" . $ifPublicNumber . "','" . $rowad['erweima'] . "','" . $ywyuedu . "','" . $infoid . "','" . $daili . "','" . $sharepic . "','" . $sharedesc . "','" . $adquanping . "','" . (int)$_POST['adid'] . "','" . (int)$_POST['music'] . "','" . (int)$_POST['autoplay'] . "','" . $rowad['gzurl'] . "','" . $zhedie . "','" . $qptime . "','" . $long . "','" . $ispl . "','" . $is_quanping2 . "',0)";
        mysql_query($sql);
        echo "<script type='text/javascript'>alert('\u53d1\u5e03\u6210\u529f\uff01');location.href='fxedit.php?fid=" . $infoid . "';</script>";
    }
    $quyu = '';
    $html = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>" . $html;
    $hj = QueryList::Query($html, $caiji, $quyu);
    $arr = $hj->jsonArr;
    $title = urlencode($arr[0]['title']);
    $gongzhonghao = $arr[0]['gongzhonghao'];
    $ywyuedu = $arr[0]['ywyuedu'];
    $body = $arr[0]['body'];
    $content = preg_replace("/<(\/?i?frame.*?)>/si", "", $arr[0]['content']); //过滤frame标签
    $content = str_replace('https', 'http', $arr[0]['content']); //过滤frame标签
    $content = str_replace("🌈", "", $content);
    $content = str_replace("&#39;", "'", $content);
    $content = str_replace("&quot;", '"', $content);
    $content = str_replace("&nbsp;", " ", $content);
    $content = str_replace("&gt;", ">", $content);
    $content = str_replace("&lt;", "<", $content);
    $content = str_replace("&amp;", "&", $content);
    $content = str_replace("&yen;", "¥", $content);
    $content = str_replace("https", "http", $content);
    $content = preg_replace("/<(\/?i?frame.*?)>/si", "", $arr[0]['content']); //过滤frame标签
    $shareimage = cut($body, 'var msg_cdn_url = "', '"'); // 分享图标
    $sharedesc = cut($body, 'var msg_desc = "', '"'); // 过滤描述
    $shareimage = str_replace('http://mmbiz', 'image_proxy.php?1=1&siteid=1&url=http://mmbiz', $shareimage);
    $sharepic = $shareimage;
    if ($vid !== '') {
        $content = "<p id='shipin'><iframe id='aaa' height=300 width=100% src=\"http://v.qq.com/iframe/player.html?vid={$vid}&auto=0\" frameborder=0 allowfullscreen></iframe></p>" . $content;
    }
    $pic = cut($html, 'var msg_cdn_url = "', '"');
    if (url_exists($long) == 1) {
        echo "<script>alert('\u7f51\u5740\u4e0d\u5b58\u5728');location.href='index.php'</script>";
        exit;
    }
    $sqlad = "select * from tbl_ad where id = " . $_POST['adid'];
    $queryad = mysql_query($sqlad);
    $rowad = mysql_fetch_array($queryad);
    $ifPublicNumber = trim($_POST['ifgongzhonghao']);
    $adquanping = trim($_POST['adquanping']);
    $zhedie = trim($_POST['zhedie']);
    $qptime = trim($_POST['qptime']);
    $ispl = trim($_POST['ispl']);
    $is_quanping2 = trim($_POST['is_quanping2']);
    //$ywyuedu='qq';
    //$sql = "insert into tbl_info values (0,'".$title."','".addslashes($content)."','".$rowad['ad_img']."','".$rowad['ad_link']."','".$_COOKIE['username']."',0,0,'".date('Y-m-d H:i:s')."')";
    if ($rowad['wechat_url'] != "") {
        $long = $rowad['wechat_url'];
    }
    if ($rowad['wechat_name'] != "") {
        $gongzhonghao = $rowad['wechat_name'];
    }
    $sql = "insert into tbl_info values (0,'" . urldecode($title) . "','" . addslashes($content) . "','" . $rowad['ad_img'] . "','" . $rowad['ad_img_one'] . "','" . $rowad['ad_img_two'] . "','" . $rowad['ad_link'] . "','" . $_COOKIE['username'] . "',0,0,'" . date('Y-m-d') . "','" . $rowad['adtelnumber'] . "','" . $rowad['adqqnumber'] . "','" . $ifadtop . "','" . $gongzhonghao . "','" . $ifPublicNumber . "','" . $rowad['erweima'] . "','" . $ywyuedu . "','" . $infoid . "','" . $daili . "','" . $sharepic . "','" . $sharedesc . "','" . $adquanping . "','" . (int)$_POST['adid'] . "','" . (int)$_POST['music'] . "','" . (int)$_POST['autoplay'] . "','" . $rowad['gzurl'] . "','" . $zhedie . "','" . $qptime . "','" . $long . "','" . $ispl . "','" . $is_quanping2 . "',0)";
    mysql_query($sql);
    echo "<script type='text/javascript'>alert('\u53d1\u5e03\u6210\u529f\uff01');location.href='fxedit.php?fid=" . $infoid . "';</script>";
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="dns-prefetch" href="//res.wx.qq.com">
    <link rel="dns-prefetch" href="//mmbiz.qpic.cn">
    <title>分享文章 - <?php echo $cfg_webname ?></title>
    <meta name="referrer" content="never">
    <meta name="description" content=""/>
    <meta name="viewport"
          content="width=device-width , initial-scale=1.0 , user-scalable=0 , minimum-scale=1.0 , maximum-scale=1.0"/>
    <link rel="stylesheet" href="css/css.css">
    <style type="text/css">
        .bot_main li.ico_1 {
            background: #F1901F;
        }
    </style>
    <script type='text/javascript' src='js/jquery-2.0.3.min.js'></script>
    <script type='text/javascript' src='js/patch/mobileBUGFix.mini.js'></script>
    <script type='text/javascript' src='js/swipeSlide.min.js'></script>
    <script type='text/javascript' src='js/jquery.cookie.min.js'></script>
    <script type="text/javascript">
        //##################未点击分类菜单加载信息
        $(function () {
            $.ajax({
                url: 'caiji.php',
                data: "cjid=pc_0",
                type: "post",
                cache: false,
                beforeSend: function () {
                    $(".cjlist").html("<span class='loading'><img src='images/loading.gif' width='81' height='78'></span>")
                },
                success: function (data) {
                    $(".cjlist").html(data)
                },
                error: function () {
                    $(".cjlist").html("信息加载失败!")
                }
            })
        });
        $(function () {
            $(".cjclas").click(function () {
                var cjclasid = "cjid=" + $(this).attr("id");
                $.ajax({
                    url: 'caiji.php',
                    data: cjclasid,
                    type: "post",
                    cache: false,
                    beforeSend: function () {
                        $(".cjlist").html("<span class='loading'><img src='images/loading.gif' width='81' height='78'></span>")
                    },
                    success: function (data) {
                        $(".cjlist").html(data)
                    },
                    error: function () {
                        $(".cjlist").html("信息加载失败!")
                    }
                })
            })
        });
        $(document).ready(function () {
            $(".qqcopyurl").click(function () {
                var fburl = $(this).attr("id");
                $("#wxlink").val(fburl);
                $("#sswxlink").html(fburl);
                $("html,body").animate({
                        scrollTop: $("#wxlink").offset().top
                    },
                    1000)
            })
        });
    </script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
        .new_btn {
            font-size: 0.7em;
            margin: 2px;
            color: #F00;
            border: 1px solid #FFF;
            border-radius: 3px;
            background-color: #FFF;
            line-height: 22px;
            height: 22px;
            padding: 2px;
        }

        .zhankaibtn {
            text-align: center;
            padding: 3px;
            width: 150px;
            background-color: #F0F0F0;
            color: #666666;
        }

        .shouqibtn {
            text-align: center;
            padding: 3px;
            width: 150px;
            background-color: #F0F0F0;
            color: #666666;
        }

        span.ydl {
            display: block;
            font-size: 12px;
            color: #999;
            padding-top: 0px;
            line-height: 25px;
        }

        /* 焦点图*/
        .slideBox {
            position: relative;
            overflow: hidden;
            margin: 10px auto;
            max-width: 640px;
            /* 设置焦点图最大宽度*/
        }

        .slideBox .hd {
            position: absolute;
            height: 28px;
            line-height: 28px;
            bottom: 0;
            right: 0;
            z-index: 1;
        }

        .slideBox .hd li {
            display: inline-block;
            width: 5px;
            height: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            background: #333;
            text-indent: -9999px;
            overflow: hidden;
            margin: 0 6px;
        }

        .slideBox .hd li.on {
            background: #34c751;
        }

        .slideBox .bd {
            position: relative;
            z-index: 0;
        }

        .slideBox .bd li {
            position: relative;
            text-align: center;
        }

        .slideBox .bd li img {
            background: url(images/loading.gif) center center no-repeat;
            vertical-align: top;
            width: 100%;
            /* 图片宽度100%，达到自适应效果*/
        }

        .slideBox .bd li a {
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        /* 去掉链接触摸高亮*/
        .slideBox .bd li .tit {
            display: block;
            width: 100%;
            position: absolute;
            bottom: 0;
            text-indent: 10px;
            height: 28px;
            line-height: 28px;
            background: url(images/focusBg.png) repeat-x;
            color: #fff;
            text-align: left;
        }
    </style>
</head>
<body>
<div class="apply" id="apply">
    <p style="text-align:left;padding-left:10px;">发布文章

        <!-- 隐藏 -->
        <span style="visibility: hidden;float:right;font-size:0.7em;margin-right:10px; line-height:22px">
		账户:<a><?php echo $_COOKIE['username']; ?>&nbsp;</a>
            <?php if (empty($maiguo['id'])) { ?>
                <a href="vip.php" class="new_btn">点击充值</a>
            <?php } else { ?>
                VIP <a href="vip.php" class="new_btn">点击充值</a>
            <?php } ?>
            <br>
		<a>剩余文章:<?= $s ?>&nbsp;&nbsp;天数:<?= $tt ?>天</a></span>
        <!-- 隐藏 -->


    </p>
    <form action="?act=add" id="signupok" method="post" name="addform" enctype="multipart/form-data">
        <input type="hidden" name="artid" value="<?php echo time() . rand(10, 1000); ?>"/>
        <input type="hidden" name="sharepic" id="sharepic">
        <input type="hidden" name="sharedesc" id="sharedesc">
        <input type="hidden" name="type" value="1"/>
        <dl class="clearfix">
            <dd class="inptmain">
				<span class="link_inpt">
					<input type="text" id="wxlink" value="" name="wxlink" placeholder="请输入原文链接">
				</span>
                <span class="btnss">
					<input type="button" name="signup" value="点击分享" onclick="return postcheck();">
				</span>
            </dd>
        </dl>
        <dl class="clearfix" style="display:none">
            <dd>联系电话：</dd>
            <dd>
                <input type="hidden" class="input_txt" id="telnumber" value="13899999999" name="telnumber"
                       placeholder="请输入电话号码">
            </dd>
        </dl>
        <div id="more" style="display:block">


            <dl class="clearfix" style="display: none">
                <dd>
                    <select class="input_txt sel" name="adid">
<!--                        <option value="">请选择广告</option>-->
                        <?
                        $sql = "select * from tbl_ad where userid = '" . $_COOKIE['userid'] . "' ORDER by id DESC";
                        $query = mysql_query($sql);
                        while ($row = mysql_fetch_array($query)) {
                            ?>
                            <option value="<?= $row['id'] ?>"><?= $row['ad_title'] ?></option>
                            <?
                        }
                        ?>
                    </select>
                </dd>
            </dl>


            <dl class="clearfix">
                <dd style="display: none">
                    <select class="input_txt" id="musiccat" name="musiccat" style="width:49%;border: #99CC33 1px solid;">
                        <option value="">选择音乐分类</option>
                    </select>
                    <select class="input_txt" name="music" id="music" style="width:49%;border: #99CC33 1px solid;" onChange="showUser(this.value)">
                        <option value="">选择音乐分类</option>
                    </select>
                </dd>

                <dl class="clearfix" style="display: none">
                    <dd><font color="#f00">广告位置：</font><br>
                        <input class="rad" type="radio" name="adweizhi" value="0" data-labelauty="顶部悬浮"/>
                        <input class="rad" name="adweizhi" type="radio" value="1" data-labelauty="底部悬浮"/>
                        <input class="rad" name="adweizhi" type="radio" value="4" data-labelauty="顶底悬浮"/><br>
                        <input class="rad" name="adweizhi" type="radio" value="5" data-labelauty="顶部固定"/>
                        <input class="rad" name="adweizhi" type="radio" value="2" data-labelauty="底部固定"/>
                        <input class="rad" name="adweizhi" type="radio" value="6" data-labelauty="顶底固定"/><br>
                        <input class="rad" name="adweizhi" type="radio" value="8" data-labelauty="跑马灯[顶]"/>
                        <input class="rad" name="adweizhi" type="radio" value="3" data-labelauty="跑马灯[底]"/><br>
                        <input class="rad" name="adweizhi" type="radio" id="adweizhibtm" value="7" checked="CHECKED" data-labelauty="顶部固定、底部悬浮"/>
                    </dd>
                    <dd>
                        <span style=" color:#f00; float:left">全屏广告：</span>
                        <input onClick="qpShow();" class="rad" type="radio" name="adquanping" value="1" id="adquanping" class="radioItem" data-labelauty="显示"/>
                        <input onClick="qpHide();" class="rad" name="adquanping" type="radio" id="adquanping2" value="0" checked="CHECKED" class="radioItem" data-labelauty="隐藏"/>
                    </dd>
                    <dd class="quanpingtime" style="display:none; padding-left:20px;">
                        <span style=" color:#f00; float:left">全屏时间：</span>
                        <input class="rad" type="radio" name="qptime" value="3" id="qptime" class="radioItem" data-labelauty="3秒"/>
                        <input class="rad" name="qptime" type="radio" value="5" checked="CHECKED" class="radioItem" data-labelauty="5秒"/>
                        <input class="rad" name="qptime" type="radio" value="7" class="radioItem" data-labelauty="7秒"/>
                    </dd>
                    <dd class="is_quanping2" style="display:none; padding-left:20px">
                        <span style=" color:#f00; float:left">全屏后顶部广告：</span>
                        <input class="rad" name="is_quanping2" type="radio" value="1" class="radioItem" data-labelauty="显示"/>
                        <input class="rad" name="is_quanping2" type="radio" value="0" checked="CHECKED" class="radioItem" data-labelauty="隐藏"/>
                    </dd>
                    <o id='morexx' style='display:none'>
                        <dd>
                            <font color="#f00" style="float:left">背景音乐：</font>
                            <input class="rad" name="autoplay" type="radio" value="1" data-labelauty="自动播"/>
                            <input class="rad" name="autoplay" type="radio" value="0" checked="CHECKED" data-labelauty="手动播"/>
                        </dd>
                        <dd><span style=" color:#F00; float:left">公众号：</span>
                            <input class="rad" type="radio" name="ifgongzhonghao" value="1" checked="CHECKED" data-labelauty="显示"/>
                            <input class="rad" name="ifgongzhonghao" type="radio" value="0" data-labelauty="隐藏"/>
                        </dd>
                        <dd><span style="color:#F00; float:left">文章太长折叠：</span>
                            <input class="rad" type="radio" name="zhedie" value="1" data-labelauty="开启"/>
                            <input class="rad" name="zhedie" type="radio" value="0" checked="CHECKED" data-labelauty="关闭"/>
                        </dd>
                        <dd><span style="color:#F00; float:left">开启文章评论：</span>
                            <input class="rad" type="radio" name="ispl" value="1" data-labelauty="开启"/>
                            <input class="rad" name="ispl" type="radio" value="0" checked="CHECKED" data-labelauty="关闭"/>
                        </dd>
                    </o>
                    <div style="width:100%; text-align:center">
                        <span id="zhankaibtn" style="display:block">∨更多选项</span>
                        <span id="shouqibtn" style="display:none;">∧点击收起</span>
                    </div>
                </dl>

                <div class="blank10"></div>

                <div class="btn_box" style="display: none;">
                    <input type="button" name="signup" class="button" value="直接编写文章" onClick="window.open('add_article.php');" style="width:32%;height:30px;line-height:30px; background-color:#66CCFF; font-size:14px" align="left">
                    <input type="button" name="signup" class="button" value="购买会员" onClick="window.open('vip.php');" style="width:32%;height:30px;line-height:30px;background-color:#66CCFF; font-size:14px" align="left">
                    <input type="button" name="signup" class="button" value="联系客服" onClick="window.open('kefu.php');" style="width:32%;height:30px;line-height:30px;background-color:#66CCFF; font-size:14px" align="left">
                </div>

                <dd style="color:#F1901F; font-size:12px;line-height:30px;  margin-top:6px; height:30px; border-top:#ccc 1px solid; display: none;">
                    声明：禁止发布黄赌毒以及违反任何国家相关法律法规的信息
                </dd>
            </dl>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="display: none;margin-bottom: 15px;">
                <tr>
                    <td align="center"><a href="http://weixin.sogou.com/"><img src="images/ico1.png" width="59"
                                                                               height="59" border="0"></a></td>
                    <td align="center"><a href="http://xw.qq.com/m/news/index.htm"><img src="images/ico2.png" width="59"
                                                                                        height="59" border="0"></a></td>
                    <td align="center"><a href="http://m.toutiao.com/?W2atIF=1"><img src="images/ico3.png" width="59"
                                                                                     height="59" border="0"></a></td>
                    <td align="center"><a href="http://inews.ifeng.com/"><img src="images/ico4.png" width="59"
                                                                              height="59" border="0"></a></td>
                </tr>
            </table>
        </div>
        <div align="center">
        </div>
        <script src="js/jquery-labelauty.js"></script>
        <link rel="stylesheet" href="css/jquery-labelauty.css">
        <script language="javascript">
            $(document).ready(function () {
                if ($.cookie('adweizhi') != null && $.cookie('adweizhi') != 'undefined') {
                    cweizhi = $.cookie('adweizhi');
                    $("input[name='adweizhi'][value=" + cweizhi + "]").attr("checked", true);
                }
            });
            $(document).ready(function () {
                $("#zhankaibtn").click(function () {
                    $("#morexx").show();
                    $("#zhankaibtn").hide();
                    $("#shouqibtn").show();
                })
                $("#shouqibtn").click(function () {
                    $("#morexx").hide();
                    $("#zhankaibtn").show();
                    $("#shouqibtn").hide();
                })
            });
            $(function () {
                $(':input').labelauty();
            });

            function qpShow() {
                $(".quanpingtime").show();
                $(".is_quanping2").show();
            }

            function qpHide() {
                $(".quanpingtime").hide();
                $(".is_quanping2").hide();
            }
        </script>
        <div class="cjfenlei"><a id="pc_0" class="cjclas" href="javascript:void(0);">热门</a> <a id="pc_1" class="cjclas"
                                                                                               href="javascript:void(0);">推荐</a>
            <a id="pc_2" class="cjclas" href="javascript:void(0);">段子</a> <a id="pc_3" class="cjclas"
                                                                             href="javascript:void(0);">养生</a> <a
                    id="pc_4" class="cjclas" href="javascript:void(0);">私房</a> <a id="pc_5" class="cjclas"
                                                                                  href="javascript:void(0);">八卦</a> <a
                    id="pc_6" class="cjclas" href="javascript:void(0);">生活</a> <a id="pc_7" class="cjclas"
                                                                                  href="javascript:void(0);">财经</a> <a
                    id="pc_8" class="cjclas" href="javascript:void(0);">汽车</a> <a id="pc_9" class="cjclas"
                                                                                  href="javascript:void(0);">科技</a> <a
                    id="pc_10" class="cjclas" href="javascript:void(0);">潮人</a> <a id="pc_11" class="cjclas"
                                                                                   href="javascript:void(0);">辣妈</a> <a
                    id="pc_12" class="cjclas" href="javascript:void(0);">点赞</a> <a id="pc_13" class="cjclas"
                                                                                   href="javascript:void(0);">旅行</a> <a
                    id="pc_14" class="cjclas" href="javascript:void(0);">职场</a> <a id="pc_15" class="cjclas"
                                                                                   href="javascript:void(0);">美食</a> <a
                    id="pc_16" class="cjclas" href="javascript:void(0);">古今</a> <a id="pc_17" class="cjclas"
                                                                                   href="javascript:void(0);">学霸</a> <a
                    id="pc_18" class="cjclas" href="javascript:void(0);">星座</a> <a id="pc_19" class="cjclas"
                                                                                   href="javascript:void(0);">体育</a> <a
                    id="pc_20" class="cjclas" href="http://weixin.sogou.com/?p=73141200&kw=">更多</a></div>
        <!--
        <dl class="clearfix">
            <dd>广告链接：</dd>
            <dd><input type="tel" class="input_txt" value="" name="adlink" id="adlink" placeholder="请输入广告链接" style="height:50px;">
            </dd>
        </dl>
        <dl class="clearfix">
            <dd>广告图片：</dd>
            <dd><input type="file" class="input_txt" type="file"  placeholder="选择上传广告图片" name="upfile" style="width: 100%;height:50px;box-sizing: border-box;padding: 14px;color: #696969;font-size: 12px;line-height: 12px;border: #e6e6e6 1px solid;background: #fff;"></dd>
        </dl>
        -->
        <div class="cjcontlist">
            <ul class="cjlist">
            </ul>
        </div>
        <div class="blank10"></div>
    </form>
</div>
<? include('foot.php'); ?>
<script type="text/javascript">
    $("#musiccat").change(function () {
        var id = $("#musiccat").val();
        if (id != '') {
            $('#music').html('<option value="">请选择音乐</option>');
            $.ajax({
                url: location.href,
                data: {
                    catid: id
                },
                type: 'get',
                async: true,
                success: function (res) {
                    $('#music').append(res);
                }
            });
        }
    });

    function postcheck() {
        if (document.addform.wxlink.value == "") {
            alert('请填写原文链接！');
            document.addform.wxlink.focus();
            return false;
        }
        if (document.addform.adid.value == "") {
            alert('请选择广告！');
            document.addform.adid.focus();
            return false;
        }
        if (document.addform.telnumber.value == "") {
            alert('请输入电话号码！');
            document.addform.adid.focus();
            return false;
        }
        var wxurl = document.addform.wxlink.value; //获取Windowstext文本框的值
        var $t = wxurl.replace("https", "http");
        $('#wxlink').val($t);
        adweizhi = $("input[name='adweizhi']:checked").val();
        $.cookie('adweizhi', adweizhi, {
            expires: 7
        });
        document.addform.submit();
        return true;
    }
</script>
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
