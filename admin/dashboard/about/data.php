<?php  
	//0521 改成只抓ID=3的關於公司
	$about = array();
	$query = 'select * from about where id = 3;';
	$query = query_despace($query);
	$result = mysql_query($query);
	while($row = mysql_fetch_assoc($result)){
		$data = $row;
	}
	
	$commit = (!empty($_POST['about_btn'])) ? $_POST['about_btn'] :  null;
	if($commit == 'Save'){
		$new_value = $_POST['about_value'];
		$new_id = 3;
		if(empty($new_value)){//輸入的值為空白
			js_location($URL_ROOT.'admin/dashboard/about');
		}else{                        //不為空白時進行更新
			$new_value = stripslashes(htmlspecialchars($new_value));
			
			$query = 'UPDATE `about` SET  `value` =  \''.$new_value.'\' , `modify_name` = "'.$_SESSION['admin']['name'].'" ,`modify_time` = NOW() WHERE  `about`.`id` = "'.$new_id.'" LIMIT 1 ; ';
			$query = query_despace($query);
			$result = mysql_query($query);
			if($result){
				php_call_jbox('success', '修改成功', URL_ADMIN_ROOT.'about');
			}else{
				php_call_jbox('error','修改失敗，請確認您輸入的資料是否有誤', URL_ADMIN_ROOT.'about');
			}
		}
	}
?>
