<!DOCTYPE html>
<html>
<?php include('../head.php'); ?>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
	<?php include('../header.php'); ?>
	<?php include('../navbar.php'); ?>
	<?php 
		$id = (!empty($_GET['product_id'])) ? $_GET['product_id'] : null;
		$act = ($id == null) ? 'add' : 'edit';
		switch ($act) {
			case 'add':
					$data = [
						'product_id' => null,
						'product_name' => null,
						'product_category_id' => null,
						'product_priority' => 0,
						'product_model' => null,
						'product_standard' => null,
						'product_material' => null,
						'product_produce_time' => null,
						'product_lowest' => null,
						'product_memo' => null,
						'product_content' => null,
						'product_status' => 'close',
						'product_description' => null,
						'product_inserttime' => null,
						'product_modify_time' => null,
					];
					$cover = null; $cover_dir = URL_IMG_ROOT."default_bg.png";

					$a_category = null;
					$query = 'select * from `category` where `category`.`category_status` != "delete"';
					$result = mysql_query($query);
					while($row = mysql_fetch_assoc($result)){ $a_category[] = $row;	}
				break;
			
			case 'edit':
					$query = 'select * from `product` where `product_status` != "delete" and product_id = '.$id;
					$result = mysql_query($query);
					while($row = mysql_fetch_assoc($result)){ $data = $row;	}
					if(empty($data)) js_location(URL_ADMIN2_ROOT.'product', '[Error]找不到資料');
					$cover_dir = (!empty($data['product_cover'])) ?  ADMIN_IMG_UPLOAD.P_CLASS.'/'.$data['product_cover'] : null ;
					$cover = (!empty($data['product_cover'])) ?  $data['product_cover'] : null ;

					$category_name = null;
					$query = 'select category_name from `category` where `category`.`category_id` = "'.$data['product_category_id'].'" and `category`.`category_status` != "delete"';
					$result = mysql_query($query);
					while($row = mysql_fetch_assoc($result)){ $category_name = $row['category_name'];	}

				break;
		}

	?>
	<div class="content-wrapper">
		<section class="content-header">
			<div class="box-body"><h2>產品管理</h2></div>
			<h1>				
				<small><p class="text-light-blue"></p></small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo URL_ADMIN2_ROOT ?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">產品管理</li>
			</ol>
		</section>

		<section class="content">
			<div class="box">
				<div class="box-body">
					<div class="row">
						<div class="col-md-10">
							<div class="box-body box-solid">
								
								<div class="nav-tabs-custom">
									<ul class="nav nav-tabs">
										<li class="active"><a href="#tab_1" data-toggle="tab">產品資料</a></li>
										<li><a href="#tab_2" data-toggle="tab">產品標籤</a></li>
										<li><a href="#tab_3" data-toggle="tab">產品其他</a></li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tab_1">
											<!--tab1-->
											<div class="box-header with-border">
												<i class="fa fa-file-text-o"></i>
												<h3 class="box-title"> <?php echo ($act == 'add') ? '新增產品' : '編輯產品 ： <span style="color:#3c8dbc;font-weight:bold">'.$data['product_name'] ?></span> </h>
											</div>
											<div class="box-body">
												<dl class="dl-horizontal">
													<dt>編號:</dt>
														<dd># <?php echo $data['product_id'] ?></dd>
													<br>
													<dt>名稱:</dt>
														<dd>
															<input type="text" class="form-control" name="name" placeholder="產品名稱" style="width:30%" value="<?php echo $data['product_name'] ?>">
														</dd>
													<br>
													<dt>所屬項目:</dt>
														<dd style="<?php echo ($act == 'edit') ? 'display:none;' : null; ?>">
										                    <select class="form-control select2" id="category_id" style="width: 30%;">
										                    	<option value="0" selected="selected">請選擇所屬項目</option>
										                    	<?php 
										                    		foreach ($a_category as $k0 => $v0) {
										                    			echo '<option value="'.$v0['category_id'].'">'.$v0['category_name'].'</option>';
										                    		}
										                    	?>
										                    </select>
														</dd>
														<dd style="<?php echo ($act == 'add') ? 'display:none;' : null; ?>">
															<p style="color:#00b7b0;font-weight: bold;font-size:14px;"><?php echo $category_name ?></p>
														</dd>
													<br>
													<dt>排序:</dt>
														<dd>
															<input type="number" class="form-control" name="priority" placeholder="1~255" min="0" max="255" style="width:20%" value="<?php echo $data['product_priority'] ?>">
														</dd>
													<br>
													<dt>型號:</dt>
														<dd>
															<input type="text" class="form-control" name="model" placeholder="產品型號" style="width:30%" value="<?php echo $data['product_model'] ?>">
														</dd>
													<br>
													<dt>規格:</dt>
														<dd>
															<input type="text" class="form-control" name="standard" placeholder="產品規格" style="width:30%" value="<?php echo $data['product_standard'] ?>">
														</dd>
													<br>
													<dt>材質:</dt>
														<dd>
															<input type="text" class="form-control" name="material" placeholder="產品材質" style="width:30%" value="<?php echo $data['product_material'] ?>">
														</dd>
													<br>
													<dt>生產所需時間:</dt>
														<dd>
															<input type="text" class="form-control" name="produce_time" placeholder="產品生產時間" style="width:30%" value="<?php echo $data['product_produce_time'] ?>">
														</dd>
													<br>
													<dt>最低訂購量:</dt>
														<dd>
															<input type="text" class="form-control" name="lowest" placeholder="最低訂購量" style="width:30%" value="<?php echo $data['product_lowest'] ?>">
														</dd>
													<br>
													<dt>狀態:</dt>
														<dd>
															<div class="form-group">
																<label for="r1">
																	<input id="r1" type="radio" name="status" class="minimal-red" value="open" <?php if($data['product_status'] == 'open') echo 'checked'; ?>>
																	Open
																</label>&nbsp;&nbsp;&nbsp;
																<label for="r2">
																	<input id="r2" type="radio" name="status" class="minimal-red" value="close" <?php if($data['product_status'] == 'close') echo 'checked'; ?>>
																	Close
																</label>
															</div>
														</dd>
													<br>
													<dt>介紹:</dt>
														<dd>
															<input type="text" class="form-control" name="description" placeholder="介紹" style="width:80%" value="<?php echo $data['product_description'] ?>">
														</dd>
													<br>
													<dt>備註:</dt>
														<dd>
															<textarea class="form-control" name="memo" rows="3" placeholder="Enter ..."><?php echo $data['product_memo'] ?></textarea>
														</dd>
													<br>
													<dt>內文:</dt>
														<dd>
															<textarea rows="10" cols="30" name="product_content" class="ckeditor" id="product_content"><?php echo $data['product_content']; ?></textarea>
															<script type="text/javascript">CKEDITOR.replace('product_content',
																{
																	toolbar : 'Full'
																});
															</script>  
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
															    <br><br>
															    <!-- The global progress bar -->
															    <div id="progress" class="progress">
															        <div class="progress-bar progress-bar-success"></div>
															    </div>
															    <!-- The container for the uploaded files -->
															    <div id="files" class="files"></div>
															    <br>
															    <img style="width:240px;height: 320px;" id="cover" alt="<?php echo $cover ?>" src="<?php echo $cover_dir ?>" data-state="old" class="img-responsive">
															</div>
														</dd>
													<br>
													<dt>新增時間:</dt>
														<dd>
															<p class="text-muted"><?php echo $data['product_inserttime'] ?></p>
														</dd>
													<br>
													<dt>修改時間:</dt>
														<dd>
															<p class="text-muted"><?php echo $data['product_modify_time'] ?></p>
														</dd>
													<br>
												</dl>
											</div>							
										<!--end tab1-->
										</div>
										
										<div class="tab-pane" id="tab_2">
											tab2
										</div>
										
										<div class="tab-pane" id="tab_3">
											tab3
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<a class="btn btn-app" href="<?php echo URL_ADMIN2_ROOT.'product' ?>">
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
	$("#category_id").select2();

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
						id : '<?php echo $data['product_id'] ?>',
						act : '<?php echo $act ?>',
						name : $('input[name="name"]').val(),
						priority : priority.val(),
						model : $('input[name="model"]').val(),
						standard :  $('input[name="standard"]').val(),
						material :  $('input[name="material"]').val(),
						produce_time :  $('input[name="produce_time"]').val(),
						lowest :  $('input[name="lowest"]').val(),
						category_id : <?php echo ($act =='edit') ? $data['product_category_id'] : '$(\'#category_id option:selected\').val()' ?>,
						description : $('input[name="description"]').val(),
						content : CKEDITOR.instances['product_content'].getData(),
						memo : $('textarea[name="memo"]').val(),
						status : $('input[name="status"]:checked').val(),
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