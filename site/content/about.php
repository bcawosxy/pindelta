<div class="model_all">
<!-- 
	0331因不需用到其他類別 先拿掉
  <div class="model_navbar">
	
    <div class="model_navbar_title">
	  <img src="./lib/img/small_logo.png" width="40" height="40">
	  <span><b>關於我們</b></span>
	  <hr>
	</div>
	
	
	<div class="model_navbar_list">
	  <ul>
	    <li> <a href="#">經營理念 </a></li>
	    <li> <a href="#">創辦理念</a></li>
	    <li> <a href="#">關於公司 </a></li>
	    <li> <a href="#">人才招募 </a></li>

	  </ul>
	</div>
	
  </div>
--> 
	<?php 
		$query = 'select * from about where id = 3' ;
		$query = query_despace($query);
		$result = mysql_query($query);
		
		while($row = mysql_fetch_array($result)){
			$about = $row['value'];
		}
		//只作外圈樣式，其他用WYSWYG呈現
	?>
	<div class="about_content">
		<?php 
			echo htmlspecialchars_decode($about);
		?>

	</div>
</div>