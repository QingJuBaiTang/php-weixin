<script>
    $(document).ready(function () {
        $(".copyurl").click(function () {
            var fburl = $(this).attr("id");
            $("#wxlink").val(fburl);
            var sharepic = $(this).data('sharepic');
            $("#sharepic").val(sharepic);
            $("html,body").animate({scrollTop: $("#wxlink").offset().top}, 1000);
        });
    });
    $(document).ready(function () {
        $(".zjfx").click(function () {
            var fburl = $(this).attr("id");
            $("#wxlink").val(fburl);
            postcheck();
        });
    });
</script>
<?php
error_reporting(0);
header("content-Type: text/html; charset=Utf-8");
set_time_limit(60);
include 'include/phpQuery/phpQuery.php';
$cjid = $_POST['cjid'];
$cjtitle = '';
$preg = '/<a .*?href="(.*?)".*?>/is';//取链接正则
$ydpreg = '/<\/span>阅读(.*?)<bb/is';//阅读量正则
//$titreg='/<h4>(.*?)<\/h4>/is';//标题正则
$cjurl = "http://weixin.sogou.com/pcindex/pc/" . $cjid . "/" . $cjid . ".html";//要采集地址
//phpQuery::newDocumentFile('http://weixin.sogou.com/pcindex/pc/pc_1/pc_1.html'); 
phpQuery::newDocumentFile($cjurl);
//$artlist = pq("#pc_0_subd");
$artlist = pq(".txt-box");
$sourcelist = pq(".news-list >li");
$imglist = pq(".img-box");
$cjzong = $artlist;
//if(is_array($cjzong)){ 
//echo "8888<br>";
//}
$imgliststr = '';
$imglistArr = array();
//var_dump($imglist);
foreach ($imglist as $key => $img) {
    $strimg = pq($img)->find('img')->attr('src');
    $strimg = urldecode($strimg);
    $tmpArr = explode('&url=', $strimg);
    $replaceStr = $tmpArr[0];
//	$strimg=str_replace($replaceStr,'http://img02.sogoucdn.com/net/a/04/link?appid=100520033',$strimg);
    $strimg = str_replace($replaceStr, 'image_proxy.php?1=1&siteid=1', $strimg);
    $imgliststr .= $strimg . '<br/>';
    $imglistArr[$key] = $strimg;
}
$sourceliststr = '';
$sourcelistArr = array();
foreach ($sourcelist as $key => $source) {
    $strsource = pq($source)->find('p')->text();
    $strsource = urldecode($strsource);
    $tmpArr = explode('&url=', $strsource);
    $replaceStr = $tmpArr[0];
    //$strsource=str_replace($replaceStr,'image_proxy.php?1=1',$strsource);
    $sourceliststr .= $strsource . '<br/>';
    $sourcelistArr[$key] = $strsource;
}
foreach ($cjzong as $key => $company) {
    $cont = pq($company)->find('h3')->html();
    $ydcont = pq($company)->find('.account')->html();//阅读量
    $imgsrc = pq($imglist[$key])->find('img')->attr('src');
    preg_match_all($preg, $cont, $match);//链接
    preg_match_all($ydpreg, $ydcont, $ydmatch);//阅读量
    $tHref = $match[1][0];
    $gtHref = str_replace(array("&amp;", "#"), array("|", ".."), $tHref);
    $sharepic_url = str_replace(array("&", "#"), array("|", ".."), $imglistArr[$key]);
    $cjtitle = $cjtitle .
        "<li>
	<ul>
		<li class='tit'>
			<div style='float:left;padding-right:10px;'>
				<img style='width:80px;height:65px;' src=" . $imglistArr[$key] . "></div>" . $cont . "
		</li>";
    $cjtitle = $cjtitle . "<li class='cont'><span class='ydl'><!--shafa公众号:" . $sourcelistArr[$key] . "    -->公众号:" . $ydcont . "</span><span><a href='javascript:void(0);' class='copyurl shafa公众号' id=" . $tHref . " data-sharepic='" . $imglistArr[$key] . "'>复制地址</a><a href='javascript:void(0);' class='zjfx shafa公众号' id=" . $tHref . " data-sharepic='" . $imglistArr[$key] . "'>立即分享</a></span></li></ul></li>";
}
echo $cjtitle;
?>