<?php 
define('IN_XD',true);
require("../include/common.inc.php");
//$str = $_POST[imagedata];
define('UPLOAD_DIR', '../../../upload/');
$imgd = $_POST['imagedata'];
$userid =  $_POST['uid'];
$infoid =  $_POST['pid'];
$imgd = str_replace('data:image/png;base64,', '', $imgd);
$imgd = str_replace(' ', '+', $imgd);
$data = base64_decode($imgd);
$uniqid = uniqid();
$file = UPLOAD_DIR . $uniqid . '.png';
$success = file_put_contents($file, $data);
$sql = "insert into tbl_imglist values (0,'".$userid."','".$file."','".date('Y-m-d H:i:s')."','".$infoid."')";
//echo $sql;
//exit;
mysql_query($sql);
//$text = "Here\nis\nthe\ntext.";  
//file_put_contents("data.txt", $text); 
$newhtml = '<div id="img_"'.$uniqid.' class="txt1 c3 r50">
  <div class="fr k c7 pa5 ra2 ma1 xn" data-h="querenurl(&#39;确定删除？删除将会导致所有插入此图的地方此图不能显示。&#39;,&#39;./deleteAd.php?id=3412&#39;)">删除</div>
  <div class="fr k c8 pa5 ra2 ma1 xn" data-h="showchoicephoto(1,&#39;'.$file.'&#39;)">选定</div>
  <div class="fl txt1 c8 pa2 ra2 ma1 xn" style="display:block">
    <div class="k c3 pa5 xn" style="min-width: 15px;height: 15px" data-h="morechoise(&#39;'.$file.'&#39;)"></div>
  </div>
  <div class="cb n5"></div>
  <div class="txt1 pa5">
    <img src="'.$file.'" class="photo cb"></div>
    </div>';
//echo $success ? 'html{}ok{}'.$newhtml : 'Unable to save the file.';
echo $file ;
?>