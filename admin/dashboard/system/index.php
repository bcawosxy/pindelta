<!DOCTYPE html>
<?php 
  include('./../../../config/global.php');
  include('./../../../config/function.php');
  if( (empty($_SESSION['admin']['id']))){
    js_location(URL_ROOT."admin");
  }
?>
<html>
<head>
	<meta name="robots" content="noindex">
	<meta name="robots" content="nofollow" />
	<meta name="googlebot" content="noindex">
	<meta charset="UTF-8">
	<title>品利興國際有限公司 - 後台管理系統</title>
	<link rel="stylesheet" href="<?php echo URL_LIB_ROOT.'css/style_admin.css' ?>">
	<link rel="stylesheet" href="<?php echo URL_LIB_ROOT.'css/bootstrap.css' ?>">
    <link href="<?php echo URL_LIB_ROOT.'js/jbox/jbox.css' ?>" rel="stylesheet" type="text/css"/>
	
	
	<script type="text/javascript" src="<?php echo URL_LIB_ROOT.'js/jquery-1.11.2.min.js' ;?>"></script>	
	<script type="text/javascript" src="<?php echo URL_LIB_ROOT.'js/javascript.js' ;?>"></script>	
    <script src="<?php echo URL_LIB_ROOT.'js/jbox/jbox.js' ?>" type="text/javascript"></script>
	
</head>
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
</script>

<body>
  <div id="main">
    <div id="container">
	  <div class="header">
	    <div class="header_banner">
		      <span class="header_banner_img">
	            <img src="<?php echo $URL_IMG_ROOT."banner.png"; ?>"  height="70%" width="35%">
	          </span>
		</div>	
	  </div>
	  
	  <div class="content">
	    <div class="content_title">
		  <!-- 先留空 只有樣式-->
		</div>
		
		<div class="content_main">
		  <?php include('./main.php'); ?>
		</div>
	  </div>

	</div>
	
    <div id="footer">
      <div class="footer_content">
	    Copyright @ 2015 Pindelta International Co., Ltd All Rights Reserved
	  </div>
    </div>	
	
  </div>
  

</body>