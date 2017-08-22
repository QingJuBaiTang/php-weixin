<div class="bot_main">

	<ul>

		<li class="ico_1" onclick="window.location.href='index.php'" style="width:20%"><span class="ico"><img src="images/index.png" /></span><span class="txt">分享文章</span></li>

		<li class="ico_2" onclick="window.location.href='fxlist.php'" style="width:20%"><span class="ico"><img src="images/wz.png" /></span><span class="txt">文章管理</span></li>

		<li class="ico_3" onclick="window.location.href='ad_list.php'" style="width:20%"><span class="ico"><img src="images/ad.png" /></span><span class="txt">广告管理</span></li>

		<li class="ico_4" onclick="window.location.href='vip.php'" style="width:20%"><span class="ico"><img src="images/vip.png" /></span><span class="txt">在线充值</span></li>

		<li class="ico_5"  id="umoreserver" onclick="Show_Hidden(tr1)"  style="width:20%"><span class="ico"><a href="#"><img src="images/hy.png" /></a></span><span class="txt">会员服务</span>

	   <ul id="tr1">

		<li><a href="logout.php">退出登录</a></li>

		<li><a href="paylist.php">充值记录</a></li>

		<li><a href="user.php">修改密码</a></li>

		<li><a href="kefu.php">联系客服</a></li>
		<li><a href="about.php">系统介绍</a></li>

        </ul>

        </li>

	</ul>

</div>

<script type="text/javascript">

function get_search_box(){

	if(document.getElementById('search').style.display=='none'){

		document.getElementById('search').style.display="block";

		document.getElementById('apply').style.display="none";

	}else{

		document.getElementById('search').style.display="none";

		document.getElementById('apply').style.display="block";

	}

}

</script>

<script type="text/javascript">

function Show_Hidden(trid){

    if(trid.style.display=="block"){

        trid.style.display='none';

    }else{

        trid.style.display='block';

    }

}

</script>

