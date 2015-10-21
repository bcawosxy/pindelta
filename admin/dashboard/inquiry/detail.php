	<div class="page_title">產品詢價 - 資料</div><hr>
	<!--<div class="admin_tips"></div>-->
	<?php 
		$id = (!empty($_GET['id'])) ? $_GET['id'] : js_location(URL_ADMIN_ROOT.'inquiry');
		$query = 'select `inquiry`.* from `inquiry` where `inquiry`.`id`  = "'.$id.'" ;';
		$query = query_despace($query);
		$result = mysql_query($query);
		if (mysql_num_rows($result) < 1) js_location(URL_ADMIN_ROOT.'inquiry');	
		$inquiry = array();
		$inquiry = mysql_fetch_assoc($result);

		
		//first read
		if($inquiry['read'] == 'unread'){
			$query = 'UPDATE `inquiry` SET `read` = "read", `reader` = "'.$_SESSION['admin']['id'].'", `read_time` = NOW() where `id` = "'.$inquiry['id'].'"';
			$query = query_despace($query);
			if (!mysql_query($query)) js_location(URL_ADMIN_ROOT.'inquiry');
			
			$inquiry['reader'] = $_SESSION['admin']['name'];
			$inquiry['read_time'] = date("Y-m-d H:i:s");
		}else{
			//has read 轉換ID為名稱
			$query = 'SELECT * from admin where id = "'.$inquiry['reader'].'"';
			$query = query_despace($query);
			$result = mysql_query($query);
			if(!$result) js_location(URL_ADMIN_ROOT.'inquiry');
			while($row = mysql_fetch_assoc($result)){
				$inquiry['reader'] = $row['admin_name'];
			}
		}

		$inquiry['demand'] = ( $inquiry['demand'] == 'true') ? 'Required' : 'Not required';
		
		//預設的onclick
		$onclick = 'archive_issue('.$inquiry['id'].')';
		$class = 'btn-warning';
		$value = 'Archive';
		
		
		if($inquiry['status'] == 'archive'){
			//要還原的onclick
			$onclick = 'recover_issue('.$inquiry['id'].')';
			$class = 'btn-success';
			$value = 'Recover';
		}
	
	?>
	<div>
		<table data-page-size="20">
			<tr><td width="110"  style="text-align:right;">姓:</td><td><span class="contact_data"> <?php echo $inquiry['last_name']; ?> </span></td></tr>
			<tr><td width="110"  style="text-align:right;">名:</td><td><span class="contact_data"> <?php echo $inquiry['first_name']; ?> </span></td></tr>
			<tr><td style="text-align:right;">Email:</td><td><span class="contact_data"> <?php echo $inquiry['email']; ?> </span></td></tr>
			<tr><td style="text-align:right;">公司名稱:</td><td><span class="contact_data"> <?php echo $inquiry['quantity']; ?> </span></td></tr>
			<tr><td style="text-align:right;">電話:</td><td><span class="contact_data"> <?php echo $inquiry['country']; ?> </span></td></tr>
			<tr><td style="text-align:right;">傳真:</td><td><span class="contact_data"> <?php echo $inquiry['company']; ?> </span></td></tr>
			<tr><td style="text-align:right;">地址:</td><td><span class="contact_data"> <?php echo $inquiry['weblink']; ?> </span></td></tr>
			<tr><td style="text-align:right;">Logo:</td><td><span class="contact_data"> <?php echo $inquiry['demand']; ?> </span></td></tr>
			<tr><td style="text-align:right;">memo:</td><td><span class="contact_data"> <?php echo $inquiry['memo']; ?> </span></td></tr>
			<tr>
				<td style="text-align:right;">狀態:</td>
				<td><span class="contact_data"> <?php echo $inquiry['status']; ?> </span></td>
			</tr>
			<tr><td style="text-align:right;">Reader:</td><td><span class="contact_data"> <?php echo $inquiry['reader']; ?> </span></td></tr>
			<tr><td style="text-align:right;">Read time:</td><td><span class="contact_data"> <?php echo $inquiry['read_time']; ?> </span></td></tr>
			<tr><td style="text-align:right;">ip:</td><td><span class="contact_data"> <?php echo $inquiry['ip']; ?> </span></td></tr>
			<tr><td style="text-align:right;">時間:</td><td><span class="contact_data"> <?php echo $inquiry['inserttime']; ?> </span></td></tr>
		</table>
		<br><input type="button" class="btn btn-link" onclick="history.back()" value="<<Back">&nbsp;&nbsp;&nbsp;
		<input type="button" class="btn <?php echo $class ?>" onclick="<?php echo $onclick; ?>" value="<?php echo $value; ?>">&nbsp;&nbsp;&nbsp;
		<input type="button" class="btn btn-danger" onclick="delete_issue(<?php echo $inquiry['id'] ?>)" value="Delete">
	</div>
  </div>
</div>
