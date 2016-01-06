<!DOCTYPE html>
<html>
<?php include('../head.php'); ?>
<body class="hold-transition login-page">
	<?php 
		if(isset($_SESSION['admin'])) {
			unset($_SESSION['admin']) ;
			js_location(URL_ADMIN2_ROOT.'index/login.php', '"登出完成。"');
		}
	?>

</body>
</html>
<?php include('../foot.php') ?>