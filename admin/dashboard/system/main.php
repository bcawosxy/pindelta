<div class="model_all">
  <div class="model_navbar">
    <div class="model_navbar_title">
	  <img src="<?php echo URL_IMG_ROOT."small_logo.png" ;?>" width="40" height="40">
	  <span><b><a class="nav_headlink" href="<?php echo URL_ADMIN_ROOT ?>">管理後台</a></b></span>
	  <hr>
	</div>
	
	<div class="model_navbar_list">
      <?php include('./../navlist.php'); ?>
	</div>
  </div>
  <?php 
	$query = 'select * from `system` ; ';
	$query = query_despace($query);
	$result = mysql_query($query);
	if(!$result) js_location(URL_ADMIN_ROOT);
	$row = mysql_fetch_assoc($result);
    
	$flat_check = null;
	$birman_check = null;
	$classic_check = null;
	$single_check = null;
	$horizontal_check = null;
	switch ($row['social_skin']){
		case 'flat':
			$flat_check = 'checked="true"';
		break;
		
		case 'birman':
			$birman_check = 'checked="true"';
		break;
		
		default:
			$classic_check = 'checked="true"';
		break;
	}
  
	switch ($row['social_look']){
		case 'single':
			$single_check = 'checked="true"';
		break;
		
		default:
			$horizontal_check = 'checked="true"';
		break;
	}
  
	$commit = (!empty($_POST['commit_btn'])) ? $_POST['commit_btn'] : null ;
	if($commit == 'Save'){
		$contact_email = (!empty($_POST['contact_email'])) ? $_POST['contact_email'] : null ;
		$inquiry_email = (!empty($_POST['inquiry_email'])) ? $_POST['inquiry_email'] : null ;
		$web_title = (!empty($_POST['web_title'])) ? $_POST['web_title'] : null ;
		$web_description = (!empty($_POST['web_description'])) ? $_POST['web_description'] : null ;
		$office_info_phone = (!empty($_POST['office_info_phone'])) ? $_POST['office_info_phone'] : null ;
		$office_info_email = (!empty($_POST['office_info_email'])) ? $_POST['office_info_email'] : null ;
		$social_look = (!empty($_POST['look'])) ? $_POST['look'] : null ;
		$social_skin = (!empty($_POST['skin'])) ? $_POST['skin'] : null ;
		
		$query = 'update `system` set 
				`contact_email` = "'.$contact_email.'",
				`inquiry_email` = "'.$inquiry_email.'",
				`web_title` = "'.$web_title.'",
				`web_description` = "'.$web_description.'",
				`office_info_phone` = "'.$office_info_phone.'",
				`office_info_email` = "'.$office_info_email.'",
				`social_look` = "'.$social_look.'",
				`social_skin` = "'.$social_skin.'"
				where id = 1;';
		$query = query_despace($query);
		$result = mysql_query($query);
		if(!$result) php_call_jbox('error','修改失敗' ,URL_ADMIN_ROOT.'system');
		
		php_call_jbox('success','修改完成' ,URL_ADMIN_ROOT.'system');
	}
  ?>
  <div class="model_content">
    <div class="page_title">系統參數</div><hr>
	<div>
	<form action="./" method="post">
		<table class="system_table">	
		<!--
			<tr>
				<td class="">
					<p class="system_title">Email </p>
					<div class="admin_tips">接收使用者提交問題的信箱</div>				
					<p>聯繫我們 - 信箱設定 ： <input type="email" class="system_text" maxlength="30" name="contact_email" value="<?php echo $row['contact_email'] ?>">  </p>
					<p>產品詢價 - 信箱設定 ： <input type="email" class="system_text" maxlength="30" name="inquiry_email" value="<?php echo $row['inquiry_email'] ?>">  </p>
				</td>
			</tr>
			<tr><td><br><br></td></tr>
		-->
			<tr>
				<td class="system_list">
					<p class="system_title">Title 及 Description  </p>
					<div class="admin_tips">網站標題及描述</div>
					<p>　　　Title ： <input type="text"  class="system_text" maxlength="30" name="web_title" value="<?php echo $row['web_title'] ?>">  </p>
					<p>Description ： <input type="text"  class="system_text" maxlength="50" name="web_description" value="<?php echo $row['web_description'] ?>">  </p>
				</td>
			</tr>
			<tr><td><br><br></td></tr>
			<tr>
				<td class="system_list">
					<p class="system_title">聯絡資料 </p>
					<div class="admin_tips">在Contact頁面中的聯絡資料</div>
					<p>&nbsp;&nbsp;&nbsp;&nbsp;Phone ： <input type="text"  class="system_text" maxlength="15" name="office_info_phone" value="<?php echo $row['office_info_phone'] ?>">  </p>
					<p>&nbsp;&nbsp;&nbsp;&nbsp;Email ： <input type="email"  class="system_text" maxlength="25" name="office_info_email" value="<?php echo $row['office_info_email'] ?>">  </p>
				</td>
			</tr>
			<tr><td><br><br></td></tr>
			<tr>
				<td class="system_list">
					<p class="system_title">社群網站連結樣式 </p>
					<div class="admin_tips">產品頁面上方社群網站樣式</div>
					<p>&nbsp;&nbsp;&nbsp;&nbsp;型態 ： <input type="radio" name="look" <?php echo $horizontal_check; ?> value="horizontal">展開&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="look" <?php echo $single_check; ?> value="single">收合 </p>
					<p>&nbsp;&nbsp;&nbsp;&nbsp;樣式 ： 
						<input type="radio" name="skin" <?php echo $flat_check; ?> value="flat"> A &nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="skin" <?php echo $birman_check; ?> value="birman"> B &nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="skin" <?php echo $classic_check; ?> value="classic">C 
					</p>
				</td>
			</tr>
			<tr>
				<td> <input type="submit" name="commit_btn" value="Save"></td> 
			</tr>
		</table>
	</form>
	</div>
  </div>
</div>
