<?php 
if( isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
	// $value = !empty($_POST['value']) ? $_POST['value'] : null ;
	echo 1;
	return;
	// if($value == null) json_encode_return(0, '未輸入內容');

	// $value = stripslashes(htmlspecialchars($value));
	// $new_id = 3;
	// $query = 'UPDATE `about` SET  `value` =  \''.$value.'\' , `modify_name` = "'.$_SESSION['admin']['name'].'" ,`modify_time` = NOW() WHERE  `about`.`id` = "'.$new_id.'" LIMIT 1 ; ';
	// $query = query_despace($query);
	// $result = mysql_query($query);
	// (!$result) ? json_encode_return(0, '修改失敗，請確認您輸入的資料是否有誤', URL_ADMIN2_ROOT.'about') : json_encode_return(1, '修改成功', URL_ADMIN2_ROOT.'about');
}

	header('Content-type: text/html; charset=utf-8');
	header('Location: http://'.$_SERVER['SERVER_NAME']);
?>