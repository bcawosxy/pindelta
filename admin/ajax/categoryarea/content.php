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

	if(!in_array($act, ['add', 'delete', 'edit'])) json_encode_return(0, '流程異常,請重新操作[ACT]');
	if(($act == 'edit' || $act == 'delete') && $id == null) json_encode_return(0, '流程異常,請重新操作[ID]');
	if( $act != 'delete') {
		if($name == null || $priority == null || $status == null || $cover == null) json_encode_return(0, '輸入資料不完整, 請重新輸入');
	}

	switch ($cover_state) {
		case 'new':
			$file_dir = PATH_ROOT.'/admin/files/';
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
			break;
	}

	switch ($act) {
		case 'add':
			$query = 'INSERT INTO categoryarea (
			`categoryarea_name`,`categoryarea_priority`,
			`categoryarea_description`,`categoryarea_cover`,
			`categoryarea_insert_time`,`categoryarea_admin_id`,
			`categoryarea_modify_name`,`categoryarea_status`) 
			VALUES (
			"'.htmlspecialchars($name).'","'.$priority.'",
			"'.$description.'",
			"'.$new_file_name.'",NOW(), 
			"'.$_SESSION['admin']['id'].'",
			"'.$_SESSION['admin']['name'].'","'.$status.'")';
			$query = query_despace($query);	
			$result = mysql_query($query);
			(!$result) ? json_encode_return(0, '修改失敗，請確認您輸入的資料是否有誤', URL_ADMIN2_ROOT.'categoryarea/') : json_encode_return(1, '修改成功', URL_ADMIN2_ROOT.'categoryarea/');
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
		
		case 'delete' :
			function del_categoryarea($categoryarea_id) {
				$query = 'UPDATE `categoryarea` SET `categoryarea_status` = "delete" WHERE `categoryarea`.`categoryarea_id` = '.$categoryarea_id.' ;';
				return (mysql_query($query));
			}
			
			function del_category(array $category_id_list) {
				$query = 'UPDATE `category` SET `category_status` = "delete" WHERE `category`.`category_id` IN ('.implode(',' , $category_id_list).') ;';
				$query = query_despace($query);
				return (mysql_query($query));		
			}

			function del_product(array $product_id_list) {
				$query = 'UPDATE `product` SET `product_status` = "delete" WHERE `product`.`product_id` IN ('.implode(',' , $product_id_list).') ;';
				$query = query_despace($query);
				return (mysql_query($query));		
			}
		
			function del_product_meta(array $product_id_list) {
				$query = 'DELETE FROM product_meta WHERE product_id IN ('.implode(',' , $product_id_list).') ;';
				$query = query_despace($query);
				return (mysql_query($query));		
			}
		
			//取得category_id
			function get_category_id(array $categoryarea_id) {
				$query = 'select `category_id` from category where `category_status` != "delete" and `categoryarea_id` IN ('.implode(',' ,$categoryarea_id).') ;';
				$query = query_despace($query);
				$result = mysql_query($query);
				$category_id_list = array();
				while($row=mysql_fetch_assoc($result)){
					$category_id_list[] = $row['category_id'];
				}	
				return (!empty($category_id_list)) ? $category_id_list : null; 
			}
			
			//取得product_id
			function get_product_id(array $category_id) {
				$query = 'select `product_id` from product where `product_status` != "delete" and `product_category_id` IN ('.implode(',' ,$category_id).') ;';
				$query = query_despace($query);
				$result = mysql_query($query);
				$product_id_list = array();
				while($row=mysql_fetch_assoc($result)){
					$product_id_list[] = $row['product_id'];
				}	
				return (!empty($product_id_list)) ? $product_id_list : null; 
			}
				
			
			$categoryarea_id[] = $id;

			//取得類別下的項目ID
			$category_id = get_category_id($categoryarea_id);
			
			if($category_id != null){
				//取得項目下的產品ID及刪除產品
				$product_id = get_product_id($category_id);
				if($product_id != null){
					if(!del_product($product_id)) json_encode_return(0, '刪除產品時發生錯誤,請重新操作。', URL_ADMIN2_ROOT.'categoryarea/');
					if(!del_product_meta($product_id)) json_encode_return(0, '刪除產品描述時發生錯誤,請重新操作。', URL_ADMIN2_ROOT.'categoryarea/');
				}
				//刪除項目
				if(!del_category($category_id)) json_encode_return(0, '刪除項目時發生錯誤,請重新操作。', URL_ADMIN2_ROOT.'categoryarea/');
			}
			
			//刪除類別
			(del_categoryarea($id)) ? json_encode_return(1, '刪除資料完成', URL_ADMIN2_ROOT.'categoryarea/') : json_encode_return(0, '刪除失敗', URL_ADMIN2_ROOT.'categoryarea/');		

			break;

		default:
			json_encode_return(0, '流程異常,請重新操作[ACT#2]');
			break;
	}

}

	header('Content-type: text/html; charset=utf-8');
	header('Location: http://'.$_SERVER['SERVER_NAME']);
?>