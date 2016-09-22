<!DOCTYPE html>
<html>
<?php include('../head.php'); ?>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
	<?php include('../header.php'); ?>
	<?php include('../navbar.php'); ?>
	<?php 
		$id = (!empty($_GET['categoryarea_id'])) ? $_GET['categoryarea_id'] : null;
		$act = ($id == null) ? 'add' : 'edit';

		switch ($act) {
			case 'add':
					$data = [
						'categoryarea_id' => null,
						'categoryarea_name' => null,
						'categoryarea_priority' => 0,
						'categoryarea_status' => 'close',
						'categoryarea_description' => null,
						'categoryarea_insert_time' => null,
						'categoryarea_modify_time' => null,
					];
					$cover = null; $cover_dir = URL_IMG_ROOT."default_bg.png";
				break;
			
			case 'edit':
					$query = 'select * from `categoryarea` where categoryarea_id = '.$id;
					$result = mysql_query($query);
					while($row = mysql_fetch_assoc($result)){ $data = $row;	}
					if(empty($data)) js_location(URL_ADMIN2_ROOT.'categoryarea', '[Error]找不到資料');
					$cover_dir = (!empty($data['categoryarea_cover'])) ?  ADMIN_IMG_UPLOAD.P_CLASS.'/'.$data['categoryarea_cover'] : null ;
					$cover = (!empty($data['categoryarea_cover'])) ?  $data['categoryarea_cover'] : null ;
				break;
		}

	?>
	<div class="content-wrapper">
		<section class="content-header">
			<div class="box-body"><h2>產品類別管理</h2></div>
			<h1>				
				<small><p class="text-light-blue"></p></small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo URL_ADMIN2_ROOT ?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">產品類別管理</li>
			</ol>
		</section>
		
		<section class="content">
			<div class="box">
				<div class="box-body">
					<div class="row">
						<div class="col-md-10">
							<div class="box-body box-solid">
								<div class="box-header with-border">
									<i class="fa fa-file-text-o"></i>
									<h3 class="box-title"> <?php echo ($act == 'add') ? '新增產品類別' : '編輯產品類別 ： '.$data['categoryarea_name'] ?> </h3>
								</div>
								<div class="box-body">
									<dl class="dl-horizontal">
										<dt>編號:</dt>
											<dd># <?php echo $data['categoryarea_id'] ?></dd>
										<br>
										<dt>名稱:</dt>
											<dd>
												<input type="text" class="form-control" name="name" placeholder="產品類別名稱" style="width:30%" value="<?php echo $data['categoryarea_name'] ?>">
											</dd>
										<br>
										<dt>排序:</dt>
											<dd>
												<input type="number" class="form-control" name="priority" placeholder="1~255" min="0" max="255" style="width:20%" value="<?php echo $data['categoryarea_priority'] ?>">
											</dd>
										<br>
										<dt>狀態:</dt>
											<dd>
												<div class="form-group">
													<label for="r1">
														<input id="r1" type="radio" name="status" class="minimal-red" value="open" <?php if($data['categoryarea_status'] == 'open') echo 'checked'; ?>>
														Open
													</label>&nbsp;&nbsp;&nbsp;
													<label for="r2">
														<input id="r2" type="radio" name="status" class="minimal-red" value="close" <?php if($data['categoryarea_status'] == 'close') echo 'checked'; ?>>
														Close
													</label>
												</div>
											</dd>
										<br>
										<dt>介紹:</dt>
											<dd>
												<input type="text" class="form-control" name="description" placeholder="介紹" style="width:80%" value="<?php echo $data['categoryarea_description'] ?>">
											</dd>
										<br>
										<dt>封面:</dt>
											<dd>
												<div class="form-group">
												    <!-- The fileinput-button span is used to style the file input field as button -->
												    <span class="btn btn-success fileinput-button">
												        <i class="glyphicon glyphicon-plus"></i>
												        <span>Select files...</span>
												        <!-- The file input field used as target for the file upload widget -->
												        <input id="fileupload" type="file" name="files[]" multiple>
												    </span>
												    <br>
												    <br>
												    <!-- The global progress bar -->
												    <div id="progress" class="progress">
												        <div class="progress-bar progress-bar-success"></div>
												    </div>
												    <!-- The container for the uploaded files -->
												    <div id="files" class="files"></div>
												    <br>
												    <img style="width:240px;height: 320px;" id="cover" alt="<?php echo $cover ?>" src="<?php echo $cover_dir ?>" onerror="this.src='<?php echo URL_IMG_ROOT.'default_bg.png' ?>'" data-state="old" class="img-responsive">
												</div>
											</dd>
										<br>
										<dt>新增時間:</dt>
											<dd>
												<p class="text-muted"><?php echo $data['categoryarea_insert_time'] ?></p>
											</dd>
										<br>
										<dt>修改時間:</dt>
											<dd>
												<p class="text-muted"><?php echo $data['categoryarea_modify_time'] ?></p>
											</dd>
										<br>
									</dl>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<a class="btn btn-app" href="<?php echo URL_ADMIN2_ROOT.'categoryarea' ?>">
				<i class="fa fa-angle-double-left"></i> 上一頁
			</a>

			<a class="btn btn-app" id="save">
				<i class="fa fa-save"></i> 儲存(Save)
			</a>

			<?php 
				if($act =='edit') echo '<a class="btn btn-app" id="delete"><i class="fa fa-trash-o"></i> 刪除(Delete)</a>';
			?>
		</section>
	</div>

	<?php include('../footer.php'); ?>
