<!DOCTYPE html>
<html>
<?php include('../head.php'); ?>
<body class="hold-transition login-page">
<div class="login-box">
<div style="width:100%" class="login-logo">
	<a href="#">Pindelta.<b>Admin</b></a>
</div>
<div class="login-box-body">
	<p class="login-box-msg">Sign in to start your work!</p>
	<form action="javascript:void(0)" method="post">
		<div class="form-group has-feedback">
			<input type="text" class="form-control" id="account" placeholder="Account">
			<span class="glyphicon glyphicon-user form-control-feedback"></span>
		</div>
		<div class="form-group has-feedback">
			<input type="password" class="form-control" id="password" placeholder="Password">
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		</div>
		<div class="row">
			<div class="">
				<button type="submit" id="login" class="btn btn-primary btn-block btn-flat">Sign In</button>
			</div>
		</div>
	</form>
</div>
</div>
<!-- iCheck -->
<script>
$(function () {
	$('#login').on('click', function(){
		$.post('<?php echo ajax_url(URL_ADMIN2_AJAX,P_CLASS,P_FUNCTION) ?>' , {
			account : $('#account').val() ,
			password : $('#password').val(),
		},function(r){
			r = $.parseJSON(r);
			if(r.result == 1) {
				_jbox(r, 'success');
			}else{
				_jbox(r, 'error');			
			}
		});
		
	});

	$('input').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%' // optional
	});
});
</script>
</body>
</html>
<?php include('../foot.php') ?>