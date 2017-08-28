<?php
error_reporting(0);
if (!defined('IN_XD')) {
    exit('Access deniend!');
}

function qy_alert_back($_info) {
    echo "<script type='text/javascript'>alert('$_info');history.back();</script>";
    exit();
}

function qy_location($_info, $_url) {
    if (!empty($_info)) {
        echo "<script type='text/javascript'>alert('$_info');location.href='$_url';</script>";
        exit();
    } else {
        header('Location:' . $_url);
    }
}

//分页
function qy_page($_sql, $_size) {
    global $_page, $_pagesize, $_pagenum, $_pageabsolute, $_num;
    if (isset($_GET['page'])) {
        $_page = $_GET['page'];
        if (empty($_page) || $_page <= 0 || !is_numeric($_page)) {
            $_page = 1;
        } else {
            $_page = intval($_page);
        }
    } else {
        $_page = 1;
    }
    $_pagesize = $_size;
    $_num = mysql_num_rows(mysql_query($_sql));
    if ($_num == 0) {
        $_pageabsolute = 1;
    } else {
        $_pageabsolute = ceil($_num / $_pagesize);
    }
    if ($_page > $_pageabsolute) {
        $_page = $_pageabsolute;
    }
    $_pagenum = ($_page - 1) * $_pagesize;
}

function qy_page1($array, $_sizex) {
    global $_pagex, $_pagesizex, $_pagenumx, $_pageabsolutex, $_num, $num1, $_numx, $html;
    if (isset($_GET['page'])) {
        $_pagex = $_GET['page'];
        if (empty($_pagex) || $_pagex <= 0 || !is_numeric($_pagex)) {
            $_pagex = 1;
        } else {
            $_pagex = intval($_pagex);
        }
    } else {
        $_pagex = 1;
    }
//($_pagex == "")? $_pagex = 1 : $_pagex = $_GET['page']; 
    $_pagesizex = $_sizex;
    $_numx = count($array);
    //$_numx = intval($_numx/$_num);
    if ($_numx == 0) {
        $_pageabsolutex = 1;
    } else {
        $_pageabsolutex = ceil($_numx / $_pagesizex);
    }
    if ($_pagex > $_pageabsolutex) {
        $_pagex = $_pageabsolutex;
    }
    $_pagenumx = ($_pagex - 1) * $_pagesizex;
}

function qy_paging11() {
    global $_pagex, $_pageabsolutex, $_numx, $_idx, $html;
    echo '<span style="padding-top:5px;line-height:45px;"> 共 ' . $_pageabsolutex . ' 页 当前第 ' . $_pagex . ' 页 ';
    if ($_pagex == 1) {
        echo '<a >首页</a> <a  >上一页</a>';
    } else {
        echo '<a href="' . SCRIPT . '.php?' . $_idx . 'page=1" >首页</a>  ';
        echo '<a href="' . SCRIPT . '.php?' . $_idx . 'page=' . ($_pagex - 1) . '" >上一页</a>  ';
    }
    if ($_pagex == $_pageabsolutex) {
        echo '<a >下一页</a> <a  >尾页</a>';
    } else {
        echo '<a href="' . SCRIPT . '.php?' . $_idx . 'page=' . ($_pagex + 1) . '" >下一页</a> | ';
        echo '<a href="' . SCRIPT . '.php?' . $_idx . 'page=' . $_pageabsolutex . '" >尾页</a>';
    }
    echo '</span> ';
}

function qy_paging() {
    global $_page, $_pageabsolute, $_num, $_id;
    echo '<div id="page_text">';
    echo '<ul>';
    echo '<li>' . $_page . '/' . $_pageabsolute . '页 | </li>';
    echo '<li>共有<strong>' . $_num . '</strong>条数据 | </li>';
    if ($_page == 1) {
        echo '<li>首页 | </li>';
        echo '<li>上一页 | </li>';
    } else {
        echo '<li><a href="' . SCRIPT . '.php?' . $_id . 'page=1">首页</a> | </li>';
        echo '<li><a href="' . SCRIPT . '.php?' . $_id . 'page=' . ($_page - 1) . '">上一页</a> | </li>';
    }
    if ($_page == $_pageabsolute) {
        echo '<li>下一页 | </li>';
        echo '<li>尾页</li>';
    } else {
        echo '<li><a href="' . SCRIPT . '.php?' . $_id . 'page=' . ($_page + 1) . '">下一页</a> | </li>';
        echo '<li><a href="' . SCRIPT . '.php?' . $_id . 'page=' . $_pageabsolute . '">尾页</a></li>';
    }
    echo '</ul>';
    echo '</div>';
}

