	<div class="page_title">聯繫我們 - 資料</div><hr>
	<!--<div class="admin_tips"></div>-->
	<?php 
		$id = (!empty($_GET['id'])) ? $_GET['id'] : js_location(URL_ADMIN_ROOT.'contact');
		$query = 'select `contact`.* from `contact` where `contact`.`id`  = "'.$id.'" ;';
		$query = query_despace($query);
		$result = mysql_query($query);
		if (mysql_num_rows($result) < 1) js_location(URL_ADMIN_ROOT.'contact');	
		$contact = array();
		$num = 1 ;
		while($row=mysql_fetch_array($result)){
			$contact['id'] = $row['id'];
			$contact['first_name'] = $row['first_name'];
			$contact['last_name'] = $row['last_name'];
			$contact['company'] = $row['company'];
			$contact['tel'] = $row['tel'];
			$contact['fax'] = $row['fax'];
			$contact['address'] = $row['address'];
			$contact['email'] = $row['email'];
			$contact['memo'] = $row['memo'];
			$contact['status'] = $row['status'];
			$contact['read'] = $row['read'];
			$contact['reader'] = $row['reader'];
			$contact['read_time'] = $row['read_time'];
			$contact['ip'] = $row['ip'];
			$contact['inserttime'] = $row['inserttime'];
			
			$num++;
		}
		
		//first read
		if($contact['read'] == 'unread'){
			$query = 'UPDATE `contact` SET `read` = "read", `reader` = "'.$_SESSION['admin']['id'].'", `read_time` = NOW() where `id` = "'.$contact['id'].'"';
			$query = query_despace($query);
			if (!mysql_query($query)) js_location(URL_ADMIN_ROOT.'contact');
			
			$contact['reader'] = $_SESSION['admin']['name'];
			$contact['read_time'] = date("Y-m-d H:i:s");
		}else{
			//has read 轉換ID為名稱
			$query = 'SELECT * from admin where id = "'.$contact['reader'].'"';
			$query = query_despace($query);
			$result = mysql_query($query);
			if(!$result) js_location(URL_ADMIN_ROOT.'contact');
			while($row = mysql_fetch_assoc($result)){
				$contact['reader'] = $row['admin_name'];
			}
		}

		//預設的onclick
		$onclick = 'archive_issue('.$contact['id'].')';
		$class = 'btn-warning';
		$value = 'Archive';
		
		
		if($contact['status'] == 'archive'){
			//要還原的onclick
			$onclick = 'recover_issue('.$contact['id'].')';
			$class = 'btn-success';
			$value = 'Recover';
		}
	
	?>
	<div>
		<table>
			<tr><td width="110"  style="text-align:right;">姓:</td><td><span class="contact_data"> <?php echo $contact['last_name']; ?> </span></td></tr>
			<tr><td style="text-align:right;">公司名稱:</td><td><span class="contact_data"> <?php echo $contact['company']; ?> </span></td></tr>
			<tr><td style="text-align:right;">電話:</td><td><span class="contact_data"> <?php echo $contact['tel']; ?> </span></td></tr>
			<tr><td style="text-align:right;">傳真:</td><td><span class="contact_data"> <?php echo $contact['fax']; ?> </span></td></tr>
			<tr><td style="text-align:right;">地址:</td><td><span class="contact_data"> <?php echo $contact['address']; ?> </span></td></tr>
			<tr><td style="text-align:right;">Email:</td><td><span class="contact_data"> <?php echo $contact['email']; ?> </span></td></tr>
			<tr><td style="text-align:right;">memo::</td><td><span class="contact_data"> <?php echo $contact['memo']; ?> </span></td></tr>
			<tr>
				<td style="text-align:right;">狀態:</td>
				<td><span class="contact_data"> <?php echo $contact['status']; ?> </span></td>
			</tr>
			<tr><td style="text-align:right;">Reader:</td><td><span class="contact_data"> <?php echo $contact['reader']; ?> </span></td></tr>
			<tr><td style="text-align:right;">Read time:</td><td><span class="contact_data"> <?php echo $contact['read_time']; ?> </span></td></tr>
			<tr><td style="text-align:right;">ip:</td><td><span class="contact_data"> <?php echo $contact['ip']; ?> </span></td></tr>
			<tr><td style="text-align:right;">時間:</td><td><span class="contact_data"> <?php echo $contact['inserttime']; ?> </span></td></tr>
		</table>
		<br><input type="button" class="btn btn-link" onclick="history.back()" value="<<Back">&nbsp;&nbsp;&nbsp;
		<input type="button" class="btn <?php echo $class ?>" onclick="<?php echo $onclick; ?>" value="<?php echo $value; ?>">&nbsp;&nbsp;&nbsp;
		<input type="button" class="btn btn-danger" onclick="delete_issue(<?php echo $contact['id'] ?>)" value="Delete">
	</div>
  </div>
</div>
