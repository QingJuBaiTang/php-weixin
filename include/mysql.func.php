<?php
error_reporting(0);
if(!defined('IN_XD')){
	exit('Access deniend!');
}
function xd_connect(){
	global $conn;
	if(!$conn=@mysql_connect(DB_HOST,DB_USER,DB_PWD)){
		exit('数据库连接失败!');
	}
}
function xd_select_db(){
	if(!mysql_select_db(DB_NAME)){
		exit('找不到指定数据库!');
	}
}
function xd_set_names(){
	if(!mysql_query('SET NAMES UTF8')){
		exit('字符集错误!');
	}
}
function xd_close(){
	if(!mysql_close()){
		exit('数据库关闭异常!');
	}
}
?>