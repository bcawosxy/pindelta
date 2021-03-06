<!DOCTYPE html>
<html>
<?php include('../head.php'); ?>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
	<?php include('../header.php'); ?>
	<?php include('../navbar.php'); ?>
	<?php 
		$query = query_despace('select * from `inquiry` where status != "delete" order by `inserttime` desc;');
		$result = mysql_query($query);
		$data = array();$a_inquiry_open = array(); $a_inquiry_archive = array();
		while($row = mysql_fetch_assoc($result)){ $data[] = $row;	}
		foreach($data as $k => $v) {
			$v['read'] = ($data[$k]['read'] == 'read') ? '<span class="label label-success">Read</span>' : '<span class="label label-warning">Unread</span>' ;
			if($v['status'] == 'open') {
				$a_inquiry_open[] = $v;
			} else {
				$a_inquiry_archive[] = $v;
			}
		}
		//預設開啟標籤
		$tab1 = ($_GET['tab'] != 'tab2') ? 'active' : null;
		$tab2 = (isset($_GET['tab']) && $_GET['tab'] == 'tab2') ? 'active' : null;
	?>
	<div class="content-wrapper">
		<section class="content-header">
			<div class="box-body" ><h2>產品詢價</h2></div>
			<h1>				
				<small><p class="text-light-blue"></p></small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo URL_ADMIN2_ROOT ?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">產品詢價</li>
			</ol>
		</section>
		<section class="content">
			<div class="box">
				<div class="box-body">
					<div class="row">
						<div class="col-md-11">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs">
									<li class="<?php echo $tab1; ?>"><a href="#tab_1" data-toggle="tab"><i class="fa fa-inbox"></i>&nbsp;&nbsp;Inbox</a></li>
									<li class="<?php echo $tab2; ?>"><a href="#tab_2" data-toggle="tab"><i class="fa fa-folder-open-o"></i>&nbsp;&nbsp;Archive</a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane <?php echo $tab1; ?>" id="tab_1">
										<div class="box-header">
											<div class="callout callout-success">
												<h4 style="font-family:微軟正黑體;">產品詢價 - 資料列表</h4>
											</div>
										</div>
										<div class="box-body">
											<table id="example1" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th>#</th>
														<th>編輯</th>
														<th>詢價產品</th>
														<th>姓名</th>
														<th>Email</th>
														<th>國家</th>
														<th>公司名稱</th>
														<th>網站連結</th>
														<th>狀態</th>
														<th>read</th>
													</tr>
												</thead>
												<tbody>
													<?php 
													foreach($a_inquiry_open as $k0 => $v0) {
														echo '<tr>
																<td>'.$v0['id'].'</td>
																<td><a href="'.URL_ADMIN2_ROOT.P_CLASS.'/content.php?inquiry_id='.$v0['id'].'">編輯</a></td>
																<td>'.get_product_url($v0['product_id']).'</td>
																<td>'.$v0['last_name'].' - '.$v0['first_name'].'</td>
																<td>'.$v0['email'].'</td>
																<td>'.$v0['country'].'</td>
																<td>'.$v0['company'].'</td>
																<td>'.$v0['weblink'].'</td>
																<td>'.$v0['status'].'</td>
																<td>'.$v0['read'].'</td>
															</tr>';
													}
													?>
												</tbody>
											</table>
										</div>
									</div>

									<div class="tab-pane <?php echo $tab2; ?>" id="tab_2">
										<div class="box-header">
											<div class="callout callout-success" >
												<h4 style="font-family:微軟正黑體;">產品詢價 - 封存列表</h4>
											</div>
										</div>										
										<div class="box-body">
											<table id="example2" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th>#</th>
														<th>編輯</th>
														<th>詢價產品</th>
														<th>姓名</th>
														<th>Email</th>
														<th>國家</th>
														<th>公司名稱</th>
														<th>網站連結</th>
														<th>狀態</th>
														<th>read</th>
													</tr>
												</thead>
												<tbody>
													<?php 
													foreach($a_inquiry_archive as $k0 => $v0) {
														echo '<tr>
																<td>'.$v0['id'].'</td>
																<td><a href="'.URL_ADMIN2_ROOT.P_CLASS.'/content.php?inquiry_id='.$v0['id'].'">編輯</a></td>
																<td>'.get_product_url($v0['product_id']).'</td>
																<td>'.$v0['last_name'].' - '.$v0['first_name'].'</td>
																<td>'.$v0['email'].'</td>
																<td>'.$v0['country'].'</td>
																<td>'.$v0['company'].'</td>
																<td>'.$v0['weblink'].'</td>
																<td>'.$v0['status'].'</td>
																<td>'.$v0['read'].'</td>
															</tr>';
													}
													?>
												</tbody>
											</table>
										</div>								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	<?php include('../footer.php'); ?>
</div>
<script>
$(function () {
	$('#save').on('click', function(){
		$.post('<?php echo ajax_url(URL_ADMIN2_AJAX,P_CLASS,P_FUNCTION) ?>' , {
			value : CKEDITOR.instances['about_value'].getData(),
		},function(r){
			r = $.parseJSON(r);
			if(r.result == 1) {
				_jbox(r, 'success');
			}else{
				_jbox(r, 'error');			
			}
		});
	});

	$("#example1").DataTable({
		"order": [[ 0, "desc" ]],
		"columnDefs": [
			{ "orderable": false, "targets": 9 }
		]
		
	});


	$("#example2").DataTable({
		"order": [[ 0, "desc" ]],
		"columnDefs": [
			{ "orderable": false, "targets": 9 }
		]
		
	});

});
</script>
</body>
</html>
<?php include('../foot.php') ?>