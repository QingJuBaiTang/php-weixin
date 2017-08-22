<?php
class String {
    /**
     * 生成UUID 单机使用
     * @access public
     * @return string
     */
     static public function uuid() {
        $charid = md5(uniqid(mt_rand(), true));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
               .substr($charid, 0, 8).$hyphen
               .substr($charid, 8, 4).$hyphen
               .substr($charid,12, 4).$hyphen
               .substr($charid,16, 4).$hyphen
               .substr($charid,20,12)
               .chr(125);// "}"
        return $uuid;
    }
    /**
     * 生成Guid主键
     * @return Boolean
     */
    static public function keyGen() {
        return str_replace('-','',substr(String::uuid(),1,-1));
    }
    /**
     * 检查字符串是否是UTF8编码
     * @param string $string 字符串
     * @return Boolean
     */
    static public function isUtf8($str) {
        $c=0; $b=0;
        $bits=0;
        $len=strlen($str);
        for($i=0; $i<$len; $i++){
            $c=ord($str[$i]);
            if($c > 128){
                if(($c >= 254)) return false;
                elseif($c >= 252) $bits=6;
                elseif($c >= 248) $bits=5;
                elseif($c >= 240) $bits=4;
                elseif($c >= 224) $bits=3;
                elseif($c >= 192) $bits=2;
                else return false;
                if(($i+$bits) > $len) return false;
                while($bits > 1){
                    $i++;
                    $b=ord($str[$i]);
                    if($b < 128 || $b > 191) return false;
                    $bits--;
                }
            }
        }
        return true;
    }
    /**
     * 字符串截取，支持中文和其他编码
     * @static
     * @access public
     * @param string $str 需要转换的字符串
     * @param string $start 开始位置
     * @param string $length 截取长度
     * @param string $charset 编码格式
     * @param string $suffix 截断显示字符
     * @return string
     */
    static public function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
        if(function_exists("mb_substr"))
            $slice = mb_substr($str, $start, $length, $charset);
        elseif(function_exists('iconv_substr')) {
            $slice = iconv_substr($str,$start,$length,$charset);
        }else{
            $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
            $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
            preg_match_all($re[$charset], $str, $match);
            $slice = join("",array_slice($match[0], $start, $length));
        }
        return $suffix ? $slice.'...' : $slice;
    }
   
    /**
     * 生成一定数量的随机数，并且不重复
     * @param integer $number 数量
     * @param string $len 长度
     * @param string $type 字串类型
     * 0 字母 1 数字 其它 混合
     * @return string
     */
    static public function buildCountRand ($number,$length=4,$mode=1) {
            if($mode==1 && $length<strlen($number) ) {
                //不足以生成一定数量的不重复数字
                return false;
            }
            $rand   =  array();
            for($i=0; $i<$number; $i++) {
                $rand[] =   self::randString($length,$mode);
            }
            $unqiue = array_unique($rand);
            if(count($unqiue)==count($rand)) {
                return $rand;
            }
            $count   = count($rand)-count($unqiue);
            for($i=0; $i<$count*3; $i++) {
                $rand[] =   self::randString($length,$mode);
            }
            $rand = array_slice(array_unique ($rand),0,$number);
            return $rand;
    }
    /**
     *  带格式生成随机字符 支持批量生成
     *  但可能存在重复
     * @param string $format 字符格式
     *     # 表示数字 * 表示字母和数字 $ 表示字母
     * @param integer $number 生成数量
     * @return string | array
     */
    static public function buildFormatRand($format,$number=1) {
        $str  =  array();
        $length =  strlen($format);
        for($j=0; $j<$number; $j++) {
            $strtemp   = '';
            for($i=0; $i<$length; $i++) {
                $char = substr($format,$i,1);
                switch($char){
                    case "*"://字母和数字混合
                        $strtemp   .= String::randString(1);
                        break;
                    case "#"://数字
                        $strtemp  .= String::randString(1,1);
                        break;
                    case "$"://大写字母
                        $strtemp .=  String::randString(1,2);
                        break;
                    default://其他格式均不转换
                        $strtemp .=   $char;
                        break;
               }
            }
            $str[] = $strtemp;
        }
        return $number==1? $strtemp : $str ;
    }
    /**
     * 获取一定范围内的随机数字 位数不足补零
     * @param integer $min 最小值
     * @param integer $max 最大值
     * @return string
     */
    static public function randNumber ($min, $max) {
        return sprintf("%0".strlen($max)."d", mt_rand($min,$max));
    }
    // 自动转换字符集 支持数组转换
    static public function autoCharset($string, $from='gbk', $to='utf-8') {
        $from = strtoupper($from) == 'UTF8' ? 'utf-8' : $from;
        $to = strtoupper($to) == 'UTF8' ? 'utf-8' : $to;
        if (strtoupper($from) === strtoupper($to) || empty($string) || (is_scalar($string) && !is_string($string))) {
            //如果编码相同或者非字符串标量则不转换
            return $string;
        }
        if (is_string($string)) {
            if (function_exists('mb_convert_encoding')) {
                return mb_convert_encoding($string, $to, $from);
            } elseif (function_exists('iconv')) {
                return iconv($from, $to, $string);
            } else {
                return $string;
            }
        } elseif (is_array($string)) {
            foreach ($string as $key => $val) {
                $_key = self::autoCharset($key, $from, $to);
                $string[$_key] = self::autoCharset($val, $from, $to);
                if ($key != $_key)
                    unset($string[$key]);
            }
            return $string;
        }
        else {
            return $string;
        }
    }
}