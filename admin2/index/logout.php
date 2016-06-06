<!DOCTYPE html>
<html>
<?php include('../head.php'); ?>
<body class="hold-transition login-page">
	<?php 
		if(isset($_SESSION['admin'])) {
			unset($_SESSION['admin']) ;
			redirect_php(URL_ADMIN2_ROOT);
		}
	?>

</body>
</html>
<?php include('../foot.php') ?>