function qy_paging3($param) {
    global $_page, $_pageabsolute, $_num, $_id;
    if ($_page == 1) {
        //echo '<a href="javascript::" style="margin-left:10px;"><img src="images/triangle-left.png"/></a>';
    } else {
        echo '<a href="' . SCRIPT . '.php?' . $param . '&' . $_id . 'page=' . ($_page - 1) . '" style="margin-left:10px;">上一页</a>';
    }
    if ($_page == $_pageabsolute) {
        //echo '<a href="javascript::" style="float:right;margin-right:10px;"><img src="images/triangle-right.png"/></a>';
    } else {
        echo '<a href="' . SCRIPT . '.php?' . $param . '&' . $_id . 'page=' . ($_page + 1) . '" style="float:right;margin-right:10px;">下一页</a>';
    }
}

function qy_paginga() {
    global $_page, $_pageabsolute, $_num, $_id;
    //echo $_page.'/'.$_pageabsolute.'页 | ';
    //echo '共有<strong>'.$_num.'</strong>条数据 | ';
    echo '<div class="pagin"><div class="message">共<i class="blue">' . $_num . '</i>条记录，当前显示第&nbsp;<i class="blue">' . $_page . '&nbsp;</i>页</div><ul class="paginList">';
    if ($_page == 1) {
        //echo '<a href="#">上一页</a>';
        echo '<li class="paginItem"><a href="javascript:;"><span class="pagepre"></span></a></li>';
    } else {
        //echo '<a href="'.SCRIPT.'.php?'.$_id.'page='.($_page-1).'">上一页</a>';
        echo '<li class="paginItem"><a href="' . SCRIPT . '.php?' . $_id . 'page=' . ($_page - 1) . '"><span class="pagepre"></span></a></li>';
    }
    if ($_pageabsolute > 5) {
        if ($_pageabsolute - $_page > 4) {
            for ($i = $_page; $i < ($_page + 5); $i++) {
                if ($_pageabsolute >= $i) {
                    if ($i == $_page) {
                        //echo '<a href="'.SCRIPT.'.php?'.$_id.'page='.$i.'" class="on">'.$i.'</a>';
                        echo '<li class="paginItem current"><a href="' . SCRIPT . '.php?' . $_id . 'page=' . $i . '">' . $i . '</a></li>';
                    } else {
                        //echo '<a href="'.SCRIPT.'.php?'.$_id.'page='.$i.'" >'.$i.'</a>';
                        echo '<li class="paginItem "><a href="' . SCRIPT . '.php?' . $_id . 'page=' . $i . '">' . $i . '</a></li>';
                    }
                }
            }
            echo '<li class="paginItem more"><a href="javascript:;">...</a></li><li class="paginItem"><a href="' . SCRIPT . '.php?' . $_id . 'page=' . ($_pageabsolute) . '">' . $_pageabsolute . '</a></li>';
        } else {
            echo '<li class="paginItem"><a href="' . SCRIPT . '.php?' . $_id . 'page=1">1</a></li><li class="paginItem more"><a href="javascript:;">...</a></li>';
            for ($i = ($_pageabsolute - 4); $i <= $_pageabsolute; $i++) {
                if ($_pageabsolute >= $i) {
                    if ($i == $_page) {
                        echo '<li class="paginItem current"><a href="' . SCRIPT . '.php?' . $_id . 'page=' . $i . '">' . $i . '</a></li>';
                    } else {
                        echo '<li class="paginItem "><a href="' . SCRIPT . '.php?' . $_id . 'page=' . $i . '">' . $i . '</a></li>';
                    }
                }
            }
        }
    } else {
        for ($i = 1; $i < $_pageabsolute + 1; $i++) {
            if ($i == $_page) {
                echo '<li class="paginItem current"><a href="' . SCRIPT . '.php?' . $_id . 'page=' . $i . '">' . $i . '</a></li>';
            } else {
                echo '<li class="paginItem "><a href="' . SCRIPT . '.php?' . $_id . 'page=' . $i . '">' . $i . '</a></li>';
            }
        }
    }
    if ($_page == $_pageabsolute) {
        echo '<li class="paginItem"><a href="javascript:;"><span class="pagenxt"></span></a></li>';
    } else {
        echo '<li class="paginItem"><a href="' . SCRIPT . '.php?' . $_id . 'page=' . ($_page + 1) . '"><span class="pagenxt"></span></a></li>';
    }
    echo ' </ul></div>';
}

