<?php 
if( isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
	$contact_id = !empty($_POST['contact_id']) ? $_POST['contact_id'] : null ;
	$act = !empty($_POST['act']) ? $_POST['act'] : null ;
	if($contact_id == null || $act == null ) json_encode_return(0, '[Error] 資料錯誤請重新操作');

	switch($act) {
		case 'archive' :
			$query = query_despace('UPDATE `contact` SET `status` = "archive" where `id` = "'.$contact_id.'" limit 1');
			$result = mysql_query($query);
			(!$result) ? json_encode_return(0, '修改失敗，請確認您輸入的資料是否有誤', URL_ADMIN2_ROOT.'contact/content.php?contact_id='.$contact_id) : json_encode_return(1, '修改成功', URL_ADMIN2_ROOT.'contact/content.php?contact_id='.$contact_id);
		break;
		
		case 'delete' :
			$query = query_despace('UPDATE `contact` SET `status` = "delete" where `id` = "'.$contact_id.'" limit 1');
			$result = mysql_query($query);
			(!$result) ? json_encode_return(0, '刪除資料失敗，請確認您輸入的資料是否有誤', URL_ADMIN2_ROOT.'contact') : json_encode_return(1, '刪除資料成功', URL_ADMIN2_ROOT.'contact');
		break;	
	}
}
	header('Content-type: text/html; charset=utf-8');
	header('Location: http://'.$_SERVER['SERVER_NAME']);
?>