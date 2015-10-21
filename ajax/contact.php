<?php 
	include('../config/global.php');
			
	$act = $_GET['act'];
	switch ($act){
	
		case 'add': //from site
			$first_name = (!empty($_POST['first_name'])) ? $_POST['first_name'] : null ;
			$last_name = (!empty($_POST['last_name'])) ? $_POST['last_name'] : null ;
			$tel = (!empty($_POST['tel'])) ? $_POST['tel'] : null ;
			$fax = (!empty($_POST['fax'])) ? $_POST['fax'] : null ;
			$company = (!empty($_POST['company'])) ? $_POST['company'] : null ;
			$email = (!empty($_POST['email'])) ? $_POST['email'] : null ;
			$address = (!empty($_POST['address'])) ? $_POST['address'] : null ;
			$memo = (!empty($_POST['memo'])) ? $_POST['memo'] : null ;
			$code = (!empty($_POST['code'])) ? $_POST['code'] : null ;

			//空值
			if($first_name == null || $last_name == null || $tel == null){
				$return = array(
					'result' => 0,
					'data' => null,
				);
				echo json_encode($return);
				exit;
			}
			
			//驗證碼不符
			if(strtolower($code) != strtolower($_COOKIE['captcha'])){
				$return = array(
					'result' => 2,
					'data' => null,
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
			
			//檢查10分鐘之內送出的次數，限制為10分鐘5次
			$query = 'select COUNT(*) from `contact` WHERE `ip` = "'.$ip.'" AND inserttime > DATE_SUB(NOW(), INTERVAL 10 MINUTE)';
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result)){
				$count =  $row[0];
			}
			//次數過多
			if($count > 5){
				$return = array(
					'result' => 3,
					'data' => null,
				);
				echo json_encode($return);
				exit;
			}

			$query = 'INSERT INTO `contact` (`first_name`, `last_name`, `company`, `tel`, `fax`, `address`, `email`, `memo`, `ip`, `inserttime`) VALUES 
			("'.$first_name.'", "'.$last_name.'", "'.$tel.'", "'.$fax.'", "'.$company.'", "'.$email.'", "'.$address.'", "'.$memo.'", "'.$ip.'", NOW())';
			
			//寄送表單
			if(mysql_query($query)){
				$return = array(
					'result' => 1,
					'data' => '<form name="myform" method="post" action="http://www.pumo.com.tw/www/f2m?id=26880">
								姓 : <input type="text" name="1.姓" value="'.$first_name.'">
								名 : <input type="text" name="2.名" value="'.$last_name.'"> 
								電話 : <input type="text" name="3.電話" value="'.$tel.'"> 
								傳真 : <input type="text" name="4.傳真" value="'.$fax.'"> 
								公司 : <input type="text" name="5.公司" value="'.$company.'"> 
								信箱 : <input type="text" name="6.信箱" value="'.$email.'"> 
								地址 : <input type="text" name="7.地址" value="'.$address.'"> 
								備註 : <input type="text" name="8.備註" value="'.$memo.'"> 
								<input type="hidden" name="charset" value="UTF-8">  
								<input id="contact_btn" type="submit">
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
			$query = 'UPDATE `contact` SET `status` = "archive" where id = "'.$id.'" limit 1';
			echo (mysql_query($query)) ? 1 : 0 ;

		break;
		
		case 'delete': //from admin
			$id = (!empty($_POST['id'])) ? $_POST['id'] : null ;
			$query = 'UPDATE `contact` SET `status` = "delete" where id = "'.$id.'" limit 1';
			echo (mysql_query($query)) ? 1 : 0 ;

		break;
		
		case 'recover': //from admin
			$id = (!empty($_POST['id'])) ? $_POST['id'] : null ;
			$query = 'UPDATE `contact` SET `status` = "open" where id = "'.$id.'" limit 1';
			echo (mysql_query($query)) ? 1 : 0 ;

		break;

	}


?>