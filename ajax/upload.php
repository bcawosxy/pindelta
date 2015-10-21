<?php
	if(isset($_FILES['files']) && $_FILES['files']['error'] == 0){
		/*
		 4/29 分成不同目錄存放並加上隨機名稱
		 */
		
		$folder = $_GET['type'];
		$upload_folder = dirname(dirname ( __FILE__ )).'/upload/admin/images/'.$folder.'/';		
		
		switch ($_FILES['files']['type']){
			case 'image/jpeg':
			$img_type = '.jpg';
			
			case 'image/png':
			$img_type = '.png';
			
			default:
			$img_type = '.jpg';
		}
		
		$file_name = uniqid().$img_type;
		
		$upload_path = $upload_folder.$file_name;
		move_uploaded_file($_FILES['files']['tmp_name'], $upload_path);		
		echo '{"status":"'.$file_name.'"}';

		exit;
	}
	echo '{"status":"error"}';
	exit;
?>