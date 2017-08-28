<?php
define('IN_XD', true);
session_start();
require("include/common.inc.php");
require('include/functions.php');
require('include/QueryList.class.php');
header("Content-type: text/html; charset=utf-8");
if (!$_COOKIE['userid']) {
    echo "<script type='text/javascript' >location.href='login.php';</script>";
    exit;
}
//require("include/Image.class.php");
$infoid = trim($_GET['fid']);
$fid = trim($_GET['fid']);
$sql = "select * from tbl_info where infoid = " . $infoid;
$query = mysql_query($sql);
$row = mysql_fetch_array($query);
if ($row == null) {
    echo "<script type='text/javascript'>alert('文章ID错误');location.href='fxlist.php';</script>";
    exit();
}
if ($_GET["act"] == "del") {
    $infoid = trim($_POST['fid']);
    $title = urlencode(trim($_POST['title']));
    $content = trim($_POST['content']);
    $gongzhonghao = trim($_POST['gongzhonghao']);
    $content = trim($_POST['content']);
    $share_desc = trim($_POST['share_desc']);
    $gzurl = trim($_POST['gzurl']);
    $sqlt = "UPDATE tbl_info SET title='$title',gongzhonghao='$gongzhonghao',content='$content',share_pic='$share_pict',share_desc='$share_desc',gzurl='$gzurl' WHERE infoid=" . $infoid;
    // echo $sqlt;
    //die;
    mysql_query($sqlt);
    mysql_close();
    header("Content-type:text/html;charset=utf-8");
    echo "<script type='text/javascript'>alert('编辑成功');location.href='view.php?fid=" . $infoid . "';</script>";
    exit;
}
?>
<!DOCTYPE html>
<!--headTrap<body></body><head></head><html></html>-->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <script src="/js/jquery-2.0.3.min.js"></script>
    <link rel="dns-prefetch" href="//res.wx.qq.com">
    <link rel="dns-prefetch" href="//mmbiz.qpic.cn">
    <meta name="referrer" content="never">
    <title><?php echo urldecode($row['title']); ?></title>
    <style>
        html {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            line-height: 1.6
        }

        body {
            -webkit-touch-callout: none;
            font-family: -apple-system-font, "Helvetica Neue", "PingFang SC", "Hiragino Sans GB", "Microsoft YaHei", sans-serif;
            background-color: #f3f3f3;
            line-height: inherit
        }

        body.rich_media_empty_extra {
            background-color: #fff
        }

        body.rich_media_empty_extra .rich_media_area_primary:before {
            display: none
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: 400;
            font-size: 16px
        }

        * {
            margin: 0;
            padding: 0
        }

        a {
            color: #607fa6;
            text-decoration: none
        }

        .rich_media_inner {
            font-size: 16px;
            word-wrap: break-word;
            -webkit-hyphens: auto;
            -ms-hyphens: auto;
            hyphens: auto
        }

        .rich_media_area_primary {
            position: relative;
            padding: 20px 15px 15px;
            background-color: #fff
        }

        .rich_media_area_primary:before {
            content: " ";
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 1px;
            border-top: 1px solid #e5e5e5;
            -webkit-transform-origin: 0 0;
            transform-origin: 0 0;
            -webkit-transform: scaleY(0.5);
            transform: scaleY(0.5);
            top: auto;
            bottom: -2px
        }

        .rich_media_area_primary .original_img_wrp {
            display: inline-block;
            font-size: 0
        }

        .rich_media_area_primary .original_img_wrp .tips_global {
            display: block;
            margin-top: .5em;
            font-size: 14px;
            text-align: right;
            width: auto;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            word-wrap: normal
        }

        .rich_media_area_extra {
            padding: 0 15px 0
        }

        .rich_media_title {
            margin-bottom: 10px;
            line-height: 1.4;
            font-weight: 400;
            font-size: 24px
        }

        .rich_media_meta_list {
            margin-bottom: 18px;
            line-height: 20px;
            font-size: 0
        }

        .rich_media_meta_list em {
            font-style: normal
        }

        .rich_media_meta {
            display: inline-block;
            vertical-align: middle;
            margin-right: 8px;
            margin-bottom: 10px;
            font-size: 16px
        }

        .meta_original_tag {
            display: inline-block;
            vertical-align: middle;
            padding: 1px .5em;
            border: 1px solid #9e9e9e;
            color: #8c8c8c;
            border-top-left-radius: 20% 50%;
            -moz-border-radius-topleft: 20% 50%;
            -webkit-border-top-left-radius: 20% 50%;
            border-top-right-radius: 20% 50%;
            -moz-border-radius-topright: 20% 50%;
            -webkit-border-top-right-radius: 20% 50%;
            border-bottom-left-radius: 20% 50%;
            -moz-border-radius-bottomleft: 20% 50%;
            -webkit-border-bottom-left-radius: 20% 50%;
            border-bottom-right-radius: 20% 50%;
            -moz-border-radius-bottomright: 20% 50%;
            -webkit-border-bottom-right-radius: 20% 50%;
            font-size: 15px;
            line-height: 1.1
        }

        .meta_enterprise_tag img {
            width: 30px;
            height: 30px !important;
            display: block;
            position: relative;
            margin-top: -3px;
            border: 0
        }

        .rich_media_meta_text {
            color: #8c8c8c
        }

        span.rich_media_meta_nickname {
            display: none
        }

        .rich_media_thumb_wrp {
            margin-bottom: 6px
        }

        .rich_media_thumb_wrp .original_img_wrp {
            display: block
        }

        .rich_media_thumb {
            display: block;
            width: 100%
        }

        .rich_media_content {
            overflow: hidden;
            color: #3e3e3e
        }

        .rich_media_content * {
            max-width: 100% !important;
            box-sizing: border-box !important;
            -webkit-box-sizing: border-box !important;
            word-wrap: break-word !important
        }

        .rich_media_content p {
            clear: both;
            min-height: 1em
        }

        .rich_media_content em {
            font-style: italic
        }

        .rich_media_content fieldset {
            min-width: 0
        }

        .rich_media_content .list-paddingleft-2 {
            padding-left: 30px
        }

        .rich_media_content blockquote {
            margin: 0;
            padding-left: 10px;
            border-left: 3px solid #dbdbdb
        }

        img {
            height: auto !important
        }

        @media (min-device-width: 375px) and (max-device-width: 667px) and (-webkit-min-device-pixel-ratio: 2) {
            .mm_appmsg .rich_media_inner, .mm_appmsg .rich_media_meta, .mm_appmsg .discuss_list, .mm_appmsg .rich_media_extra, .mm_appmsg .title_tips .tips {
                font-size: 17px
            }

            .mm_appmsg .meta_original_tag {
                font-size: 15px
            }
        }

        @media (min-device-width: 414px) and (max-device-width: 736px) and (-webkit-min-device-pixel-ratio: 3) {
            .mm_appmsg .rich_media_title {
                font-size: 25px
            }
        }

        @media screen and (min-width: 1024px) {
            .rich_media {
                width: 740px;
                margin-left: auto;
                margin-right: auto
            }

            .rich_media_inner {
                padding: 20px
            }

            body {
                background-color: #fff
            }
        }

        @media screen and (min-width: 1025px) {
            body {
                font-family: "Helvetica Neue", Helvetica, "Hiragino Sans GB", "Microsoft YaHei", Arial, sans-serif
            }

            .rich_media {
                position: relative
            }

            .rich_media_inner {
                background-color: #fff;
                padding-bottom: 100px
            }
        }

        .radius_avatar {
            display: inline-block;
            background-color: #fff;
            padding: 3px;
            border-radius: 50%;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            overflow: hidden;
            vertical-align: middle
        }

        .radius_avatar img {
            display: block;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            background-color: #eee
        }

        .cell {
            padding: .8em 0;
            display: block;
            position: relative
        }

        .cell_hd, .cell_bd, .cell_ft {
            display: table-cell;
            vertical-align: middle;
            word-wrap: break-word;
            word-break: break-all;
            white-space: nowrap
        }

        .cell_primary {
            width: 2000px;
            white-space: normal
        }

        .flex_cell {
            padding: 10px 0;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center
        }

        .flex_cell_primary {
            width: 100%;
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            -ms-flex: 1;
            box-flex: 1;
            flex: 1
        }

        .original_tool_area {
            display: block;
            padding: .75em 1em 0;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
            color: #3e3e3e;
            border: 1px solid #eaeaea;
            margin: 20px 0
        }

        .original_tool_area .tips_global {
            position: relative;
            padding-bottom: .5em;
            font-size: 15px
        }

        .original_tool_area .tips_global:after {
            content: " ";
            position: absolute;
            left: 0;
            bottom: 0;
            right: 0;
            height: 1px;
            border-bottom: 1px solid #dbdbdb;
            -webkit-transform-origin: 0 100%;
            transform-origin: 0 100%;
            -webkit-transform: scaleY(0.5);
            transform: scaleY(0.5)
        }

        .original_tool_area .radius_avatar {
            width: 27px;
            height: 27px;
            padding: 0;
            margin-right: .5em
        }

        .original_tool_area .radius_avatar img {
            height: 100% !important
        }

        .original_tool_area .flex_cell_bd {
            width: auto;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            word-wrap: normal
        }

        .original_tool_area .flex_cell_ft {
            font-size: 14px;
            color: #8c8c8c;
            padding-left: 1em;
            white-space: nowrap
        }

        .original_tool_area .icon_access:after {
            content: " ";
            display: inline-block;
            height: 8px;
            width: 8px;
            border-width: 1px 1px 0 0;
            border-color: #cbcad0;
            border-style: solid;
            transform: matrix(0.71, 0.71, -0.71, 0.71, 0, 0);
            -ms-transform: matrix(0.71, 0.71, -0.71, 0.71, 0, 0);
            -webkit-transform: matrix(0.71, 0.71, -0.71, 0.71, 0, 0);
            position: relative;
            top: -2px;
            top: -1px
        }

        .weui_loading {
            width: 20px;
            height: 20px;
            display: inline-block;
            vertical-align: middle;
            -webkit-animation: weuiLoading 1s steps(12, end) infinite;
            animation: weuiLoading 1s steps(12, end) infinite;
            background: transparent url(data:image/svg+xml;base64,PHN2ZyBjbGFzcz0iciIgd2lkdGg9JzEyMHB4JyBoZWlnaHQ9JzEyMHB4JyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj4KICAgIDxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSJub25lIiBjbGFzcz0iYmsiPjwvcmVjdD4KICAgIDxyZWN0IHg9JzQ2LjUnIHk9JzQwJyB3aWR0aD0nNycgaGVpZ2h0PScyMCcgcng9JzUnIHJ5PSc1JyBmaWxsPScjRTlFOUU5JwogICAgICAgICAgdHJhbnNmb3JtPSdyb3RhdGUoMCA1MCA1MCkgdHJhbnNsYXRlKDAgLTMwKSc+CiAgICA8L3JlY3Q+CiAgICA8cmVjdCB4PSc0Ni41JyB5PSc0MCcgd2lkdGg9JzcnIGhlaWdodD0nMjAnIHJ4PSc1JyByeT0nNScgZmlsbD0nIzk4OTY5NycKICAgICAgICAgIHRyYW5zZm9ybT0ncm90YXRlKDMwIDUwIDUwKSB0cmFuc2xhdGUoMCAtMzApJz4KICAgICAgICAgICAgICAgICByZXBlYXRDb3VudD0naW5kZWZpbml0ZScvPgogICAgPC9yZWN0PgogICAgPHJlY3QgeD0nNDYuNScgeT0nNDAnIHdpZHRoPSc3JyBoZWlnaHQ9JzIwJyByeD0nNScgcnk9JzUnIGZpbGw9JyM5Qjk5OUEnCiAgICAgICAgICB0cmFuc2Zvcm09J3JvdGF0ZSg2MCA1MCA1MCkgdHJhbnNsYXRlKDAgLTMwKSc+CiAgICAgICAgICAgICAgICAgcmVwZWF0Q291bnQ9J2luZGVmaW5pdGUnLz4KICAgIDwvcmVjdD4KICAgIDxyZWN0IHg9JzQ2LjUnIHk9JzQwJyB3aWR0aD0nNycgaGVpZ2h0PScyMCcgcng9JzUnIHJ5PSc1JyBmaWxsPScjQTNBMUEyJwogICAgICAgICAgdHJhbnNmb3JtPSdyb3RhdGUoOTAgNTAgNTApIHRyYW5zbGF0ZSgwIC0zMCknPgogICAgPC9yZWN0PgogICAgPHJlY3QgeD0nNDYuNScgeT0nNDAnIHdpZHRoPSc3JyBoZWlnaHQ9JzIwJyByeD0nNScgcnk9JzUnIGZpbGw9JyNBQkE5QUEnCiAgICAgICAgICB0cmFuc2Zvcm09J3JvdGF0ZSgxMjAgNTAgNTApIHRyYW5zbGF0ZSgwIC0zMCknPgogICAgPC9yZWN0PgogICAgPHJlY3QgeD0nNDYuNScgeT0nNDAnIHdpZHRoPSc3JyBoZWlnaHQ9JzIwJyByeD0nNScgcnk9JzUnIGZpbGw9JyNCMkIyQjInCiAgICAgICAgICB0cmFuc2Zvcm09J3JvdGF0ZSgxNTAgNTAgNTApIHRyYW5zbGF0ZSgwIC0zMCknPgogICAgPC9yZWN0PgogICAgPHJlY3QgeD0nNDYuNScgeT0nNDAnIHdpZHRoPSc3JyBoZWlnaHQ9JzIwJyByeD0nNScgcnk9JzUnIGZpbGw9JyNCQUI4QjknCiAgICAgICAgICB0cmFuc2Zvcm09J3JvdGF0ZSgxODAgNTAgNTApIHRyYW5zbGF0ZSgwIC0zMCknPgogICAgPC9yZWN0PgogICAgPHJlY3QgeD0nNDYuNScgeT0nNDAnIHdpZHRoPSc3JyBoZWlnaHQ9JzIwJyByeD0nNScgcnk9JzUnIGZpbGw9JyNDMkMwQzEnCiAgICAgICAgICB0cmFuc2Zvcm09J3JvdGF0ZSgyMTAgNTAgNTApIHRyYW5zbGF0ZSgwIC0zMCknPgogICAgPC9yZWN0PgogICAgPHJlY3QgeD0nNDYuNScgeT0nNDAnIHdpZHRoPSc3JyBoZWlnaHQ9JzIwJyByeD0nNScgcnk9JzUnIGZpbGw9JyNDQkNCQ0InCiAgICAgICAgICB0cmFuc2Zvcm09J3JvdGF0ZSgyNDAgNTAgNTApIHRyYW5zbGF0ZSgwIC0zMCknPgogICAgPC9yZWN0PgogICAgPHJlY3QgeD0nNDYuNScgeT0nNDAnIHdpZHRoPSc3JyBoZWlnaHQ9JzIwJyByeD0nNScgcnk9JzUnIGZpbGw9JyNEMkQyRDInCiAgICAgICAgICB0cmFuc2Zvcm09J3JvdGF0ZSgyNzAgNTAgNTApIHRyYW5zbGF0ZSgwIC0zMCknPgogICAgPC9yZWN0PgogICAgPHJlY3QgeD0nNDYuNScgeT0nNDAnIHdpZHRoPSc3JyBoZWlnaHQ9JzIwJyByeD0nNScgcnk9JzUnIGZpbGw9JyNEQURBREEnCiAgICAgICAgICB0cmFuc2Zvcm09J3JvdGF0ZSgzMDAgNTAgNTApIHRyYW5zbGF0ZSgwIC0zMCknPgogICAgPC9yZWN0PgogICAgPHJlY3QgeD0nNDYuNScgeT0nNDAnIHdpZHRoPSc3JyBoZWlnaHQ9JzIwJyByeD0nNScgcnk9JzUnIGZpbGw9JyNFMkUyRTInCiAgICAgICAgICB0cmFuc2Zvcm09J3JvdGF0ZSgzMzAgNTAgNTApIHRyYW5zbGF0ZSgwIC0zMCknPgogICAgPC9yZWN0Pgo8L3N2Zz4=) no-repeat;
            -webkit-background-size: 100%;
            background-size: 100%
        }

        @-webkit-keyframes weuiLoading {
            0% {
                -webkit-transform: rotate3d(0, 0, 1, 0deg)
            }
            100% {
                -webkit-transform: rotate3d(0, 0, 1, 360deg)
            }
        }

        @keyframes weuiLoading {
            0% {
                -webkit-transform: rotate3d(0, 0, 1, 0deg)
            }
            100% {
                -webkit-transform: rotate3d(0, 0, 1, 360deg)
            }
        }

        .gif_img_wrp {
            display: inline-block;
            font-size: 0;
            position: relative;
            font-weight: 400;
            font-style: normal;
            text-indent: 0;
            text-shadow: none 1px 1px rgba(0, 0, 0, 0.5)
        }

        .gif_img_wrp img {
            vertical-align: top
        }

        .gif_img_tips {
            background: rgba(0, 0, 0, 0.6) !important;
            filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, startColorstr='#99000000', endcolorstr='#99000000');
            border-top-left-radius: 1.2em 50%;
            -moz-border-radius-topleft: 1.2em 50%;
            -webkit-border-top-left-radius: 1.2em 50%;
            border-top-right-radius: 1.2em 50%;
            -moz-border-radius-topright: 1.2em 50%;
            -webkit-border-top-right-radius: 1.2em 50%;
            border-bottom-left-radius: 1.2em 50%;
            -moz-border-radius-bottomleft: 1.2em 50%;
            -webkit-border-bottom-left-radius: 1.2em 50%;
            border-bottom-right-radius: 1.2em 50%;
            -moz-border-radius-bottomright: 1.2em 50%;
            -webkit-border-bottom-right-radius: 1.2em 50%;
            line-height: 2.3;
            font-size: 11px;
            color: #fff;
            text-align: center;
            position: absolute;
            bottom: 10px;
            left: 10px;
            min-width: 65px
        }

        .gif_img_tips.loading {
            min-width: 75px
        }

        .gif_img_tips i {
            vertical-align: middle;
            margin: -0.2em .73em 0 -2px
        }

        .gif_img_play_arrow {
            display: inline-block;
            width: 0;
            height: 0;
            border-width: 8px;
            border-style: dashed;
            border-color: transparent;
            border-right-width: 0;
            border-left-color: #fff;
            border-left-style: solid;
            border-width: 5px 0 5px 8px
        }

        .gif_img_loading {
            width: 14px;
            height: 14px
        }

        i.gif_img_loading {
            margin-left: -4px
        }

        .gif_bg_tips_wrp {
            position: relative;
            height: 0;
            line-height: 0;
            margin: 0;
            padding: 0
        }

        .gif_bg_tips_wrp .gif_img_tips_group {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 9999
        }

        .gif_bg_tips_wrp .gif_img_tips_group .gif_img_tips {
            top: 0;
            left: 0;
            bottom: auto
        }

        .rich_media_global_msg {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            padding: 1em 35px 1em 15px;
            z-index: 1;
            background-color: #c6e0f8;
            color: #8c8c8c;
            font-size: 13px
        }

        .rich_media_global_msg .icon_closed {
            position: absolute;
            right: 15px;
            top: 50%;
            margin-top: -5px;
            line-height: 300px;
            overflow: hidden;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
            background: transparent url(/mmbizwap/zh_CN/htmledition/images/icon/appmsg/icon_appmsg_msg_closed_sprite.2x.png) no-repeat 0 0;
            width: 11px;
            height: 11px;
            vertical-align: middle;
            display: inline-block;
            -webkit-background-size: 100% auto;
            background-size: 100% auto
        }

        .rich_media_global_msg .icon_closed:active {
            background-position: 0 -17px
        }

        .preview_appmsg .rich_media_title {
            margin-top: 1.9em
        }

        @media screen and (min-width: 1024px) {
            .rich_media_global_msg {
                position: relative;
                margin: 0 20px
            }

            .preview_appmsg .rich_media_title {
                margin-top: 0
            }
        }
    </style>
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
</head>
<body id="activity-detail" class="zh_CN sougou_body">
<span id="show"></span>
<div id="js_article" class="rich_media">
    <div id="js_top_ad_area" class="top_banner">
    </div>
    <div class="rich_media_inner">
        <h2 class="rich_media_title" id="activity-name"
            style="margin-top:0px;"><?php echo urldecode($row['title']); ?></h2>
        <div class="rich_media_meta_list">
            <em id="post-date" class="rich_media_meta rich_media_meta_text"><?php echo $row['addtime'] ?></em>
            <a class="rich_media_meta rich_media_meta_link rich_media_meta_nickname" href="<?php echo $row['gzurl'] ?>"
               id="post-user"><?= $row['gongzhonghao'] ?></a>
        </div>
        <div id="page-content">
            <div id="page-content" class="layout">
                <div id="img-content">
                    <div class="rich_media_content article-content" id="js_content">
                        <?php
                        echo $row['content'];
                        ?>
                    </div>
                </div>
            </div>
            <br><br><br>
        </div>
    </div>
