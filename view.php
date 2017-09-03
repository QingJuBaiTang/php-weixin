<?php
define('IN_XD', true);
session_start();
require("include/common.inc.php");
require("include/Wxjs.class.php");
$action = 0;
$action = trim($_POST['action']);
if ($action == 'zan') {
    $iid = trim($_POST['iid']);
    $jjf = trim($_POST['jjf']);
    if ($jjf == '+') {
        $sql = "update tbl_info set zan=zan+1 where id=" . $iid;
    } else {
        $sql = "update tbl_info set zan=zan-1 where id=" . $iid;
    }
    echo mysql_query($sql);
    exit();
}

$sql = "select * from tbl_param_config limit 0,1";
$res = mysql_query($sql);
$data = mysql_fetch_assoc($res);
$Wxjs = new Wxjs($data['appid'], $data['appsecret']);
$shareScript = $Wxjs->getShareScript();
$infoid = trim($_GET['fid']);
$sqld = "select * from tbl_site  where id=1";
$queryd = mysql_query($sqld);
$rowd = mysql_fetch_array($queryd);
$fxdomains = explode("|", $rowd['fxdomain']);
$suijishu = mt_rand(0, count($fxdomains) - 1);

if (!empty($fxdomains[$suijishu])) {
    $fxdomain = 'http://' . $fxdomains[$suijishu];
} else {
    $fxdomain = 'http://' . $_SERVER['SERVER_NAME'];
}

