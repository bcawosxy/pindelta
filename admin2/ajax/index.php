<?php
$config =  dirname(dirname(dirname(__FILE__))) ; include( $config.'/config/global.php' ) ; include( $config.'/config/function.php' ) ;
$class = $_GET['class']; $function = $_GET['function'];
$file = './'.$class.'/'.$function.'.php' ;

(file_exists($file)) ? include($file) : json_encode_return(0, 'Bad request!', null);

?>
