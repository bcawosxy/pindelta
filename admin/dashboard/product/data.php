<?php 
  $key_act = ['show', 'edit', 'add', 'tags', 'description'];
  $key_type = ['categoryarea', 'category', 'product'];

  ((empty($_GET['act']) || $_GET['act'] == "" || (!in_array($_GET['act'],$key_act)))) ? $act = 'show' : $act = $_GET['act'];
  
  //新增資料的view
  if($act == 'add'){
	//type不在範圍內
	if(!in_array($_GET['type'],$key_type)){
		js_location(URL_ADMIN_ROOT.'/product');
	}
	
	//新增類別
	if($_GET['type'] == 'categoryarea'){
	?>
		<div class="page_title">新增類別</div><hr>
		<div class="admin_tips">圖片建議上傳png/jpg/jpef格式，大小為240px * 320 px</div>
		<form method="post" action="./action.php?act=add&type=<?php echo $_GET['type'] ; ?>" id="categoryarea_form">
			<table class="table table-bordered table-hover ">
				<tr>
					<td style="text-align:right" class="info product_add_table_td">名稱：</td>
					<td> <input class="form-control" maxlength="35" name="categoryarea_name" type="text" placeholder="類別名稱"> </td>
				</tr>
				<tr>
					<td style="text-align:right" class="info product_add_table_td">優先序：</td>
					<td> <input class="form-control" maxlength="3" name="categoryarea_priority" type="text" placeholder="數值範圍 : 1 ~ 255"> </td>
				</tr>
				<tr>
					<td style="text-align:right" class="info product_add_table_td">狀態：</td>
					<td>
						<div class="radio">
							<label>
								<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked> 關閉
							</label>
						</div>
					</td>
				</tr>
				<tr>
					<td style="text-align:right" class="info product_add_table_td">介紹：</td>
					<td> <input class="form-control" name="categoryarea_description" maxlength="100" type="text" placeholder="說明文字"> </td>
				</tr>
				<tr>
					<td rowspan="2" style="text-align:right" class="info product_add_table_td">封面：</td>
					<td> 
						<div class="img_area" style="border:0px red solid;width:400px;height:350px;">
							<div class="img_show"><img onclick="$('#fileupload').trigger('click');" style="width:240px;height:320px;"></div>
							<span class="img_info">  </span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<input type="file" style="display:none;" id="fileupload" name="files" accept="image/png,image/jpg,image/jpeg"  />
						<input type="button" name="open_file" class="btn btn-success" value="上傳檔案" onclick="$('#fileupload').trigger('click');">
						<input type="text" id="cover" name="categoryarea_cover" style="display:none;" value="">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" onclick="return check_form(this.form.id)" name="key_btn"  class="btn btn-primary" style="width:200px" value="確定新增">  
						<span id="loadbar" style="display:none;"><img src="<?php echo URL_IMG_ROOT.'loader.gif' ?>"> </span>
						<button type="button" onclick="history.back()" class="btn btn-warning">取消</button>				
					</td>
				</tr>
			</table>
		</form>
  <?php
		return;
	}
	
	//新增項目
	if($_GET['type'] == 'category'){ 
		$query = 'select * from categoryarea where categoryarea_status = "open";';
		$query = query_despace($query);
		$result = mysql_query($query);
		$categoryarea = array();
		while($row=mysql_fetch_array($result)){
			$categoryarea[$row['categoryarea_id']]['categoryarea_id'] = $row['categoryarea_id'];
			$categoryarea[$row['categoryarea_id']]['categoryarea_name'] = $row['categoryarea_name'];
		}
	?>
		<div class="page_title">新增項目</div><hr>
		<div class="admin_tips">圖片建議上傳png/jpg/jpef格式，大小為170px * 220 px</div>
		<form method="post" action="./action.php?act=add&type=<?php echo $_GET['type'] ; ?>" id="category_form">
			<table class="table table-bordered table-hover ">
				<tr>
					<td style="text-align:right" class="info product_add_table_td">名稱：</td>
					<td> <input class="form-control" maxlength="35"  name="category_name" type="text" placeholder="項目名稱"> </td>
				</tr>
				<tr>
					<td style="text-align:right" class="info product_add_table_td">優先序：</td>
					<td> <input class="form-control" maxlength="3" name="category_priority" type="text" placeholder="數值範圍 : 1 ~ 255"> </td>
				</tr>
				<tr>
					<td style="text-align:right" class="info product_add_table_td">所屬類別：</td>
					<td> 
						<select id="category_belong_categoryarea" name="categoryarea_id">
							<option value="0">請選擇所屬類別 </option>
							<?php 
								foreach($categoryarea as $k => $v){
									echo '<option value='.$v['categoryarea_id'].'>'.$v['categoryarea_name'].' </option>';
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td style="text-align:right" class="info product_add_table_td">狀態：</td>
					<td>
						<div class="radio">
							<label>
								<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked> 關閉
							</label>
						</div>
					</td>
				</tr>
				<tr>
					<td style="text-align:right" class="info product_add_table_td">介紹：</td>
					<td> <input class="form-control" name="category_description" maxlength="100" type="text" placeholder="說明文字"> </td>
				</tr>
				<tr>
					<td rowspan="2" style="text-align:right" class="info product_add_table_td">封面：</td>
					<td> 
						<div class="img_area" style="border:0px red solid;width:400px;height:350px;">
							<div class="img_show"><img onclick="$('#fileupload').trigger('click');" style="width:240px;height:320px;"></div>
							<span class="img_info">  </span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<input type="file" style="display:none;" id="fileupload" name="files" accept="image/png,image/jpg,image/jpeg"  />
						<input type="button" name="open_file" class="btn btn-success" value="上傳檔案" onclick="$('#fileupload').trigger('click');">
						<input type="text"  id="cover" name="category_cover" style="display:none;">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" onclick="return check_form(this.form.id)" name="key_btn" class="btn btn-primary" style="width:200px" value="確定新增">  
						<span id="loadbar" style="display:none;"><img src="<?php echo URL_IMG_ROOT.'loader.gif' ?>"> </span>
						<button type="button" onclick="history.back()" class="btn btn-warning">取消</button>				
					</td>
				</tr>
			</table>
		</form>

	<?php 
		return;
	}
	
	//新增產品
	if($_GET['type'] == 'product'){
		$query = 'select * from categoryarea where categoryarea_status = "open" order by categoryarea_priority asc;';
		$query = query_despace($query);
		$result = mysql_query($query);
		$category = array();
		$n = 0;
		while($row=mysql_fetch_array($result)){
			$category[$n]['categoryarea_id'] = $row['categoryarea_id'];
			$category[$n]['categoryarea_name'] = $row['categoryarea_name'];
			$n++;
		}

		
		foreach($category as $k => $v){
			$category[$k]['category'] = array();
			$n = 0;
			$query = 'select * from category where category_status = "open" and categoryarea_id = "'.$v['categoryarea_id'].'" order by category_priority asc;';
			$result = mysql_query($query);
			while($row=mysql_fetch_array($result)){
				$category[$k]['category'][$n]['id'] = $row['category_id'];
				$category[$k]['category'][$n]['name'] = $row['category_name'];
				$n++;
			}
		}
		
		
	?>
		<div class="page_title">新增產品</div><hr>
		<div class="admin_tips">圖片建議上傳png/jpg/jpef格式，大小為170px * 220 px</div>
		<form method="post" action="./action.php?act=add&type=<?php echo $_GET['type'] ; ?>" id="product_form">
			<table class="table table-bordered table-hover " data-page-size="20">
				<tr>
					<td style="text-align:right" class="info product_add_table_td">名稱：</td>
					<td> <input class="form-control" name="product_name" maxlength="35" type="text" placeholder="產品名稱"> </td>
					<td style="text-align:right" class="info product_add_table_td">優先序：</td>
					<td> <input class="form-control" maxlength="3" name="product_priority" type="text" placeholder="數值範圍 : 1 ~ 255"> </td>
				</tr>
				<tr>
					<td style="text-align:right" class="info product_add_table_td">型號：</td>
					<td> <input class="form-control" maxlength="40" name="product_model" type="text" placeholder="產品型號"> </td>
					<td style="text-align:right" class="info product_add_table_td">規格：</td>
					<td> <input class="form-control" maxlength="30" name="product_standard" type="text" placeholder="產品規格"> </td>
				</tr>
				<tr>
					<td style="text-align:right" class="info product_add_table_td">材質：</td>
					<td> <input class="form-control" maxlength="30" name="product_material" type="text" placeholder="產品材質"> </td>
					<td style="text-align:right" class="info product_add_table_td">生產時間：</td>
					<td> <input class="form-control" maxlength="10" name="product_produce_time" type="text" placeholder="生產所需時間"> </td>
				</tr>
				<tr >
					<td  style="text-align:right" class="info product_add_table_td">最低訂量：</td>
					<td> <input class="form-control" maxlength="8" name="product_lowest" type="text" placeholder="產品最低訂量"> </td>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td style="text-align:right" class="info product_add_table_td">所屬類別：</td>
					<td> 
						<select id="product_belong_category" name="category_id">
							<option value="0">請選擇所屬類別 </option>
							<?php 
								foreach($category as $k => $v){
									echo '<optgroup label="'.$v['categoryarea_name'].'">';
									foreach($v['category'] as $k2 => $v2){
										echo '<option value='.$v2['id'].'>'.$v2['name'].' </option>';
									}	
									echo '</optgroup>';
								}
							?>
						</select>
					</td>
					<td style="text-align:right" class="info product_add_table_td">狀態：</td>
					<td>
						<div class="radio">
							<label>
								<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked> 關閉
							</label>
						</div>
					</td>
					
				</tr>
				<tr>
					<td style="text-align:right" class="info product_add_table_td">描述：</td>
					<td colspan="3"> <input class="form-control" name="product_description" maxlength="100" type="text" placeholder="說明文字"> </td>
				</tr>
				<tr>
					<td style="text-align:right" class="info product_add_table_td">備註：</td>
					<td colspan="3"> <textarea rows="5" cols="80" name="product_memo" style="resize:none;"> </textarea> </td>
				</tr>
				<tr>
					<td style="text-align:right" class="info product_add_table_td">內文：</td>
					<td colspan="3">
						<textarea rows="10" cols="30" name="product_content" class="ckeditor"></textarea>
						<script type="text/javascript">CKEDITOR.replace('about_value',
							{
								toolbar : 'Full'
							});
						</script> 
					</td>
				</tr>
				<tr>
					<td rowspan="2" style="text-align:right" class="info product_add_table_td">封面：</td>
					<td colspan="3"> 
						<div class="img_area" style="border:0px red solid;width:400px;height:350px;">
							<div class="img_show"><img onclick="$('#fileupload').trigger('click');" style="width:250px;height:300px;"></div>
							<span class="img_info">  </span>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<input type="file" style="display:none;" id="fileupload" name="files" accept="image/png,image/jpg,image/jpeg"  />
						<input type="button" name="open_file" class="btn btn-success" value="上傳檔案" onclick="$('#fileupload').trigger('click');">
						<input type="text" id="cover" name="product_cover" style="display:none;">
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<input type="submit" onclick="return check_form(this.form.id)" name="key_btn" class="btn btn-primary" style="width:200px" value="確定新增">  
						<span id="loadbar" style="display:none;"><img src="<?php echo URL_IMG_ROOT.'loader.gif' ?>"> </span>
						<button type="button" onclick="history.back()" class="btn btn-warning">取消</button>				
					</td>
				</tr>
			</table>
		</form>
	
	
	<?php
	return;
	}
  }
  //end add 
   
  //呈現資料的view
  if($act == 'show'){
	$type = (empty($_GET['type'])) ? 'categoryarea' : $_GET['type'] ; 
	
	if(!in_array($type,$key_type)){
		js_location(URL_ADMIN_ROOT.'/product');
	}

	if($type == 'categoryarea'){
		$query = 'select * from categoryarea order by `categoryarea_priority` asc;';
		$query = query_despace($query);
		$result = mysql_query($query);
		$categoryarea = array();
		while($row=mysql_fetch_array($result)){
			$categoryarea[$row['categoryarea_id']]['categoryarea_id'] = $row['categoryarea_id'];
			$categoryarea[$row['categoryarea_id']]['categoryarea_name'] = $row['categoryarea_name'];
			$categoryarea[$row['categoryarea_id']]['categoryarea_priority'] = $row['categoryarea_priority'];
			$categoryarea[$row['categoryarea_id']]['categoryarea_cover'] = $row['categoryarea_cover'];
			$categoryarea[$row['categoryarea_id']]['categoryarea_admin_id'] = $row['categoryarea_admin_id'];
			$categoryarea[$row['categoryarea_id']]['categoryarea_modify_name'] = $row['categoryarea_modify_name'];
			$categoryarea[$row['categoryarea_id']]['categoryarea_modify_time'] = $row['categoryarea_modify_time'];
			$categoryarea[$row['categoryarea_id']]['categoryarea_status'] = $row['categoryarea_status'];
		}
		echo '<div class="page_title">類別管理</div><hr>';
		echo  '<table class="footable metro-blue" data-page-size="20">
				<thead>
				  <tr>
					<th>類別名稱 </th>
					<th>優先順序</th>
					<th data-hide="phone">最後修改時間</th>
					<th data-hide="phone">編輯</th>
					<th data-hide="phone">狀態 </th>
					<th data-hide="phone,tablet">封面</th>	
					<th data-hide="phone,tablet">最後修改人員</th>
				  </tr>
				</thead>
				<tbody>';
					foreach($categoryarea as $k => $v){
						echo '<tr>
								<td>'.remade_str($v['categoryarea_name']).'</td>
								<td>'.$v['categoryarea_priority'].'</td>
								<td>'.$v['categoryarea_modify_time'].'</td>
								<td><a href="./?act=edit&type=categoryarea&id='.$v['categoryarea_id'].'"> 修改 </a></td>';
								
								if($v['categoryarea_status'] == 'close'){
									echo '<td><span class="status-metro status-disabled" title="Disabled">'.$v['categoryarea_status'].'</span></td>';
								}else{
									echo '<td><span class="status-metro status-active" title="Active">'.$v['categoryarea_status'].'</span></td>';
								}
								
						echo   '<td><img width="240px" height="320px" src="'.ADMIN_IMG_UPLOAD.$type.'/'.$v['categoryarea_cover'].'"></td>
								<td>'.$v['categoryarea_modify_name'].'</td>
							  </tr>';
					}
		   echo '</tbody>
				<tfoot>
				  <tr>
					<td colspan="7">
					  <div class="pagination pagination-centered"></div>
					</td>
				  </tr>
				</tfoot>
			  </table><br>';?>
			<input type="button" id="add_categoryarea" class="btn btn-primary" style="width:200px" value="新增類別">
  <?php 
		return;
	}
	
	if($type == 'category'){
		$query = 'select `category`.*,`categoryarea`.`categoryarea_name` from category left join categoryarea using(categoryarea_id) order by `category_priority` asc;';
		$query = query_despace($query);
		$result = mysql_query($query);
		$category = array();
		$categoryarea_option = array();
		$num = 1 ;
		while($row=mysql_fetch_array($result)){
			$category[$num]['category_id'] = $row['category_id'];
			$category[$num]['category_name'] = $row['category_name'];
			$category[$num]['categoryarea_name'] = $row['categoryarea_name'];
			$category[$num]['category_priority'] = $row['category_priority'];
			$category[$num]['categoryarea_id'] = $row['categoryarea_id'];
			$category[$num]['category_cover'] = $row['category_cover'];
			$category[$num]['category_status'] = $row['category_status'];
			$category[$num]['category_modify_time'] = $row['category_modify_time'];
			$category[$num]['category_modify_name'] = $row['category_modify_name'];
			
			if(!in_array($row['categoryarea_name'], $categoryarea_option)){
				$categoryarea_option[] = $row['categoryarea_name'];
			}			

			$num++;
		}
		$num = 0;
	?>
		<div class="page_title">項目管理</div><hr>
		 Search: <input id="filter" type="text"/>&nbsp;&nbsp;&nbsp;
		 類別搜尋: <select class="filter-status">
				<option value=""></option>
				<?php 
					if(!empty($categoryarea_option)){
						foreach($categoryarea_option as $v ){
							echo '<option value="'.$v.'">'.$v.'</option>';
						}
					}
				?>
		 </select>

		 <br><br>
		<table class="footable metro-blue" data-page-size="20" data-filter="#filter" data-filter-text-only="true">
			<thead>
				<tr>
					<th>項目名稱 </th>
					<th>所屬類別 </th>
					<th>優先順序</th>
					<th data-hide="phone">最後修改時間</th>
					<th data-hide="phone">編輯</th>
					<th data-hide="phone">狀態 </th>
					<th data-hide="phone,tablet">封面</th>		
					<th data-hide="phone,tablet">最後修改人員</th>
				</tr>
			</thead>
		<tbody>
		<?php 
		foreach($category as $k => $v){
			echo '<tr>
				<td>'.remade_str($v['category_name']).'</td>
				<td>'.remade_str($v['categoryarea_name']).'</td>
				<td>'.$v['category_priority'].'</td>
				<td>'.$v['category_modify_time'].'</td>
				<td><a href="./?act=edit&type=category&id='.$v['category_id'].'"> 修改 </a></td>';

				if($v['category_status'] == 'close'){
					echo '<td><span class="status-metro status-disabled" title="Disabled">'.$v['category_status'].'</span></td>';
				}else{
					echo '<td><span class="status-metro status-active" title="Active">'.$v['category_status'].'</span></td>';
				}

				echo  '<td><img width="170px" height="220px" src="'.ADMIN_IMG_UPLOAD.$type.'/'.$v['category_cover'].'"></td>
				<td>'.$v['category_modify_name'].'</td>
			</tr>';
		}
		?>
		</tbody>
			<tfoot>
				<tr>
					<td colspan="7">
						<div class="pagination pagination-centered"></div>
					</td>
				</tr>
			</tfoot>
		</table>
		<br>
		<input type="button" id="add_category" class="btn btn-primary" style="width:200px" value="新增項目">
	<?php
		return;
	}
	
	if($type == 'product'){
		$query = 'select `product`.*, `category`.`category_name` from product left join `category` on `product`.`product_category_id` = `category`.`category_id` order by `product_priority` asc;';
		$query = query_despace($query);
		$result = mysql_query($query);
		$product = array();
		$category_option = array();
		$num = 1 ;
		while($row=mysql_fetch_array($result)){
			$product[$num]['product_id'] = $row['product_id'];
			$product[$num]['product_category_id'] = $row['product_category_id'];
			$product[$num]['product_name'] = $row['product_name'];
			$product[$num]['product_cover'] = $row['product_cover'];
			$product[$num]['product_status'] = $row['product_status'];
			$product[$num]['product_priority'] = $row['product_priority'];
			$product[$num]['product_model'] = $row['product_model'];
			$product[$num]['product_standard'] = $row['product_standard'];
			$product[$num]['product_material'] = $row['product_material'];
			$product[$num]['product_produce_time'] = $row['product_produce_time'];
			$product[$num]['product_lowest'] = $row['product_lowest'];
			$product[$num]['product_description'] = $row['product_description'];
			$product[$num]['product_inserttime'] = $row['product_inserttime'];
			$product[$num]['product_admin'] = $row['product_admin'];
			$product[$num]['product_modify_time'] = $row['product_modify_time'];
			$product[$num]['product_modify_name'] = $row['product_modify_name'];
			$product[$num]['product_material'] = $row['product_material'];
			$product[$num]['category_name'] = $row['category_name'];
	
			if(!in_array($row['category_name'], $category_option)){
				$category_option[] = $row['category_name'];
			}			
			$num++;
		}
		$num = 0;
	
	?>
		<div class="page_title">產品管理</div><hr>
		Search: <input id="filter" type="text"/>&nbsp;&nbsp;&nbsp;
		項目搜尋: <select class="filter-status">
		<option value=""></option>
		<?php 
			if(!empty($category_option)){
				foreach($category_option as $v ){
					echo '<option value="'.$v.'">'.$v.'</option>';
				}
			}
		?>
		</select>
		<br><br>
		<table class="footable metro-blue" data-page-size="20" data-filter="#filter" data-filter-text-only="true">
			<thead>
				<tr>
					<td  colspan="7">
						<div class="pagination pagination-centered"></div>
					</td>
				</tr>
				<tr>
					<th>產品名稱 </th>
					<th>所屬項目 </th>
					<th>優先順序</th>
					<th data-hide="phone">產品標籤</th>
					<th data-hide="phone">編輯</th>
					<th data-hide="phone">狀態 </th>				
					<th data-hide="phone,tablet">型號</th>
					<th data-hide="phone,tablet">規格</th>
					<th data-hide="phone,tablet">材質</th>
					<th data-hide="phone,tablet">最後修改時間</th>
					<th data-hide="phone,tablet">最後修改人員</th>
				</tr>
			</thead>
		<tbody>
		<?php 
		foreach($product as $k => $v){
			echo '<tr>
				<td>'.remade_str($v['product_name']).'</td>
				<td>'.remade_str($v['category_name']).'</td>
				<td>'.$v['product_priority'].'</td>
				<td><a href="./?act=tags&type=product&id='.$v['product_id'].'">修改</a></td>	
				<td><a href="./?act=edit&type=product&id='.$v['product_id'].'">修改</a></td>';
				if($v['product_status'] == 'close'){
					echo '<td><span class="status-metro status-disabled" title="Disabled">'.$v['product_status'].'</span></td>';
				}else{
					echo '<td><span class="status-metro status-active" title="Active">'.$v['product_status'].'</span></td>';
				}				
				echo '<td>'.$v['product_model'].'</td>
					<td>'.$v['product_standard'].'</td>
					<td>'.$v['product_material'].'</td>
					<td>'.$v['product_modify_time'].'</td>
				<td>'.$v['product_modify_name'].'</td>
			</tr>';
		}
		?>
		</tbody>
			<tfoot>
				<tr>
					<td colspan="7">
						<div class="pagination pagination-centered"></div>
					</td>
				</tr>
			</tfoot>
		</table>
		<br>
		
		<input type="button" id="add_product" class="btn btn-primary" style="width:200px" value="新增產品">
	
	
	
	<?php
		return;
	}
	
  } 
  //end show
  
  //修改資料的view
  if($act == 'edit'){
  
    if(empty($_GET['type']) || empty($_GET['id']) || (!in_array($_GET['type'],$key_type))){
	  js_location(URL_ADMIN_ROOT.'/product');
	}else{
	  $type= $_GET['type'];
	  $id= $_GET['id'];
	}
	

	if($type == 'categoryarea'){  
		$query = 'select * from categoryarea where categoryarea_id = '.$id.';';
		$query = query_despace($query);
		$result = mysql_query($query);
		if (mysql_num_rows($result) < 1) js_location(URL_ADMIN_ROOT.'product');	
		while($row=mysql_fetch_array($result)){
			$categoryarea['categoryarea_name'] = $row['categoryarea_name'];
			$categoryarea['categoryarea_priority'] = $row['categoryarea_priority'];
			$categoryarea['categoryarea_description'] = $row['categoryarea_description'];
			$categoryarea['categoryarea_status'] = $row['categoryarea_status'];
			$categoryarea['categoryarea_cover'] = $row['categoryarea_cover'];
		}
		
	?>
		<div class="page_title">修改類別</div><hr>
		<div class="admin_tips">圖片建議上傳png/jpg/jpef格式，大小為240px * 320 px</div>
		<form method="post" id="categoryarea_form" action="./action.php?act=edit&type=<?php echo $type ; ?>&id=<?php echo $id; ?>">
			<table class="table table-bordered table-hover">
				<tr><td width="20%">名稱： </td><td> <input type="text" name="categoryarea_name" maxlength="35" value="<?php echo $categoryarea['categoryarea_name'] ;?>"></td></tr>
				<tr>
					<td>排序： </td>
					<td> <input type="text" maxlength="3" name="categoryarea_priority" value="<?php echo $categoryarea['categoryarea_priority'] ; ?>"> <span style="color:red;">範圍 1 ~ 255</span></td>
				</tr>
				<tr>
					<td>狀態：  </td>
					<td>
						<?php 
						if($categoryarea['categoryarea_status'] == 'open'){
							echo '<input type="radio" value="open" checked name="status"> Open   ';
							echo '<input type="radio" value="close" name="status"> Close ';
						}else{
							echo '<input type="radio" value="open" name="status"> Open   ';
							echo '<input type="radio" value="close" checked name="status"> Close';
						}
						?>
					</td>
				</tr>
				<tr>
					<td>介紹：  </td>
					<td> <input class="form-control" name="categoryarea_description" maxlength="100" type="text" value="<?php echo $categoryarea['categoryarea_description']; ?>" placeholder="說明文字"> </td>
				</tr>
				<tr>
					<td rowspan="2">封面：</td>
					<td> 
						<div class="img_area" style="border:0px red solid;width:400px;height:350px;">
							<div class="img_show"><img onclick="$('#fileupload').trigger('click');" src="<?php echo ADMIN_IMG_UPLOAD.$type.'/'.$categoryarea['categoryarea_cover']; ?>" style="width:240px;height:320px;"></div>
							<span class="img_info">  </span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<input type="file" style="display:none;" id="fileupload" name="files" accept="image/png,image/jpg,image/jpeg"  />
						<input type="button" name="open_file" class="btn btn-success" value="上傳檔案" onclick="$('#fileupload').trigger('click');">
						<input type="text" id="cover" name="categoryarea_cover" style="display:none;" value="<?php echo $categoryarea['categoryarea_cover'];?>">
					</td>
				</tr>
				<tr><td>刪除分類：  </td><td> <button onclick="delete_item('<?php echo $type ;?>', <?php echo $id ; ?>)" type="button" class="btn btn-danger">刪除</button>  </td></tr>
			</table>
			  
			<input type="submit" style="width:200px" onclick="return check_form(this.form.id)" class="btn btn-primary" name="key_btn" value="送出修改">
			<span id="loadbar" style="display:none;"><img src="<?php echo URL_IMG_ROOT.'loader.gif' ?>"> </span>			
			<button type="button" onclick="history.back()" class="btn btn-warning">取消</button>
		</form>
		<div id="del_form"></div>
	<?php
		return;
	}
	
	if($type == 'category'){ 
		$query = 'select * from category where category_id = '.$id.';';
		$query = query_despace($query);
		$result = mysql_query($query);
		if (mysql_num_rows($result) < 1) js_location(URL_ADMIN_ROOT.'product');	
		while($row=mysql_fetch_array($result)){
			$category['category_name'] = $row['category_name'];
			$category['category_priority'] = $row['category_priority'];
			$category['categoryarea_id'] = $row['categoryarea_id'];
			$category['category_cover'] = $row['category_cover'];
			$category['category_status'] = $row['category_status'];
			$category['category_description'] = $row['category_description'];
			$category['category_insertime'] = $row['category_insertime'];
			$category['category_modify_time'] = $row['category_modify_time'];
			$category['category_modify_name'] = $row['category_modify_name'];
			$category['status_record'] = $row['status_record'];
		}
		
		$query = 'select * from categoryarea where categoryarea_id = '.$category['categoryarea_id'];
		$query = query_despace($query);
		$result = mysql_query($query);
		if (mysql_num_rows($result) < 1) js_location(URL_ADMIN_ROOT.'product');	
		while($row=mysql_fetch_array($result)){
			$category['categoryarea_name'] = $row['categoryarea_name'];
		}
	
	?>
		<div class="page_title">修改項目</div><hr>
		<div class="admin_tips">圖片建議上傳png/jpg/jpef格式，大小為170px * 220 px</div>
		<form method="post" id="category_form" action="./action.php?act=edit&type=<?php echo $type ; ?>&id=<?php echo $id; ?>">
			<table class="table table-bordered table-hover">
				<tr><td width="20%">名稱： </td><td> <input type="text"  maxlength="35" name="category_name" value="<?php echo $category['category_name'] ;?>"></td></tr>
				<tr><td width="20%">所屬類別名稱： </td><td> <?php echo $category['categoryarea_name'] ;?></td></tr>
				<tr>
					<td>排序： </td>
					<td> <input type="text" maxlength="3" name="category_priority" value="<?php echo $category['category_priority'] ; ?>"> <span style="color:red;">範圍 1 ~ 255</span></td>
				</tr>
				<tr>
					<td>狀態：  </td>
					<td>
						<?php 
						if($category['category_status'] == 'open'){
							echo '<input type="radio" value="open" checked name="status"> Open   ';
							echo '<input type="radio" value="close" name="status"> Close ';
						}elseif($category['category_status'] == 'close'){
							echo '<input type="radio" value="open" name="status"> Open   ';
							echo '<input type="radio" value="close" checked name="status"> Close';
						}else{
							echo 'Lock';
						}
						?>
					</td>
				</tr>
				<tr>
					<td>介紹：  </td>
					<td> <input class="form-control" name="category_description" maxlength="100" type="text" value="<?php echo $category['category_description']; ?>" placeholder="說明文字"> </td>
				</tr>
				<tr>
					<td rowspan="2">封面：</td>
					<td> 
						<div class="img_area" style="border:0px red solid;width:400px;height:350px;">
							<div class="img_show"><img onclick="$('#fileupload').trigger('click');" src="<?php echo ADMIN_IMG_UPLOAD.$type.'/'.$category['category_cover']; ?>" style="width:240px;height:320px;"></div>
							<span class="img_info">  </span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<input type="file" style="display:none;" id="fileupload" name="files" accept="image/png,image/jpg,image/jpeg"  />
						<input type="button" name="open_file" class="btn btn-success" value="上傳檔案" onclick="$('#fileupload').trigger('click');">
						<input type="text" id="cover" name="category_cover" style="display:none;" value="<?php echo $category['category_cover'];?>">
					</td>
				</tr>
				<tr><td>新增時間：  </td><td> <?php echo $category['category_insertime']; ?> </td></tr>
				<tr><td>修改時間：  </td><td> <?php echo $category['category_modify_time'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;By    '.$category['category_modify_name']; ?>  </td></tr>
				<tr><td>刪除項目：  </td><td> <button type="button" onclick="delete_item('<?php echo $type ;?>', <?php echo $id ; ?>)" class="btn btn-danger">刪除</button>  </td></tr>
			</table>
			<input type="submit" style="width:200px" onclick="return check_form(this.form.id)"  class="btn btn-primary" name="key_btn" value="送出修改">
			<span id="loadbar" style="display:none;"><img src="<?php echo URL_IMG_ROOT.'loader.gif' ?>"> </span>
			<button type="button" onclick="history.back()" class="btn btn-warning">取消</button>
		</form>
		<div id="del_form"></div>
	
	
	<?php
		return;
	}
	
	if($type == 'product'){ 
		$query = 'select * from product where product_id = '.$id.';';
		$query = query_despace($query);
		$result = mysql_query($query);
		if (mysql_num_rows($result) < 1) js_location(URL_ADMIN_ROOT.'product');	
		$product = array();
		while($row=mysql_fetch_array($result)){
			$product['product_id'] = $row['product_id'];
			$product['product_category_id'] = $row['product_category_id'];
			$product['product_name'] = $row['product_name'];
			$product['product_cover'] = $row['product_cover'];
			$product['product_status'] = $row['product_status'];
			$product['product_priority'] = $row['product_priority'];
			$product['product_model'] = $row['product_model'];
			$product['product_standard'] = $row['product_standard'];
			$product['product_material'] = $row['product_material'];
			$product['product_produce_time'] = $row['product_produce_time'];
			$product['product_lowest'] = $row['product_lowest'];
			$product['product_description'] = $row['product_description'];
			$product['product_memo'] = $row['product_memo'];
			$product['product_inserttime'] = $row['product_inserttime'];
			$product['product_admin'] = $row['product_admin'];
			$product['product_modify_time'] = $row['product_modify_time'];
			$product['product_modify_name'] = $row['product_modify_name'];
			$product['product_material'] = $row['product_material'];
			$product['product_content'] = $row['product_content'];

		}

		//取得area 且open
		$query = 'select * from categoryarea where categoryarea_status = "open" order by categoryarea_priority asc;';
		$query = query_despace($query);
		$result = mysql_query($query);
		$category = array();
		$n = 0;
		while($row=mysql_fetch_array($result)){
			$category[$n]['categoryarea_id'] = $row['categoryarea_id'];
			$category[$n]['categoryarea_name'] = $row['categoryarea_name'];
			$n++;
		}

		//用area取得category
		foreach($category as $k => $v){
			$category[$k]['category'] = array();
			$n = 0;
			$query = 'select * from category where category_status = "open" and categoryarea_id = "'.$v['categoryarea_id'].'" order by category_priority asc;';
			$query = query_despace($query);
			$result = mysql_query($query);
			while($row=mysql_fetch_array($result)){
				$category[$k]['category'][$n]['id'] = $row['category_id'];
				$category[$k]['category'][$n]['name'] = $row['category_name'];
				$n++;
			}
		}

	?>
		<div class="page_title">修改產品</div><hr>
		<div class="admin_tips">1.強烈建議先至[產品SEO優化介面]編輯此產品的SEO標籤內容，讓搜尋引擎能收錄此產品完整訊息<br>2.圖片建議上傳png/jpg/jpef格式，大小為170px * 220 px</div>
		<form method="post" action="./action.php?act=edit&type=<?php echo $_GET['type'] ; ?>&id=<?php echo $id; ?>" id="product_form">
			<table class="table-bordered table-hover" data-page-size="20">
				<tr>
					<td style="text-align:right" class="info product_add_table_td">名稱：</td>
					<td> <input class="form-control" name="product_name" maxlength="35" type="text" value="<?php echo $product['product_name'] ; ?>" placeholder="產品名稱"> </td>
					<td style="text-align:right" class="info product_add_table_td">優先序：</td>
					<td> <input class="form-control" maxlength="3" name="product_priority" type="text" value="<?php echo $product['product_priority'] ; ?>" placeholder="數值範圍 : 1 ~ 255"> </td>
				</tr>
				<tr>
					<td style="text-align:right" class="info product_add_table_td">型號：</td>
					<td> <input class="form-control" maxlength="40" name="product_model" type="text" value="<?php echo $product['product_model'] ; ?>" placeholder="產品型號"> </td>
					<td style="text-align:right" class="info product_add_table_td">規格：</td>
					<td> <input class="form-control" maxlength="30" name="product_standard" type="text" value="<?php echo $product['product_standard'] ; ?>" placeholder="產品規格"> </td>
				</tr>
				<tr>
					<td style="text-align:right" class="info product_add_table_td">材質：</td>
					<td> <input class="form-control" maxlength="30" name="product_material" type="text" value="<?php echo $product['product_material'] ; ?>" placeholder="產品材質"> </td>
					<td style="text-align:right" class="info product_add_table_td">生產時間：</td>
					<td> <input class="form-control" maxlength="10" name="product_produce_time" type="text" value="<?php echo $product['product_produce_time'] ; ?>" placeholder="生產所需時間"> </td>
				</tr>
				<tr >
					<td  style="text-align:right" class="info product_add_table_td">最低訂量：</td>
					<td> <input class="form-control" maxlength="8" name="product_lowest" type="text" value="<?php echo $product['product_lowest'] ; ?>" placeholder="產品最低訂量"> </td>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td style="text-align:right" class="info product_add_table_td">所屬類別：</td>
					<td> 
						<select id="product_belong_category" name="category_id">
							<option value="0">請選擇所屬類別 </option>
							<?php 
								foreach($category as $k => $v){
									echo '<optgroup label="'.$v['categoryarea_name'].'">';
									foreach($v['category'] as $k2 => $v2){
										if($product['product_category_id'] == $v2['id']){
											echo '<option value="'.$v2['id'].'" selected="selected">'.$v2['name'].' </option>';
										}else{
											echo '<option value="'.$v2['id'].'" >'.$v2['name'].' </option>';
										}
									}	
									echo '</optgroup>';
								}
							?>
						</select>
					</td>
					<td style="text-align:right" class="info product_add_table_td">狀態：</td>
					<td>
						<?php 
						if($product['product_status'] == 'open'){
							echo '<input type="radio" value="open" checked name="status"> Open   ';
							echo '<input type="radio" value="close" name="status"> Close ';
						}elseif($product['product_status'] == 'close'){
							echo '<input type="radio" value="open" name="status"> Open   ';
							echo '<input type="radio" value="close" checked name="status"> Close';
						}else{
							echo 'Lock';
						}
						?>
					</td>
				</tr>
				<tr>
					<td style="text-align:right" class="info product_add_table_td">介紹：</td>
					<td colspan="3"> <input class="form-control" name="product_description" maxlength="100" type="text" value="<?php echo $product['product_description']; ?>" placeholder="說明文字"> </td>
				</tr>
				<tr>
					<td style="text-align:right" class="info product_add_table_td">備註：</td>
					<td colspan="3"> <textarea rows="5" cols="50" name="product_memo" style="resize:none;"><?php echo $product['product_memo'] ; ?> </textarea> </td>
				</tr>
				<tr>
					<td style="text-align:right" class="info product_add_table_td">內文：</td>
					<td colspan="3"> 
						<textarea rows="10" cols="30" name="product_content" class="ckeditor" id="about_value"><?php echo $product['product_content']; ?></textarea>
						<script type="text/javascript">CKEDITOR.replace('about_value',
							{
								toolbar : 'Full'
							});
						</script>  
					</td>
				</tr>
				<tr>
					<td rowspan="2" style="text-align:right" class="info product_add_table_td">封面：</td>
					<td colspan="3"> 
						<div class="img_area" style="border:0px red solid;width:400px;height:310px;">
							<div class="img_show"><img onclick="$('#fileupload').trigger('click');" style="width:250px;height:300px;" src="<?php echo ADMIN_IMG_UPLOAD.$type.'/'.$product['product_cover']; ?>"></div>
							<span class="img_info">  </span>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<input type="file" style="display:none;" id="fileupload" name="files" accept="image/png,image/jpg,image/jpeg"  />
						<input type="button" name="open_file" class="btn btn-success" value="上傳檔案" onclick="$('#fileupload').trigger('click');">
						<input type="text" id="cover" name="product_cover" style="display:none;" value="<?php echo $product['product_cover'];?>">
					</td>
				</tr>
				<tr><td>修改時間：  </td><td colspan="3"> <?php echo $product['product_modify_time'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;By   '.$product['product_modify_name']; ?>  </td></tr>
				<tr>
					<td>編輯：</td>
					<td colspan="2">
						<input type="submit"  onclick="return check_form(this.form.id)" name="key_btn"  class="btn btn-primary" style="width:200px" value="確定修改"> 
						<span id="loadbar" style="display:none;"><img src="<?php echo URL_IMG_ROOT.'loader.gif' ?>"> </span>
						<button type="button" onclick="history.back()" class="btn btn-warning">取消</button>				
					</td>
					<td style="text-align:right"> <button onclick="delete_item('<?php echo $type ;?>', <?php echo $id ; ?>)" type="button" class="btn btn-danger">刪除產品</button> </td>
				</tr>
	
			</table>
		</form>
		<div id="del_form"></div>
	<?php 
		return;
	}
	
	
	
  }
  //edit end
 
  //編輯標籤的view
  if($act == 'tags'){
	echo '<div class="page_title">產品標籤管理</div><hr>';
	$query = 'select * from product where product_id = '.$_GET['id'].';';
	$query = query_despace($query);
	$result = mysql_query($query);
	if (mysql_num_rows($result) < 1) js_location(URL_ADMIN_ROOT.'product');	
	while($row=mysql_fetch_array($result)){
		$product_name = $row['product_name'];
		$product_tags = json_decode($row['product_tags']);
	}
	
	echo '<div>產品名稱:<span  class="product_name">'.$product_name.'</span></div><br>' ;
 
	echo '<input type="button" onclick="add_tags()" value="新增欄位" class="btn btn-success">&nbsp;&nbsp;
			<input type="button" onclick="edit_tags()" value="送出" class="btn btn-primary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>';
	?>

	<div id="tag_area">
		<ul>
			<?php 
			if(!empty($product_tags) && $product_tags != ''){
				foreach($product_tags as $k =>$v){	
					echo '<li><input type="input" name="tag" maxlength="20" value="'.$v.'"> <input type="button" onclick="del(this)" class="btn btn-default" value="刪除"></li>';
				}
			}else{
				echo '<li><input type="input" name="tag" maxlength="20"> <input type="button" onclick="del()" class="btn btn-default" value="刪除"></li>';
			}
			
			?>
		</ul>
		<input type="button" onclick="history.back()" value="取消" class="btn btn-warning">
	</div>

	
	<?php

  }

  //編輯Description的view
  if($act == 'description'){
	echo '<div class="page_title">產品描述</div><hr>';
	
	$query = 'SELECT `product`.`product_name` ,`product`.`product_category_id` ,`product_meta`.*, `category`.`category_name`  FROM `product_meta` LEFT JOIN `product` USING(`product_id`)  LEFT JOIN `category` ON `product`.`product_category_id` = `category`.`category_id` ;';
	$query = query_despace($query);
	$result = mysql_query($query);
	if (mysql_num_rows($result) < 1) {
		echo '目前沒有產品資料';
		exit;
	}
	$n = 0;
	$category_option = array();
	while($row=mysql_fetch_array($result)){
		$product[$n]['id'] = $row['product_id'];
		$product[$n]['name'] = $row['product_name'];
		$product[$n]['description'] = $row['description'];
		$product[$n]['modifytime'] = $row['modifytime'];
		$product[$n]['modifyid'] = $row['modifyid'];
		$product[$n]['category_name'] = $row['category_name'];
		
		if(!in_array($row['category_name'], $category_option)){
			$category_option[] = $row['category_name'];
		}
		
		$n++;
	}
	?>
		Search: <input id="filter" type="text"/>&nbsp;&nbsp;&nbsp;
		項目搜尋: <select class="filter-status">
		<option value=""></option>
		<?php 
			if(!empty($category_option)){
				foreach($category_option as $v ){
					echo '<option value="'.$v.'">'.$v.'</option>';
				}
			}
		?>
		</select>
		<br><br>
		<table class="footable metro-blue" data-page-size="10" data-filter="#filter" data-filter-text-only="true">
			<thead>
				<tr>
					<th>產品名稱 </th>
					<th>項目名稱 </th>
					<th>SEO描述</th>
					<th>更新</th>
					<th data-hide="phone,tablet">修改時間</th>
				</tr>
			</thead>
		<tbody>
			<tr>
			<?php
				foreach($product as $k => $v){
					echo '<tr><td class="_this_name">'.$v['name'].'</td><td>'.$v['category_name'].'</td>
						<td style="text-align:center"><textarea style="resize:none;" cols="60" name="description">'.$v['description'].'</textarea></td>
						<td><input class="btn btn-primary" tag="'.$v['id'].'" type="button" onclick="edit_description(this)" value="update"></td>
						<td>'.$v['modifytime'].'</td></tr>';
				}
			?>
			</tr>
		</tbody>
			<tfoot>
				<tr>
					<td colspan="7">
						<div class="pagination pagination-centered"></div>
					</td>
				</tr>
			</tfoot>
		</table>
	<?php 
	}
?>

  
