<?php
error_reporting(0);
define('IN_XD', true);
session_start();
require("include/common.inc.php");
if ($_POST['id']) {
    $sql = "update tbl_info set acount=acount+1 where id=" . $_POST['id'];
    if (mysql_query($sql)) {
        echo 1;
        exit;
    } else {
        echo 0;
        exit;
    }
} else {
    echo 0;
    exit;
}
?>