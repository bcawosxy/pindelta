<?php 
	include('../config/global.php');
	
	$id = (!empty($_POST['proudct_id'])) ? $_POST['proudct_id'] : null ;
	$text = (!empty($_POST['text'])) ? $_POST['text'] : null ;

	if($id == null || $text == null){
		return 0;
		exit;
	}

	$query = 'update `product_meta` set `description` = "'.htmlspecialchars($text).'" , `modifytime` = NOW(), `modifyid` = "'.$_SESSION['admin']['id'].'" where `product_id` = "'.$id.'" limit 1;';
	echo (mysql_query($query)) ? 1 : 0;


?>