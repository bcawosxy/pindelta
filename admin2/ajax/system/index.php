<?php 
if( isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
	$web_title = !empty($_POST['web_title']) ? $_POST['web_title'] : null ;
	$web_description = !empty($_POST['web_description']) ? $_POST['web_description'] : null ;
	$office_info_phone = (!empty($_POST['office_info_phone'])) ? $_POST['office_info_phone'] : null ;
	$office_info_email = (!empty($_POST['office_info_email'])) ? $_POST['office_info_email'] : null ;
	$r1 = (!empty($_POST['r1'])) ? $_POST['r1'] : null ;
	$r2 = (!empty($_POST['r2'])) ? $_POST['r2'] : null ;
	
	$contact_email = (!empty($_POST['contact_email'])) ? $_POST['contact_email'] : null ;
	$inquiry_email = (!empty($_POST['inquiry_email'])) ? $_POST['inquiry_email'] : null ;
	
	if($web_title == null || $web_description == null || $office_info_phone  == null || $office_info_email == null|| $r1 == null|| $r2 == null) json_encode_return(0, '未輸入內容');
	
	
	$query = 'update `system` set 
			`contact_email` = "'.$contact_email.'",
			`inquiry_email` = "'.$inquiry_email.'",
			`web_title` = "'.$web_title.'",
			`web_description` = "'.$web_description.'",
			`office_info_phone` = "'.$office_info_phone.'",
			`office_info_email` = "'.$office_info_email.'",
			`social_look` = "'.$r1.'",
			`social_skin` = "'.$r2.'"
			where id = 1;';

	$result = mysql_query(query_despace($query));
	(!$result) ? json_encode_return(0, '修改失敗，請確認您輸入的資料是否有誤', URL_ADMIN2_ROOT.'system') : json_encode_return(1, '修改成功', URL_ADMIN2_ROOT.'system');
}

	header('Content-type: text/html; charset=utf-8');
	header('Location: http://'.$_SERVER['SERVER_NAME']);
	
	

?>