<?php
header('Content-Type:text/html; charset=utf-8');
define('IN_XD', true);
require("include/common.inc.php");
session_start();
$infoid = trim($_GET['fid']);
$fid = trim($_GET['fid']);
$sqlu = "select * from tbl_info where infoid = " . $infoid;
$query = mysql_query($sqlu);
$row = mysql_fetch_array($query);
if ($_GET['act'] == 'add') {
    $sql = "INSERT INTO tbl_complain " .
        "VALUES(
	0,
	'" . $_POST["fid"] . "',
	'" . $_POST["title"] . "',
	'" . date('Y-m-d H:i:s') . "',
	'" . $_POST["reson"] . "'
	)";
    mysql_query($sql);
    if (mysql_affected_rows() == 1) {
        xd_close();
        echo "<script type='text/javascript'>alert('提交成功');location.href='view.php?fid=" . $_POST['fid'] . "';</script>";
        exit;
    } else {
        xd_close();
        qy_alert_back('注册失败');
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>投诉</title>
    <meta name="description" content=""/>
    <meta name="viewport"
          content="width=device-width , initial-scale=1.0 , user-scalable=0 , minimum-scale=1.0 , maximum-scale=1.0"/>
    <script type='text/javascript' src='/js/jquery-2.0.3.min.js'></script>
    <link href="/css/complain.css" rel="stylesheet"/>
<body>
<div id="header">
    请选择投诉原因
</div>
<form action="?act=add" method="post">
    <ul class="bor">
        <li c="1">欺诈</li>
        <li c="2">色情</li>
        <li c="3">政治谣言</li>
        <li c="4">常识性谣言</li>
        <li c="5" style="border:none;">恶意营销</li>
    </ul>
    <input type="hidden" name="fid" value="<?php $infoid = trim($_GET['fid']);
    echo $infoid ?>"/>
    <input type="hidden" name="title" value="<?php echo urldecode($row['title']); ?>"/>
    <input id="reson" type="hidden" name="reson" value=""/>
    <input class="btn" onClick="return check()" type="submit" value="提交"/>
</form>
</body>
<script type="text/javascript">
    $(function () {
        $(".bor li").click(function () {
            $(".bor li").removeClass('choose');
            $(this).addClass('choose');
            var c = $(this).attr('c');
            $("input[name=complain]").val(c);
//		alert($(this).text());  
            $("#reson").val($(this).text());
        });
    });

    function check() {
        var complain = $("input[name=complain]").val();
        if (complain == '') {
            alert('请选择投诉原因');
            return false;
        }
    }
</script>
</html>