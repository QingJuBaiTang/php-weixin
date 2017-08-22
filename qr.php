<?php
require("include/phpqrcode.php");
$urlbefore=$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
$value=strstr( $urlbefore, 'url=');
$value=str_replace("url=", "",$value); 
QRcode::png($value);   
Header("Content-type: image/png");
