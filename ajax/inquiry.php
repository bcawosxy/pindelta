<?php 
	include('../config/global.php');

	$act = $_GET['act'];

	switch ($act){
	
		case 'add': //from site
			$product_id = (!empty($_POST['product_id'])) ? $_POST['product_id'] : null ;
			$first_name = (!empty($_POST['first_name'])) ? $_POST['first_name'] : null ;
			$last_name = (!empty($_POST['last_name'])) ? $_POST['last_name'] : null ;
			$email = (!empty($_POST['email'])) ? $_POST['email'] : null ;
			$quantity = (!empty($_POST['quantity'])) ? $_POST['quantity'] : null ;
			$country = (!empty($_POST['country'])) ? $_POST['country'] : null ;
			$company = (!empty($_POST['company'])) ? $_POST['company'] : null ;
			$website = (!empty($_POST['website'])) ? $_POST['website'] : null ;
			$logo = (!empty($_POST['logo'])) ? $_POST['logo'] : null ;
			$memo = (!empty($_POST['memo'])) ? $_POST['memo'] : null ;
			$code = (!empty($_POST['code'])) ? $_POST['code'] : null ;
			$product_name = (!empty($_POST['product_name'])) ? $_POST['product_name'] : null ;
			$product_url = (!empty($_POST['product_url'])) ? $_POST['product_url'] : null ;
			
			//空值
			if($product_id == null || $first_name == null || $last_name == null || $email == null || $quantity == null || $country == null){
				$return = array(
					'result' => 0,
					'data' => null,
				);
				echo json_encode($return);
				exit;
			}
			
			//驗證碼不符
			if(strtolower($code) != strtolower($_SESSION['inquiry_code'])){
				$return = array(
					'result' => 2,
					'data' => strtolower($_SESSION['inquiry_code']),
				);
				echo json_encode($return);
				exit;
			}
			
			if (!empty($_SERVER["HTTP_CLIENT_IP"])){
				$ip = $_SERVER["HTTP_CLIENT_IP"];
			}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
				$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			}else{
				$ip = $_SERVER["REMOTE_ADDR"];
			}
			
			//檢查10分鐘之內送出的次數，限制為10分鐘3次
			$query = 'select COUNT(*) from `inquiry` WHERE `ip` = "'.$ip.'" AND inserttime > DATE_SUB(NOW(), INTERVAL 10 MINUTE)';
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result)){
				$count =  $row[0];
			}
			
			//次數過多
			if($count > 3){
				$return = array(
					'result' => 3,
					'data' => null,
				);
				echo json_encode($return);
				exit;
			}

			$query = 'INSERT INTO `inquiry` (`product_id`, `first_name`, `last_name`, `email`, `quantity`, `country`, `company`, `weblink`, `demand`, `memo`, `status`, `ip`, `inserttime`) VALUES 
			("'.$product_id.'", "'.$first_name.'", "'.$last_name.'", "'.$email.'",
			"'.$quantity.'", "'.$country.'", "'.$company.'",
			"'.$website.'", "'.$logo.'",
			"'.$memo.'","open" ,"'.$ip.'", NOW())';
		
			if(mysql_query($query)){
				$logo_str = ($logo == 'true') ? 'Yes' : 'No';
				$return = array(
					'result' => 1,
					'data' => '<form name="myform" method="post" action="http://www.pumo.com.tw/www/f2m?id=26881">
									姓 : <input type="text" name="01.姓" value="'.$first_name.'">
									名 : <input type="text" name="02.名" value="'.$last_name.'"> 
									信箱 : <input type="text" name="03.信箱" value="'.$email.'"> 
									數量 : <input type="text" name="04.數量" value="'.$quantity.'"> 
									國家 : <input type="text" name="05.國家" value="'.$country.'"> 
									公司 : <input type="text" name="06.公司" value="'.$company.'"> 
									網站 : <input type="text" name="07.網站" value="'.$website.'"> 
									Logo需求 : <input type="text" name="08.Logo需求" value="'.$logo_str.'"> 
									備註 : <input type="text" name="09.備註" value="'.$memo.'"> 
									產品名稱 : <input type="text" name="10.產品名稱" value="'.$product_name.'"> 
									產品連結 : <input type="text" name="11.產品連結" value="'.$product_url.'"> 
									
									<input type="hidden" name="charset" value="UTF-8">  
									<input id="inquiry_btn" type="submit">
								</form>',
				);
				echo json_encode($return);
			}else{
				$return = array(
					'result' => 4,
					'data' => null,
				);
				echo json_encode($return);
			}
				
		break;
		
		case 'archive': //from admin
			$id = (!empty($_POST['id'])) ? $_POST['id'] : null ;
			$query = 'UPDATE `inquiry` SET `status` = "archive" where id = "'.$id.'" limit 1';
			echo (mysql_query($query)) ? 1 : 0 ;

		break;
		
		case 'delete': //from admin
			$id = (!empty($_POST['id'])) ? $_POST['id'] : null ;
			$query = 'UPDATE `inquiry` SET `status` = "delete" where id = "'.$id.'" limit 1';
			echo (mysql_query($query)) ? 1 : 0 ;

		break;
		
		case 'recover': //from admin
			$id = (!empty($_POST['id'])) ? $_POST['id'] : null ;
			$query = 'UPDATE `inquiry` SET `status` = "open" where id = "'.$id.'" limit 1';
			echo (mysql_query($query)) ? 1 : 0 ;

		break;

	}


?>