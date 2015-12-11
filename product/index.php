<!DOCTYPE html>
<?php 
	include('./../config/global.php');
	include('./../config/function.php');
	include('./../lib/js/captcha/simple-php-captcha.php');
	$_SESSION['captcha'] = simple_php_captcha();
	$_SESSION['inquiry_code'] = $_SESSION['captcha']['code'];
	$_this_name = null ;
	$_this_description = null;
	$_this_cover = null;
	$category = array();
	$product = array();
	
	$g_goods = (!empty($_GET['goods'])) ? base64_decode($_GET['goods']) : redirect_php($URL_ROOT);
	$g_category = (!empty($_GET['category'])) ? base64_decode($_GET['category']) : null ;
	$g_items = (!empty($_GET['items'])) ? base64_decode($_GET['items']) : null ;
	$g_pages = (!empty($_GET['pages'])) ? $_GET['pages'] : 1 ;

	$g_ajax = (!empty($_GET['ajax'])) ? $_GET['ajax'] : 'false';
	if(empty($g_goods) && empty($g_category) && empty($g_items)) redirect_php($URL_ROOT);
	
	$meta = array('`web_title`', '`web_description`','`social_look`', '`social_skin`');
	$meta = get_settings($meta);

	if(!empty($g_items)){
		//內頁
		$query = 'select `product_name`,`product_cover`,`product_description`,`product_memo` from `product` where `product_id` = '.$g_items.';';
		$result = mysql_query($query);
		if($result) $row = mysql_fetch_assoc($result);
		
		$_this_name = (empty($row['product_name'])) ? null : $row['product_name'] ;
		$_this_description = (empty($row['product_description'])) ? null : $row['product_description'] ;
		$_this_description .= (empty($row['product_memo'])) ? null : '. '.$row['product_memo'] ;
		$_this_cover = (empty($row['product_cover'])) ? null : $row['product_cover'] ;
	}elseif(!empty($g_category)){
		//第二層
		$query = 'select `category_name`,`category_description`,`category_cover` from `category` where `category_id` = '.$g_category.';';
		$result = mysql_query($query);
		if($result) $row = mysql_fetch_assoc($result);
		
		$_this_name = (empty($row['category_name'])) ? null : $row['category_name'] ;
		$_this_description = (empty($row['category_description'])) ? null : $row['category_description'] ;
		$_this_cover = (empty($row['category_cover'])) ? null : $row['category_cover'] ;
	}elseif(!empty($g_goods)){
		//主層
		$query = 'select `categoryarea_name`,`categoryarea_description`,`categoryarea_cover` from `categoryarea` where `categoryarea_id` = '.$g_goods.';';
		$result = mysql_query($query);
		if($result) $row = mysql_fetch_assoc($result);
		
		$_this_name = (empty($row['categoryarea_name'])) ? null : $row['categoryarea_name'] ;
		$_this_description = (empty($row['categoryarea_description'])) ? null : $row['categoryarea_description'] ;
		$_this_cover = (empty($row['categoryarea_cover'])) ? null : $row['categoryarea_cover'] ;
	}

	$social['social_look'] = $meta['social_look'];
	$social['social_skin'] = $meta['social_skin'];
	
	if($social['social_look'] == 'single'){
		$social_class = 'class="social-likes social-likes_single" data-single-title="Share"';
	}else{
		$social_class = 'class="social-likes"';
	}

?>

<html lang="en">
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $meta['web_title'].'Product | '.$_this_name; ?></title>
	<meta property="og:title" content="<?php echo $meta['web_title'].'Product | '.$_this_name; ?>">
	<meta property="og:description" content="<?php echo $_this_description; ?>">
	<meta property="og:image" content="<?php echo ADMIN_IMG_UPLOAD.'product/'.$_this_cover; ?>">
	<meta property="og:type" content="website">
	<meta name="description" content="<?php echo $_this_description; ?>" />
	<link rel="stylesheet" href="<?php echo URL_LIB_ROOT.'css/style.css' ?>">
	<link rel="stylesheet" href="<?php echo URL_LIB_ROOT.'css/bootstrap.css' ?>">
	<link rel="stylesheet" href="<?php echo URL_LIB_ROOT.'js/jquery.ias/css/jquery.ias.css' ?>">
	<link rel="stylesheet" href="<?php echo URL_LIB_ROOT.'js/jbox/jbox.css' ?>">
	<link rel="stylesheet" href="<?php echo URL_LIB_ROOT.'js/social-like/social-likes_'.$social['social_skin'].'.css' ?>">
	
    <script type="text/javascript" src="<?php echo URL_LIB_ROOT.'js/jquery-1.11.2.min.js' ;?>"></script>	
    <script type="text/javascript" src="<?php echo URL_LIB_ROOT.'js/javascript.js' ;?>"></script>	
    <script type="text/javascript" src="<?php echo URL_LIB_ROOT.'js/jquery.ias/js/jquery-ias.min.js' ;?>"></script>	
	<script type="text/javascript" src="<?php echo URL_LIB_ROOT.'js/jbox/jbox.js' ;?>"></script>	
	<script type="text/javascript" src="<?php echo URL_LIB_ROOT.'js/social-like/social-likes.min.js' ;?>"></script>		

</head>
<body>
<?php 
include('../site/content/product/data.php');
($dev_root === 'pindelta.com') ? include_once('./../analyticstracking.php') : include_once('./../analyticstracking2.php') ; 
?>
  <div id="main">
    <div id="container">
	  <div class="header">
	    <div class="header_banner">
		  <?php include('../site/header/header_banner.php'); ?>
		</div>	
	    <div class="header_menu">
		  <?php include('../site/header/header_menu.php'); ?>
		</div>
	  </div>
	  
	  <div class="content">
	    <div class="content_title">
		  <!-- 先留空 只有樣式-->
		</div>
		
		<div class="content_main">
		  <?php include('../site/content/product/product.php'); ?>
		</div>
	  </div>

	</div>
	<div class="back_top">
    
	</div>
    <div id="footer">
      <div class="footer_content">
	    Copyright @ 2015 Memorable Supplier. All Rights Reserved
	  </div>
    </div>	
	
  </div>
</body>

<script>
$('.social-likes').socialLikes({
    url: '<?php echo URL_ROOT.'product/?goods='.base64_encode($nav['categoryarea_id']).'&category='.base64_encode($nav['category_id']).'&items='.base64_encode($nav['product_id']); ?>',
    title: '品利興國際有限公司 - <?php echo $_this_name;?>',
    counters: true,
    singleTitle: 'Share it!',
	forceUpdate: true
});


$('.social-likes').on('popup_closed.social-likes', function(event, service) {
    // Request new counters
    $(event.currentTarget).socialLikes({forceUpdate: true});

    // Or just increase the number
    var counter = $(event.currentTarget).find('.social-likes__counter_' + service);
    counter.text(+(counter.text()||0)+1).removeClass('social-likes__counter_empty');
});

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
