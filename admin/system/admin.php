<!DOCTYPE html>
<html>
<?php 
include('../head.php'); 
?>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
	<?php include('../header.php'); ?>
	<?php include('../navbar.php'); ?>
	<?php 
		$query = query_despace('select * from `admin`;');
		$result = mysql_query($query);
		if(!$result) redirect_php(URL_ADMIN2_ROOT);
		$a_admin = array();
		while($row = mysql_fetch_assoc($result)) {
			$a_admin[] = $row;
		}
	?>
	<div class="content-wrapper">
		<section class="content-header">
			<div class="box-body"><h2>管理員設定</h2></div>
			<h1>				
				<small><p class="text-light-blue">(若不需修改密碼請將該欄位留空)</p></small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo URL_ADMIN2_ROOT.'system/admin.php' ?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">管理員設定</li>
			</ol>
		</section>
		<section class="content">
			<div class="row">
				<div class="col-md-8">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title">管理人員清單</h3>
						</div>
						<div class="box-body">
							<table class="table table-bordered">
								<tr>
									<th style="width: 10px">#</th>
									<th style="width: 15%">帳號</th>
									<th style="width: 15%">密碼</th>
									<th style="width: 15%">名稱</th>
									<th style="width: 15%">Email</th>
									<th>上次登入時間</th>
									<th>上次登入IP</th>
								</tr>
								<?php 
									foreach($a_admin as $k => $v) {
										echo '<tr class="data">
												<td>'.$v['id'].'.</td>
												<td><input type="text" name="account" class="form-control" value="'.$v['admin_account'].'"></td>
												<td><input type="password"  name="password" class="form-control" value=""></td>
												<td><input type="text"  name="name" class="form-control" value="'.$v['admin_name'].'"></td>
												<td><input type="text"  name="email" class="form-control" value="'.$v['admin_email'].'"></td>
												<td style="display:none;"><input type="text" name="id" class="form-control" value="'.$v['id'].'"></td>
												<td>'.$v['last_login_time'].'</td>
												<td>'.$v['last_login_ip'].'</td>
											</tr>';
									}
								
								?>
							</table>
						</div>
					</div>

				</div>
			</div>
		</section>
		<a class="btn btn-app " id="save">
			<i class="fa fa-save"></i> Save All
		</a>
	</div>
	<?php include('../footer.php'); ?>
</div>
<script>

$(function () {
	$('#save').on('click', function(){
		var data = new Array();
		$('tr.data').each(function (k, v){
			var tmp = new Array();
			$($(this)).find(':input').each(function(k1, v1) {
				var obj = $(v1);			
				tmp.push(obj.val());
			});
			data.push(tmp);
		});
	
		$.post('<?php echo ajax_url(URL_ADMIN2_AJAX, P_CLASS, P_FUNCTION) ?>' , {
			data : JSON.stringify(data),
		},function(r){
			r = $.parseJSON(r);
			if(r.result == 1) {
				_jbox(r, 'success');
			}else{
				_jbox(r, 'error');			
			}
		});
	});
});
</script>
</body>
</html>
<?php include('../foot.php') ?>