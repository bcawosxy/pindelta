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
	$__category = get_nav_category($nav['categoryarea_id']);
	$query = 'select * from category where `categoryarea_id` = '.$nav['categoryarea_id'].' AND `category_status` = "open" order by `category_priority` asc limit '.($g_pages*4).',4 ;';
	$query = query_despace($query);
	$result = mysql_query($query);
	
	//有'項目'才填充資料 組出項目方塊圖
	if(mysql_num_rows($result) > 0){
		$category = array();
		while($row=mysql_fetch_array($result)){
		  $d_category['id'] = $row['category_id'];
		  $d_category['name'] = $row['category_name'];
		  $d_category['category_description'] = $row['category_description'];
		  $d_category['category_cover'] = ADMIN_IMG_UPLOAD.'category/'.$row['category_cover'];
		  $category[] = $d_category;
		}
	}
	
	$nav['show_type'] = 'category';
}

//顯示"產品"的列表
if(!empty($nav['categoryarea_id']) && (!empty($g_category)) && empty($g_items)){
	$__category = get_nav_category($nav['categoryarea_id']);
	
	//組出產品
	$query = 'select * from `product` where `product_category_id` = '.$nav['category_id'].' and `product_status` = "open" order by `product_priority` asc limit '.($g_pages*4).',4 ;';
	$query = query_despace($query);
	$result = mysql_query($query);
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