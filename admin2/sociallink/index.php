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
		$query = query_despace('select * from `sociallink`;');
		$result = mysql_query($query);
		if(!$result) redirect_php(URL_ADMIN2_ROOT);
		$a_sociallink = array();
		while($row = mysql_fetch_assoc($result)) { $a_sociallink[] = $row; }
		foreach($a_sociallink as $k => $v) {
			$a_sociallink[$k]['status'] = ($a_sociallink[$k]['status'] == 'open') ? '<span class="label label-success">Open</span>' : '<span class="label label-warning">Close</span>' ;
		}		
	?>
	<div class="content-wrapper">
		<section class="content-header">
			<div class="box-body"><h2>社群網站連結</h2></div>
			<h1>				
				<small><p class="text-light-blue">()</p></small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo URL_ADMIN2_ROOT ?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">社群網站連結</li>
			</ol>
		</section>
		<section class="content">
			<div class="row">
				<div class="col-md-8">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title">社群網站連結清單</h3>
						</div>
						<div class="box-body">
							<table class="table table-bordered">
								<tr>
									<th style="width: 10px">#</th>
									<th style="width: 15%">名稱</th>
									<th style="width: 25%">連結</th>
									<th style="width: 8%">排序</th>
									<th style="width: 10%">顯示狀態</th>
									<th>上次登入時間</th>
								</tr>
								<?php 
									foreach($a_sociallink as $k => $v) {
										echo '<tr class="data">
												<td>'.$v['id'].'.</td>
												<td>'.$v['name'].'</td>
												<td><input type="text" name="url" class="form-control" value="'.urldecode($v['url']).'"></td>
												<td>
													<div class="form-group">
														<select class="form-control select2" style="width: 100%;">';
														foreach($a_sociallink as $k1 => $v1) {
															echo '<option>'.($k1+1).'</option>';
															// echo (($k1+1) == $v['sort']) ? '<option select="selected">'.$v['sort'].'</option>' : '<option>'.($k1).'</option>';
														}
															
														echo '</select>
													</div>
												</td>
												<td>
													<div class="Switch Off">
														<div class="Toggle"></div>
														<span class="On">ON</span>
														<span class="Off">OFF</span>
													</div>
												</td>
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
	
	// Switch toggle
	$('.Switch').click(function() {
		$(this).toggleClass('On').toggleClass('Off');
	});

});
</script>
</body>
</html>
<?php include('../foot.php') ?>