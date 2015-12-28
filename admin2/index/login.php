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
	<form action="" method="post">
		<div class="form-group has-feedback">
			<input type="email" class="form-control" placeholder="Email">
			<span class="glyphicon glyphicon-user form-control-feedback"></span>
		</div>
		<div class="form-group has-feedback">
			<input type="password" class="form-control" placeholder="Password">
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		</div>
		<div class="row">
			<div class="">
				<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
			</div>
		</div>
	</form>
</div>
</div>
<!-- iCheck -->
<script>
$(function () {
	$('input').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%' // optional
	});
});
</script>
</body>
</html>
