<!DOCTYPE html>
<?php 
  include('./../config/global.php');	
  include('./../config/function.php');	
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex">
	<meta name="robots" content="nofollow" />
	<meta name="googlebot" content="noindex">
	<title>品利興國際有限公司 - 後台管理系統</title>
	<link rel="stylesheet" href="<?php echo URL_LIB_ROOT.'css/style_admin.css' ?>">
	<link rel="stylesheet" href="<?php echo URL_LIB_ROOT.'css/bootstrap.css' ?>">

	
    <script type="text/javascript" src="<?php echo URL_LIB_ROOT.'js/jquery-1.11.2.min.js' ;?>"></script>	
    <script type="text/javascript" src="<?php echo URL_LIB_ROOT.'js/javascript.js' ;?>"></script>	
</head>

<body>
  <div id="main">
    <div id="container">
	  <div class="header">
	    <div class="header_banner">
		      <span class="header_banner_img">
	            <a href="<?php echo URL_ROOT; ?>"><img src="<?php echo URL_IMG_ROOT.'banner.png'; ?>" height="70%" width="35%"></a>
	          </span>
		</div>	
	  </div>
	  
	  <div class="content">
	    <div class="content_title">
		  <!-- 先留空 只有樣式-->
		</div>

		<div class="content_main">
          <?php 
		    include('./main.php');
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
