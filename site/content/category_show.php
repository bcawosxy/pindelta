<?php 
$num = (!empty($_GET['num'])) ? $_GET['num'] : 0 ;
//只取有`category`的area且ID不重複
$query = 'select DISTINCT `categoryarea`.`categoryarea_id` AS id , `categoryarea`.`categoryarea_name` AS name, `categoryarea`.`categoryarea_description` AS description ,`categoryarea`.`categoryarea_cover` AS cover
			from category inner join `categoryarea` on `categoryarea`.`categoryarea_id` = `category`.`categoryarea_id` 
			where `categoryarea_status` = "open" and `category`.`category_id` != "" and `category`.`category_status` = "open" 
			order by `categoryarea_priority` 
			asc limit '.($num*4).',4;';
$query = query_despace($query);
$result = mysql_query($query);
if(!$result) {
	echo 'Error!';
	exit;
}

$categoryarea = array();
$n = 1;
while($row = mysql_fetch_array($result)){
	$categoryarea[$n]['categoryarea_id'] = $row['id'];
	$categoryarea[$n]['categoryarea_name'] = $row['name'];
	$categoryarea[$n]['categoryarea_description'] = $row['description'];
	$categoryarea[$n]['categoryarea_cover'] = $row['cover'];
	$n++;
}

 ?>
<div class="category_all">
	<ul class="category_show">
		<?php
		//首頁、產品第一頁大方塊
		foreach($categoryarea as $k => $v){
			echo '<li class="item"> 
				<a href="product?goods='.base64_encode($v['categoryarea_id']).'">
					<p class="category_show_img">
						<img src="'.ADMIN_IMG_UPLOAD.'categoryarea/'.$v['categoryarea_cover'].'" class="item_big">
					</p>
				</a><hr>
					<a href="product?goods='.base64_encode($v['categoryarea_id']).'">
						<p class="category_show_title">'.$v['categoryarea_name'].'
					</p> 
				</a>
				<p class="category_show_intro">'.$v['categoryarea_description'].'</p> 
			</li>';
		}
		
		?>

	<?php $num++ ;?>
  <div id="next"><a href="<?php echo '?page=product&num='.$num; ?>"></a></div>	
  </ul>
</div>
