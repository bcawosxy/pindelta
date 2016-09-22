<?php 
$account = !empty($_POST['account']) ? $_POST['account'] : null ;
$password = !empty($_POST['password']) ? $_POST['password'] : null;

if($account == null || $password == null) json_encode_return(0, '請輸入帳號密碼');

$query = query_despace('select * from `admin` where `admin_account` = "'.$account.'" and `admin_password` = "'.$password.'"');
$result = mysql_query($query);
//驗證帳秘
if(mysql_num_rows($result) < 1 ){
	json_encode_return(0, '帳號或密碼錯誤，請重新輸入。');
}else{
	while($row=mysql_fetch_array($result)){
		$_SESSION['admin']['id'] = $row['id'];
		$_SESSION['admin']['account'] = $row['admin_account'];	//找到此帳號
		$_SESSION['admin']['passwd'] = $row['admin_password'];	//將密碼丟進去
		$_SESSION['admin']['name'] = $row['admin_name'];
		$_SESSION['admin']['email'] = $row['admin_email'];
	}
	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	
	$query = 'update `admin` set last_login_time = NOW() , 
		last_login_ip = "'.$ip.'"
		where id = "'.$_SESSION['admin']['id'].'" limit 1;';
	$query = query_despace($query);
	if($result = mysql_query($query)){ json_encode_return(1, '登入成功', URL_ADMIN2_ROOT.'charts');	}	
	
}


?>