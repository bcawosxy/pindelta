<?php ob_start() ?>
<!DOCTYPE html>
	<?php 
		include('./config/global.php');
		include('./config/function.php');
		include('./lib/js/captcha/simple-php-captcha.php');
		$_SESSION['captcha'] = simple_php_captcha();
		setcookie('captcha', $_SESSION['captcha']['code']) ; 
		$meta = array('`web_title`', '`web_description`','`social_look`', '`social_skin`');
		$menu = (!empty($_GET['p'])) ? $_GET['p'] : null ;
		$meta = get_settings($meta, $menu);
	?>

	<?php 
		$tmp0 = md5('pindelta.com');
		if (!isset($_COOKIE['viewed'])) {
			$today = '"'.date("Y-m-d").'"';
			$query = 'select `count` from `viewed` where `date` = '.$today.' limit 1' ;
			
			$result = mysql_query($query);
			while($row = mysql_fetch_assoc($result)){	$viewed = $row['count'];}
			if(empty($viewed)) {
				$insert_query = 'INSERT INTO `viewed` (`date`, `count`) VALUES ('.$today.', 1) ;' ;
				mysql_query($insert_query);
			}else{
				$update_query = 'UPDATE `pindeltanet`.`viewed` SET `count` = '.($viewed+1).' WHERE `viewed`.`date` = '.$today.' ;';
				mysql_query($update_query);
			}
			setcookie('viewed', $tmp0, time() + 86400, '/');
		}
	?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--[if lt IE 9]>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $meta['web_title'] ; ?></title>
	<meta property="og:title" content="<?php echo $meta['web_title']; ?>">
	<meta property="og:description" content="<?php echo $meta['web_description']; ?>">
	<meta property="og:type" content="website">
	<meta name="description" content="<?php echo $meta['web_description']; ?>" />
	
	<link rel="stylesheet" href="<?php echo URL_LIB_ROOT.'css/style.css' ?>">
	<link rel="stylesheet" href="<?php echo URL_LIB_ROOT.'css/bootstrap.css' ?>">
	<link rel="stylesheet" href="<?php echo URL_LIB_ROOT.'js/jquery.ias/css/jquery.ias.css' ?>">
	<link rel="stylesheet" href="<?php echo URL_LIB_ROOT.'js/social-like/social-likes_classic.css' ?>">
    <link href="<?php echo URL_LIB_ROOT.'js/jbox/jbox.css' ?>" rel="stylesheet" type="text/css"/>
 
	<script type="text/javascript" src="<?php echo URL_LIB_ROOT.'js/jquery-1.11.2.min.js' ;?>"></script>	
    <script type="text/javascript" src="<?php echo URL_LIB_ROOT.'js/javascript.js' ;?>"></script>	
	<script type="text/javascript" src="<?php echo URL_LIB_ROOT.'js/jquery.ias/js/jquery-ias.min.js' ;?>"></script>		
	<script type="text/javascript" src="<?php echo URL_LIB_ROOT.'js/social-like/social-likes.min.js' ;?>"></script>		
    <script src="<?php echo URL_LIB_ROOT.'js/jbox/jbox.js' ?>" type="text/javascript"></script>

</head>
<body>
<?php 
($dev_root === 'pindelta.com') ? include_once('./analyticstracking.php') : include_once('./analyticstracking2.php') ; 
?>
  <div id="main">
    <div id="container">
	  <div class="header">
	    <div class="header_banner">
		  <?php include('./site/header/header_banner.php'); ?>
		</div>	
	    <div class="header_menu">
		  <?php include('./site/header/header_menu.php'); ?>
		</div>
	  </div>
	  
	  <div class="content">
	    <div class="content_title">
		  <!-- 先留空 只有樣式-->
		</div>
		
		<div class="content_main">
		  <?php include('./site/content/main.php'); ?>
		  
		</div>
	  </div>
	</div>
	<div class="back_top"></div>
    <div id="footer">
      <div class="footer_content">
	    Copyright @ 2015 Memorable Supplier. All Rights Reserved
	  </div>
    </div>	
	
  </div>
  
</body>
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

var ias = $.ias({
	container:  ('.category_show'),
	item:       '.item',
	pagination: '#next',
	next:       '#next a'
});

ias.extension(new IASSpinnerExtension());
ias.extension(new IASTriggerExtension({
	offset : 3 ,
	html : '<div class="ias_next">More... </div>',
}));
ias.extension(new IASNoneLeftExtension({
    html : '<div class="ias-noneleft ias_end">- End -</div>',
}));


ias.on('loaded', function(data, items) {
   	$(items).hover(function(){
		$(this).css('opacity','0.6');
	},function(){
		$(this).css('opacity','1');
	});

});


$('.category_show li').hover(function(){
	$(this).css('opacity','0.6');
},function(){
	$(this).css('opacity','1');
});

</script>
