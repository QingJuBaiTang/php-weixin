<div class="bot_main">
    <ul>
        <li class="ico_1" onclick="window.location.href='index.php'" style="width:20%"><span class="ico"><img
                        src="/images/index.png"/></span><span class="txt">分享文章</span></li>
        <li class="ico_2" onclick="window.location.href='fxlist.php'" style="width:20%"><span class="ico"><img
                        src="images/wz.png"/></span><span class="txt">文章管理</span></li>
        <li class="ico_3" onclick="window.location.href='ad_list.php'" style="width:20%"><span class="ico"><img
                        src="images/ad.png"/></span><span class="txt">广告管理</span></li>
        <li class="ico_4" onclick="window.location.href='about.php'" style="width:20%"><span class="ico"><img
                        src="images/vip.png"/></span><span class="txt">系统介绍</span></li>
        <li class="ico_4" onclick="window.location.href='kefu.php'" style="width:20%"><span class="ico"><img
                        src="images/kf.png"/></span><span class="txt">联系客服</span></li>
    </ul>
</div>

<script type="text/javascript">
    function get_search_box() {
        if (document.getElementById('search').style.display == 'none') {
            document.getElementById('search').style.display = "block";
            document.getElementById('apply').style.display = "none";
        } else {
            document.getElementById('search').style.display = "none";
            document.getElementById('apply').style.display = "block";
        }
    }
</script>

<script type="text/javascript">
    function Show_Hidden(trid) {
        if (trid.style.display == "block") {
            trid.style.display = 'none';
        } else {
            trid.style.display = 'block';
        }
    }
</script>