function qy_paging1() {
    global $_page, $_pageabsolute, $_num, $_id;
    echo '<span style="padding-top:5px;line-height:45px;"> 共 ' . $_pageabsolute . ' 页 当前第 ' . $_page . ' 页 ';
    if ($_pagex == 1) {
        echo '<a >首页</a> <a  >上一页</a>';
    } else {
        echo '<a href="' . SCRIPT . '.php?' . $_idx . 'page=1" >首页</a>  ';
        echo '<a href="' . SCRIPT . '.php?' . $_idx . 'page=' . ($_pagex - 1) . '" >上一页</a>  ';
    }
    if ($_pagex == $_pageabsolutex) {
        echo '<a >下一页</a> <a  >尾页</a>';
    } else {
        echo '<a href="' . SCRIPT . '.php?' . $_idx . 'page=' . ($_pagex + 1) . '" >下一页</a> | ';
        echo '<a href="' . SCRIPT . '.php?' . $_idx . 'page=' . $_pageabsolutex . '" >尾页</a>';
    }
    echo '</span> ';
}

function csdy($table, $fltable, $pagesize, $dyym) {
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        if (empty($page) || $page <= 0 || !is_numeric($page)) {
            $page = 1;
        } else {
            $page = intval($page);
        }
    } else {
        $page = 1;
    }
    if ($_GET['typeid'] != "") {
        $typeid = $_GET['typeid'];
        $sql = "select * from $table where typeid='$typeid' order by id desc";
    } else {
        $sql = "select * from $table order by id desc";
    }
    $result = mysql_query($sql);
    $num = mysql_num_rows($result);
    if ($num) {
        if ($num < $pagesiz) {
            $pagecount = 1;
        }
        if ($num % $pagesize) {
            $pagecount = (int)($num / $pagesize) + 1;
        } else {
            $pagecount = ($num / $pagesize);
        }
        if ($page > $pagecount) {
            $page = $pagecount;
        }
    } else {
        $pagecount = 0;
    }
    $fypage = "共有" . $num . "条信息 " . $pagesize . "条/页";
    $fypage .= " 当前：第" . $page . "页/共" . $pagecount . "页 ";
    if ($page == 1) {
        $fypage .= ' 首页 | 上一页 |';
    } else {
        $fypage .= '<a href=' . $dyym . 'page=1>首页</a> | <a href=' . $dyym . 'page=' . ($page - 1) . '>上一页</a> |';
    }
    if ($page == $pagecount || $pagecount == 0) {
        $fypage .= ' 下一页 | 尾页 ';
    } else {
        $fypage .= ' <a href=' . $dyym . 'page=' . ($page + 1) . '> 下一页</a> | <a href=' . $dyym . 'page=' . $pagecount . '>尾页</a> ';
    }
    $fypage .= '转到：<select name="select" onchange="javascript:window.location.href=this.options[this.selectedIndex].value">';
    $a = 1;
    while ($a <= $pagecount) {
        if ($a == $page) {
            $fypage .= "<option selected value=" . $dyym . "page=" . $a . ">第" . $a . "页</option>";
        } else {
            $fypage .= "<option value=" . $dyym . "page=" . $a . ">第" . $a . "页</option>";
        }
        $a = $a + 1;
    }
    $fypage .= "</select>";
    echo $fypage;
}

function qy_class($table, $typeid) {
    echo "<select name='typeid'>";
    echo '<option value="">请选择</option>';
    $sql = "SELECT * FROM $table ORDER BY id DESC";
    $query = mysql_query($sql);
    while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
        $tid = $row['id'];
        if ($tid == $typeid)
            echo "<option  value=\"$tid\" selected >" . $row["typename"] . "</option>";
        else
            echo "<option  value=\"$tid\" >" . $row["typename"] . "</option>";
    }
    echo "</select>";
}

function qy_select($a, $b) {
    if ($a == $b) {
        return "selected";
    } else {
        return "";
    }
}

function qy_checked($a, $b) {
    if ($a == $b) {
        return "checked";
    } else {
        return "";
    }
}

function qy_check_code($first_code, $end_code) {
    if ($first_code != $end_code) {
        qy_alert_back('验证码不正确!');
    }
}

