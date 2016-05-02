<?php 
if( isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
	$id = !empty($_POST['id']) ? $_POST['id'] : null ;
	$act = !empty($_POST['act']) ? $_POST['act'] : null ;
	$name = !empty($_POST['name']) ? $_POST['name'] : null ;
	$priority = !empty($_POST['priority']) ? $_POST['priority'] : null ;
	$status = !empty($_POST['status']) ? $_POST['status'] : null ;
	$description = !empty($_POST['description']) ? $_POST['description'] : null ;
	$cover = !empty($_POST['cover']) ? $_POST['cover'] : null ;
	$cover_state = !empty($_POST['cover_state']) ? $_POST['cover_state'] : null ;

	if($id == null || $act == null || !in_array($act, ['add', 'edit'])) json_encode_return(0, '流程異常,請重新操作');
	if($name == null || $priority == null || $status == null || $cover == null) json_encode_return(0, '輸入資料不完整, 請重新輸入');

	switch ($cover_state) {
		case 'new':
			$file_dir = PATH_ROOT.'/admin2/files/';
			$file = $file_dir.$cover;
			$file_info = pathinfo($file);
			$new_file_name = uniqid().'.'.$file_info['extension'];
			$target = PATH_ROOT.'/upload/admin/images/categoryarea/';
			$new_file = $target.$new_file_name;

			if(!rename($file, $new_file)) json_encode_return(0, '圖片檔案處理失敗, 請重新操作',URL_ADMIN2_ROOT.'categoryarea/content.php?categoryarea_id='.$id);
			
			break;
		
		case 'old':
			$new_file_name = $cover;
			break;
		
		default:
			# code...
			break;
	}

	switch ($act) {
		case 'add':
			# code...
			break;

		case 'edit':
			$query = 'UPDATE `categoryarea` SET  
				`categoryarea_name` = "'.$name.'",
				`categoryarea_priority` = "'.$priority.'",
				`categoryarea_status` = "'.$status.'",
				`categoryarea_description` = "'.$description.'",
				`categoryarea_cover` = "'.$new_file_name.'",
				`categoryarea_modify_name` = "'.$_SESSION['admin']['name'].'" ,
				`categoryarea_modify_time` = NOW() WHERE  `categoryarea`.`categoryarea_id` = "'.$id.'" LIMIT 1 ; ';
			
			$query = query_despace($query);
			$result = mysql_query($query);
			(!$result) ? json_encode_return(0, '修改失敗，請確認您輸入的資料是否有誤', URL_ADMIN2_ROOT.'categoryarea/content.php?categoryarea_id='.$id) : json_encode_return(1, '修改成功', URL_ADMIN2_ROOT.'categoryarea/content.php?categoryarea_id='.$id);

			break;
		
		default:
			# code...
			break;
	}

}

	header('Content-type: text/html; charset=utf-8');
	header('Location: http://'.$_SERVER['SERVER_NAME']);
?>