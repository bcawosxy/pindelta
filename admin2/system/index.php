<!DOCTYPE html>
<html>
<?php include('../head.php'); ?>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
	<?php include('../header.php'); ?>
	<?php include('../navbar.php'); ?>
	<?php 
		$query = query_despace('select * from `system`;');
		$result = mysql_query($query);
		if(!$result) redirect_php(URL_ADMIN2_ROOT);
		$row = mysql_fetch_assoc($result);
		
		$flat_check = null;	$birman_check = null; $classic_check = null; $single_check = null; $horizontal_check = null;
		switch ($row['social_skin']){
			case 'flat':
				$flat_check = 'checked="true"';
			break;
			case 'birman':
				$birman_check = 'checked="true"';
			break;
			default:
				$classic_check = 'checked="true"';
			break;
		}
	  
		switch ($row['social_look']){
			case 'single':
				$single_check = 'checked="true"';
			break;
			
			default:
				$horizontal_check = 'checked="true"';
			break;
		}	?>
	
	<div class="content-wrapper">
	
		<section class="content-header">
			<div class="box-body"><h2>系統參數設定</h2></div>
			<ol class="breadcrumb">
				<li><a href="<?php echo URL_ADMIN2_ROOT ?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">系統參數設定</li>
			</ol>
		</section>
		<section class="content" style="min-height:180px;">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Title 及 Description</h3>
					<h4>				
						<small><p class="text-light-blue">(網站標題及描述)</p></small>
					</h4>
				</div>
				<div class="box-body">
					<label>Title</label> : 
						<input class="form-control" maxlength="30" name="web_title" style="max-width:500px;" type="text" placeholder="Text" value="<?php echo $row['web_title'] ?>"><br>
					<label>Description</label> : 
						<input class="form-control" maxlength="50" name="web_description" style="max-width:500px;" type="text" placeholder="Description" value="<?php echo $row['web_description'] ?>">
				</div>
				<div class="box-footer">
					<?php edit_info([])?>
				</div>
			</div>
		</section>
		<section class="content" style="min-height:180px;">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">聯絡資料</h3>
					<h4>				
						<small><p class="text-light-blue">(Contact頁面中的聯絡資料)</p></small>
					</h4>
				</div>
				<div class="box-body">
					<label>Phone</label> : 
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-phone"></i>
								</div>
								<input type="text" class="form-control" style="max-width:465px;" value="<?php echo $row['office_info_phone'] ?>">
							</div>
						
					<label>Email</label> : 
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-envelope"></i>
								</div>
								<input type="text" class="form-control" style="max-width:465px;" value="<?php echo $row['office_info_email'] ?>">
							</div>
				</div>
				<div class="box-footer">
					<?php edit_info([])?>
				</div>
			</div>
		</section>
		<section class="content" style="min-height:180px;">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">社群網站連結樣式</h3>
					<h4>				
						<small><p class="text-light-blue">(產品頁面上方社群網站樣式)</p></small>
					</h4>
				</div>
				<div class="box-body">
					<label>型態</label> : 
						
						<div class="form-group">
							<label>
								<input type="radio" name="r1" class="minimal" checked>
							</label>
							<label>
								<input type="radio" name="r1" class="minimal">
							</label>
						</div>
					
					<label>樣式</label> : 
						<input class="form-control" maxlength="30" name="web_title" style="max-width:500px;" type="text" placeholder="Text" value="<?php echo $row['office_info_email'] ?>"><br>
						
				</div>
				<div class="box-footer">
					<?php edit_info([])?>
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

});
</script>
</body>
</html>
<?php include('../foot.php') ?>