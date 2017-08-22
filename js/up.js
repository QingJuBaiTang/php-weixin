
	function uploadPic(flag){
		var showimg = $('#showimg_'+flag);
		var files = $("#files_"+flag);
		var btn = $("#btn_"+flag);
		$("#fileupload_"+flag).unwrap();
		$("#fileupload_"+flag).wrap("<form id='myupload_"+flag+"' action='up_action.php' method='post' enctype='multipart/form-data'></form>");
		
		$("#myupload_"+flag).ajaxSubmit({
			dataType:  'json',
			beforeSubmit: function() {
				showimg.empty();
				showimg.append("<img  style='margin:0 auto' src='/images/uping.gif' align='absmiddle'>");
				btn.html("上传中...");
        		
    		},
    		success: function(data) {
				files.html("<span class='delimg' flag='"+flag+"' onclick='delPic(this);' rel='"+data.pic+"'>删除</span>");
				var img = data.pic;
				showimg.html("<img style='max-height:200px' width='100%' src='"+img+"'>");
				$("#"+flag).val(img);
				btn.html("添加图片");
			},
			error:function(xhr){
				showimg.empty();
				btn.html("上传失败");
				files.html(xhr.responseText);
			}
		});
	}
	function uploadPicErweima(flag){
		var showimg = $('#showimg_'+flag);
		var files = $("#files_"+flag);
		var btn = $("#btn_"+flag);
		$("#fileupload_"+flag).unwrap();
		$("#fileupload_"+flag).wrap("<form id='myupload_"+flag+"' action='up_action.php' method='post' enctype='multipart/form-data'></form>");
		$("#myupload_"+flag).ajaxSubmit({
			dataType:  'json',
			beforeSend: function() {
        		showimg.empty();
				showimg.append("<img  style='margin:0 auto' src='/images/uping.gif' align='absmiddle'>");
				btn.html("上传中...");
    		},
    		success: function(data) {
				files.html("<span class='delimg' flag='"+flag+"' onclick='delPic(this);' rel='"+data.pic+"'>删除</span>");
				var img = data.pic;
				showimg.html("<img style='max-width:250px'  src='"+img+"'>");
				$("#"+flag).val(img);
				btn.html("添加图片");
			},
			error:function(xhr){
				showimg.empty();
				btn.html("上传失败");
				files.html(xhr.responseText);
			}
		});
	}
	function uploadPicQuan(flag){
		var showimg = $('#showimg_'+flag);
		var files = $("#files_"+flag);
		var btn = $("#btn_"+flag);
		$("#fileupload_"+flag).unwrap();
		$("#fileupload_"+flag).wrap("<form id='myupload_"+flag+"' action='up_action.php' method='post' enctype='multipart/form-data'></form>");
		$("#myupload_"+flag).ajaxSubmit({
			dataType:  'json',
			beforeSend: function() {
        		showimg.empty();
				showimg.append("<img  style='margin:0 auto' src='/images/uping.gif' align='absmiddle'>");
				btn.html("上传中...");
    		},
    		success: function(data) {
				files.html("<span class='delimg' flag='"+flag+"' onclick='delPic(this);' rel='"+data.pic+"'>删除</span>");
				var img = data.pic;
				showimg.html("<img style='max-width:400px' width='100%'   src='"+img+"'>");
				$("#"+flag).val(img);
				btn.html("添加图片");
			},
			error:function(xhr){
				showimg.empty();
				btn.html("上传失败");
				files.html(xhr.responseText);
			}
		});
	}
	function delPic(padd){
	var flag = $(padd).attr("flag");
	var showimg = $('#showimg_'+flag);
	var files = $("#files_"+flag);
		var pic = $(padd).attr("rel");
		$.post("up_action.php?act=delimg",{imagename:pic},function(msg){
			if(msg==1){
				files.html("<span class='delimg'>删除成功</span>");
				$("#"+flag).val("");
				showimg.empty();
			}else{
				alert(msg);
			}
		});
	}