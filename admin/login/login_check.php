<!DOCTYPE html>
<html lang="en">
<?php 
	include('../../config/global.php');
	include('../../config/function.php');
?>
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex">
	<meta name="robots" content="nofollow" />
	<meta name="googlebot" content="noindex">
	<title>品利興國際有限公司 - 後台管理系統</title>
	<link href="<?php echo URL_LIB_ROOT.'js/jbox/jbox.css' ?>" rel="stylesheet" type="text/css"/>
	
	<script type="text/javascript" src="<?php echo URL_LIB_ROOT.'js/jquery-1.11.2.min.js' ;?>"></script>	
	<script type="text/javascript" src="<?php echo URL_LIB_ROOT.'js/javascript.js' ;?>"></script>	
	<script src="<?php echo URL_LIB_ROOT.'js/jbox/jbox.js' ?>" type="text/javascript"></script>
</head>

<body>
<?php 

if($_POST['login_submit']){ 
	
	$login_account = $_POST['login_account'];
	$login_passwd = $_POST['login_passwd'];

	if(empty($login_account) || empty($login_passwd)){
	  js_location('?act=login');
	  exit;
	}else{
		unset($_SESSION['admin']);

		$query = 'select * from `admin` where admin_account = "'.$login_account.'" and admin_password = "'.$login_passwd.'";'; //將輸入的帳號與資料庫帳號做比對	
		$query = query_despace($query);
		$result = mysql_query($query);

		if($result && mysql_num_rows($result) > 0){
			while($row=mysql_fetch_array($result)){
				$_SESSION['admin']['id'] = $row['id'];
				$_SESSION['admin']['account'] = $row['admin_account']; //找到此帳號
				$_SESSION['admin']['passwd'] = $row['admin_password'];   //將密碼丟進去
				$_SESSION['admin']['name'] = $row['admin_name'];
				$_SESSION['admin']['email'] = $row['admin_email'];

			}
			
			if (!empty($_SERVER["HTTP_CLIENT_IP"])){
				$ip = $_SERVER["HTTP_CLIENT_IP"];
			}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
				$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			}else{
				$ip = $_SERVER["REMOTE_ADDR"];
			}
			
			$query = 'update `admin` set last_login_time = NOW() , 
				last_login_ip = "'.$ip.'"
				where id = "'.$_SESSION['admin']['id'].'" limit 1;';
			$query = query_despace($query);
			if($result = mysql_query($query)){
				js_location(''.URL_ADMIN_ROOT.'');
			}
			
		}else{
			php_call_jbox('error', '帳號或密碼錯誤', URL_ROOT.'admin');
			exit;
		}
	}
}else{
	php_call_jbox('error', '操作失敗。', URL_ROOT.'admin');
}
?>
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
</script>

</html>