<?php 
if( isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
	$id = !empty($_POST['id']) ? $_POST['id'] : null ;
	$act = !empty($_POST['act']) ? $_POST['act'] : null ;
	$name = !empty($_POST['name']) ? $_POST['name'] : null ;
	$priority = !empty($_POST['priority']) ? $_POST['priority'] : null ;
	$model = !empty($_POST['model']) ? $_POST['model'] : null ;
	$standard = !empty($_POST['standard']) ? $_POST['standard'] : null ;
	$material = !empty($_POST['material']) ? $_POST['material'] : null ;
	$produce_time = !empty($_POST['produce_time']) ? $_POST['produce_time'] : null ;
	$lowest = !empty($_POST['lowest']) ? $_POST['lowest'] : null ;
	$category_id = !empty($_POST['category_id']) ? $_POST['category_id'] : null ;
	$content = !empty($_POST['content']) ? $_POST['content'] : null ;
	$memo = !empty($_POST['memo']) ? $_POST['memo'] : null ;
	$description = !empty($_POST['description']) ? $_POST['description'] : null ;
	$cover = !empty($_POST['cover']) ? $_POST['cover'] : null ;
	$status = !empty($_POST['status']) ? $_POST['status'] : null ;
	$cover_state = !empty($_POST['cover_state']) ? $_POST['cover_state'] : null ;

	$a_check_value = [
		'name' => $name,
		'priority' => $priority,
		'model' => $model,
		'material' => $material,
		'produce_time' => $produce_time,
		'category_id' => $category_id,
		'cover'=> $cover,
		'status' => $status,
	];

	
	//非delete 狀態
	if($act != 'delete') {
		//檢查必填欄位
		foreach ($a_check_value as $k0 => $v0) {
			if(empty($v0)) json_encode_return(0, '資料不完全,請重新輸入-('.ucfirst($k0).')', null, null);
		}

		if( !is_numeric($a_check_value['category_id'])) json_encode_return(0, 'ID錯誤', null, ucfirst('Category'));


		if($act == 'add' && $category_id == 0) json_encode_return(0, '所選項目錯誤', null, 'Category');

		switch ($cover_state) {
			case 'new':
				$file_dir = PATH_ROOT.'/admin2/files/';
				$file = $file_dir.$cover;
				$file_info = pathinfo($file);
				$new_file_name = uniqid().'.'.$file_info['extension'];
				$target = PATH_ROOT.'/upload/admin/images/product/';
				$new_file = $target.$new_file_name;

				if(!rename($file, $new_file)) json_encode_return(0, '圖片檔案處理失敗, 請重新操作',URL_ADMIN2_ROOT.'product/content.php?product_id='.$id);
				
				break;
			
			case 'old':
				$new_file_name = $cover;
				break;
			
			default:			
				break;
		}
	}

	switch ($act) {
		case 'add':			
			$query = 'INSERT INTO product (
			`product_category_id`,`product_name`,`product_cover`,
			`product_status`,`product_priority`,`product_description`,`product_content`,
			`product_model`,`product_standard`,`product_material`,`product_produce_time`,
			`product_lowest`,`product_memo`,`product_inserttime`,
			`product_admin`,`product_modify_name`,`status_record`) 
			VALUES (
			"'.$category_id.'","'.htmlspecialchars($name).'",
			"'.$new_file_name.'","'.$status.'",
			"'.$priority.'","'.htmlspecialchars($description).'","'.htmlspecialchars($content).'","'.htmlspecialchars($model).'",
			"'.htmlspecialchars($standard).'","'.htmlspecialchars($material).'",
			"'.htmlspecialchars($produce_time).'","'.htmlspecialchars($lowest).'",
			"'.htmlspecialchars($memo).'",NOW(),"'.$_SESSION['admin']['name'].'",
			"'.$_SESSION['admin']['name'].'","close")';
			$query = query_despace($query);
			//先新增產品
			if(mysql_query($query)){
				//成功後取回ID
				$query = 'select MAX(product_id) from product;';
				$query = query_despace($query);
				$result = mysql_query($query);
				while($row=mysql_fetch_array($result)){ $max_id = $row[0]; }
				
				//新增description
				$query2 = 'INSERT INTO product_meta (`product_id`,`description` , `inserttime`,`modifyid`) VALUES (
					"'.$max_id.'", "Pindelta - '.htmlspecialchars($name).'" , NOW(), "'.$_SESSION['admin']['id'].'")';
				$query2 = query_despace($query2);
				if(mysql_query($query2)){
					json_encode_return(1, '修改成功', URL_ADMIN2_ROOT.'product/');
				}else{
					json_encode_return(0, '修改失敗，請確認您輸入的資料是否有誤', URL_ADMIN2_ROOT.'product/');
				}
			}else{
				json_encode_return(0, '修改失敗，請確認您輸入的資料是否有誤', URL_ADMIN2_ROOT.'product/');
			}

		break;

		case 'edit':
			$query = 'update `product` set 
				product_category_id = "'.$category_id.'" ,
				product_name = "'.htmlspecialchars($name).'" , 
				product_cover = "'.$new_file_name.'" , 
				product_status = "'.$status.'" , 
				product_priority = "'.$priority.'" ,  
				product_description = "'.htmlspecialchars($description).'" , 
				product_content = "'.htmlspecialchars($content).'" , 
				product_model = "'.htmlspecialchars($model).'" , 
				product_standard = "'.htmlspecialchars($standard).'" , 
				product_material = "'.htmlspecialchars($material).'" , 
				product_produce_time = "'.htmlspecialchars($produce_time).'" , 
				product_lowest = "'.htmlspecialchars($lowest).'" , 
				product_memo = "'.htmlspecialchars($memo).'" , 
				product_modify_time = NOW(), 
				product_modify_name = "'.$_SESSION['admin']['name'].'"
				where product_id = "'.$id.'" limit 1;';
			
			$query = query_despace($query);
			$result = mysql_query($query);
			(!$result) ? json_encode_return(0, '修改失敗，請確認您輸入的資料是否有誤', URL_ADMIN2_ROOT.'product/content.php?product_id='.$id) : json_encode_return(1, '修改成功', URL_ADMIN2_ROOT.'product/content.php?product_id='.$id);

			break;
		
		case 'delete' :			
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

			$product_id[] = $id;
			(del_product($product_id) && del_product_meta($product_id)) ? json_encode_return(1, '刪除產品完成。', URL_ADMIN2_ROOT.'product/') : json_encode_return(0, '刪除產品失敗,請重新操作[#2]', URL_ADMIN2_ROOT.'product/');
				
			break;

		default:
			json_encode_return(0, '流程異常,請重新操作[ACT#2]');
			break;
	}

}

	header('Content-type: text/html; charset=utf-8');
	header('Location: http://'.$_SERVER['SERVER_NAME']);
?>