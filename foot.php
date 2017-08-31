<div class="bot_main">
    <ul>
        <li class="ico_1" onclick="window.location.href='index.php'" style="width:50%">
            <span class="ico"><img src="images/index.png"/></span><span class="txt">分享文章</span>
        </li>
        <li class="ico_2" onclick="window.location.href='fxlist.php'" style="width:50%">
            <span class="ico"><img src="images/wz.png"/></span><span class="txt">文章管理</span>
        </li>
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
