<!DOCTYPE html>
<html>
<?php include('../head.php'); ?>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
	<?php include('../header.php'); ?>
	<?php include('../navbar.php'); ?>
	<?php 
		$inquiry_id = (empty($_GET['inquiry_id'])) ? null : $_GET['inquiry_id'] ;
		if($inquiry_id != null){
			$query = query_despace('select * from `inquiry` where `status` != "delete" and `id` = '.$inquiry_id.' ;');
			$result = mysql_query($query);
			$data = mysql_fetch_assoc($result) ;
			if(empty($data)) js_location(URL_ADMIN2_ROOT.'inquiry', '[Error]找不到資料');
			if($data['reader']) $data['reader'] = get_admin($data['reader'])['admin_name'];
			
			if($data['read'] == 'unread') {
				$query = 'UPDATE `inquiry` SET `read` = "read", `reader` = "'.$_SESSION['admin']['id'].'", `read_time` = NOW() where `id` = "'.$inquiry_id.'" ;';
				$query = query_despace($query);
				if (!mysql_query($query)) js_location(URL_ADMIN2_ROOT, '[Error]更新資料失敗');
				$data['reader'] = $_SESSION['admin']['name'];
				$data['read_time'] = date("Y-m-d G:i:s");
			}
			
			//不同status 
			if($data['status'] == 'open') {
				//底色標籤不同
				$status_text = '<div><span style="font-weight:bold;" class="bg-green color-palette">Open</span></div>';
				//回上頁後呈現的標籤位置
				$tab = 'tab1';
			} else {
				$status_text = '<div><span style="font-weight:bold;" class="bg-light-blue color-palette">Archive</span></div>';
				$tab = 'tab2';
			}
		} else {
			js_location(URL_ADMIN2_ROOT, '[Error]未取得id');
		}
	?>
	<div class="content-wrapper">
		<section class="content-header">
			<div class="box-body"><h2>產品詢價</h2></div>
			<h1>				
				<small><p class="text-light-blue"></p></small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo URL_ADMIN2_ROOT ?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li><a href="<?php echo URL_ADMIN2_ROOT.'inquiry/' ?>">產品詢價</a></li>
				<li class="active">詳情</li>
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
									<h3 class="box-title"> 詳情 </h3>
								</div>
								<div class="box-body">
									<dl class="dl-horizontal">
										<dt>編號:</dt>
											<dd><?php echo '#'.$data['id'] ?></dd>
										<dt>詢價產品:</dt>
											<dd><?php echo get_product_url($data['product_id']); ?></dd>
										<dt>姓名:</dt>
											<dd><?php echo $data['last_name'].' - '.$data['first_name'] ?></dd>
										<dt>公司:</dt>
											<dd><?php echo $data['company'] ?></dd>
										<dt>Email:</dt>
											<dd><?php echo $data['email'] ?></dd>
										<dt>地區:</dt>
											<dd><?php echo $data['country'] ?></dd>
										<dt>數量:</dt>
											<dd><?php echo $data['quantity'] ?></dd>
										<dt>網站:</dt>
											<dd><?php echo $data['weblink'] ?></dd>
										<dt>Logo需求:</dt>
											<dd><?php echo $data['demand'] ?></dd>
										<dt>備註:</dt>
											<dd><?php echo $data['memo'] ?></dd>
										<dt>狀態:</dt>
											<dd><?php echo $status_text ?></dd>
										<dt>閱讀人員:</dt>
											<dd><?php echo $data['reader'] ?></dd>
										<dt>閱讀時間:</dt>
											<dd><?php echo $data['read_time'] ?></dd>
										<dt>聯繫時間:</dt>
											<dd><?php echo $data['inserttime'] ?></dd>
									</dl>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<a class="btn btn-app" href="<?php echo URL_ADMIN2_ROOT.'inquiry/index.php?tab='.$tab ?>">
			<i class="fa fa-angle-double-left"></i> 上一頁
		</a>
		<?php 
			if($data['status'] == 'open') {
				echo '<a class="btn btn-app " id="archive">
						<i class="fa fa-envelope"></i> 封存(Archive)
					</a>';
			}
		?>
		<a class="btn btn-app " id="delete">
			<i class="fa fa-trash-o"></i> 刪除(Delete)
		</a>
	</div>
	<?php include('../footer.php'); ?>
</div>
<script>
$(function () {
	$('#archive').on('click', function(){
		$.post('<?php echo ajax_url(URL_ADMIN2_AJAX,P_CLASS,P_FUNCTION) ?>' , {
			inquiry_id : '<?php echo $data['id'] ?>',
			act : 'archive',
		},function(r){
			r = $.parseJSON(r);
			if(r.result == 1) {
				_jbox(r, 'success');
			}else{
				_jbox(r, 'error');			
			}
		});
	});
	
	$('#delete').on('click', function(){
		var myConfirm = new jBox('Confirm', {
			cancelButton: '否',
			confirmButton: '是',
			confirm: function() {	
				$.post('<?php echo ajax_url(URL_ADMIN2_AJAX,P_CLASS,P_FUNCTION) ?>' , {
					inquiry_id : '<?php echo $data['id'] ?>',
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