<div class="model_all">
  <div class="model_navbar">
    <div class="model_navbar_title">
	  <img src="<?php echo $URL_IMG_ROOT; ?>small_logo.png" width="40" height="40">
	  <span><b>Catagory</b></span>
	  <hr>
	</div>
	
	<div class="model_navbar_list">
	  <ul>
		  <?php 
          foreach($area as $k => $v){
		    $class =  ($v['id'] == $nav['categoryarea_id']) ? 'active' : 'unactive';
			echo '<li>';
            echo '<a class="'.$class.'" href=./?goods='.base64_encode($v['id']).'>'.$v['name'].' </a>';
			echo '<ul>';
              if($class== 'active'){
			    foreach($__category as $k2 => $v2){
					if($v2['id'] == $nav['category_id']){
						echo '<li class="category_list_active"><a href=./?goods='.base64_encode($v['id']).'&category='.base64_encode($v2['id']).'>'.$v2['name'].'</a></li>';
					}else{
						echo '<li class="category_list"><a href=./?goods='.base64_encode($v['id']).'&category='.base64_encode($v2['id']).'>'.$v2['name'].'</a></li>';
					}
				}
			  }
			echo '</ul>';
			echo '</li>';
          }
		  ?>
	  </ul>
	</div>
  </div>
  
  <div class="model_content">
    <?php include('../site/content/product/content.php'); ?>
  </div>
</div>
