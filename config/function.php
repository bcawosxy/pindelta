<?php 

//用JS轉址
function js_location($href, $text=null){  
	echo "<script>";
	if($text != null) {
		echo 'alert("'.$text.'");';
	}
    echo "location.href = \"$href\";";
    echo "</script>";
	die();
}
  
//用PHP轉址
function redirect_php($url) {
	header('Content-type: text/html; charset=utf-8');
	header('Location: '.$url);
	die();
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
  
/**
 * 1228 admin後台head區塊引入CSS檔案的處理
 */
function admin_set_css($file) {
	$return = null;
	if( is_array($file)) {
		foreach($file as $k => $v){
			$return .=  '<link rel="stylesheet" href="'.URL_ADMIN2_STATIC_FILE.$v.'">';
		}
	}
	echo $return;
}

/**
 * 1228 admin後台head區塊引入JS檔案的處理
 */
function admin_set_js($file) {
	$return = null;
	if( is_array($file)) {
		foreach($file as $k => $v){
			$return .=  '<script src="'.URL_ADMIN2_STATIC_FILE.$v.'"></script>';
		}
	}
	echo $return;
}
 
/**
 *  0102 admin再要求ajax處理時的路徑函式
 */
function ajax_url($root, $class = null, $function=null) {
	$return = null;
	if($class != null){
		$return = $root.'?class='.$class;
	}
	
	if($function != null){
		$return .= '&function='.$function;
	}
	
	return $return;
}

/**
 * 0102 AJAX 的固定回應字串
 */ 
function json_encode_return($result, $message=null, $redirect=null, $data=null) {
	echo json_encode(['result'=>$result,'message'=>$message,'redirect'=>$redirect, 'data'=>$data]);
	exit;
}
 
/**
 * 0104 admin 顯示修改資訊
 */
function edit_info($param = array()) {
	$return = null;
	if(!empty($param) && is_array($param)) {
		foreach($param as $k => $v) {
			$return .= $k.'<p class="text-light-blue">'.$v.'</p>';
		}
	}
	echo $return ;
}
 
/**
 * 0107 取得admin資料
 */
function get_admin($id = null) {
	$return = null;
	if($id != null){
		$query = query_despace('SELECT * from `admin` where id = "'.$id.'"');
		$result = mysql_query($query);
		if($result) {
			$return = mysql_fetch_assoc($result) ;
		}
	}
	return $return;
}	

/**
 * 0107 將 url 的 get urldecode 後 return 出 array
 */
function query_string_parse() {
	$return = array();
	$tmp1 = array();
	parse_str($_SERVER['QUERY_STRING'], $tmp1);
	foreach ($tmp1 as $k1 => $v1) {
		$return[urldecode($k1)] = urldecode($v1);
	}

	return $return;
}

/**
 * 0108 透過product_id取得前台產品的連結網址
 */
function get_product_url($id=null) {
	$return = null;
	if($id != null){
		$query = query_despace('select * from `product` where `product_id` = '.$id.' ;');
		$result = mysql_query($query);
		$product = mysql_fetch_assoc($result) ;
		if(empty($product)) return $return;
		
		$query = query_despace('select * from `category` where `category_status` = "open" and `category_id` = '.$product['product_category_id'].' ;');
		$result = mysql_query($query);
		$category = mysql_fetch_assoc($result) ;
		if(empty($category)) return $return;
		
		$query = query_despace('select * from `categoryarea` where `categoryarea_status` = "open" and `categoryarea_id` = '.$category['categoryarea_id'].' ;');
		$result = mysql_query($query);
		$categoryarea = mysql_fetch_assoc($result) ;
		if(empty($categoryarea)) return $return;
		
		$param = 'goods='.base64_encode($categoryarea['categoryarea_id']).'&category='.base64_encode($category['category_id']).'&items='.base64_encode($product['product_id']);
		$return = '<a target="_blank" href="'.URL_ROOT.'product?'.$param.'">'.$product['product_name'].'</a>';
	}
	return $return;
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