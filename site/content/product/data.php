<?php 

$nav = array();
$nav['categoryarea_id'] = ( $g_goods);
$nav['category_id'] = ($g_category);
$nav['product_id'] = ($g_items);

//取得展開的category清單
function get_nav_category($id = null){
	$return = array();
	$query = 'select `category_id`,`category_name` from category where `categoryarea_id` = '.$id.' AND `category_status` = "open" order by `category_priority` asc ;';
	$query = query_despace($query);
	$result = mysql_query($query);
	//有'項目'才填充資料 - 讓左側的category項目填滿不用limit 
	if(mysql_num_rows($result) > 0){
		$nav_category = array();
		while($row=mysql_fetch_array($result)){
		  $nav_category['id'] = $row['category_id'];
		  $nav_category['name'] = $row['category_name'];
		  $return[] = $nav_category;
		}
	}
	return $return;
}


//取得全部的分類 for 左側
//0505 增加無"項目"類別的話不出現在側邊
$query = 'select * from `categoryarea` where `categoryarea_status` = "open" order by `categoryarea_priority` asc';
$query = query_despace($query);
$result = mysql_query($query);
while($row=mysql_fetch_array($result)){
	$category_query = 'select * from `category` where `category_status` = "open" AND `categoryarea_id` = '.$row['categoryarea_id'].' order by `category_priority` asc';
	$result2 = mysql_query($category_query);
	if(mysql_num_rows($result2) < 1) continue;
	$d_categoryarea['id'] = $row['categoryarea_id'];
	$d_categoryarea['name'] = $row['categoryarea_name'];
	$area[] = $d_categoryarea;
};


//顯示"項目"的列表
if(!empty($nav['categoryarea_id']) && (empty($nav['category_id'])) && empty($g_items)){	
	$num = 15;
	$__category = get_nav_category($nav['categoryarea_id']);
	$start_page = (int)($g_pages-1) * $num;
	$query = 'select * from category where `categoryarea_id` = '.$nav['categoryarea_id'].' AND `category_status` = "open" order by `category_priority` asc limit '.$start_page.','.$num.';';
	$query = query_despace($query);
	$result = mysql_query($query);
	$n_query = 'select * from category where `categoryarea_id` = '.$nav['categoryarea_id'].' AND `category_status` = "open" order by `category_priority` asc;';
	$n_query = query_despace($n_query);
	$n_result = mysql_query($n_query);
	$num_rows = mysql_num_rows($n_result);

	//有'項目'才填充資料 組出項目方塊圖
	if(mysql_num_rows($result) > 0){
		$category = array();
		while($row=mysql_fetch_array($result)){
		  $d_category['id'] = $row['category_id'];
		  $d_category['name'] = $row['category_name'];
		  $d_category['categoryarea_id'] = $row['categoryarea_id'];
		  $d_category['category_description'] = $row['category_description'];
		  $d_category['category_cover'] = ADMIN_IMG_UPLOAD.'category/'.$row['category_cover'];
		  $category[] = $d_category;
		}
	}
	
	/**
	 * 1206 若項目僅有一項且與類別同名稱，視為可直接跳轉進入項目顯示區塊
	 */
	$nav['show_type'] = 'category';
	if(count($category) == 1) {
		$query = 'select * from `categoryarea` where `categoryarea_id` = '.$d_category['categoryarea_id'].';';
		$result = mysql_query($query);
		while($row=mysql_fetch_assoc($result)){$chech_categoryare = $row;}
		if($d_category['name'] == $chech_categoryare['categoryarea_name']) {
			js_location(URL_ROOT.'product/?goods='.base64_encode($chech_categoryare['categoryarea_id']).'&category='.base64_encode($d_category['id']));
		}
	}
}

//顯示"產品"的列表
if(!empty($nav['categoryarea_id']) && (!empty($g_category)) && empty($g_items)){
	//組出產品
	$num = 15;
	$__category = get_nav_category($nav['categoryarea_id']);
	$start_page = (int)($g_pages-1) * $num;
	$query = 'select * from `product` where `product_category_id` = '.$nav['category_id'].' and `product_status` = "open" order by `product_priority` asc limit '.$start_page.','.$num.' ;';
	$query = query_despace($query);
	$result = mysql_query($query);
	
	$n_query = 'select * from `product` where `product_category_id` = '.$nav['category_id'].' and `product_status` = "open" order by `product_priority` asc ;';
	$n_query = query_despace($n_query);
	$n_result = mysql_query($n_query);
	$num_rows = mysql_num_rows($n_result);
	
	$d_product = array();
	if(mysql_num_rows($result) > 0){
		while($row=mysql_fetch_array($result)){
		  $d_product['id'] = $row['product_id'];
		  $d_product['name'] = $row['product_name'];
		  $d_product['description'] = $row['product_description'];
		  $d_product['cover'] = ADMIN_IMG_UPLOAD.'product/'.$row['product_cover'];
		  $product[] = $d_product;
		}
	}else{
		if(($g_ajax) != 'true'){
			$d_product['id'] = null;
			$d_product['name'] = null;
			$d_product['description'] = null;
			$d_product['cover'] = URL_IMG_ROOT.'coming_soon2.jpg';
			$product[] = $d_product;
		}
  }
	$nav['show_type'] = 'items';
}

//顯示"產品介紹頁"
if(!empty($nav['categoryarea_id']) && (!empty($nav['category_id'])) && (!empty($g_items))){
	$__category = get_nav_category($nav['categoryarea_id']);
	$query = 'select * from product where `product_id` = '.$nav['product_id'].' and `product_status` = "open" ;';
	$query = query_despace($query);
	$result = mysql_query($query);
	$product = array();
	$product = mysql_fetch_assoc($result);
	if(empty($product)) php_call_jbox('error', 'Error. contact us please.', URL_ROOT) ; 
	$nav['show_type'] = 'items_content';
}

?>