<!DOCTYPE html>
<html>
<?php include('../head.php'); ?>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
	<?php include('../header.php'); ?>
	<?php include('../navbar.php'); ?>
	<?php 
		$query = query_despace('select * from `contact` where status != "delete" order by `inserttime` desc;');
		$result = mysql_query($query);
		$data = array();$a_contact_open = array(); $a_contact_archive = array();
		while($row = mysql_fetch_assoc($result)){ $data[] = $row;	}
		foreach($data as $k => $v) {
			$v['read'] = ($data[$k]['read'] == 'read') ? '<p class="text-green">Read</p>' : '<p class="text-yellow">Unread</p>' ;
			if($v['status'] == 'open') {
				$a_contact_open[] = $v;
			} else {
				$a_contact_archive[] = $v;
			}
		}
	?>
	<div class="content-wrapper">
		<section class="content-header">
			<div class="box-body"><h2>聯繫我們</h2></div>
			<h1>				
				<small><p class="text-light-blue"></p></small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo URL_ADMIN2_ROOT ?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">聯繫我們</li>
			</ol>
		</section>
		<section class="content">
			<div class="box">
				<div class="box-body">
					<div class="row">
						<div class="col-md-10">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-inbox"></i>&nbsp;&nbsp;Inbox</a></li>
									<li><a href="#tab_2" data-toggle="tab"><i class="fa fa-folder-open-o"></i>&nbsp;&nbsp;Archive</a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_1">

										<div class="box-header">
											<h2 class="box-title text-light-blue">聯繫我們 - 資料列表</h2>
										</div>

										<div class="box-body">
											<table id="example1" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th>#</th>
														<th>Last Name</th>
														<th>First Name</th>
														<th>Email</th>
														<th>Tel</th>
														<th>Read</th>
														<th>查看</th>
													</tr>
												</thead>
												<tbody>
													<?php 
													foreach($a_contact_open as $k0 => $v0) {
														echo '<tr>
																<td>'.$v0['id'].' </td>
																<td>'.$v0['last_name'].' </td>
																<td>'.$v0['first_name'].' </td>
																<td>'.$v0['email'].' </td>
																<td>'.$v0['tel'].' </td>
																<td>'.$v0['read'].' </td>
																<td><a href="'.URL_ADMIN2_ROOT.P_CLASS.'/content.php?contact_id='.$v0['id'].'">編輯</a></td>
															</tr>';
													}
													?>
												</tbody>
											</table>
										</div>
									</div>

									<div class="tab-pane " id="tab_2">
										<div class="box-header">
											<h2 class="box-title text-light-blue">聯繫我們 - 封存列表</h2>
										</div>										
										<div class="box-body">
											<table id="example2" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th>#</th>
														<th>Last Name</th>
														<th>First Name</th>
														<th>Email</th>
														<th>Tel</th>
														<th>Read</th>
														<th>查看</th>
													</tr>
												</thead>
												<tbody>
													<?php 
													foreach($a_contact_archive as $k0 => $v0) {
														echo '<tr>
																<td>'.$v0['id'].' </td>
																<td>'.$v0['last_name'].' </td>
																<td>'.$v0['first_name'].' </td>
																<td>'.$v0['email'].' </td>
																<td>'.$v0['tel'].' </td>
																<td>'.$v0['read'].' </td>
																<td><a href="javascript:void(0)">編輯</a></td>
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
			{ "orderable": false, "targets": 6 }
		]
		
	});

	$("#example2").DataTable({
		"order": [[ 0, "desc" ]],
		"columnDefs": [
			{ "orderable": false, "targets": 6 }
		]
		
	});

});
</script>
</body>
</html>
<?php include('../foot.php') ?>