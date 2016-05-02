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
	die();
}
  
function php_call_jbox($status='success', $text, $redirect){
	echo '<script>';
	echo 'jbox_'.$status.'("'.$text.'", "'.$redirect.'")';
	echo '</script>';
	exit;
}
  
function show_msg($statu,$code){

	$status = "success";
	$result_msg[$status]['msg_1'] = "資料修改完成!";

	$status = "error";
	$result_msg[$status]['msg_1'] = "警告! 內容不可為空，請輸入內容!";


	if($statu == 'success'){
		echo "<div id='identifier' class='alert alert-success'>";
	}else{
		echo "<div id='identifier' class='alert alert-danger'>";
	}
	echo "<strong>".$result_msg[$statu]["msg_".$code]."</strong>"; 
	echo "</div>";
}
  
function get_remote_ip(){
	if (!empty($_SERVER["HTTP_CLIENT_IP"])){
		$ip = $_SERVER["HTTP_CLIENT_IP"];
	}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}else{
		$ip = $_SERVER["REMOTE_ADDR"];
	}
	
	return $ip;
}  

/**
 * 0524 拿資料庫中常用的系統參數 
 */
function get_settings($key){
	$key = implode(',', $key);

	$query = 'select '.$key.' from `system` where `system`.`id` = 1 ;';
	$result = mysql_query($query);
	if($result){
		$row = mysql_fetch_assoc($result);
		return $row;
	}
	
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
		
		}else{
			return $query;
		}
}  
  
  
function remade_str($str, $length=25){
	if(strlen($str) > $length){
		$str = substr($str, 0 , $length).'...';
	}
	
	return $str ;
}
  
class info_bar{
	function update_result_show($statu,$code){

		$status = "success";
		$result_msg[$status]['msg_1'] = "資料修改完成!";

		$status = "error";
		$result_msg[$status]['msg_1'] = "警告! 內容不可為空，請輸入內容!"; 

		if($statu == 'success'){
			echo "<div id='identifier' class='alert alert-success'>";
		}else{
			echo "<div id='identifier' class='alert alert-danger'>";
		}
		echo "<strong>".$result_msg[$statu]["msg_".$code]."</strong>"; 
		echo "</div>";
	}

  
	function modify_info_show($name=null,$time=null){
		echo  '<h4><div class="label label-default">最後修改人員:&nbsp;<span class="modify_info">'.$name.'</span>&nbsp;&nbsp;&nbsp;&nbsp;最後修改時間:&nbsp;<span class="modify_info">'.$time.'</span></div></h4>';
	}
}
?>

<script>
//JS轉址 搭配Jbox OR 直接呼叫
function js_location(url) {
	location.href = url;
}

//Error的提示Jbox
function jbox_error(text, url){
	if(url == undefined) url = 'javascript:void(0)';
	var modal = new jBox('Modal', {
			attach: $('#myModal'),
			delayOpen : 300,
			content: '<img width="20" height="20" src="<?php echo $URL_IMG_ROOT.'error.png' ?>"><span style="color:red; font-size:18px; font-family:微軟正黑體; font-weight:bold;">'+text+'</span>',
			onCloseComplete : function(){
				js_location(url);
			}
		});
	modal.open();	
}

//Success的提示Jbox
function jbox_success(text, url){
	if(url == undefined) url = 'javascript:void(0)';
	var modal = new jBox('Modal', {
			attach : $('#myModal'),
			delayOpen : 300,
			content : '<img width="30" height="30" src="<?php echo $URL_IMG_ROOT.'success.png' ?>"><span style="color:#108199; font-size:18px; font-family:微軟正黑體; font-weight:bold;">'+text+'</span>',
			onCloseComplete : function(){
				js_location(url);
			}
		});
	modal.open();	
}

function check_form(v){
	var reg = /^([a-zA-Z0-9_-{.}])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/; 
	var reg2 =/^[0123456789]+$/;
	var reg3 =/^[a-zA-Z0-9_-]+$/; 
	var reg4 =/^([0])+([9])+([0123456789])+$/ ;
	var reg5 =/^([0123456789])+$/ ;
	var reg6 =/^([0])+([0123456789])+$/ ;
	var reg7 =/^([a-zA-Z])+([a-zA-Z0-9_])+$/ ;
	var reg8 =/\\/ ;
	
	
	if(v == 'categoryarea_form'){
		var name = $('input[name=categoryarea_name]').val();
		var priority = $('input[name=categoryarea_priority]').val();	
		var cover = $('input[name=categoryarea_cover]').val();
		var description = $('input[name=categoryarea_description]').val();
		
		if(name.length<=0 || priority.length<=0 ||  cover.length<=0 || reg8.test(name)==true || reg5.test(priority)==false){
			jbox_error("請輸入正確的資料!");
			return false;
		}
		
		return true;
		
	}	
	
	if(v == 'category_form'){
		var name = $('input[name=category_name]').val();
		var priority = $('input[name=category_priority]').val();
		var categoryarea_id = $('#category_belong_categoryarea :selected').val();
		var cover = $('input[name=category_cover]').val();
		var description = $('input[name=category_description]').val();
		
		if(name.length<=0 || priority.length<=0 || categoryarea_id == "0" || cover.length<=0 ||  reg8.test(name)==true || reg5.test(priority)==false){
			jbox_error("請輸入正確的資料!");
			return false;
		}
		
		return true;
		
	}
	
	if(v == 'product_form'){
		var name = $('input[name=product_name]').val();
		var priority = $('input[name=product_priority]').val();
		var model = $('input[name=product_model]').val();
		var standard = $('input[name=product_standard]').val();
		var material = $('input[name=product_material]').val();
		var produce_time = $('input[name=product_produce_time]').val();
		var lowest = $('input[name=product_lowest]').val();
		var category_id = $('#product_belong_category :selected').val();
		var cover = $('input[name=product_cover]').val();
		var description = $('input[name=product_description]').val();
		
		
		if(name.length<=0 || priority.length<=0 || model.length<=0 || material.length<=0 || produce_time.length<=0 || lowest.length<=0 || category_id == "0" || cover.length<=0 || reg8.test(name)==true || reg5.test(priority)==false){
			jbox_error("請輸入正確的資料!");
			return false;
		}
		
		return true;
		
	}
	
	
	
}

</script>

