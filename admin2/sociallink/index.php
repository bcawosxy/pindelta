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
			$a_sociallink[$k]['status'] = ($a_sociallink[$k]['status'] == 'open') ? 'Off' : 'On' ;
		}
		
		$a_icon = ['fa-google', 'fa-facebook', 'fa-flickr', 'fa-twitter', 'fa-google', 'fa-instagram', 'fa-linkedin', 'fa-pinterest', 'fa-tumblr'];
	?>
	<div class="content-wrapper">
		<section class="content-header">
			<div class="box-body">
				<h2 style="font-family: 'Source Sans Pro',sans-serif;font-size: 30px;margin-top: 20px; margin-bottom: 10px;font-weight: 500; line-height: 1.1;color: inherit;">
					社群網站連結
				</h2>
			</div>	
			<h1>				
				<small><p class="text-light-blue"></p></small>
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
									<th style="width: 30%">連結</th>
									<th style="width: 8%">排序</th>
									<th style="width: 10%">顯示狀態</th>
									<th>修改時間</th>
								</tr>
								<?php 
									foreach($a_sociallink as $k => $v) {
										echo '<tr class="data">
												<td>'.$v['id'].'.</td>
												<td><small class="label label-success">'.ucfirst ($v['name'] ).'</small></td>
												<td><div class="input-group">
														<div class="input-group-addon bg-light-blue color-palette">
															<i class="fa '.$a_icon[$k].'"></i>
														</div>
														<input type="text" name="url" class="form-control" value="'.urldecode( $v['url']).'">
													</div></td>
												<td>
													<div class="form-group">
														<select class="form-control select2" name="sort" style="width: 100%;">';
														foreach($a_sociallink as $k1 => $v1) {
															echo (($k1+1) == $v['sort']) ? '<option selected="selected">'.($k1+1).'</option>' : '<option>'.($k1+1).'</option>';
														}
														echo '</select>
													</div>
												</td>
												<td>
													<div id="switch_'.$k.'" class="Switch '.$v['status'].'">
														<div class="Toggle"></div>
														<span class="On">ON</span>
														<span class="Off">OFF</span>
													</div>
												</td>
												<td>'.$v['modifytime'].'</td>
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
			var obj = $(v);
			var tmp = [
				$(obj).find(':input[name="url"]').val(),
				$(obj).find('[name="sort"] option:selected').val(),
				$(obj).find('div[id^="switch_"]').attr('class'),
			];
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