<script>
//Error的提示Jbox
function jbox_error(text, url){
	if(url == undefined) url = 'javascript:void(0)';
	var modal = new jBox('Modal', {
			attach: $('#myModal'),
			delayOpen : 300,
			content: '<img width="20" height="20" src="<?php echo $URL_IMG_ROOT.'error.png' ?>"><span style="color:red; font-size:18px; font-family:微軟正黑體; font-weight:bold;">'+text+'</span>',
			onCloseComplete : function(){
				js_location(url);
			}
		});
	modal.open();	
}

//Success的提示Jbox
function jbox_success(text, url){
	if(url == undefined) url = 'javascript:void(0)';
	var modal = new jBox('Modal', {
			attach : $('#myModal'),
			delayOpen : 300,
			content : '<img width="30" height="30" src="<?php echo $URL_IMG_ROOT.'success.png' ?>"><span style="color:#108199; font-size:18px; font-family:微軟正黑體; font-weight:bold;">'+text+'</span>',
			onCloseComplete : function(){
				js_location(url);
			}
		});
	modal.open();	
}

function js_location(url) {	location.href = url;}
</script>