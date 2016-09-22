<!DOCTYPE html>
<?php 
  include('./../../../config/global.php');
  include('./../../../config/function.php');
  if(empty($_SESSION['admin']['id'])){
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
    <link href="<?php echo URL_LIB_ROOT.'footable/css/footable.core.css' ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo URL_LIB_ROOT.'footable/css/footable.standalone.css' ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo URL_LIB_ROOT.'footable/css/footable-demos.css' ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo URL_LIB_ROOT.'js/jbox/jbox.css' ?>" rel="stylesheet" type="text/css"/>
	
	<script type="text/javascript" src="<?php echo URL_LIB_ROOT.'js/jquery-1.11.2.min.js' ;?>"></script>	
    <script type="text/javascript" src="<?php echo URL_LIB_ROOT.'js/javascript.js' ;?>"></script>	
	<script src="<?php echo URL_LIB_ROOT.'footable/js/footable.js' ?>" type="text/javascript"></script>
    <script src="<?php echo URL_LIB_ROOT.'footable/js/footable.sort.js' ?>" type="text/javascript"></script>
    <script src="<?php echo URL_LIB_ROOT.'footable/js/footable.filter.js' ?>" type="text/javascript"></script>
    <script src="<?php echo URL_LIB_ROOT.'footable/js/footable.paginate.js' ?>" type="text/javascript"></script>
    <script src="<?php echo URL_LIB_ROOT.'footable/js/bootstrap-tab.js' ?>" type="text/javascript"></script>
    <script src="<?php echo URL_LIB_ROOT.'footable/js/demos.js' ?>" type="text/javascript"></script>
    <script src="<?php echo URL_LIB_ROOT.'js/jbox/jbox.js' ?>" type="text/javascript"></script>
	<?php include('../admin_function.php') ?>
</head>

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
			<?php 
				if($_SESSION['admin']['id'] != 1) {
					php_call_jbox('error', '您沒有權限訪問此頁面。', URL_ADMIN_ROOT.'index.php');
				}else{
					include('./main.php'); 
				}
			?>
		</div>
	  </div>

	</div>
	
    <div id="footer">
      <div class="footer_content">
	    Copyright @ 2015 Memorable Supplier. All Rights Reserved
	  </div>
    </div>	
	
  </div>
  

</body>