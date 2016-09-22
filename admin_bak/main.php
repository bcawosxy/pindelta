<?php 
   $act = (!empty($_GET['act'])) ? $_GET['act'] : 'login';
  if( (!empty($_SESSION['admin']['id'])) && ($act != 'logout') ){
    js_location('./dashboard');
  }

 if($act == 'logout'){
    include('./login/logout.php');
  }else{
    include('./login/login.php');
  }
?>