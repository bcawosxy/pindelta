<div class="model_all">
  <div class="model_navbar">
    <div class="model_navbar_title">
	  <img src="<?php echo URL_IMG_ROOT.'small_logo.png' ;?>" width="40" height="40">
	  <span><b><a class="nav_headlink" href="<?php echo URL_ADMIN_ROOT ?>">管理後台</a></b></span>
	  <hr>
	</div>
	
	<div class="model_navbar_list">
      <?php include('./navlist.php'); ?>
	</div>
  </div>
<?php
	$query = 'select * from `admin` where id = "'.$_SESSION['admin']['id'].'"';
	$query = query_despace($query);
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result)){
		$last_login_time = $row['last_login_time'];
		$last_login_ip = $row['last_login_ip'];
	}
	
?>

  <div class="model_content">
    <div style="font-family:Arial, 微軟正黑體"> 
		<p style="font-size:18px;">Hello! <span style="color:#108199;"> <?php echo $_SESSION['admin']['name'] ?><span></p>
		<p>您在：<span style="color:#F7931D;font-weight:bold;"><?php echo  $last_login_time;?></span> 從 <span style="color:#F7931D;font-weight:bold;"> <?php echo $last_login_ip ?></span> 登入</p>
	</div>
	
  </div>
</div>