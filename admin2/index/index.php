<?php $config =  dirname(dirname(dirname(__FILE__))); include( $config.'/config/global.php' ) ;include( $config.'/config/function.php' ) ;?>
<!DOCTYPE html>
<html>
<body class="hold-transition login-page">
<?php
isset( $_SESSION['admin']  )? redirect_php(URL_ADMIN2_ROOT.'about/') : redirect_php(URL_ADMIN2_ROOT.'index/login');
?>
</body>
</html>
