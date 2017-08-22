<?php
define('IN_XD',true);
require("../include/common.inc.php");
$uid = $_POST["data"];
//echo ($uid);
//exit;
$html1 = '<div class="k xn c6 pa5 ra5 ma1 w80 fr" data-h="showmodal(0)" style="background-color: #FF0000;">返回编辑</div>
<!--<div class="k xn c6 pa5 ra5 ma1 w80 fr" data-h="ojax(&#39;/newEdit/js/ajax/advert_edit.php&#39;)">新建广告</div>-->
<div class="cb n5"></div>
<div class="txt1 pa20">
  <div class="txt1 c8 ra5 pa1">
    <div class="c3 ra5 pa2">
      <dl class="clearfix" style="padding-left:5px;>
			<dd  style=" margin-left:35; z-index:auto; margin-top:2px;">
                 广告位置类型：
                 <label style="margin-left:5px;"><input name="isflow" type="checkbox" id="isflow" value="0" />是否浮动  </label>
                 <label style="margin-left:5px;"><input name="adweizhi" type="radio" id="wz_dqwz" value="1" checked="CHECKED" />当前位置 </label>
                 <label style="margin-left:5px;"><input name="adweizhi" type="radio" id="wz_pf" value="2"  />漂浮 </label>
                 <label style="margin-left:5px;" onClick="add_my_ad(&#39;'.'99999999'.'&#39;);"><input name="adweizhi" type="radio" id="wz_dbwz" value="3"  />底部文字 </label>
                 <label style="margin-left:5px;" onClick="add_my_ad(&#39;'.'99999999'.'&#39;);"><input name="adweizhi" type="radio" id="wz_dblb" value="4"  />底部轮播 </label>
                 <label style="margin-left:5px;"><input name="adweizhi" type="radio" id="wz_dbdt" value="5"  />底部单条 </label>
            </dd>
            </dl>
      <!--<div class="cb n5"></div>-->
    </div>
  </div>
</div>
';
$sql="select * from tbl_ad where is_check > 0 and username='".$uid."' ORDER by id ASC ";
$query=mysql_query($sql);
while($row=mysql_fetch_array($query)){
$html2 = $html2.'<div class="cb n5"></div><div class="txt1 pa20"><div class="txt1 c8 ra5 pa1"><div class="c3 ra5 pa2">
			<div class="pa10 cb liti">广告</div>
			<div class="txt1" id="insertad_'.$row["id"].'"><div class="pa5 anc bn" id="add1999" style=" position: relative;">
			<div style="position: absolute; top:75%; left:80%; margin-right:5px;">
    <a href="http://www.yizgg.com/hydl.php" ><img src="images/myadd.png" style="width:90px; max-height:20px;" ></a>
</div>
			<a href="javascript:posad(\''.$row["id"].'\')"><img src="'.$row["ad_img"].'"></a></div></div><div class="cb n5"></div>'.$row["ad_title"].'</div></div>					
			<div class="cb n5"></div>
			<div class="k xn c2 pa5 ra5 ma1 w100 fr" data-h="add_my_ad(&#39;'.$row["id"].'&#39;);">选定</div>					
			<!--<div class="k xn c6 pa5 ra5 ma1 w80 fr" data-h="ojax(&#39;/newEdit/js/ajax/advert_edit.php?id='.$row["id"].'&#39;)">修改</div><div class="k xn c6 pa5 ra5 ma1 w80 fr" data-h="queren(&#39;确定删除此广告？&#39;,&#39;ojax(\&#39;/newEdit/js/ajax/advert_delete.php?id='.$row["id"].'\&#39;)&#39;)">删除</div>-->	</div>';
}
$html3 = '';
$finalHtml = $html1 . $html2 . $html3;
echo 'inmgupload{{}}mymodal{}#mymodal{}'.$finalHtml.'{{}}ok';
			?>