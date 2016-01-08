<?php 
if( isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
	$inquiry_id = !empty($_POST['inquiry_id']) ? $_POST['inquiry_id'] : null ;
	$act = !empty($_POST['act']) ? $_POST['act'] : null ;
	if($inquiry_id == null || $act == null ) json_encode_return(0, '[Error] 資料錯誤請重新操作');

	switch($act) {
		case 'archive' :
			$query = query_despace('UPDATE `inquiry` SET `status` = "archive" where `id` = "'.$inquiry_id.'" limit 1');
			$result = mysql_query($query);
			(!$result) ? json_encode_return(0, '修改失敗，請確認您輸入的資料是否有誤', URL_ADMIN2_ROOT.'inquiry/content.php?inquiry_id='.$inquiry_id) : json_encode_return(1, '修改成功', URL_ADMIN2_ROOT.'inquiry/content.php?inquiry_id='.$inquiry_id);
		break;
		
		case 'delete' :
			$query = query_despace('UPDATE `inquiry` SET `status` = "delete" where `id` = "'.$inquiry_id.'" limit 1');
			$result = mysql_query($query);
			(!$result) ? json_encode_return(0, '刪除資料失敗，請確認您輸入的資料是否有誤', URL_ADMIN2_ROOT.'inquiry') : json_encode_return(1, '刪除資料成功', URL_ADMIN2_ROOT.'inquiry');
		break;	
	}
}
	header('Content-type: text/html; charset=utf-8');
	header('Location: http://'.$_SERVER['SERVER_NAME']);
?>