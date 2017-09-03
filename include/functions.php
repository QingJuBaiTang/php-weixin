<?php
function is_weixin() {
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $is_weixin = strpos($agent, 'micromessenger') ? true : false;
    if ($is_weixin) {
        return true;
    } else {
        return false;
    }
}

function guolv($value) {
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }
    if (!is_numeric($value)) {
        $value = mysql_real_escape_string($value);
    }
    return $value;
}

function substr_cn($str, $start, $len) {
    $strlen = $start + $len;
    $t = '';
    for ($i = 0, $j = 0; $j < $start; $i++, $j++) {
        if (ord(substr($str, $i, 1)) > 160) {
            $i += 2;
        }
    }
    for ($j = 0; $j < $len; $i++, $j++) {
        if (ord(substr($str, $i, 1)) > 160) {
            $t .= substr($str, $i, 3);
            $i += 2;
        } else {
            $t .= substr($str, $i, 1);
        }
    }
    return $t;
}

function get_contents($url) {
    if (function_exists('curl_init')) {
        $ch = curl_init();
        $timeout = 100;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        curl_setopt($ch, CURLOPT_ENCODING, "utf-8");
        $file_contents = curl_exec($ch);
        curl_close($ch);
    } else {
        $file_contents = file_get_contents($url);
    }
    return $file_contents;
}

function cut($from, $start, $end, $lt = false, $gt = false) {
    $str = explode($start, $from);
    if (isset($str['1']) && $str['1'] != '') {
        $str = explode($end, $str['1']);
        $strs = $str['0'];
    } else {
        $strs = '';
    }
    if ($lt) {
        $strs = $start . $strs;
    }
    if ($gt) {
        $strs .= $end;
    }
    return $strs;
}

function url_exists($url) {
    return !ereg("[a-zA-z]+://[^\s]*", $url);
}
?>