<?php

$action = $_GET['act'];

if($action=='delimg'){

	$filename = $_POST['imagename'];

	if(!empty($filename)){

	try{

	@unlink('./files/'.$filename);

	}catch(Exception $e){

	

	}

		echo '1';

	}else{

		echo '删除失败，请刷新页面!';

	}



}else{

	$picname = $_FILES['mypic']['name'];

	$picsize = $_FILES['mypic']['size'];

	

	if ($picname != "") {

		if ($picsize > 1024000 || $picsize =='undefined(undefinedk)') {

			echo '图片大小不能超过1M';

			exit;

		}

		$type = get_file_type($picname);

	

		if ($type != "gif" && $type != "jpg" && $type != "jpeg" && $type != "png") {

			echo '图片格式不对！';

			exit;

		}

		$rand = rand(100, 999);

		$pics = date("YmdHis") . $rand . '.'.$type;

		//上传路径

		$pic_path = "files1/". $pics;

		move_uploaded_file($_FILES['mypic']['tmp_name'], $pic_path);

	}

	$size = round($picsize/1024,2);

	$arr = array(

		'name'=>$picname,

		'pic'=>$pics,

		'size'=>$size

	);

	echo json_encode($arr);

}



function get_file_type($filename){

   return strtolower(trim(substr(strrchr($filename, '.'), 1)));

}

?>