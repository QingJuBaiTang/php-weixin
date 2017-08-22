<?php
header('Content-Type:text/html; charset=utf-8');
define('IN_XD',true);
require("../include/common.inc.php");
require("../include/functions.php");
require("check.php");
$shuyu =  $_SESSION['admin_user'];
if($_POST['add']=='添加'){
	if(is_uploaded_file($_FILES['upfile']['tmp_name'])){
		$upfile=$_FILES["upfile"]; 
		//获取数组里面的值 
		$array = explode('.',$_FILES['upfile']['name']);
		$type=$upfile["type"];//上传文件的类型 
		$size=$upfile["size"];//上传文件的大小 
		$tmp_name=$upfile["tmp_name"];//上传文件的临时存放路径 
		$name = '/upload/music/'.iconv('UTF-8', 'GBK', $array[0]).'.'.$array[1];
		//判断是否为音乐 
		switch ($type){ 
			case 'audio/mp3':$okType=true; 
			break; 
		}
		if($okType){ 
			$error=$upfile["error"];//上传后系统返回的值 
			//把上传的临时文件移动到up目录下面 
			if (!move_uploaded_file($tmp_name,dirname(dirname(__FILE__)).$name)){
				qy_alert_back('上传失败');
			}
		}else{ 
			qy_alert_back('请上传mp3文件');
		}
		$sql = "INSERT INTO tbl_music (title,path,add_time,cat_id) value ('".$_POST['title']."','".'/upload/music/'.$_FILES['upfile']['name']."','".time()."',".$_POST['cat_id'].")";
		mysql_query($sql);
		if(mysql_affected_rows() == 1){
			xd_close();
			echo "<script>alert('添加成功！');window.location.href='music_list.php';</script>";
			exit;
		}else{
			xd_close();
			qy_alert_back('信息编辑失败或无修改动作!');
		}
	}else{
		qy_alert_back('请上传mp3文件');
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>易推</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/select-ui.min.js"></script>
	</head>
	<body>
		<div class="place">
		    <span>位置：</span>
		    <ul class="placeul">
			    <li><a href="main.php">首页</a></li>
			    <li><a href="#">音乐管理</a></li>
		    </ul>
	    </div>
	    <form action="" method="post" name="newsform"  enctype="multipart/form-data">
		    <div class="formbody">
		    <div class="formtitle"><span>添加音乐</span></div>
		    <ul class="forminfo">
		    	<li><label>分类</label>
		    		<select name="cat_id" >
		    		<?
						$page_sql = "select * from tbl_music";
						$sql = "select * from tbl_music_cat ORDER by id DESC";
						$query=mysql_query($sql);
						while($rowc=mysql_fetch_array($query)){
					?>
						<option   value="<?=$rowc['id']?>"><?=$rowc['name']?></option>
				    <?
					}
					?>  
					</select> 
				</li> 
				<li><label>名称</label><input name="title" type="text"  class=""  value="必填"/></li>
				<li><label>上传</label><input name="upfile" type="file"  class=""/></li>
			    <li><label>&nbsp;</label><input name="add" type="submit" class="btn" value="添加"/></li>
		    </ul>
		    </div>
		</form>
	</body>
</html>
