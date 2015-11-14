<div class="model_all">
  <div class="model_navbar">
    <div class="model_navbar_title">
	  <img src="<?php echo URL_IMG_ROOT.'small_logo.png' ;?>" width="40" height="40">
	  <span><b><a class="nav_headlink" href="<?php echo URL_ADMIN_ROOT ?>">管理後台</a></b></span>
	  <hr>
	</div>
	
	<div class="model_navbar_list">
      <?php include('./../navlist.php'); ?>
	</div>
  </div>
  <?php 
    include('./data.php');
  ?>
  <div class="model_content"><!-- 所見即所得編輯區 -->
	<div class="page_title">關於公司</div><hr>
	<div class="admin_tips">建議上傳圖片格式: PNG / JPEG / JPG</div>
	<form method="post" action="./">
      <textarea rows="10" cols="30" name="about_value" class="ckeditor"><?php echo $data['value']; ?></textarea>
      <script type="text/javascript">CKEDITOR.replace('about_value',
        {
          toolbar : 'Full'
        });
	  </script>  
	  <p><br><input type="submit" name="about_btn" class="btn btn-warning" style="width:200px" value="Save"></p>
	</form>
	
     <?php
 	   $show_info_bar = new info_bar();
       $show_info_bar->modify_info_show($data['modify_name'],$data['modify_time']);
	 ?>
	
  </div>
</div>