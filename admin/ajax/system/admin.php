<?php 
if( isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
	$data = !empty($_POST['data']) ? $_POST['data'] : null ;

	if($data == null) json_encode_return(0, '未輸入內容');
	$data = json_decode($data, true);

	/**
	 *  v0[0] => admin_account, v0[1] => admin_password , v0[2] => admin_name , v0[3] => admin_email , v0[4] => id 
	 */

	foreach($data as $k0 => $v0) {
		$query = 'update `admin` set `admin_account` = "'.$v0[0].'",';
		if(!empty($v0[1]) && $v0[1] != '') $query .= '`admin_password` = "'.$v0[1].'",';
		$query .= '`admin_name` = "'.$v0[2].'", `admin_email` = "'.$v0[3].'" where `id`  = "'.$v0[4].'" ;';
		$result = mysql_query(query_despace($query));
		
		if(!$result) json_encode_return(0, '修改失敗. [Error id:'.$v0[4].']', URL_ADMIN2_ROOT.'system/admin.php');
	}
	
	json_encode_return(1, '修改成功', URL_ADMIN2_ROOT.'system/admin.php');
}
	header('Content-type: text/html; charset=utf-8');
	header('Location: http://'.$_SERVER['SERVER_NAME']);
?>