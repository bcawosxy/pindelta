<ul>
  <li class="nav_title"> <span>關於我們 </span>
    <ul class="model_navbar_list_link">
	  <!--<li> <a href="<?php //echo URL_ADMIN_ROOT.'about?type=a' ?>">經營理念 </a> </li>-->
	  <!--<li> <a href="<?php //echo URL_ADMIN_ROOT.'about?type=b' ?>">創辦理念 </a> </li>-->
	  <li> <a href="<?php echo URL_ADMIN_ROOT.'about' ?>">關於公司 </a> </li>
	  <!--<li> <a href="<?php //echo URL_ADMIN_ROOT.'about?type=d' ?>">人才招募 </a> </li>-->
	</ul>
  </li>  
  <li class="nav_title">  <span>產品管理 </span>
    <ul class="model_navbar_list_link">
	  <li> <a href="<?php echo URL_ADMIN_ROOT.'product?act=show&type=categoryarea'; ?>">類別管理 </a> </li>
	  <li> <a href="<?php echo URL_ADMIN_ROOT.'product?act=show&type=category' ;?>">項目管理 </a> </li>
	  <li> <a href="<?php echo URL_ADMIN_ROOT.'product?act=show&type=product' ;?>">產品管理 </a> </li>
	  <li> <a href="<?php echo URL_ADMIN_ROOT.'product?act=description' ;?>">產品SEO優化 </a> </li>
	</ul>
  </li>

  <li class="nav_title">  <span>社群網站 </span>
    <ul class="model_navbar_list_link">
	  <li> <a href="<?php echo URL_ADMIN_ROOT.'sociallink'; ?>">社群網站管理 </a> </li>
	</ul>
  </li>

  <li class="nav_title">  <span>聯繫我們/詢價 </span>
    <ul class="model_navbar_list_link">
	  <li> <a href="<?php echo URL_ADMIN_ROOT.'contact'; ?>">聯繫我們 </a> </li>
	  <li> <a href="<?php echo URL_ADMIN_ROOT.'inquiry'; ?>">詢價 </a> </li>
	</ul>
  </li>

  <li class="nav_title">  <span>系統 </span>
    <ul class="model_navbar_list_link">
	  <li> <a href="<?php echo URL_ADMIN_ROOT.'system'; ?>">系統參數 </a> </li>
	</ul>
  </li>

	<?php
	if($_SESSION['admin']['id'] == 1){
		echo '<li class="nav_title">  <span>管理員 </span>
			<ul class="model_navbar_list_link">
			<li> <a href="'.URL_ADMIN_ROOT.'manage">管理員設定 </a> </li>
			</ul>
		</li>';
	}
	?>

  <li> <a href="<?php echo URL_ROOT.'/admin?act=logout' ?>"> Logout</a></li>
</ul>