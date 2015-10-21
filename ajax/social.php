<?php 
	include('../config/global.php');
	$id = (!empty($_POST['id'])) ? $_POST['id'] : null ;
	$name = (!empty($_POST['name'])) ? $_POST['name'] : null ;
	$status = (!empty($_POST['status'])) ? $_POST['status'] : null ;
	$url = (!empty($_POST['url'])) ? $_POST['url'] : null ;
	$sort = (!empty($_POST['sort'])) ? $_POST['sort'] : 0 ;

	if($id == null || $name == null || $status == null){
		return 0;
		exit;
	}
	//防呆
	if(empty($url) || $url == null) $status = 'close';
	// if(strpos($url, 'http://') == 0) $url = 'http://'.$url;
	
	
	$query = 'update sociallink set   
		status = "'.$status.'" , 
		url = "'.urlencode($url).'" , 
		sort = "'.$sort.'" , 
		modifytime = NOW()
		where id = "'.$id.'" AND name = "'.$name.'" limit 1;';
 	echo (mysql_query($query)) ? 1 : 0;


?>