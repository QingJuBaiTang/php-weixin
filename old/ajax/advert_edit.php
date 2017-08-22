<?php
$finalHtml = '<div class="txt1">广告文字：<br>
	  <textarea class="inp pa10" id="d_text" style="height: 100px; value=" "=""></textarea>
       <div class="cb n5"></div></div> <div class="txt1">链接地址(可放入淘宝购买网址)：<br><spam style="color:#f00">(中国唯一一家淘宝和微信相互融合的平台)<input id="d_url" type="text" style="width:85%;float: left;" class="inp pa10" placeholder="点击广告跳转到此地址" value=""><div class="k xn c5 fr ra2 ma1" data-h="$(&#39;#d_url&#39;).val(&#39;&#39;)" style="">清空</div></spam></div><div class="txt1">上传广告图片：<br><div class="txt1">底部广告（图片120X80）:<input type="checkbox" id="bottom"></div><div class="inp pa10"><div id="showphoto"></div> <input type="hidden" id="photourl" value=""><iframe src="/newEdit/js/ajax/upload.htm" frameborder="0" scrolling="no" style="width:100%;height:60px;"></iframe></div><div class="cb n5"></div></div><div class="txt1">在图片中间插入下列文字：<br><input id="water" type="text" class="inp pa10" value=""></div><div class="txt1" style="float:left;">请选择插入位置：<br>
				  <select name="weizhi" id="weizhi" style="width:95px;">
				  <option value="7">图片左下角</option>
				  <option value="8">图片中下角</option>
				  <option value="9">图片右下角</option>
				  </select>
				  </div><div class="txt1" style="float:left;">选择插入文字颜色：<br>
				  <select name="yanse" id="yanse" style="width:95px;">
				  <option value="#FF0000">红色</option>
				  <option value="#0000C6">蓝色</option>
				  <option value="#00DB00">绿色</option>
				  </select>
				  </div><div class="txt1 k xn c12 ra2 ma1" data-h="$(&#39;#showphoto&#39;).html(&#39;&#39;);$(&#39;#photourl&#39;).val(&#39;&#39;);" style="    padding-left: 4px;">删除图片</div><div class="m5" style=" margin-top:10px; margin-left:0px;"><div class="k xn c13 fl ra2 ma1 w100" id="replybutton" data-h="edit_ad_ck(&#39;&#39;)" style="position: relative;top: -473px;right: -220px;">提交</div></div>';
echo 'inmgupload{{}}mymodal{}#mymodal{}'.$finalHtml.'{{}}ok';  
				  ?>