function qy_fck($content = '', $tname = 'con', $w = '99%', $h = '400') {
    include_once("fckeditor/fckeditor.php");
    $sBasePath = 'fckeditor/';
    $oFCKeditor = new FCKeditor($tname);
    $oFCKeditor->Width = $w;
    $oFCKeditor->Height = $h;
    $oFCKeditor->BasePath = $sBasePath;
    $oFCKeditor->Value = $content;
    $oFCKeditor->Create();
}

function qy_htm($table, $id) {
    $query = mysql_query("SELECT * FROM $table WHERE id=$id");
    $row = mysql_fetch_array($query);
    if ($row['id']) {
        return $row['content'];
    }
}

function qy_pic($table, $id) {
    $query = mysql_query("SELECT * FROM $table WHERE id=$id");
    $row = mysql_fetch_array($query);
    if ($row['id']) {
        return $row['picurl'];
    }
}

function qy_seo($table, $id, $ac) {
    $query = mysql_query("SELECT * FROM $table WHERE id=$id");
    $row = mysql_fetch_array($query);
    if ($row['id']) {
        return $row["$ac"];
    }
}

function qy_pic_link($table, $id) {
    $query = mysql_query("SELECT * FROM $table WHERE id=$id");
    $row = mysql_fetch_array($query);
    if ($row['id']) {
        return $row['link'];
    }
}

function qy_html($_string) {
    if (is_array($_string)) {
        foreach ($_string as $_key => $_value) {
            $_string[$_key] = qy_html($_value);
        }
    } else {
        $_string = htmlspecialchars($_string);
    }
    return $_string;
}

function qy_mysql_string($_string) {
    //get_magic_quotes_gpc()如果开启状态，那么就不需要转义
    if (!get_magic_quotes_gpc()) {
        if (is_array($_string)) {
            foreach ($_string as $_key => $_value) {
                $_string[$_key] = qy_mysql_string($_value);
            }
        } else {
            $_string = mysql_real_escape_string($_string);
        }
    }
    return $_string;
}

function htmtocode($content) {
    $content = str_replace("\n", "<br>", str_replace(" ", "&nbsp;", $content));
    return $content;
}

function qy_p($str) {
    $str = str_replace("<p>", "", $str);
    $str = str_replace("</p>", "", $str);
    return $str;
}

function qy_p1($str) {
    $str = str_replace("<p>", "", $str);
    $str = str_replace("</p>", "<br/>", $str);
    return $str;
}

function qy_sp($str) {
    $str = str_replace("<p>", "", $str);
    $str = str_replace("</p>", "", $str);
    $str = str_replace("&nbsp;", "", $str);
    return $str;
}

function qy_title($_string, $_strlen) {
    if (mb_strlen($_string, 'utf-8') > $_strlen) {
        $_string = mb_substr($_string, 0, $_strlen, 'utf-8');
    }
    return $_string;
}

function dafenglei_select($m, $id, $index) {
    global $class;
    $n = str_pad('', $m, '-', STR_PAD_RIGHT);
    $n = str_replace("-", "&nbsp;&nbsp;&nbsp;", $n);
    for ($i = 0; $i < count($class); $i++) {
        if ($class[$i][2] == $id) {
            if ($class[$i][0] == $index) {
                echo "        <option value=\"" . $class[$i][0] . "\" selected=\"selected\">" . $n . "|--" . $class[$i][1] . "</option>\n";
            } else {
                echo "        <option value=\"" . $class[$i][0] . "\">" . $n . "|--" . $class[$i][1] . "</option>\n";
            }
            dafenglei_select($m + 1, $class[$i][0], $index);
        }
    }
}

function getFid($id) {
    global $ids;
    //$ids=array();
    $sql = "SELECT * FROM qy_type WHERE id='$id'";
    $query = mysql_query($sql);
    $row = mysql_fetch_array($query);
    if ($row) {
        $ids[] = $row['fid'];
        getFid($row['fid']);
    }
    return array_reverse($ids);
}

function get_str($pid = 0) {
    global $str;
    $sql = "select * from newclass where paid=" . $pid . " order by id asc";
    $query = mysql_query($sql);
    while ($rs = mysql_fetch_array($query)) {
        $str .= $rs['id'] . ","; //构建字符串
        get_str($rs['id']); //调用get_str()，将记录集中的id参数传入函数中，继续查询下级
    }
    return $str;
}
?>