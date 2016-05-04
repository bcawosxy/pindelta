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
	$categoryarea_id = !empty($_POST['categoryarea_id']) ? $_POST['categoryarea_id'] : null ;

	if(!in_array($act, ['add', 'delete', 'edit'])) json_encode_return(0, '流程異常,請重新操作[ACT]');
	if(($act == 'edit' || $act == 'delete') && $id == null) json_encode_return(0, '流程異常,請重新操作[ID]');
	if( $act != 'delete') {
		if($name == null || $priority == null || $status == null || $cover == null) json_encode_return(0, '輸入資料不完整, 請重新輸入');
	}
	if($act == 'add' && $categoryarea_id == 0) json_encode_return(0, '請選擇所屬類別');

	switch ($cover_state) {
		case 'new':
			$file_dir = PATH_ROOT.'/admin2/files/';
			$file = $file_dir.$cover;
			$file_info = pathinfo($file);
			$new_file_name = uniqid().'.'.$file_info['extension'];
			$target = PATH_ROOT.'/upload/admin/images/category/';
			$new_file = $target.$new_file_name;

			if(!rename($file, $new_file)) json_encode_return(0, '圖片檔案處理失敗, 請重新操作',URL_ADMIN2_ROOT.'category/content.php?category_id='.$id);
			
			break;
		
		case 'old':
			$new_file_name = $cover;
			break;
		
		default:			
			break;
	}

	switch ($act) {
		case 'add':
			$query = 'INSERT INTO category (
			`category_name`,`category_priority`,`categoryarea_id`,
			`category_description`,`category_cover`,
			`category_insertime`,`category_admin`,
			`category_modify_name`,`category_status`) 
			VALUES (
			"'.htmlspecialchars($name).'","'.$priority.'","'.$categoryarea_id.'",
			"'.$description.'",
			"'.$new_file_name.'",NOW(), 
			"'.$_SESSION['admin']['id'].'",
			"'.$_SESSION['admin']['name'].'","'.$status.'")';
			$query = query_despace($query);	
			// echo $query;
			$result = mysql_query($query);
			(!$result) ? json_encode_return(0, '修改失敗，請確認您輸入的資料是否有誤', URL_ADMIN2_ROOT.'category/') : json_encode_return(1, '修改成功', URL_ADMIN2_ROOT.'category/');
		break;

		case 'edit':
			$query = 'UPDATE `category` SET  
				`category_name` = "'.$name.'",
				`category_priority` = "'.$priority.'",
				`category_status` = "'.$status.'",
				`category_description` = "'.$description.'",
				`category_cover` = "'.$new_file_name.'",
				`category_modify_name` = "'.$_SESSION['admin']['name'].'" ,
				`category_modify_time` = NOW() WHERE  `category`.`category_id` = "'.$id.'" LIMIT 1 ; ';
			
			$query = query_despace($query);
			$result = mysql_query($query);
			(!$result) ? json_encode_return(0, '修改失敗，請確認您輸入的資料是否有誤', URL_ADMIN2_ROOT.'category/content.php?category_id='.$id) : json_encode_return(1, '修改成功', URL_ADMIN2_ROOT.'category/content.php?category_id='.$id);

			break;
		
		case 'delete' :			
			function del_category(array $category_id_list) {
				$query = 'DELETE FROM category WHERE category_id IN ('.implode(',' , $category_id_list).') ;';
				$query = query_despace($query);
				return (mysql_query($query));		
			}

			function del_product(array $product_id_list) {
				$query = 'DELETE FROM product WHERE product_id IN ('.implode(',' , $product_id_list).') ;';
				$query = query_despace($query);
				return (mysql_query($query));		
			}
		
			function del_product_meta(array $product_id_list) {
				$query = 'DELETE FROM product_meta WHERE product_id IN ('.implode(',' , $product_id_list).') ;';
				$query = query_despace($query);
				return (mysql_query($query));		
			}
			
			//取得product_id
			function get_product_id(array $category_id) {
				$query = 'select `product_id` from product where product_category_id IN ('.implode(',' ,$category_id).') ;';
				$query = query_despace($query);
				$result = mysql_query($query);
				$product_id_list = array();
				while($row=mysql_fetch_assoc($result)){
					$product_id_list[] = $row['product_id'];
				}	
				return (!empty($product_id_list)) ? $product_id_list : null; 
			}
				
			
			$category_id[] = $id;
			
			//取得項目下的產品ID及刪除產品
			$product_id = get_product_id($category_id);
			if($product_id != null){
				if(!del_product($product_id)) json_encode_return(0, '刪除產品時發生錯誤,請重新操作。', URL_ADMIN2_ROOT.'category/');
				if(!del_product_meta($product_id)) json_encode_return(0, '刪除產品描述時發生錯誤,請重新操作。', URL_ADMIN2_ROOT.'category/');
			}
			//刪除項目
			(del_category($category_id)) ? json_encode_return(1, '刪除資料完成', URL_ADMIN2_ROOT.'category/') : json_encode_return(0, '刪除失敗', URL_ADMIN2_ROOT.'category/');

			break;

		default:
			json_encode_return(0, '流程異常,請重新操作[ACT#2]');
			break;
	}

}

	header('Content-type: text/html; charset=utf-8');
	header('Location: http://'.$_SERVER['SERVER_NAME']);
?>