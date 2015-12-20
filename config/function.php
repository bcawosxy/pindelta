<?php 
//用JS轉址
function js_location($href){  
	echo "<script>";
    echo "location.href = \"$href\";";
    echo "</script>";
}
  
//用PHP轉址
function redirect_php($url) {
	header('Content-type: text/html; charset=utf-8');
	header('Location: '.$url);
	die;
}
  
function php_call_jbox($status='success', $text, $redirect){
	echo '<script>';
	echo 'jbox_'.$status.'("'.$text.'", "'.$redirect.'")';
	echo '</script>';
	exit;
}
  
function show_msg($statu,$code){

	$status = 'success';
	$result_msg[$status]['msg_1'] = '資料修改完成!';

	$status = 'error';
	$result_msg[$status]['msg_1'] = '警告! 內容不可為空，請輸入內容!';


	if($statu == 'success'){
		echo '<div id="identifier" class="alert alert-success">';
	}else{
		echo '<div id="identifier" class="alert alert-danger">';
	}
	echo '<strong>'.$result_msg[$statu]['msg_'.$code].'</strong>'; 
	echo '</div>';
}
  
function get_remote_ip(){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	
	return $ip;
}  

/**
 * 0524 拿資料庫中常用的系統參數
 * 0925 配合取出DB.system參數，title及contact資訊由此取出
 */
function get_settings($key, $menu = null){
	$return = false;
	$suffix = null;
	$key = implode(',', $key);
 
	//依不同Menu插入suffix
	switch($menu){
		case 'about':
			$suffix = ' | About us';
		break;
		
		case 'product':
			$suffix = ' | Product';
		break;
		
		case 'contact':
			$suffix = ' | Contact us';
		break;
		
		default:
			$suffix = '';
	}
	
	//從DB撈出prefix以及contant 資訊
	$query = 'select '.$key.' from `system` where `system`.`id` = 1 ;';
	$result = mysql_query($query);
	if($result){
		$row = mysql_fetch_assoc($result);
		$return['web_title'] = !empty($row['web_title']) ? $row['web_title'].$suffix : null ;
		$return['web_description'] = !empty($row['web_description']) ? $row['web_description'] : null;
		$return['social_look'] = !empty($row['social_look']) ? $row['social_look'] : null;
		$return['social_skin'] = !empty($row['social_skin']) ? $row['social_skin'] : null;
		$return['office_info_phone'] = !empty($row['office_info_phone']) ? $row['office_info_phone'] : null;
		$return['office_info_email'] = !empty($row['office_info_email']) ? $row['office_info_email'] : null;
	}
	return $return;
}  
  
/**
 * 0524 對query作空白處理 
 */
function query_despace($query = null){
		if($query !== null){
			//去掉開始和結束的空白
			$query = trim($query);
			//去掉跟隨別的擠在一塊的空白
			$query = preg_replace('/\s(?=\s)/', '', $query);
			//去掉非space 的空白，用一個空格代替
			$query = preg_replace('/[\n\r\t]/', ' ', $query);
			return $query;
		
		}
		return $query;
}  

function remade_str($str, $length=25){
	if(strlen($str) > $length){
		$str = substr($str, 0 , $length).'...';
	}
	return $str ;
}
  
class info_bar{
	function update_result_show($statu,$code){

		$status = 'success';
		$result_msg[$status]['msg_1'] = '資料修改完成!';

		$status = 'error';
		$result_msg[$status]['msg_1'] = '警告! 內容不可為空，請輸入內容!'; 

		if($statu == 'success'){
			echo '<div id="identifier" class="alert alert-success">';
		}else{
			echo '<div id="identifier" class="alert alert-danger">';
		}
		echo '<strong>'.$result_msg[$statu]['msg_'.$code].'</strong>'; 
		echo '</div>';
	}
	function modify_info_show($name=null,$time=null){
		echo  '<h4><div class="label label-default">最後修改人員:&nbsp;<span class="modify_info">'.$name.'</span>&nbsp;&nbsp;&nbsp;&nbsp;最後修改時間:&nbsp;<span class="modify_info">'.$time.'</span></div></h4>';
	}
}
?>