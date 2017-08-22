<?php 
define('IN_XD',true);
require("../include/common.inc.php");
//$str = var_dump($_POST);
$uid = $_POST["data"];
$newhtml1 = '<canvas id="myCanvas" style="display:none;"></canvas> 
<div class="tit1 h4">服务器上的图片</div>
<div class="n5 cb"></div>
<div id="adcbox" style="display:none;position:relative"> <canvas id="adCanvas" width="100" height="200"></canvas>
    <div id="fgbox" style="width:200;position:absolute;top:0px;background-color:rgb(110, 110, 110); filter:alpha(opacity=80); -moz-opacity:0.8; -khtml-opacity: 0.8; opacity: 0.8; "> <div id="loadnum" class="ra5 pa10 h1" style="width:60px;margin:auto;color:white;background-color:rgb(110, 110, 110); ">0%</div> </div> </div> 
<div class="n5 cb"></div>
<div class="k xn c16 fr ra2 ma1" data-h="showmodal(0)">返回</div>
<div id="up_pic" class="k xn c13 fr ra2 ma1" style="position:relative;color:red;text-align:center;background-color: deepskyblue;"> 上传图片<input type="file" id="fileimg" style="width:100%;height:100%; cursor: pointer;outline: medium none; position: absolute; filter:alpha(opacity=0);-moz-opacity:0;opacity:0; left:0px;top: 0px;" onchange="showuphtml(1);"></div>
<div class="k xn c8 fr ra2 ma1" style="display:block" data-h="ok_imglist()">确定批量选择</div>
<div class="n5 cb"></div>
<script>
    var moreimglist = "";
    function morechoise(url) {
		//alert(\'morechoise\');
        if (k_obj.attr("class").indexOf("c3") > 0) {
            k_obj.removeClass("c3");
            k_obj.addClass("c13");
            moreimglist += url + ",";
        } else if (k_obj.attr("class").indexOf("c13") > 0) {
            k_obj.removeClass("c13");
            k_obj.addClass("c3");
            moreimglist = moreimglist.replace(url + ",", "");
        }
    }
    function ok_imglist() {
		//alert(\'ok_imglist\');
        var arr = moreimglist.split(",");
        if (arr.length < 1) {
            alert("请先选择图片。");
        }
        if (1 == 1) {
            var htm = \'\';
            for (var i = 0; i < arr.length; i++) {
                if (arr[i].length > 1) {
                    select_id++;
                    htm += \'<div class="n5"></div><img id="a\' + select_id + \'" width="100%" src="\' + arr[i] + \'">\';
                }
            }
            p_obj.after(htm);
            if ($(\'.c7\').length > 0) {
                $(\'.c7\').removeClass(\'c7 pa5\');
            }
            $("#ok8sedit").remove();
            $("#ok8sinput").remove();
            showmodal(0);
        } else {
            alert("编辑下才能用此功能。");
        }
    }
    function showupimghtml() {
		//alert(\'showupimghtml\');
        var fileObj = document.getElementById("fileimg").files[0];
        $("#up_pic").html("上传中。。。");
        loadingImage(fileObj);
    }
    function renderstart(src, type) {
		//alert(\'renderstart\');
        image = new Image();
        image.onload = function () {
			alert(\'onload\');
            var canvas = document.getElementById("myCanvas");
            if (image.width > MAX_WIDTH) {
                image.height = image.height * MAX_WIDTH / image.width;
                image.width = MAX_WIDTH;
            }
            var ctx = canvas.getContext("2d");
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            canvas.width = image.width;
            canvas.height = image.height;
            ctx.drawImage(image, 0, 0, image.width, image.height);
            var data = ctx.getImageData(0, 0, image.width, image.height).data;
            var red = 0, blue = 0, green = 0, alpha = 0;
            for (var i = 0, len = data.length; i < len; i += 4) {
                red += data[i];
                green += data[i + 1];
                blue += data[i + 2];
                alpha += data[i + 3];
            }
            var ared = 255 - red / (image.width * image.height);
            var agreen = 255 - green / (image.width * image.height);
            var ablue = 255 - blue / (image.width * image.height);
            sendimgImage();
        };
        image.src = src;
		alert(image.src);
    }
    function loadingImage(src) {
		//alert(\'loadingImage\');
        var type = src.type;
        if (!type.match(/image.*/)) {
            if (window.console) {
                console.log("选择的文件类型不是图片: ", src.type);
            } else {
                window.confirm("只能选择图片文件");
            }
            return;
        }
        var reader = new FileReader();
        reader.onload = function (e) {
            renderstart(e.target.result, type);
        };
        reader.readAsDataURL(src);
    }
    function sendimgImage() {
		//alert(\'sendimgImage\');
        loadi = 0;
        pageload();
        var canvas = document.getElementById("myCanvas");
        var dataurl = canvas.toDataURL("image/png");
		//alert(dataurl);
        var imagedata = dataurl;
        url = "/newEdit/js/ajax/upimg.php";
        var data = {
            imagedata: imagedata,
			pid:$("#qid").val(),
			uid:$("#uid").val(),
            k: getkey(\'k\')
        };
		//alert(url);
        $.ajax({
            url: url,
            data: data,
            type: "POST",
            dataType: "json",
            complete: function (xhr, result) {
                if (!xhr) {
                    alert("网络连接失败,上传错误。");
                    return;
                }
                var text = xhr.responseText;
				//alert(text);
                if (!text) {
                    alert("网络错误,上传错误。");
                    return;
                }
				$("#myimg").append(text);
				$("#myCanvas").html("");
            }
        });
    }
    function showchoicephoto(t, url ,j) {
		//alert(\'showchoicephoto\');
        if (t == 0) {
            var htm = "<img src=\'" + url + "\' class=\'photo\'>";
            $("#showphoto").html(htm);
            $("#photourl").val(url);
        } else if (t == 1) {
            select_id++;
            var htm = \'<div class="n5"></div><img id="a\' + select_id + \'" width="100%" src="\' + url + \'">\';
            p_obj.after(htm);
            if ($(\'.c7\').length > 0) {
                $(\'.c7\').removeClass(\'c7 pa5\');
            }
            $("#ok8sedit").remove();
            $("#ok8sinput").remove();
        } else {
            goodsdetail(url, t);
        }
        showmodal(0);
    }
    function showchangephoto(t, url) {
		//alert(\'showchangephoto\');
        if (t == 0) {
            var htm = "<img src=\'" + url + "\' class=\'photo\'>";
            $("#showphoto").html(htm);
            $("#photourl").val(url);
        } else if (t == 1) {
            select_id++;
            var htm = \'<div class="n5"></div><img id="a\' + select_id + \'" width="100%" src="\' + url + \'">\';
            if ($(p_obj).attr("src")) {
                $(p_obj).attr("src", url);
            } else {
                p_obj.html(htm);
            }
            if ($(\'.c7\').length > 0) {
                $(\'.c7\').removeClass(\'c7 pa5\');
            }
            $("#ok8sedit").remove();
            $("#ok8sinput").remove();
        } else {
            goodsdetail(url, t);
        }
        showmodal(0);
    }
</script>
<div id="myimg"> 
'	;		
$sql="select * from tbl_imglist where userid='".$uid."' ORDER by id DESC ";
			$query=mysql_query($sql);
			while($row=mysql_fetch_array($query)){
				$newhtml = $newhtml.'<div id="img_"'.$row['id'].' class="txt1 c3 r50">
  <div class="fr k c7 pa5 ra2 ma1 xn" data-h="querenurl(&#39;确定删除？删除将会导致所有插入此图的地方此图不能显示。&#39;,&#39;./deleteAd.php?id='.$row['id'].'&#39;)">删除</div>
  <div class="fr k c8 pa5 ra2 ma1 xn" data-h="showchoicephoto(1,&#39;'.$row['piclink'].'&#39;)">选定</div>
  <div class="fl txt1 c8 pa2 ra2 ma1 xn" style="display:block">
    <div class="k c3 pa5 xn" style="min-width: 15px;height: 15px" data-h="morechoise(&#39;'.$row['piclink'].'&#39;)"></div>
  </div>
  <div class="cb n5"></div>
  <div class="txt1 pa5">
    <img src="'.$row['piclink'].'" class="photo cb"></div>
    </div>';
			}
$finalHtml = $newhtml1 . $newhtml ;
echo 'inmgupload{{}}mymodal{}#mymodal{}'.$finalHtml.'{{}}ok';
//echo $uid;
?>