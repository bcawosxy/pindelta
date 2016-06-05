<!DOCTYPE html>
<html>
<?php include('../head.php'); ?>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
	<?php include('../header.php'); ?>
	<?php include('../navbar.php'); ?>
	<?php 
		$query = query_despace('select * from `categoryarea` where `categoryarea_status` != "delete" order by `categoryarea_insert_time` desc;');
		$result = mysql_query($query);
		$data = array();
		while($row = mysql_fetch_assoc($result)){ $data[] = $row;	}
		foreach($data as $k => $v) {
			$data[$k]['categoryarea_status'] = ($data[$k]['categoryarea_status'] == 'open') ? '<span class="label label-success">Open</span>' : '<span class="label label-warning">Close</span>' ;
		}

	?>
	<div class="content-wrapper">
		<section class="content-header">
			<div class="box-body"><h2>產品類別區域</h2></div>
			<h1>				
				<small><p class="text-light-blue"></p></small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo URL_ADMIN2_ROOT ?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">產品類別區域</li>
			</ol>
		</section>
		<section class="content">
			<div class="box">
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div class="box-header">
							</div>
							<div class="box-body">
								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>編輯</th>
											<th>名稱</th>
											<th>優先順序</th>
											<th>描述</th>
											<th>狀態</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											foreach($data as $k0 => $v0) {
												echo '
													<tr>
														<td>'.$v0['categoryarea_id'].'</td>
														<td><a href="'.URL_ADMIN2_ROOT.P_CLASS.'/content.php?categoryarea_id='.$v0['categoryarea_id'].'">編輯</a></td>
														<td>'.$v0['categoryarea_name'].'</td>
														<td>'.$v0['categoryarea_priority'].'</td>
														<td>'.$v0['categoryarea_description'].'</td>
														<td>'.$v0['categoryarea_status'].'</td>
													</tr>
												';
											}
										?>
									</tbody>
								</table>
							</div>
						<a class="btn btn-app " id="add" href="<?php echo URL_ADMIN2_ROOT.P_CLASS.'/content.php' ?>">
							<i class="fa fa-plus-square-o"></i> Add
						</a>
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
	$("#example1").DataTable({
		"order": [[ 0, "desc" ]],
		
	});
});
</script>
</body>
</html>
<?php include('../foot.php') ?>