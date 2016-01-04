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
			<div class="box-body"><h2>關於品利興</h2></div>
			<h1>				
				<small><p class="text-light-blue">(建議上傳圖片格式: PNG / JPEG / JPG)</p></small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo URL_ADMIN2_ROOT ?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">關於品利興</li>
			</ol>
		</section>
		<section class="content">
			<div class="box">
				<div class="box-body">
					<form method="post">
						<textarea rows="10" cols="50" id="about_value" name="about_value" class="ckeditor"><?php echo $data['value']; ?></textarea>
						<script type="text/javascript">CKEDITOR.replace('about_value',
						{toolbar : 'Full'});
						</script><br>
						<a class="btn btn-app " id="save">
							<i class="fa fa-save"></i> Save
						</a>
					</form>
					
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
			value : $('#about_value').find('body').html(),
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