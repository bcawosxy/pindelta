<?php
$page = (!empty($_GET['p'])) ? $_GET['p'] : null;

if(!empty($page) && $page == 'about' ){
  include('./site/content/about.php');
}else if(!empty($page) && $page == 'product'){
  include('./site/content/category_show.php');
}else if(!empty($page) && $page == 'contact'){
  include('./site/content/contact.php');
}else{
  include('./site/content/category_show.php');
}
?>
