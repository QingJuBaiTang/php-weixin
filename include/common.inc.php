<?php
error_reporting(0);

//防止恶意调用
if(!defined('IN_XD')){
	exit('Access denied!');
}

include("include/website.inc.php");

//设置字符集编码
//header('Content-Type:text/html; charset=utf-8');

//转换硬路径常量
define('QY_ROOT',substr(dirname(__FILE__),0,-7));

//拒绝PHP低版本
if(PHP_VERSION<'4.1.0'){
	exit('Version is to Low!');
}

require QY_ROOT.'include/global.func.php';
require QY_ROOT.'include/mysql.func.php';

//连接数据库
define('DB_HOST','localhost');//数据库连接地址,数据库接口（默认：3306)
define('DB_USER','root');//数据库用户名
define('DB_PWD','root');//数据库密码
define('DB_NAME','wx50');//数据库名

date_default_timezone_set(PRC);

xd_connect();
xd_select_db();
xd_set_names();
?>