</div>
<script>
$(function () {
    'use strict';
    var url = '<?php echo ajax_url(URL_ADMIN2_AJAX,'fileupload','index') ?>';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('#cover').attr({'alt': file.name,'src':'<?php echo URL_ADMIN2_ROOT.'files/' ;?>'+file.name}).data('state', 'new');
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });

	$('#save').on('click', function(){
		var priority = $('input[name=priority]');

		if (!/^\d+$/.test(priority.val())) {
			var r = {'message': '排序須輸入正整數。'};
			_jbox(r, 'error');
		} else {
			var processingBox = new jBox('Modal', {
				closeOnClick: false,
				closeButton: 'title',
				width: 140,
				height: 50,
				onOpen : function(){	
					$.post('<?php echo ajax_url(URL_ADMIN2_AJAX,P_CLASS,P_FUNCTION) ?>' , {
						id : '<?php echo $id ?>',
						act : '<?php echo $act ?>',
						name : $('input[name="name"]').val(),
						priority : priority.val(),
						status : $('input[name="status"]:checked').val(),
						description : $('input[name="description"]').val(),
						cover : $('#cover').attr('alt'),
						cover_state : $('#cover').data('state'),
					},function(r){
						processingBox.close();
						r = $.parseJSON(r);
						if(r.result == 1) {
							_jbox(r, 'success');
						}else{
							_jbox(r, 'error');			
						}
					});
				},
			}).setContent('<span style="padding-left:20px;font-weight:bold;color:rgba(85, 85, 85, 0.8);">處理中...</span><img src="<?php echo URL_IMG_ROOT.'loading.gif'?>">').open();
		}
	});

	$('#delete').on('click', function(){
		var myConfirm = new jBox('Confirm', {
			cancelButton: '否',
			confirmButton: '是',
			confirm: function() {	
				$.post('<?php echo ajax_url(URL_ADMIN2_AJAX,P_CLASS,P_FUNCTION) ?>' , {
					id : '<?php echo $id ?>',
					act : 'delete',
				},function(r){
					r = $.parseJSON(r);
					if(r.result == 1) {
						_jbox(r, 'success');
					}else{
						_jbox(r, 'error');			
					}
				});
			},
			onCloseComplete: function() {	
				myConfirm.destroy();
			}
		}).setContent(
			'<div>' +
				'確定刪除此筆資料嗎?'+
			'</div>'
		).open();

	});
});
</script>
</body>
</html>
<?php include('../foot.php') ?>