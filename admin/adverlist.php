<?
header('Content-Type:text/html; charset=utf-8');
define('IN_XD',true);
require('../include/common.inc.php');
define('SCRIPT','adverlist');
session_start();
require("check.php");
//删除
if($_GET["act"]=="del"){
    $sql="delete from tbl_ad where id=".$_GET['id'];
    mysql_query($sql);
    mysql_close();
    echo "<script type='text/javascript'>alert('成功删除!');location.href='adverlist.php?page=".$_GET["page"]."&t=".$_GET['t']."&s=".$_GET['s']."&userid=".$_GET['userid']."';</script>";
    exit;
}
if($_GET["act"]=="setdefault"){
  //$sql="update from tbl_ad where id=".$_GET['id'];
  	$sql3="update  tbl_ad SET systemdefault = '0'";
	$sql="update  tbl_ad SET systemdefault = '1' where id=".$_GET['id'];
	mysql_query($sql3);
    mysql_query($sql);
    mysql_close();
    echo "<script type='text/javascript'>alert('设为默认广告成功!');location.href='adverlist.php?page=".$_GET["page"]."&t=".$_GET['t']."&s=".$_GET['s']."&userid=".$_GET['userid']."';</script>";
    exit;
}
//批量删除
if($_GET["act"]=="delall"){
    for($i=0;$i<count($_POST['ids']);$i++){
        $sql="delete from tbl_ad where id=".$_POST['ids'][$i];
        mysql_query($sql);
    }
    echo "<script type='text/javascript'>alert('成功删除!');location.href='adverlist.php?page=".$_GET["page"]."&t=".$_GET['t']."&s=".$_GET['s']."&userid=".$_GET['userid']."';</script>";
    exit;
}
$where=" ";
if($_GET['s']!=""){
    $where .= " and status = ".$_GET['s'];
}
if($_GET["act"]=="search" && $_POST['title']!=''){
    $where .= " and (title like '%".$_POST['title']."%' or content like '%".$_POST['title']."%')";
}
if($_GET["userid"]){
    $where .= " and userid = '".$_GET["userid"]."'";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>易推</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/lanrenzhijia.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="js/jquery.js"></script>
    <script language="javascript">
        $(function(){
            //导航切换
            $(".imglist li").click(function(){
                $(".imglist li.selected").removeClass("selected")
                $(this).addClass("selected");
            })
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".click").click(function(){
                $(".tip").fadeIn(200);
            });
            $(".tiptop a").click(function(){
                $(".tip").fadeOut(200);
            });
            $(".sure").click(function(){
                $(".tip").fadeOut(100);
            });
            $(".cancel").click(function(){
                $(".tip").fadeOut(100);
            });
        });
    </script>
    <script language="javascript">
        function CheckAll(form){
            for (var i=0;i<form.elements.length;i++){
                var e = form.elements[i];
                if (e.Name != "chkAll")
                    e.checked = form.chkAll.checked;
            }
        }
        function ConfirmDel(){
            if(confirm("确定要操作吗？"))
                return true;
            else
                return false;
        }
    </script>
    <script type="text/javascript">
        function delall(){
            a = 0;
            var conditions=document.getElementsByName("ids[]");
            for(var i=0;i<conditions.length;i++){
                if(conditions[i].checked==true){
                    a++;
                }
            }
            if(a>0){
                if(confirm('您已选中'+a+'条数据,是否确认删除?')){
                    document.forms.action='adverlist.php?act=delall&t=<?=$_GET["t"]?>&page=<?=$_GET["page"]?>&s=<?=$_GET["s"]?>';
                    document.getElementById('forms').submit();
                }else{
                    return false;
                }
            }else{
                alert('您没有选中任何信息！');
                return false;
            }
        }
        function shall(v){
            a = 0;
            var conditions=document.getElementsByName("ids[]");
            for(var i=0;i<conditions.length;i++){
                if(conditions[i].checked==true){
                    a++;
                }
            }
            if(a>0){
                if(confirm('您已选中'+a+'条数据,是否确认审核?')){
                    document.forms.action='bdlist.php?act=shall&v='+v+'&t=<?=$_GET["t"]?>&page=<?=$_GET["page"]?>&s=<?=$_GET["s"]?>';
                    document.getElementById('forms').submit();
                }else{
                    return false;
                }
            }else{
                alert('您没有选中任何信息！');
                return false;
            }
        }
    </script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.imgbox.pack.js"></script>
    <script>
        $(function(){
            $(".example1").imgbox();
            $("#example2").imgbox({
                'speedIn'		: 0,
                'speedOut'		: 0,
                'alignment'		: 'center',
                'overlayShow'	: true,
                'allowMultiple'	: false
            });
        });
    </script>
