<?php
header("Content-type: text/html; charset=utf-8");
ini_set("display_errors", "On");
error_reporting(E_ALL || E_STRICT);
$action = $_GET['act'];
if ($action == 'delimg') {
    $filename = $_POST['imagename'];
    if (!empty($filename)) {
        try {
            @unlink($filename);
        } catch (Exception $e) {
        }
        echo '1';
    } else {
        echo '删除失败，请刷新页面!';
    }
} else {
    $picname = $_FILES['mypic']['name'];
    $picsize = $_FILES['mypic']['size'];
    if ($picname != "") {
        if ($picsize > 1024000 || $picsize == 'undefined(undefinedk)') {
            echo '图片大小不能超过1M';
            exit;
        }
        $type = get_file_type($picname);
        if ($type != "gif" && $type != "jpg" && $type != "jpeg" && $type != "png") {
            echo '图片格式不对！';
            exit;
        }
        $rand = rand(100, 999);
        $pics = time() . $rand . '.' . $type;
        //上传路径
        $pic_path = mk_dir() . "/" . $pics;
        move_uploaded_file($_FILES['mypic']['tmp_name'], $pic_path);
    }
    $size = round($picsize / 1024, 2);
    $arr = array(
        'name' => $picname,
        'pic' => $pic_path,
        'size' => $size
    );
    echo json_encode($arr);
}

function get_file_type($filename) {
    return strtolower(trim(substr(strrchr($filename, '.'), 1)));
}

function mk_dir() {
    $dir = "upload/" . date("Ymd");
    if (is_dir($dir)) {
        return $dir;
    } else {
        mkdir($dir, 0766, true);
        return $dir;
    }
}
?>
