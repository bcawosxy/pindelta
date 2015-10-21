<div class="header_banner_box">
	<div class="header_banner_left">
		<span class="header_banner_img">
			<a href="<?php echo URL_ROOT; ?>"><img class="img"  src="<?php echo URL_IMG_ROOT; ?>banner.png" height="100%" width="55%"></a>
		</span>
	</div>
	<?php 
		$query = 'SELECT * FROM `sociallink` WHERE status = "open" AND url != "" ORDER BY `sort` DESC' ;
		$query = query_despace($query);
		$result = mysql_query($query);
		$social= null;
		if (mysql_num_rows($result) > 0) {
			$n = 1;
			$social = array();
			while($row = mysql_fetch_array($result)){
				$social[$n]['name'] = $row['name'];
				$social[$n]['url'] = urldecode($row['url']);
				$n++;
			}
		}
	?>
	
	<div class="header_banner_right">
		<ul >
			<?php 
			if(!empty($social)){
				foreach($social as $k => $v){
					echo '<li style="padding-left:5px;float:right"><a target="_blank" href="'.$v['url'].'"> <img  src="'.URL_IMG_ROOT.'social_icon/rounded/'.$v['name'].'.png'.'"></a></li>';
				}
			
			}
			?>
		</ul>
	</div>
</div>