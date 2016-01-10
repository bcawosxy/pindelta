<?php 
if( isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
	$data = !empty($_POST['data']) ? $_POST['data'] : null ;

	if($data == null) json_encode_return(0, '未輸入內容');
	$data = json_decode($data, true);

	/**
	 *  v0[0] => url, v0[1] => sort , v0[2] => act(on/off) , 
	 */

	foreach($data as $k0 => $v0) {
		$v0[2] = ($data[$k0][2] == 'Switch Off') ? 'open' : 'close';
		if( !is_url($v0[0]) ) json_encode_return(0, '非法的URL連結 [Error id:'.$v0[0].']', URL_ADMIN2_ROOT.'sociallink');
		
		$query = 'update `sociallink` set `url` = "'.$v0[0].'",';
		$query .= '`sort` = "'.$v0[1].'", `status` = "'.$v0[2].'", `modifytime` = NOW() where `id`  = "'.($k0+1).'" ;';
		$result = mysql_query(query_despace($query));
		if(!$result) json_encode_return(0, '修改失敗. [Error id:'.($k0+1).']', URL_ADMIN2_ROOT.'sociallink');
	}
	
	json_encode_return(1, '修改成功', URL_ADMIN2_ROOT.'sociallink');
}
	header('Content-type: text/html; charset=utf-8');
	header('Location: http://'.$_SERVER['SERVER_NAME']);
?>