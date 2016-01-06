<!DOCTYPE html>
<html>
<?php include('../head.php'); ?>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
	<?php include('../header.php'); ?>
	<?php include('../navbar.php'); ?>
	<?php 
		$query = query_despace('select * from about where id = 3');
		$result = mysql_query($query);
		while($row = mysql_fetch_assoc($result)){	$data = $row;	}
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
									<li><a href="#tab_2" data-toggle="tab"><i class="fa fa-folder-open-o"></i>&nbsp;&nbsp;archive</a></li>
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
														<th>Rendering engine</th>
														<th>Browser</th>
														<th>Platform(s)</th>
														<th>Engine version</th>
														<th>CSS grade</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Trident</td>
														<td></td>
														<td>Win 95+</td>
														<td> 4</td>
														<td>X</td>
													</tr>
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
														<th>Rendering engine</th>
														<th>Browser</th>
														<th>Platform(s)</th>
														<th>Engine version</th>
														<th>CSS grade</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Trident</td>
														<td></td>
														<td>Win 95+</td>
														<td> 4</td>
														<td>X</td>
													</tr>
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
	
	$("#example1").DataTable();
	$("#example2").DataTable();
});
</script>
</body>
</html>
<?php include('../foot.php') ?>