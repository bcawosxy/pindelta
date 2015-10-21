<?php 
	include('../config/global.php');
	$id = (!empty($_POST['product_id'])) ? $_POST['product_id'] : null ;
	$tags = (!empty($_POST['tags'])) ? $_POST['tags'] : null ;
	$name = (!empty($_POST['name'])) ? $_POST['name'] : null ;

	if($id == null || $name == null){
		return 0;
		exit;
	}
	
	$tags = (!is_array($tags) && $tags == null) ? null :  addslashes(json_encode($tags)) ;

	$query = 'update product set  
		product_tags = "'.$tags.'" , 
		product_modify_time = NOW() ,
		product_modify_name = "'.$_SESSION['admin']['name'].'"
		where product_id = "'.$id.'" AND product_name = "'.$name.'" limit 1;';

 	echo (mysql_query($query)) ? 1 : 0;


?>