<div class="model_all">
  <div class="model_navbar">
    <div class="model_navbar_title">
	  <img src="<?php echo URL_IMG_ROOT."small_logo.png" ;?>" width="40" height="40">
	  <span><b><a class="nav_headlink" href="<?php echo URL_ADMIN_ROOT ?>">管理後台</a></b></span>
	  <hr>
	</div>
	
	<div class="model_navbar_list">
      <?php include('./../navlist.php'); ?>
	</div>
  </div>
  
  <div class="model_content">
	<?php 
		$act = (!empty($_GET['act'])) ? $_GET['act'] : null;
		switch ($act){
			case 'archive';
			include('./archive.php') ;
			break;
			
			case 'detail';
			include('./detail.php') ;
			break;

			default:
			include('./show.php');
			break;
		}
		
	?>
<script>
function delete_issue(id){
	var content = 'Are you sure to delete this issue?';
	var confirm = new jBox('Confirm', {
			content : content,
			confirm : function(){
				$.post('<?php echo URL_ROOT.'ajax/inquiry.php?act=delete'?>', {
					id : id,
				}, function(r) {		
					if(r == 1){
						jbox_success('Success!', '<?php echo URL_ADMIN_ROOT.'inquiry' ?>');
					}else{
						jbox_error('Fail.');
					}
				});
				
			}
		});
	confirm.open();	

}

function archive_issue(id){
	var content = 'Are you sure to archive this issue?';
	var confirm = new jBox('Confirm', {
			content : content,
			confirm : function(){
				$.post('<?php echo URL_ROOT.'ajax/inquiry.php?act=archive'?>', {
					id : id,
				}, function(r) {		
					if(r == 1){
						jbox_success('Success!', '<?php echo URL_ADMIN_ROOT.'inquiry' ?>');
					}else{
						jbox_error('Fail.');
					}
				});
				
			}
		});
	confirm.open();	

}

function recover_issue(id){
	var content = 'Are you sure to recover this issue?';
	var confirm = new jBox('Confirm', {
			content : content,
			confirm : function(){
				$.post('<?php echo URL_ROOT.'ajax/inquiry.php?act=recover'?>', {
					id : id,
				}, function(r) {		
					if(r == 1){
						jbox_success('Success!', '<?php echo URL_ADMIN_ROOT.'inquiry' ?>');
					}else{
						jbox_error('Fail.');
					}
				});
				
			}
		});
	confirm.open();	

}


$(document).ready(function(){
	$('table').footable();
	$('table').trigger('footable_filter', {filter: $('#filter').val()});

});
</script>






















