<div class="model_all">
  <div class="model_navbar">
    <div class="model_navbar_title">
	  <img src="<?php echo URL_IMG_ROOT."small_logo.png" ;?>" width="40" height="40">
	  <span><b><a class="nav_headlink" href="<?php echo URL_ADMIN_ROOT ?>">管理後台</a></b></span>
	  <hr>
	</div>
	
	<div class="model_navbar_list">
      <?php  include('./../navlist.php'); ?>
	</div>
  </div>
	<?php 
		$query = 'select * from `admin`;';
		$query = query_despace($query);
		$result = mysql_query($query);
		$d_admin = array();
		$n = 0 ;
		while($row=mysql_fetch_array($result)){
			$d_admin[$n]['id'] = $row['id'];
			$d_admin[$n]['admin_account'] = $row['admin_account'];
			$d_admin[$n]['admin_name'] = $row['admin_name'];
			$d_admin[$n]['admin_email'] = $row['admin_email'];
			$d_admin[$n]['last_login_time'] = $row['last_login_time'];
			$d_admin[$n]['last_login_ip'] = $row['last_login_ip'];
			$n++;
		}
	?>
	
	<div class="model_content">
		<div class="page_title">管理員清單</div><hr>
		<div class="admin_tips">若更改資料時密碼留空則視為不更改密碼。</div>

		<table class="footable metro-blue" data-page-size="10" data-filter="#filter" data-filter-text-only="true">
			<thead>
				<tr>
					<th>管理員名稱 </th>
					<th>管理員帳號 </th>
					<th>修改密碼 </th>
					<th>修改</th>	
					<th data-hide="phone,tablet">上次登入時間</th>		
					<th data-hide="phone,tablet">上次登入IP</th>					
				</tr>
			</thead>
		<tbody>
		<?php 
		foreach($d_admin as $k => $v){
			echo '<tr id="admin_'.$v['id'].'">
				<td><input style="width:110px;" maxlength="10" name="name" type="text" value="'.$v['admin_name'].'"></td>
				<td><input style="width:110px;" maxlength="10" name="account" type="text" value="'.$v['admin_account'].'"></td>
				<td><input style="width:100px;" maxlength="20" name="password" type="password" ></td>
				<td><input style="width:80px;" maxlength="10" class="btn btn-primary" type="button" onclick="edit('.$v['id'].')" value="update" ></td>
				<td>'.$v['last_login_time'].'</td>
				<td>'.$v['last_login_ip'].'</td>
			</tr>';
		}
		?>
		</tbody>
			<tfoot>
				<tr>
					<td colspan="4">
						<div class="pagination pagination-centered"></div>
					</td>
				</tr>
			</tfoot>
		</table>

	</div>
</div>

<script>
function edit(num){
	var obj = $('#admin_'+num);
	
	$.post('<?php echo URL_ROOT.'ajax/manage.php'?>', {
		id : num,
		name : obj.find('input[name=name]').val(),
		account : obj.find('input[name=account]').val(),
		password : obj.find('input[name=password]').val(),
	}, function(r) {
		if(r == 1){
			jbox_success('修改完成', '<?php echo URL_ADMIN_ROOT.'manage' ?>');
		}else if(r == 2){
			jbox_success('您沒有修改管理員資料的權利。');
		}else{
			jbox_success('修改失敗，請重新輸入。');
		}
	});

}

$(document).ready(function(){
	$('table').footable();
});


</script>













