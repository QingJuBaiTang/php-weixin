function menuFixed(id){
var obj = document.getElementById(id);
var _getHeight = obj.offsetTop;
window.onscroll = function(){
changePos(id,_getHeight);
}
}
function changePos(id,height){
var obj = document.getElementById(id);
var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
if(scrollTop < height){
obj.style.position = 'relative';
}else{
obj.style.position = 'fixed';
obj.style.top = '0';
}
}
function zan(id){
		if(id!=''){
			var zansum=$("#zansum").html();
			if($("#zanpic").attr('f')==1){
				$.post('view.php',{iid:id,action:'zan',jjf:'-'},function(data) { 
					if(data){
						$("#zanpic").attr('src','/images/zan1.png'); 
						$("#zanpic").attr('f','0');
						$("#zansum").html(zansum*1-1);
					}
       			 });
			} else{
				$.post('view.php',{iid:id,action:'zan',jjf:'+'},function(data) { 
					if(data){
						$("#zanpic").attr('src','/images/zan2.png'); 
						$("#zanpic").attr('f','1');
						$("#zansum").html(zansum*1+1);
					}
       			 });
			}
		}else{
			alert('·¢Éú´íÎó!');
		}
		}