<?php $config =  dirname(dirname(__FILE__)); include( $config.'/config/global.php' ) ;include( $config.'/config/function_admin2.php' ) ;?>
<!DOCTYPE html>
<html>
<body class="hold-transition login-page">
<?php
isset( $_SESSION['admin']  )? redirect_php(URL_ADMIN2_ROOT.'charts/') : redirect_php(URL_ADMIN2_ROOT.'index/login.php');
?>
</body>
</html>