if (is_numeric($infoid)) {
    $sql = "select * from tbl_info where infoid = " . $infoid;
    $query = mysql_query($sql);
    $row = mysql_fetch_array($query);
    $sql = "select * from tbl_ad where id = " . $row['adid'];
    $query = mysql_query($sql);
    $rowad = mysql_fetch_array($query);
    if ($row['telnum'] != "") {
        $telnum .= '<a href="tel:' . $row['telnum'] . '" class="" style="width: 35px;height: 35px;padding-top: 5px;"><img src="/images/phone.png" style="width: 35px;height: 35px" data-bd-imgshare-binded="1"></a>';
    } else {
        $telnum = "";
    }
    if (!empty($row['qrcode'])) {
        $telnum .= '<a data-dialog="somedialog"  class="" style="width: 35px;height: 35px;padding-top: 5px;"><img src="/images/wechat.png" style="width: 35px;height: 35px" data-bd-imgshare-binded="1"></a>';
    }
    if ($row['qqnum'] != "") {
        $telnum .= '<a href="http://wpa.qq.com/msgrd?v=3&uin=' . $row['qqnum'] . '&site=qq&menu=yes" class="" style="width: 35px;height: 35px;padding-top: 5px;"><img src="/images/qq.png" style="width: 35px;height: 35px" data-bd-imgshare-binded="1"></a>';
    }
    if ($rowad['adlbs'] != "") {
        $telnum .= '<a href="' . $rowad['adlbs'] . '" class="" style="width: 35px;height: 35px;padding-top: 5px;"><img src="/images/lbs.png" style="width: 35px;height: 35px" data-bd-imgshare-binded="1"></a>';
    }
    $sql = "update tbl_info set wcount=wcount+1 where infoid=" . $infoid;
    mysql_query($sql);
} else {
    echo "<script type='text/javascript'>alert('\u6587\u7ae0\u4e0d\u5b58\u5728\uff01');history.go(-1);</script>";
    exit;
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no"/>
    <link rel="dns-prefetch" href="//res.wx.qq.com"/>
    <link rel="dns-prefetch" href="//mmbiz.qpic.cn"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no"/>
    <title><?php echo urldecode($row['title']); ?></title>
    <link rel="stylesheet" type="text/css" href="css/css_view.css"/>
    <link rel="stylesheet" type="text/css" href="css/view2.css"/>
    <link rel="stylesheet" type="text/css" href="css/amazeui.min.css"/>
    <script type="text/javascript" src="js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="js/patch/jquery.js"></script>
    <script type="text/javascript" src="js/patch/jquery.banner.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/dialog/dialog.css"/>
    <link rel="stylesheet" type="text/css" href="/css/dialog/dialog-sally.css"/>
    <script type="text/javascript" src="/js/dialog/modernizr.custom.js"></script>
    <script type="text/javascript" src="js/v.js"></script>
    <meta name="referrer" content="never">
    <script>
        $(function () {
            var pattern = /^http:\/\/mmbiz/;
            var prefix = 'http://<? echo $_SERVER['SERVER_NAME']; ?>/image_proxy2.php?1=1&siteid=1&url=';
            $("img").each(function () {
                var src = $(this).attr('src');
                if (pattern.test(src)) {
                    if (src.indexOf('mmbiz_png') != -1) {
                        src = src.replace('tp=webp', 'tp=gif');
                    }
                    var newsrc = prefix + src;
                    $(this).attr('src', newsrc);
                }
            });
        });
    </script>
    <?php
    if ($row['zhedie'] != 0) { ?>
        <script>
            $(document).ready(function () {
                var content_height = $('#js_content').height();
                if (content_height > 700) {
                    $('#js_content').css('height', '700px');
                    $('#js_content').after('<div id="showallbtn" style="width:120px;height:30px;line-height:30px;text-align:center;margin:0 auto;border-radius:10px;color:#4C9AEA;border:1px solid #4C9AEA;margin-top:20px;margin-bottom:20px;">展开全文 ∨</div>')
                    $('#showallbtn').click(function () {
                        $('#js_content').removeAttr('style');
                        $(this).remove();
                    })
                }
            });
        </script>
    <?php } ?>
</head>

<body id="activity-detail" class="zh_CN ">
<!--默认分享图标开始 -->
<div style='margin:0 auto;width:0px;height:0px;overflow:hidden;'>
    <img src="<?= empty($row['share_pic']) ? '' : 'http://' . $_SERVER['HTTP_HOST'] . '/' . $row['share_pic'] ?>"
         width="700"/>
</div>
<!--默认分享图标结束 -->

<!--默认广告比例标准 -->
<div style="display:none">
    <?php if ($rowad['ad_img'] != '') { ?> <img id='adbz' src="<?= $rowad['ad_img'] ?>"/>  <?php } ?>
</div>

<div id="allcontent">
    <!--文章内容开始-->
    <div class="rich_media " style="padding:15px 10px">
        <div class="rich_media_inner" style="padding:0px">
            <h2 class="rich_media_title" id="activity-name"
                style="margin-top:0px;"><?php echo urldecode($row['title']); ?></h2>
            <div class="rich_media_meta_list">
                <em id="post-date" class="rich_media_meta rich_media_meta_text"><?php echo $row['addtime'] ?></em>
                <?php if ($row['ifPublicNumber'] == 1) { ?>
                    <a class="rich_media_meta rich_media_meta_link rich_media_meta_nickname"
                       href="<?php echo $row['url2'] ?>" id="post-user">
                        <?= $row['gongzhonghao'] ?>
                    </a>
                <?php } ?>
            </div>
        </div>

        <!-- 顶部悬浮跑马灯 -->
        <div class="topad" id="topadPmd" style="display: block;">
            <div class="str1 str_wrap" id="tPmd" style="width:100%;left:0px;bottom:0px;height:65px;line-height:65px;vertical-align:middle;font-size:38px;font-weight:900;color:#fff;background-image: url('images/bottom.jpg')">
                <a href="javascript:adClick(<?= $row['id'] ?>,'<?= $rowad['ad_link'] ?>');"><?= $rowad['pmd'] ?></a>
            </div>
        </div>
        <link rel="stylesheet" href="css/liMarquee.css">
        <script src="js/jquery.liMarquee.js"></script>
        <script>
            $(window).load(function () {
//                    menuFixed('topadPmd');//是否悬浮
                $('#tPmd').liMarquee();
            });
        </script>
        <!-- 顶部悬浮跑马灯结束 -->

        <div id="page-content" class="layout">
            <div id="img-content">
                <div class="rich_media_content article-content" id="js_content">
                    <?php echo $row['content']; ?>
                    <font style="font-size:12px; float:right; padding-right:5px">本页面内容来源于网络，如有侵权，请告知删除!</font>
                </div>
                <!--二维码弹窗内容开始-->
                <?php if ($row['qrcode'] != '') { ?>
                    <div id="somedialog" class="dialog">
                        <div class="dialog__overlay"></div>
                        <div class="dialog__content">
                            <img src="<?= $row['qrcode'] ?>" style="max-width:270px; max-height:270px">
                            <p>长按二维码扫描 添加好友</p>
                            <div>
                                <button class="action" data-dialog-close>关闭</button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!--二维码弹窗内容开始-->
                <div class="rich_media_tool" id="js_toobar3" style="display: block;">
                    <div id="js_read_area3" class="media_tool_meta tips_global meta_primary"
                         style="display:block;color:#8c8c8c!important; font-family:'宋体'; padding-left:9px">
                        阅读 <font id="viewsum"><?= $row['wcount'] ?></font> &nbsp;<img id='zanpic' f='0'
                                                                                      src="/images/zan1.png" width="15"
                                                                                      style="vertical-align:baseline; padding:0"
                                                                                      onClick="zan(<?= $row['id'] ?>);">
                        <font id="zansum"><?= $row['zan'] ?></font>
                    </div>
                    <a id="js_report_article3" style="display:block;color:#8c8c8c!important;"
                       class="media_tool_meta tips_global meta_extra"
                       href="complain.php?fid=<?= $row['infoid'] ?>">投诉</a>
                </div>
            </div>
        </div>
        <div id="js_pc_qr_code" class="qr_code_pc_outer" style="display: block;">
            <div class="qr_code_pc_inner">
                <div class="qr_code_pc">
                    <script type="text/javascript">/* 2016/09/08 18:53 */
                        var _qrContent = '', _qrLogo = '', _qrWidth = 100, _qrHeight = 100, _qrType = 'auto';
                        if (!_qrContent) var _qrContent = escape(document.location.href);
                        document.write(unescape("%3Cscript src='http://qrcode.leipi.org/js.html?qw=" + _qrWidth + "&qh=" + _qrHeight + "&qt=" + _qrType + "&qc=" + escape(_qrContent) + "&ql=" + escape(_qrLogo) + "' type='text/javascript'%3E%3C/script%3E"));</script>
                    <p>微信扫一扫<br/> 分享到朋友圈</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if ($row['ispl'] == 1) {
    ?>
    <!--WAP版 评论框-->
    <?php echo $cfg_pinglun ?>
    <?php
}
?>

<!--底部悬浮开始 -->
<div id="bXfH"></div> <!--底部悬浮间隔 -->
<div class="app-guide1 adweix " id="bannerDowm" style="display:block">
    <div class="am-text-right">
        <?php echo $telnum; ?>
        <a href="javascript:;" class="" style="width: 35px;height: 35px;padding-top: 5px;"> <img
                    src="images/close.png" style="width: 35px;height: 35px" onClick="hideYt('bannerDowm','bXfH');"
                    data-gjalog="index_bottom_banner_close@atype=click" data-bd-imgshare-binded="1"/> </a>
    </div>
    <div class="banner" id='bXf'>
        <ul class="banList">
            <?php if ($rowad['ad_img'] != '') { ?>
                <li class="active"><a href="javascript:adClick(<?= $row['id'] ?>,'<?= $rowad['ad_link'] ?>');"><img
                                class="bannerImg" src="<?= $rowad['ad_img'] ?>"/></a></li>   <?php } ?>
            <?php if ($rowad['ad_img_one'] != '') { ?>
                <li><a href="javascript:adClick(<?= $row['id'] ?>,'<?= $rowad['ad_link'] ?>');"><img
                                class="bannerImg" src="<?= $rowad['ad_img_one'] ?>"/></a></li>  <?php } ?>
            <?php if ($rowad['ad_img_two'] != '') { ?>
                <li><a href="javascript:adClick(<?= $row['id'] ?>,'<?= $rowad['ad_link'] ?>');"><img
                                class="bannerImg" src="<?= $rowad['ad_img_two'] ?>"/></a></li>  <?php } ?>
        </ul>
        <div class="fomW">
            <div class="jsNav">
                <?php if ($rowad['ad_img'] != '') { ?><a href="javascript:;"
                                                         class="trigger current"></a>  <?php } ?>
                <?php if ($rowad['ad_img_one'] != '') { ?><a href="javascript:;" class="trigger"></a>  <?php } ?>
                <?php if ($rowad['ad_img_two'] != '') { ?><a href="javascript:;" class="trigger"></a>  <?php } ?>
            </div>
        </div>
    </div>
</div>
<!--底部悬浮结束 -->

<script type="text/javascript">
    function hideYt(id1, id2) {
        $("#" + id1).hide();
        $("#" + id2).hide();
    }

    $(function () {
//获取广告标准比例adbz
        var realWidth;
        var realHeight;
        $("<img/>").attr("src", $("#adbz").attr('src')).load(function () {
            realWidth = this.width;
            realHeight = this.height;
            bili = realWidth / realHeight;
            $(".bannerImg").each(function () {
                //给每个.banner赋高度 广告宽高比3.5
                $(this).height(($(this).width()) / bili)//修改广告高度自适应
            });
            $(".banner").each(function () {
                //给每个.banner赋高度 广告宽高比3.5
                $(this).css("height", ($(this).width()) / bili)//修改广告高度自适应
                $(this).swBanner();
            });
        });
//底部悬浮设置间隔高度	  
        <?php if($row['ifweizhi'] == 1 || $row['ifweizhi'] == 4 || $row['ifweizhi'] == 7 ){ ?>
        $("#bXfH").height($("#bXf").height() + 25);
        <?php }?>
    });
</script>

<!-- 弹出二维码开始 -->
<script type="text/javascript" src="/js/dialog/classie.js"></script>
<script type="text/javascript" src="/js/dialog/dialogFx.js"></script>
<script type="text/javascript">
    //遍历二维码按钮绑定弹窗
    (function () {
        somedialog = document.getElementById('somedialog'),
            dlg = new DialogFx(somedialog);
        $("a[data-dialog='somedialog']").each(function () {
            $(this).click(dlg.toggle.bind(dlg));
        });
    })();
</script>
<!-- 弹出二维码结束-->

<script>
    window.shareData = {
        "imgUrl": "<?=empty($row['share_pic']) ? '' : 'http://' . $_SERVER['HTTP_HOST'] . '/' . $row['share_pic']?>",
        "timeLineLink": "<?=$fxdomain . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];?>",
        "sendFriendLink": "<?=$fxdomain . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];?>",
        "weiboLink": "<?=$fxdomain . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];?>",
        "tTitle": "<?php echo urldecode($row['title']);?>",
        "tContent": "<?=$row['share_desc']?>",
        "fTitle": "<?php echo urldecode($row['title']);?>",
    };
</script>
<?= $shareScript ?>
</body>
</html>