</head>
<body>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="main.php">首页</a></li>
        <li><a href=""><?=$types[$_GET['t']]?>管理</a></li>
    </ul>
</div>
<div class="rightinfo">
    <div class="tools">
        <ul class="toolbar">
            <li>
                <a onclick="delall()">
                    <span>
                        <img src="images/t03.png" />
                    </span>批量删除
                </a>
            </li>
           <!-- <li style="float:right">
                <form name="searchsoft" method="post" action="?act=search&t=<?=$_GET['t']?>&s=<?=$_GET['s']?>">
                    <strong>&nbsp;&nbsp;&nbsp;搜索关键字：</strong>
                    <input name="title" type="text" id="title" size="20" maxlength="50" class="dfinput" style="width:200px;height:28px" placeholder="标题或内容"/>
                    <input name="Query" type="submit" id="Query" value="查 询" class="scbtn" style="height:28px">
                    <i>&nbsp;&nbsp;请输入关键字。如果为空，则查找所有信息</i>
                </form>
            </li> -->
        </ul>
    </div>
    <form method="post" action="?" id="forms" name="forms">
        <table class="imgtable">
            <thead>
            <tr>
                <th width="50px;">
                    <input name="chkAll" type="checkbox" id="chkAll" onclick=CheckAll(this.form) value="checkbox"/>
                </th>
                <th>标题</th>
                <th>用户ID</th>
                <th>广告图片</th>
                <th>二维码</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?
            $page_sql = "select * from tbl_ad where 1=1   $where";
            qy_page($page_sql,20);
            $sql = "select * from tbl_ad where 1=1    $where ORDER by id DESC LIMIT $_pagenum,$_pagesize";
            $_id ='t='.$_GET['t'].'&userid='.$_GET['userid'].'&';
            $query=mysql_query($sql);
            while($row=mysql_fetch_array($query)){
                ?>
                <tr height="35px">
                    <td>
                        <input name='ids[]' type='checkbox' onClick="unselectall()" id="ID" value='<?=$row['id']?>'>
                    </td>
                    <td><?=$row['ad_title']?></td>
                    <td><?=$row['username']?></td>
                    <td>
                        <?php if($row['ad_img_one']==''){ ?>
                        <a href="<?=$row['adlink']?>" target="_blank">
                            <img src="../<?=$row['ad_img']?>" width="260" style="max-height:60px;">
                        </a><br/>
                        <?php }else if($row['ad_img_two']==''){ ?>
                        <a href="<?=$row['adlink']?>" target="_blank">
                            <img src="../<?=$row['ad_img']?>" width="260" style="max-height:60px;">
                        </a>
                            <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="<?=$row['adlink']?>" target="_blank">
                            <img src="../<?=$row['ad_img_one']?>" width="260" style="max-height:60px;">
                        </a>
                        <?php }else{ ?>
                        <a href="<?=$row['adlink']?>" target="_blank">
                            <img src="../<?=$row['ad_img']?>" width="260" style="max-height:60px;">
                        </a>
                            <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="<?=$row['adlink']?>" target="_blank">
                            <img src="../<?=$row['ad_img_one']?>" width="260" style="max-height:60px;">
                        </a>
                            <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="<?=$row['adlink']?>" target="_blank">
                            <img src="../<?=$row['ad_img_two']?>" width="260" style="max-height:60px;">
                        </a>
                        <?php }?>
                    </td>
                    <td>
                        <?php if($row['erweima']==''){?>
                            无图片
                        <?php }else{ ?>
                        <img src="../<?=$row['erweima']?>" width="60" style="max-height:60px;">
                        <?php }?>
                    </td>
                    <td>
                        <a href="adverlist.php?id=<?=$row['id']?>&act=del&t=<?=$_GET['t']?>&page=<?=$_GET['page']?>&s=<?=$_GET['s']?>&userid=<?=$_GET['userid']?>" onclick="if (confirm('确定要删除吗？')) return true; else return false;" class="tablelink"> 删除</a>
						<?
    if($row['systemdefault']==0){
	?>
    <font color="#FF0000"><a href="adverlist.php?id=<?=$row['id']?>&act=setdefault&t=<?=$_GET['t']?>&page=<?=$_GET['page']?>&s=<?=$_GET['s']?>&userid=<?=$_GET['userid']?>" onclick="if (confirm('确定要设置默认广告吗？')) return true; else return false;" class="tablelink"> 设为默认广告</a>
						</font>
    <?
	}else{
	?>
    已是默认广告
    <?
	}
	?>
				   </td>
                </tr>
                <?
            }
            ?>
            </tbody>
        </table>
        <div class="pagin">
            <?=qy_paginga()?>
        </div>
</div>
</form>
<script type="text/javascript">
    $('.imgtable tbody tr:odd').addClass('odd');
</script>
</body>
</html>
