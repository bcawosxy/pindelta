<?php 
	include('../config/global.php');

	$id = (!empty($_POST['id'])) ? $_POST['id'] : null ;
	$name = (!empty($_POST['name'])) ? $_POST['name'] : null ;
	$account = (!empty($_POST['account'])) ? $_POST['account'] : null ;
	$password = (!empty($_POST['password'])) ? $_POST['password'] : null ;

	if($id == null || $name == null || $account == null){
		echo  0;
		exit;
	}
	
	if($_SESSION['admin']['id'] != 1) {
		echo 2;
		exit;
	}
	
	$str = 'update admin set   
		admin_account = "'.urlencode($account).'" , 
		admin_name = "'.urlencode($name).'" , 
		admin_modify_time = NOW()';
	
	if($password != null) $str = $str.',admin_password = "'.$password.'"';
	
	
	$query = $str.' where id = "'.$id.'" limit 1;';
 	echo (mysql_query($query)) ? 1 : 0;


?>