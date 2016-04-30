<!DOCTYPE html>
<html lang="en">
<?php 
	//取得pindelta.com.tw目錄
	$PATH_ROOT = dirname(dirname(dirname(dirname(__FILE__))));
	include($PATH_ROOT.'/config/global.php');
	include($PATH_ROOT.'/config/function.php');
?>
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex">
	<meta name="robots" content="nofollow" />
	<meta name="googlebot" content="noindex">
	<title>品利興國際有限公司 - 後台管理系統</title>
	<script type="text/javascript" src="<?php echo URL_LIB_ROOT.'js/jquery-1.11.2.min.js' ;?>"></script>	
	<script src="<?php echo URL_LIB_ROOT.'js/jbox/jbox.js' ?>" type="text/javascript"></script>
	<link href="<?php echo URL_LIB_ROOT.'js/jbox/jbox.css' ?>" rel="stylesheet" type="text/css"/>
</head>

<body>

<?php
    /**
	 *	1. 0418 作htmlspecialchars 處理
	 *	2. 0419 加入驗證Btn(submit)來源以及jbox訊息 => (狀態, 文字, URL)
	 *	3.      php_call_jbox => 可轉址
	 *  4. 0617 沒有html標籤導致Jbox無法顯示文字，完整化此頁面的html 標籤宣告
	 */

    if(empty($_GET['act']) || empty($_GET['type']) || empty($_POST['key_btn'])) {
		js_location(URL_ADMIN_ROOT.'product');
	}else{
	  $act= (!empty($_GET['act'])) ? $_GET['act'] : null ;
	  $type= (!empty($_GET['type'])) ? $_GET['type'] : null ;
	  $id= (!empty($_GET['id'])) ? $_GET['id'] : null ;
	}
	
	$key_type = array();
	$key_type[] = 'categoryarea';
	$key_type[] = 'category';
	$key_type[] = 'product';	
	
	
	if($act == 'edit' ){
		if(!in_array($type, $key_type)) {
			js_location($URL_ADMIN_ROOT);
			exit;
		}
		
		if($_GET['type'] == 'categoryarea'){
			$name = $_POST['categoryarea_name'];
			$priority = $_POST['categoryarea_priority'];
			$description = (!empty($_POST['categoryarea_description'])) ? $_POST['categoryarea_description'] : '';
			$status = $_POST['status'];
			$cover = $_POST['categoryarea_cover'];
			
			$query = 'UPDATE `categoryarea` SET categoryarea_name = "'.htmlspecialchars($name).'" , 
					  categoryarea_priority = "'.$priority.'", 
					  categoryarea_description = "'.$description.'", 
					  categoryarea_cover = "'.$cover.'" , 
					  categoryarea_status = "'.$status.'", 
					  categoryarea_modify_time = NOW(), 
					  categoryarea_modify_name = "'.$_SESSION['admin']['name'].'" where categoryarea_id = "'.$id.'" limit 1;';
			
			
			$query = query_despace($query);

			if(mysql_query($query)) {				
				php_call_jbox('success', '修改成功', URL_ADMIN_ROOT.'product/?act=edit&type='.$type.'&id='.$id);
				
			}else{
				php_call_jbox('error','修改失敗，請確認您輸入的資料是否有誤', URL_ADMIN_ROOT.'product/?act=show&type='.$type);		
			}
			
		}		
		
		if($_GET['type'] == 'category'){
			$name = $_POST['category_name'];
			$priority = $_POST['category_priority'];
			$description = (!empty($_POST['category_description'])) ? $_POST['category_description'] : '';
			$status = (empty($_POST['status'])) ? 'lock' : $_POST['status'] ;
			$cover = $_POST['category_cover'];
			
			$query = 'update '.$type.' set category_name = "'.htmlspecialchars($name).'" ,
					  category_priority = "'.$priority.'", 
					  category_description = "'.$description.'", 
					  category_cover = "'.$cover.'" , 
					  category_status = "'.$status.'", 
					  category_modify_time = NOW(), 
					  category_modify_name = "'.$_SESSION['admin']['name'].'" where category_id = "'.$id.'" limit 1;';
			$query = query_despace($query);	
			
			if(mysql_query($query)) {
				php_call_jbox('success', '修改成功', URL_ADMIN_ROOT.'product/?act=edit&type='.$type.'&id='.$id);
			}else{
				php_call_jbox('error','修改失敗，請確認您輸入的資料是否有誤', URL_ADMIN_ROOT.'product/?act=show&type='.$type);		
			}
		}

		if($_GET['type'] == 'product') {
			$name = $_POST['product_name'];
			$priority = $_POST['product_priority'];
			$model = $_POST['product_model'];
			$standard = $_POST['product_standard'];
			$material = $_POST['product_material'];
			$produce_time = $_POST['product_produce_time'];
			$lowest = $_POST['product_lowest'];
			$category_id = $_POST['category_id'];
			$description = (!empty($_POST['product_description'])) ? $_POST['product_description'] : '';
			$content = $_POST['product_content'];
			$memo = $_POST['product_memo'];
			$cover = $_POST['product_cover'];
			$status = $_POST['status'];
			
			if(empty($name) || empty($priority) || empty($model) || empty($material) || empty($produce_time) || empty($lowest) || empty($category_id) 
			|| $category_id == 0 || empty($cover) || empty($status)) {
				js_location($URL_ADMIN_ROOT);
				exit;
			}
			$query = 'update '.$type.' set 
				product_category_id = "'.$category_id.'" ,
				product_name = "'.htmlspecialchars($name).'" , 
				product_cover = "'.$cover.'" , 
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
			if(mysql_query($query)){
				php_call_jbox('success', '修改成功', URL_ADMIN_ROOT.'product/?act=edit&type='.$type.'&id='.$id);
			}else{
				php_call_jbox('error','修改失敗，請確認您輸入的資料是否有誤', URL_ADMIN_ROOT.'product/?act=show&type='.$type);		
			}
		}	

		
	}
	
	if($act == 'add'){
		if(!in_array($type, $key_type)) {
			js_location($URL_ADMIN_ROOT);
			exit;
		}
		
		//進入產品類別新增
		if($_GET['type'] == 'categoryarea'){
			$name = $_POST['categoryarea_name'];
			$priority = $_POST['categoryarea_priority'];
			$categoryarea_cover = $_POST['categoryarea_cover'];
			$description = (!empty($_POST['categoryarea_description'])) ? $_POST['categoryarea_description'] : '';
		
			if(empty($name) || empty($priority) || empty($categoryarea_cover)) {
				js_location($URL_ADMIN_ROOT);
				exit;
			}
			
			$query = 'INSERT INTO categoryarea (
			`categoryarea_name`,`categoryarea_priority`,
			`categoryarea_description`,`categoryarea_cover`,
			`categoryarea_insert_time`,`categoryarea_admin_id`,
			`categoryarea_modify_name`,`categoryarea_status`) 
			VALUES (
			"'.htmlspecialchars($name).'","'.$priority.'",
			"'.$description.'",
			"'.$categoryarea_cover.'",NOW(), 
			"'.$_SESSION['admin']['id'].'",
			"'.$_SESSION['admin']['name'].'","close")';
			$query = query_despace($query);		
			if(mysql_query($query)){
				php_call_jbox('success', '新增資料完成', URL_ADMIN_ROOT.'product/?act=show&type='.$type);
			}else{
				php_call_jbox('error','新增失敗，請確認您輸入的資料是否有誤', URL_ADMIN_ROOT.'product/?act=show&type='.$type);		
			}
			
			js_location($URL_ROOT."admin/dashboard/product");
		}elseif($_GET['type'] == 'category'){
			$name = $_POST['category_name'];
			$priority = $_POST['category_priority'];
			$categoryarea_id = $_POST['categoryarea_id'];
			$description = (!empty($_POST['category_description'])) ? $_POST['category_description'] : '';
			$category_cover = $_POST['category_cover'];
			
			if(empty($name) || empty($priority) || empty($categoryarea_id) || $categoryarea_id == 0 || empty($category_cover)) js_location($URL_ADMIN_ROOT);
			
			$query = 'INSERT INTO category (
			`category_name`,`category_priority`,`category_description`,
			`categoryarea_id`,`category_cover`,`category_status`,
			`category_insertime`,`category_admin`,
			`category_modify_name`) 
			VALUES (
			"'.htmlspecialchars($name).'","'.$priority.'","'.$description.'",
			"'.$categoryarea_id.'","'.$category_cover.'",
			"close",NOW(),"'.$_SESSION['admin']['id'].'","'.$_SESSION['admin']['name'].'")';
			$query = query_despace($query);
			if(mysql_query($query)){
				php_call_jbox('success', '新增資料完成', URL_ADMIN_ROOT.'product/?act=show&type='.$type);
			}else{
				php_call_jbox('error','新增失敗，請確認您輸入的資料是否有誤', URL_ADMIN_ROOT.'product/?act=show&type='.$type);		
			}
			
			js_location($URL_ROOT."admin/dashboard/product?act=show&type=category");
			
		}elseif($_GET['type'] == 'product'){
			$name = $_POST['product_name'];
			$priority = $_POST['product_priority'];
			$model = $_POST['product_model'];
			$standard = $_POST['product_standard'];
			$material = $_POST['product_material'];
			$produce_time = $_POST['product_produce_time'];
			$lowest = $_POST['product_lowest'];
			$category_id = $_POST['category_id'];
			$description = (!empty($_POST['product_description'])) ? $_POST['product_description'] : '';
			$content = $_POST['product_content'];
			$memo = $_POST['product_memo'];
			$cover = $_POST['product_cover'];
			
			if(empty($name) || empty($priority) || empty($model) || empty($material) || empty($produce_time) || empty($lowest) || empty($category_id) 
			|| $category_id == 0 || empty($cover)) {
				js_location($URL_ADMIN_ROOT);
				exit;
			}
			
			//新增 product
			$query = 'INSERT INTO product (
			`product_category_id`,`product_name`,`product_cover`,
			`product_status`,`product_priority`,`product_description`,`product_content`,
			`product_model`,`product_standard`,`product_material`,`product_produce_time`,
			`product_lowest`,`product_memo`,`product_inserttime`,
			`product_admin`,`product_modify_name`,`status_record`) 
			VALUES (
			"'.$category_id.'","'.htmlspecialchars($name).'",
			"'.$cover.'","close",
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
				while($row=mysql_fetch_array($result)){
					$max_id = $row[0];
				}
				//新增description
				$query2 = 'INSERT INTO product_meta (`product_id`,`description` , `inserttime`,`modifyid`) VALUES (
					"'.$max_id.'", "Pindelta - '.htmlspecialchars($name).'" , NOW(), "'.$_SESSION['admin']['id'].'")';
				$query2 = query_despace($query2);
				if(mysql_query($query2)){
					php_call_jbox('success', '新增資料完成', URL_ADMIN_ROOT.'product/?type='.$type);
				}else{
					php_call_jbox('error','新增失敗，請確認您輸入的資料是否有誤(M)', URL_ADMIN_ROOT.'product/?act=show&type='.$type);		
				}
			}else{
				php_call_jbox('error','新增失敗，請確認您輸入的資料是否有誤(P)', URL_ADMIN_ROOT.'product/?act=show&type='.$type);		
			}
			
			js_location($URL_ROOT."admin/dashboard/product?act=show&type=product");
		}
		
	
		
	}
	
	if($act == 'delete'){
		if(!in_array($type, $key_type)) js_location($URL_ADMIN_ROOT);
		
		function del_categoryarea($categoryarea_id) {
			$query = 'DELETE FROM categoryarea WHERE categoryarea_id = '.$categoryarea_id.' ;';
			$query = query_despace($query);
			return (mysql_query($query));
		}
		
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
	
		//取得category_id
		function get_category_id(array $categoryarea_id) {
			$query = 'select `category_id` from category where categoryarea_id IN ('.implode(',' ,$categoryarea_id).') ;';
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
			$query = 'select `product_id` from product where product_category_id IN ('.implode(',' ,$category_id).') ;';
			$query = query_despace($query);
			$result = mysql_query($query);
			$product_id_list = array();
			while($row=mysql_fetch_assoc($result)){
				$product_id_list[] = $row['product_id'];
			}	
			return (!empty($product_id_list)) ? $product_id_list : null; 
		}
		
		if($type == 'categoryarea' ){
			$categoryarea_id[] = $id;

			//取得類別下的項目ID
			$category_id = get_category_id($categoryarea_id);
			
			if($category_id != null){
				//取得項目下的產品ID及刪除產品
				$product_id = get_product_id($category_id);
				if($product_id != null){
					if(!del_product($product_id)) php_call_jbox('error', '刪除產品時發生錯誤,請重新操作。', URL_ADMIN_ROOT.'product/?act=show&type='.$type);
					if(!del_product_meta($product_id)) php_call_jbox('error', '刪除產品描述時發生錯誤,請重新操作。', URL_ADMIN_ROOT.'product/?act=show&type='.$type);
				}
				//刪除項目
				if(!del_category($category_id)) php_call_jbox('error', '刪除項目時發生錯誤,請重新操作。', URL_ADMIN_ROOT.'product/?act=show&type='.$type);
			}
			
			//刪除類別
			(del_categoryarea($id)) ? php_call_jbox('success', '刪除資料完成', URL_ADMIN_ROOT.'product/?act=show&type='.$type) : php_call_jbox('error', '刪除失敗', URL_ADMIN_ROOT.'product/?act=show&type='.$type);		

		}
		
		if($type == 'category' ){
			$category_id[] = $id;
			
			//取得項目下的產品ID及刪除產品
			$product_id = get_product_id($category_id);
			if($product_id != null){
				if(!del_product($product_id)) php_call_jbox('error', '刪除產品時發生錯誤,請重新操作。', URL_ADMIN_ROOT.'product/?act=show&type='.$type);
				if(!del_product_meta($product_id)) php_call_jbox('error', '刪除產品描述時發生錯誤,請重新操作。', URL_ADMIN_ROOT.'product/?act=show&type='.$type);
			}
			//刪除項目
			(del_category($category_id)) ? php_call_jbox('success', '刪除資料完成', URL_ADMIN_ROOT.'product/?act=show&type='.$type) : php_call_jbox('error', '刪除失敗', URL_ADMIN_ROOT.'product/?act=show&type='.$type);
		}
		
		if($type == 'product'){
			$product_id[] = $id;
			(del_product($product_id) && del_product_meta($product_id)) ? php_call_jbox('success', '刪除資料完成', URL_ADMIN_ROOT.'product/?act=show&type='.$type) : php_call_jbox('error', '刪除失敗', URL_ADMIN_ROOT.'product/?act=show&type='.$type);
		}
		
		
	}
?>
</body>

</html>