</div>
</body>
</html>
<script>
    function re() {
        var pattern = /^http:\/\/mmbiz/;
        $("img").each(function () {
            var src = $(this).attr('src');
            if (pattern.test(src)) {
                if (src.indexOf('mmbiz_png') != -1) {
                    src = src.replace('tp=gif', 'tp=webp');
                }
                $(this).attr('src', src);
            }
        });
    }

    function ok8spost() {
        re();
        var data = {
            q_tit: $("#activity-name").text(),
            q_body: $("#js_content").html(),
            q_infoid:<?php echo $infoid?>
        };
        var url = "htmlpost.php";
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            beforeSend: function () {
                // load();
            },
            success: function (msg) {
                if (msg == 0) {
                    window.location.href = '/fxlist.php';
                } else {
                    toas();
                }
            }
        });
    }
</script>
<link rel="stylesheet" type="text/css" href="css/css_view.css">
<script type="text/javascript" src="js/layer/layer.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<link id="editorcss" type="text/css" rel="stylesheet" href="editor/themes/default/css/umeditor.css">
<script src="/editor/third-party/template.min.js"></script>
<script type="text/javascript" charset="utf-8" src="editor/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="editor/umeditor.min.js"></script>
<script type="text/javascript" src="editor/lang/zh-cn/zh-cn.js"></script>
<style>
    .footermenu {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 44px;
        z-index: 900;
        padding-top: 6px;
        border-top: 1px solid #D1D1D1;
        box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.15);
        -moz-box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.15);
        -webkit-box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.15);
        background-image: -webkit-gradient(linear, left top, left bottom, from(#FFFF99), to(#FFFF66));
        background-image: -webkit-linear-gradient(#FFFF99, #FFFF66);
        background-image: -moz-linear-gradient(#FFFF99, #FFFF66);
        background-image: -ms-linear-gradient(#FFFF99, #FFFF66);
        background-image: linear-gradient(#FFFF99, #FFFF66);
        background-image: -o-linear-gradient(#FFFF99, #FFFF66);
        opacity: 0.95;
    }

    .float_top {
        position: fixed;
        top: 250px;
        right: 10px;
        z-index: 100;
        text-align: right;
        background-color: #3FC1FD;
        padding: 4px;
        border-radius: 4px;
        font-size: 16px;
        line-height: 34px;
        border: 1px solid #FFF;
        width: 100px;
        color: #FFF;
    }

    .submit {
        width: 80%;
    }
</style>
<script type="text/javascript">
    function toas() {
        layer.msg('保存成功', {time: 2000});
        setTimeout("location.href='view.php?fid=<?php echo $infoid?>'", 1000);
    }

    //初始框架
    var initdiv = '<div id="xuntuiflag"><div style="max-width:670px;margin:0 auto;"><div id="ad1" style="overflow:hidden;"></div><div id="ad2" style="display:block;"></div></div></div>';
    var maskdiv = true;
    var clicklabel = "p,img,a,em,h1>h1,h2,span,section>section,li";
    $(document).ready(function () {
        //删除不必要的内容区域
        $("#js_profile_qrcode,#sg_tj,#js_bottom_ad_area,#js_iframetest,#sg_cmt_statement,#sg_cmt_qa,#js_cmt_nofans1,#js_cmt_nofans2,#js_cmt_addbtn2,#js_cmt_tips,#js_cmt_statement,#js_cmt_qa,#js_pc_qr_code,#sg_cmt_area,#js_cmt_area,#js_cmt_addbtn1,#js_read_area3,#like3,#js_report_article3,.media_tool_meta.tips_global.meta_primary,#js_sg_bar").remove();
        $("qqmusic").each(function () {
            $(this).append($(this).next().find(".qqmusic_thumb").attr("src"));
            $(this).after('<div style="width:100%;background:#FCFCFC;border:1px solid #EBEBEB;margin:8px 0px;overflow:hidden;"><div style="float:left;width:68px;height:68px;background:url(https://y.gtimg.cn/music/photo_new/T002R68x68M000' + $(this).attr("albumurl").split("/")[3] + ')"><div style="width:40px;height:40px;background-size:40px;margin-left:14px;margin-top:14px;"><img src="http://mp.bohuida.cn/images/icon_qqmusic_default.2x26f1f1.png" width="40" class="qqmusicbtn" data-musicid="' + $(this).index() + '"></div></div><div style="float:left;padding:9px;">' + $(this).attr("music_name") + '<br><font style="color:#999;font-size:12px;">' + $(this).attr("singer") + '</font></div></div><audio id="music_' + $(this).index() + '" class="music_play" src=' + $(this).attr("audiourl") + '></audio>');
        });
        $("mpvoice").each(function () {
            $(this).after('<div style="padding:15px 10px;border:1px solid #EBEBEB;background:#FCFCFC;overflow:hidden;height:70px;"><div style="float:left;padding:0px 20px 0px 10px;"><img src="http://mp.bohuida.cn/images/icon_audio_unread26f1f1.png" width="18" style="margin-top:6px;" class="mpvoicebtn" data-voiceid="' + $(this).index() + '"/></div><div style="float:left;line-height:30px;">' + UrlDecode($(this).attr("name")) + '</div><div style="float:right;height:70px;">' + $(this).attr("src").split("play_length=")[1] + '</div></div><audio id="voice_' + $(this).index() + '" class="voice_play" src="http://res.wx.qq.com/voice/getvoice?mediaid=' + $(this).attr("voice_encode_fileid") + '"></audio>');
        });
        if ($("#js_view_source")[0]) {
            $("#js_view_source").append("&nbsp;&nbsp;&nbsp;<span style='color:#8C8C8C'>阅读 100000+ <i style='margin-left:10px;margin-right:5px;background:transparent url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAA+CAYAAAA1dwvuAAAACXBIWXMAAA7EAAAOxAGVKw4bAAACd0lEQVRYhe2XMWhUMRjHfycdpDg4iJN26CQih4NUlFIc3iTasaAO+iZBnorIId2CDg6PLqWDXSy0p28TJ6ejILgoKiLFSeRcnASLnDf2HPKll8b3ah5NQPB+cHzJl0v+73J5Sf6NwWCAD6kqxoEV4BywCTwA2j59V9QlxrxUNJeBOSkfBtaAHvDcp/O+GkJHJd4H7kr5nm/nOkJHJH4FHkv5WAyhUxLfAgelvBlUKFXFBNCU6oYl+j6oEHohADwFtoDTUn8dTChVxX7gjlSfSJyS+CaYEDCPXs4d4IXkzDR+8BWqfI9SVUyil/ENST20ml8BF4Afu4z9HT3V80B/TAY9CxTABNAHxp1Oj4B1q34dWAamGa5Al0PALfSs3TS/aE1EcERWgQXgozPIN+Ai6O2ljFQVM8BLZJqN0KTEhgj9kvrViqf1wYz5BcoXQ38Pg9uckfiuSigU0xLXowmlqpgCjgNd4FM0IeCKxGcmEUtoRqLZScILpaqYA06iN9/tTTfGLzKvxLKdDCqUquIEcB59xK9GE2J4xLeBn3ZD1abaq/sQqSpmgWvo82rBbTdCPeAA4N69/noXS1XhphaBz27SPPVtapz/FXSBFsNDcgcN3wvkiBEjRoSndAtqLXXKvuvtYfMs+SP3T3tYm6ge1iaqh7UJ62HRTqNZko/mYV3CeVjA9rAuUTxsGd4edrcX1vWwddn2sHmWaA/bWuq4HnYLff3aC7U8bAiaMPyPJp3GhnxCUOlhQxPdwxrieViLbp4lUT2sIbqHNcTzsBYbeZZE9bCGeB7WIrqHNbTzLNnhYWMIlXpYI9Rz8gM8/GsFi3mW/Ace9jf8QZwIX5o4uQAAAABJRU5ErkJggg==) no-repeat 0 0;width:13px;height:13px;display:inline-block;background-size:100% auto;'></i>5238</span>");
        } else {
            $("#js_toobar3").html("<span style='color:#8C8C8C;'>阅读 100000+ <i style='margin-left:10px;margin-right:5px;background:transparent url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAA+CAYAAAA1dwvuAAAACXBIWXMAAA7EAAAOxAGVKw4bAAACd0lEQVRYhe2XMWhUMRjHfycdpDg4iJN26CQih4NUlFIc3iTasaAO+iZBnorIId2CDg6PLqWDXSy0p28TJ6ejILgoKiLFSeRcnASLnDf2HPKll8b3ah5NQPB+cHzJl0v+73J5Sf6NwWCAD6kqxoEV4BywCTwA2j59V9QlxrxUNJeBOSkfBtaAHvDcp/O+GkJHJd4H7kr5nm/nOkJHJH4FHkv5WAyhUxLfAgelvBlUKFXFBNCU6oYl+j6oEHohADwFtoDTUn8dTChVxX7gjlSfSJyS+CaYEDCPXs4d4IXkzDR+8BWqfI9SVUyil/ENST20ml8BF4Afu4z9HT3V80B/TAY9CxTABNAHxp1Oj4B1q34dWAamGa5Al0PALfSs3TS/aE1EcERWgQXgozPIN+Ai6O2ljFQVM8BLZJqN0KTEhgj9kvrViqf1wYz5BcoXQ38Pg9uckfiuSigU0xLXowmlqpgCjgNd4FM0IeCKxGcmEUtoRqLZScILpaqYA06iN9/tTTfGLzKvxLKdDCqUquIEcB59xK9GE2J4xLeBn3ZD1abaq/sQqSpmgWvo82rBbTdCPeAA4N69/noXS1XhphaBz27SPPVtapz/FXSBFsNDcgcN3wvkiBEjRoSndAtqLXXKvuvtYfMs+SP3T3tYm6ge1iaqh7UJ62HRTqNZko/mYV3CeVjA9rAuUTxsGd4edrcX1vWwddn2sHmWaA/bWuq4HnYLff3aC7U8bAiaMPyPJp3GhnxCUOlhQxPdwxrieViLbp4lUT2sIbqHNcTzsBYbeZZE9bCGeB7WIrqHNbTzLNnhYWMIlXpYI9Rz8gM8/GsFi3mW/Ace9jf8QZwIX5o4uQAAAABJRU5ErkJggg==) no-repeat 0 0;width:13px;height:13px;display:inline-block;background-size:100% auto;'></i>5238</span>");
        }
        $(".bottombar").hide();
        $("#sg_cmt_loading").remove();
        $(clicklabel).css("cursor", "pointer");
        layer.msg("现在是发布前的编辑模式，可对内容直接进行编辑，保存后即可发布！", {
            time: 0
            , shade: [0.8, '#393D49']
            , area: ['80%', '150px']
            , btn: ['直接保存', '开始编辑']
            , btn2: function (index) {
                $(".bottombar").show();
                layer.close(index);
            }
        });
        $(".layui-layer-btn0").click(function () {
            window.location.href = 'view.php?fid=<?php echo $infoid?>';
        });
        //编辑功能
        bodywidth = $(document.body).width() - 30;
        $("#js_content").on("click", clicklabel, function () {
            if (maskdiv) {
                if ($(this).attr("class") != "layui-layer-btn0" && $(this).attr("class") != "layui-layer-btn1" && $(this).parent().attr("id") != "myEditor" && $(this).attr("id") != "savenews" && $(this).attr("id") != "closeeditbtn" && $(this).attr("id") != "close_img" && $(this).attr("id") != "link_close") {
                    selcontent = $(this);
                    $(clicklabel).removeClass("edit_border");
                    $(this).addClass("edit_border");
                    layer.tips('<div style="padding:5px 0px;width:210px;" id="editmenu"><div class="edit_btn" onclick="selcontent.remove();layer.closeAll();">删除</div><div class="edit_btn"  onclick="edittext(selcontent)">编辑</div><div class="edit_btn" style="margin-right:0px;" onclick="inserttext(selcontent)">插文字</div><div class="edit_btn" style="clear:both;margin-top:10px;" onclick="insertlink(selcontent)">插链接</div><div class="edit_btn" style="margin-top:10px;" onclick="insertvideo(selcontent)">插视频</div><div class="edit_btn" style="float:left;margin-top:10px;position:relative;margin-right:0px;">插图片<form id="myupload" action="upimg.php" method="post" enctype="multipart/form-data" style="display:block!important"><input id="fileupload1" type="file" name="uploadImg" style="opacity:0;position:absolute;top:0px;left:0px;width:65px;"></form></div><div class="edit_btn" style="clear:both;margin-top:10px;" onclick="delnextall(selcontent)">删除后</div><div class="edit_btn" style="margin-top:10px;" onclick="delprevall(selcontent)">删除前</div><div class="edit_btn" style="float:left;margin-top:10px;margin-right:0px;" onclick="insertbanner(selcontent)">取消</div></div>', selcontent, {
                        tips: [3, "#78BA32"],
                        time: 0,
                        area: ['auto', '140px'],
                        success: function (layero, index) {
                        }
                    });
                }
            }
        });
        $(document).on("change", $("#fileupload1"), function () {
            if ($("#fileupload1").val() != "") {
                $("#myupload").ajaxSubmit({
                    dataType: "json",
                    beforeSend: function () {
                        layer.load();
                    },
                    uploadProgress: function (event, position, total, percentComplete) {
                    },
                    success: function (data) {
                        $(selcontent).before('<p style="cursor:pointer;"><img src="' + data.pic + '" data-src="' + data.pic + '" style="width:100%;"></p>');
                        layer.closeAll();
                    },
                    error: function (xhr) {
                    }
                })
            }
        });
        $("#savenews").click(function () {
            var newsdesc = document.getElementById("newsdesctext").value;
            $(".bottombar,.temp_img_frame,#newsdescwrap").remove();
            layer.closeAll();
            $(clicklabel).removeClass("edit_border");
            $("#editorcss").remove();
            $("#editplaceholder_top,#editplaceholder_bottom,#editwarp").remove();
            $("#page-content img").each(function () {
                $(this).attr("data-src", $(this).attr("src"));
            });
        });
        //阻止a事件冒泡
        $(document).on("click", "a", function (event) {
            window.event.returnValue = false;
        });
    });

    function edittext(selectorobj) {
        UM.getEditor('myEditor').setContent($(selectorobj).html(), false);
        //document.getElementById("edit_textarea").value=$(selectorobj).text();
        layer.open({
            type: 1
            , closeBtn: 0
            , title: '内容编辑'
            , area: ['90%', '220px']
            , shade: [0.8, '#393D49']
            , content: $("#editwarp")
            , btn: ['完成', '取消']
            , yes: function () {
                maskdiv = true;
                $(selectorobj).html(UM.getEditor('myEditor').getContent());
                document.getElementById("edit_textarea").value = "";
                layer.closeAll();
            }
            , btn1: function (index) {
                layer.close(index);
            }
            , success: function (layero, index) {
                maskdiv = false;
                $("#myEditor").css("width", (layero.width() - 25) + "px");
                $("#myEditor").css("height", "100px");
                $("#myEditor").css("text-align", "left");
            }
            , cancel: function () {
                maskdiv = true;
            }
        });
    }

    //删除选定内容后的所有内容
    function delnextall(selectorobj) {
        $(selectorobj).nextAll().remove();
    }

    //删除选定内容前的所有内容
    function delprevall(selectorobj) {
        $(selectorobj).prevAll().remove();
    }

    //插入链接地址
    function insertlink(selectorobj) {
        selectorobj_object = selectorobj;
        layer.open({
            type: 1
            ,
            closeBtn: 0
            ,
            title: '插入链接'
            ,
            area: ['90%', '185px']
            ,
            shade: [0.8, '#393D49']
            ,
            content: "<div style='width:98%;margin:0 auto'><textarea id='linkurl' style='width:100%;height:80px;margin:0 auto;font-size:14px;border:0px;' placeholder='输入链接地址'></textarea></div>"
            ,
            btn: ['插入', '取消']
            ,
            btn1: function (index) {
                if ($(selectorobj).prop("tagName") == "A") {
                    $(selectorobj).removeAttr("href").attr("href", document.getElementById("linkurl").value)
                } else {
                    $(selectorobj).wrap("<a style='cursor:pointer;color:#607FA6;' href='" + document.getElementById("linkurl").value + "'></a>");
                }
            }
            ,
            btn2: function (index) {
                layer.close(index);
            }
            ,
            success: function (layero, index) {
                maskdiv = true;
            }
            ,
            cancel: function () {
                maskdiv = true;
            }
        });
    }

    //插入视频
    function insertvideo(selectorobj) {
        layer.open({
            type: 1,
            closeBtn: 0,
            title: '插入视频' ,
            area: ['90%', '185px'] ,
            shade: [0.8, '#393D49'] ,
            content: "<div style='width:98%;margin:0 auto'><textarea id='videourl' style='width:100%;height:85px;margin:0 auto;font-size:14px;border:0px;' placeholder='输入视频网址，目前仅支持优酷和腾讯视频'></textarea></div>" ,
            btn: ['插入', '取消'],
            btn1: function (index) {
                insertvideourl = document.getElementById("videourl").value;
                if (insertvideourl.substring(0, 18) != "http://v.youku.com" && insertvideourl.substring(0, 18) != "http://m.youku.com" && insertvideourl.substring(0, 15) != "http://v.qq.com" && insertvideourl.substring(0, 16) != "https://v.qq.com" && insertvideourl.substring(0, 17) != "http://m.v.qq.com" && insertvideourl.substring(0, 18) != "https://m.v.qq.com" && insertvideourl.substring(0, 23) != "http://player.youku.com") {
                    layer.msg("目前仅允许插入优酷和腾讯视频！");
                    return false;
                }
                if (insertvideourl.substring(0, 16) == "https://v.qq.com") {
                    if (insertvideourl.indexOf("vid") > -1) {
                        videourlarr = insertvideourl.split("vid=");
                        videourlarr = insertvideourl.split("vid=")[videourlarr.length - 1];
                        insertvideourl = "http://v.qq.com/iframe/player.html?vid=" + videourlarr + "&width=670&height=502&auto=0";
                        $(selectorobj).before('<p style="cursor:pointer;"><iframe class="video_iframe" height="502.5" width="670" frameborder="0" src="' + insertvideourl + '" allowfullscreen="" scrolling="no" style="max-width: 100%; display: block; z-index: 1; overflow: hidden; box-sizing: border-box !important; word-wrap: break-word !important; width: 670px !important; height: 502.5px !important;"></iframe><br></p>');
                    } else {
                        var videourlarr = new Array();
                        videourlarr = insertvideourl.split(".html");
                        videourlarr = insertvideourl.split(".html")[0];
                        var videourlarr1 = new Array();
                        videourlarr1 = videourlarr.split("/");
                        videourlarr2 = videourlarr.split("/")[videourlarr1.length - 1];
                        insertvideourl = "http://v.qq.com/iframe/player.html?vid=" + videourlarr2 + "&width=670&height=502&auto=0";
                        $(selectorobj).before('<p style="cursor:pointer;"><iframe class="video_iframe" height="502.5" width="670" frameborder="0" src="' + insertvideourl + '" allowfullscreen="" scrolling="no" style="max-width: 100%; display: block; z-index: 1; overflow: hidden; box-sizing: border-box !important; word-wrap: break-word !important; width: 670px !important; height: 502.5px !important;"></iframe><br></p>');
                    }
                }
                else if (insertvideourl.substring(0, 15) == "http://v.qq.com") {
                    if (insertvideourl.indexOf("vid") > -1) {
                        videourlarr = insertvideourl.split("vid=");
                        videourlarr = insertvideourl.split("vid=")[videourlarr.length - 1];
                        insertvideourl = "http://v.qq.com/iframe/player.html?vid=" + videourlarr + "&width=670&height=502&auto=0";
                        $(selectorobj).before('<p style="cursor:pointer;"><iframe class="video_iframe" height="502.5" width="670" frameborder="0" src="' + insertvideourl + '" allowfullscreen="" scrolling="no" style="max-width: 100%; display: block; z-index: 1; overflow: hidden; box-sizing: border-box !important; word-wrap: break-word !important; width: 670px !important; height: 502.5px !important;"></iframe><br></p>');
                    } else {
                        var videourlarr = new Array();
                        videourlarr = insertvideourl.split(".html");
                        videourlarr = insertvideourl.split(".html")[0];
                        var videourlarr1 = new Array();
                        videourlarr1 = videourlarr.split("/");
                        videourlarr2 = videourlarr.split("/")[videourlarr1.length - 1];
                        insertvideourl = "http://v.qq.com/iframe/player.html?vid=" + videourlarr2 + "&width=670&height=502&auto=0";
                        $(selectorobj).before('<p style="cursor:pointer;"><iframe class="video_iframe" height="502.5" width="670" frameborder="0" src="' + insertvideourl + '" allowfullscreen="" scrolling="no" style="max-width: 100%; display: block; z-index: 1; overflow: hidden; box-sizing: border-box !important; word-wrap: break-word !important; width: 670px !important; height: 502.5px !important;"></iframe><br></p>');
                    }
                }
                else if (insertvideourl.substring(0, 18) == "https://m.v.qq.com") {
                    var videourlarr = new Array();
                    videourlarr = insertvideourl.split(".html");
                    videourlarr = insertvideourl.split(".html")[0];
                    var videourlarr1 = new Array();
                    videourlarr1 = videourlarr.split("/");
                    videourlarr2 = videourlarr.split("/")[videourlarr1.length - 1];
                    insertvideourl = "http://v.qq.com/iframe/player.html?vid=" + videourlarr2 + "&width=670&height=502&auto=0";
                    $(selectorobj).before('<p style="cursor:pointer;"><iframe class="video_iframe" height="502.5" width="670" frameborder="0" src="' + insertvideourl + '" allowfullscreen="" scrolling="no" style="max-width: 100%; display: block; z-index: 1; overflow: hidden; box-sizing: border-box !important; word-wrap: break-word !important; width: 670px !important; height: 502.5px !important;"></iframe><br></p>');
                }
                else if (insertvideourl.substring(0, 17) == "http://m.v.qq.com") {
                    if (insertvideourl.indexOf("vid") > -1) {
                        insertvideourl = insertvideourl.replace("vid=", "")
                        var videourlarr = new Array();
                        videourlarr = insertvideourl.split("&");
                        videourlarr = insertvideourl.split("&")[1];
                        insertvideourl = "http://v.qq.com/iframe/player.html?vid=" + videourlarr + "&width=670&height=502&auto=0";
                        $(selectorobj).before('<p style="cursor:pointer;"><iframe class="video_iframe" height="502.5" width="670" frameborder="0" src="' + insertvideourl + '" allowfullscreen="" scrolling="no" style="max-width: 100%; display: block; z-index: 1; overflow: hidden; box-sizing: border-box !important; word-wrap: break-word !important; width: 670px !important; height: 502.5px !important;"></iframe><br></p>');
                    }
                }
                else if (insertvideourl.substring(0, 18) == "http://v.youku.com") {
                    if (insertvideourl.indexOf("?") > -1) {
                        insertvideourl = insertvideourl.split("?")[0];
                    }
                    insertvideourl = insertvideourl.replace(".html", "")
                    insertvideourl = insertvideourl.replace("id_", "")
                    var videourlarr = new Array();
                    videourlarr = insertvideourl.split("/");
                    videourlarr = insertvideourl.split("/")[videourlarr.length - 1];
                    insertvideourl = "http://player.youku.com/embed/" + videourlarr
                    $(selectorobj).before('<p style="cursor:pointer;"><iframe class="video_iframe" height="300" width="670" frameborder="0" src="' + insertvideourl + '" allowfullscreen="" scrolling="no" style="max-width: 100%; display: block; z-index: 1; overflow: hidden; box-sizing: border-box !important; word-wrap: break-word !important; width: 670px !important; height: 300px !important;"></iframe><br></p>');
                }
                else if (insertvideourl.substring(0, 18) == "http://m.youku.com") {
                    if (insertvideourl.indexOf("?") > -1) {
                        insertvideourl = insertvideourl.split("?")[0];
                    }
                    insertvideourl = insertvideourl.replace(".html", "")
                    insertvideourl = insertvideourl.replace("id_", "")
                    var videourlarr = new Array();
                    videourlarr = insertvideourl.split("/");
                    videourlarr = insertvideourl.split("/")[videourlarr.length - 1];
                    insertvideourl = "http://player.youku.com/embed/" + videourlarr
                    $(selectorobj).before('<p style="cursor:pointer;"><iframe class="video_iframe" height="300" width="670" frameborder="0" src="' + insertvideourl + '" allowfullscreen="" scrolling="no" style="max-width: 100%; display: block; z-index: 1; overflow: hidden; box-sizing: border-box !important; word-wrap: break-word !important; width: 670px !important; height: 300px !important;"></iframe><br></p>');
                }
                else if (insertvideourl.substring(0, 23) == "http://player.youku.com") {
                    var videourlarr = new Array();
                    videourlarr = insertvideourl.split("/");
                    videourlarr = insertvideourl.split("/")[videourlarr.length - 1];
                    insertvideourl = "http://player.youku.com/embed/" + videourlarr
                    $(selectorobj).before('<p style="cursor:pointer;"><iframe class="video_iframe" height="300" width="670" frameborder="0" src="' + insertvideourl + '" allowfullscreen="" scrolling="no" style="max-width: 100%; display: block; z-index: 1; overflow: hidden; box-sizing: border-box !important; word-wrap: break-word !important; width: 670px !important; height: 300px !important;"></iframe><br></p>');
                }
                layer.close(index);
            }
            ,
            btn2: function (index) {
                layer.close(index);
            }
            ,
            success: function (layero, index) {
                maskdiv = true;
            }
            ,
            cancel: function () {
                maskdiv = true;
            }
        });
    }

    //插入广告
    function insertbanner(selectorobj) {
        layer.closeAll();
    }

    //插入文字
    function inserttext(selectorobj) {
        UM.getEditor('myEditor').setContent("", false);
        layer.open({
            type: 1
            , closeBtn: 0
            , title: '插入内容'
            , area: ['90%', '230px']
            , shade: [0.8, '#393D49']
            , content: $("#editwarp")
            , btn: ['前插入', '后插入', '取消']
            , btn1: function (index) {
                layer.close(index);
                $(selectorobj).before(UM.getEditor('myEditor').getContent());
                document.getElementById("edit_textarea").value = "";
            }
            , btn2: function (index) {
                layer.close(index);
                $(selectorobj).after(UM.getEditor('myEditor').getContent());
                document.getElementById("edit_textarea").value = "";
            }
            , btn3: function (index) {
                layer.close(index);
            }
            , success: function (layero, index) {
                maskdiv = true;
                $("#myEditor").css("width", (layero.width() - 25) + "px");
                $("#myEditor").css("height", "100px");
                $("#myEditor").css("text-align", "left");
            }
            , cancel: function () {
                maskdiv = true;
            }
        });
    }
</script>
<div id="editwarp" style='width:100%;text-align:center;margin-top:5px;display:none;font-size:14px;'>
    <script type="text/plain" id="myEditor" style="width:1px;height:120px;">
    </script>
    <
    script >
    var um = UM.getEditor('myEditor');</script>
</div>
<div class="bottombar"
     style="width:100%;text-align:center;position:fixed;left:0px;bottom:0px;height:60px;line-height:60px;z-index:99999">
    <div style="max-width:670px;margin:0 auto;background:#FF9000;color:#fff;">
        <a href="javascript:;" id="savenews"
           style="border:2px solid #fff;color:#fff;padding:5px 20px;border-radius:5px;" onclick="ok8spost()">保存文章</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a id="closeeditbtn" style="border:2px solid #fff;color:#fff;padding:5px 20px;border-radius:5px;"
           onClick="javascript:window.location.href='view.php?fid=<?php echo $infoid ?>'">退出编辑</a>
    </div>
</div>
