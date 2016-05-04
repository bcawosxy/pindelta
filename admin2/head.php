<?php $config =  dirname(dirname(__FILE__)) ; include( $config.'/config/global.php' ) ; include( $config.'/config/function_admin2.php' ) ;?>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Pindelta.com | <?php echo strtoupper(P_CLASS).'-'.P_FUNCTION  ?> | Admin System</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<?php 
		/**
		 * 1228 不同CLASS及FUNCTION 載入不同靜態檔案，避免影響速度
		 */
		$p_class = P_CLASS;
		$p_function = P_FUNCTION;
		$obj = (!class_exists($p_class)) ? redirect_php(URL_ADMIN2_ROOT) : new $p_class;
		
		if(P_CLASS == 'system' && P_FUNCTION == 'admin' && $_SESSION['admin']['id'] != 1) js_location(URL_ADMIN2_ROOT.'about/', '您並非最高管理員，目前沒有訪問此頁面的權限');
		
		//驗證用字串
		echo 'P_CLASS:['.$p_class.'] P_FUNCTION:['.$p_function.']<br>';
		
		if (P_CLASS != 'index' && P_FUNCTION != 'login' && !isset($_SESSION['admin'])) redirect_php(URL_ADMIN2_ROOT.'index/login.php');
		
		$common_css = array(
			'bootstrap/css/bootstrap.min.css',
			'adminlte/css/AdminLTE.min.css',
			'adminlte/css/_all-skins.min.css',
			'plugins/icheck/all.css',
			'plugins/font-awesome/css/font-awesome.css',
			'../../lib/jbox/jBox.css',
		);
		
		$common_js = array(
			'js/jquery_2.1.4.min.js',
			'bootstrap/js/bootstrap.min.js',
			'adminlte/js/app.min.js',
			'adminlte/js/demo.js',
			'../../lib/jbox/jBox.js',
		);		

		//Display css&js html tag
		list($css_file, $js_file) = $obj::$p_function($common_css, $common_js);
		admin_set_css($css_file);
		admin_set_js($js_file);
	?>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<?php 
class about{
	function index($common_css, $common_js){
		$css = $common_css; $js = $common_js;
		
		$js[] = 'plugins/slimscroll/jquery.slimscroll.min.js';
		$js[] = 'plugins/fastclick/fastclick.min.js';
		$js[] = '../../lib/ckeditor/ckeditor.js';
		$js[] = '../../lib/ckeditor/adapters/jquery.js';
		return array($css, $js);
	}
}

class category{
	function index($common_css, $common_js){
		$css = $common_css; $js = $common_js;
		$css[] = 'plugins/datatables/dataTables.bootstrap.css';
		
		
		$js[] = 'plugins/datatables/jquery.dataTables.min.js';
		$js[] = 'plugins/datatables/dataTables.bootstrap.min.js';
		return array($css, $js);
	}

	function content($common_css, $common_js){
		$css = $common_css; $js = $common_js;
		$css[] = 'plugins/icheck/minimal/minimal.css';
		$css[] = 'plugins/select2/select2.min.css';
		$css[] = 'js/jquery-file-upload/css/jquery.fileupload.css';

		$js[] = 'plugins/icheck/icheck.min.js';	
		$js[] = 'plugins/select2/select2.full.min.js';	
		$js[] = 'js/jquery-file-upload/js/jquery.ui.widget.js';
		$js[] = 'js/jquery-file-upload/js/jquery.iframe-transport.js';
		$js[] = 'js/jquery-file-upload/js/jquery.fileupload.js';
		return array($css, $js);
	}
}

class categoryarea{
	function index($common_css, $common_js){
		$css = $common_css; $js = $common_js;
		$css[] = 'plugins/datatables/dataTables.bootstrap.css';
		
		
		$js[] = 'plugins/datatables/jquery.dataTables.min.js';
		$js[] = 'plugins/datatables/dataTables.bootstrap.min.js';
		return array($css, $js);
	}

	function content($common_css, $common_js){
		$css = $common_css; $js = $common_js;
		$css[] = 'plugins/icheck/minimal/minimal.css';
		$css[] = 'js/jquery-file-upload/css/jquery.fileupload.css';

		$js[] = 'plugins/icheck/icheck.min.js';	
		$js[] = 'js/jquery-file-upload/js/jquery.ui.widget.js';
		$js[] = 'js/jquery-file-upload/js/jquery.iframe-transport.js';
		$js[] = 'js/jquery-file-upload/js/jquery.fileupload.js';
		return array($css, $js);
	}
}

class contact {
	function index($common_css, $common_js){
		$css = $common_css; $js = $common_js;
		$css[] = 'plugins/datatables/dataTables.bootstrap.css';
		
		$js[] = 'plugins/datatables/jquery.dataTables.min.js';
		$js[] = 'plugins/slimscroll/jquery.slimscroll.min.js';
		$js[] = 'plugins/datatables/dataTables.bootstrap.min.js';
		$js[] = 'plugins/fastclick/fastclick.min.js';
		return array($css, $js);
	}
	
	function content($common_css, $common_js){
		$css = $common_css; $js = $common_js;
		$css[] = 'plugins/datatables/dataTables.bootstrap.css';
		
		$js[] = 'plugins/datatables/jquery.dataTables.min.js';
		$js[] = 'plugins/slimscroll/jquery.slimscroll.min.js';
		$js[] = 'plugins/datatables/dataTables.bootstrap.min.js';
		$js[] = 'plugins/fastclick/fastclick.min.js';
		return array($css, $js);
	}
}

class index{
	function login($common_css, $common_js){
		$css = $common_css; $js = $common_js;
		$css[] =  'plugins/iCheck/square/blue.css';
		$js[] = 'plugins/iCheck/icheck.min.js';
		return array($css, $js);
	}
	
	function logout($common_css, $common_js){
		$css = $common_css; $js = $common_js;
		return array($css, $js);
	}
}

class inquiry {
	function index($common_css, $common_js){
		$css = $common_css; $js = $common_js;
		$css[] = 'plugins/datatables/dataTables.bootstrap.css';
		
		$js[] = 'plugins/datatables/jquery.dataTables.min.js';
		$js[] = 'plugins/slimscroll/jquery.slimscroll.min.js';
		$js[] = 'plugins/datatables/dataTables.bootstrap.min.js';
		$js[] = 'plugins/fastclick/fastclick.min.js';
		return array($css, $js);
	}
	
	function content($common_css, $common_js){
		$css = $common_css; $js = $common_js;
		$css[] = 'plugins/datatables/dataTables.bootstrap.css';
		
		$js[] = 'plugins/datatables/jquery.dataTables.min.js';
		$js[] = 'plugins/slimscroll/jquery.slimscroll.min.js';
		$js[] = 'plugins/datatables/dataTables.bootstrap.min.js';
		$js[] = 'plugins/fastclick/fastclick.min.js';
		return array($css, $js);
	}

}

class sociallink{
	function index($common_css, $common_js){
		$css = $common_css; $js = $common_js;
		$css[] = 'css/switch.css';
		$js[] = 'plugins/iCheck/icheck.min.js';
		return array($css, $js);
	}
}

class system{
	function index($common_css, $common_js){
		$css = $common_css; $js = $common_js;
		
		$js[] = 'plugins/iCheck/icheck.min.js';
		return array($css, $js);
	}

	function admin($common_css, $common_js){
		$css = $common_css; $js = $common_js;
		$js[] = 'plugins/fastclick/fastclick.min.js';
		$js[] = 'plugins/slimscroll/jquery.slimscroll.min.js';
		return array($css, $js);
	}
}


?>