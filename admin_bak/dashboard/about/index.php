<!DOCTYPE html>
<?php  
  include('./../../../config/global.php');
  include('./../../../config/function.php');
  if( (empty($_SESSION['admin']['id']))){
    js_location($URL_ROOT."admin");
  }
  
  // $type = $_GET['type'];
  // if( ($type != 'a') && ($type != 'b') && ($type != 'c') && ($type != 'd') && (empty($type))){
    // js_location($URL_ROOT."admin/dashboard/about?type=c");
  // }
  
  // switch ($type){
    // case 'b':
	// $type_title = '創辦理念';
    // break;
	
    // case 'c':
	// $type_title = '關於公司';
    // break;
	
    // case 'd':
	// $type_title = '人才招募';
    // break;
	
	// default:
	// $type_title = '關於公司';
  // }
?>
<html>
<head>
	<meta name="robots" content="noindex">
	<meta name="robots" content="nofollow" />
	<meta name="googlebot" content="noindex">

	<meta charset="UTF-8">
	<title>品利興國際有限公司 - 後台管理系統</title>
	<link rel="stylesheet" href="<?php echo $URL_LIB_ROOT.'css/style_admin.css' ?>">
	<link rel="stylesheet" href="<?php echo $URL_LIB_ROOT.'css/bootstrap.css' ?>">
	<link href="<?php echo $URL_LIB_ROOT.'js/jbox/jbox.css' ?>" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="<?php echo $URL_LIB_ROOT.'js/jquery-1.11.2.min.js' ;?>"></script>	
    <script type="text/javascript" src="<?php echo $URL_LIB_ROOT.'js/javascript.js' ;?>"></script>	
    <script type="text/javascript" src="<?php echo $URL_LIB_ROOT.'js/bootstrap.js' ;?>"></script>	
    <script type="text/javascript" src="<?php echo $URL_LIB_ROOT.'ckeditor/ckeditor.js' ;?>"></script>  
    <script type="text/javascript" src="<?php echo $URL_LIB_ROOT.'ckeditor/adapters/jquery.js' ;?>"></script>	
    <script type="text/javascript" src="<?php echo $URL_LIB_ROOT.'ckeditor/adapters/jquery.js' ;?>"></script>	
	<script src="<?php echo $URL_LIB_ROOT.'js/jbox/jbox.js' ?>" type="text/javascript"></script>
	<?php include('../admin_function.php') ?>
</head>
<body>
  <div id="main">
    <div id="container">
	  <div class="header">
	    <div class="header_banner">
		      <span class="header_banner_img">
	            <a href="<?php echo $URL_ROOT; ?>"><img src="<?php echo $URL_IMG_ROOT."banner.png"; ?>"  height="70%" width="35%"></a>
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
	    Copyright @ 2015 Memorable Supplier. All Rights Reserved
	  </div>
    </div>	
  </div>
</body>

</html>