<div class="model_all">
  <div class="model_navbar">
    <div class="model_navbar_title">
	  <img src="<?php echo URL_IMG_ROOT."small_logo.png" ;?>" width="40" height="40">
	  <span><b><a class="nav_headlink" href="<?php echo URL_ADMIN_ROOT ?>">管理後台</a></b></span>
	  <hr>
	</div>
	
	<div class="model_navbar_list">
      <?php include('./../navlist.php'); ?>
	</div>
  </div>
  
  <div class="model_content">
    <div class="page_title">社群網站連結管理</div><hr>
	<div class="admin_tips">建議輸入完整網址描述，如 http://google.com.tw</div>
	<?php 
		$query = 'select * from sociallink;';
		$query = query_despace($query);
		$result = mysql_query($query);
		$sociallink = array();
		$num = 1 ;
		while($row=mysql_fetch_array($result)){
			$sociallink[$num]['id'] = $row['id'];
			$sociallink[$num]['name'] = $row['name'];
			$sociallink[$num]['status'] = $row['status'];
			$sociallink[$num]['url'] = $row['url'];
			$sociallink[$num]['sort'] = $row['sort'];
			$sociallink[$num]['modifytime'] = $row['modifytime'];
			$num++;
		}

	
	?>
	<table class="footable metro-blue" data-page-size="10" data-filter="#filter" data-filter-text-only="true">
		<thead>
			<tr>
				<th>編號</th>
				<th>開啟</th>
				<th>名稱</th>
				<th>連結</th>
				<th>順序</th>
				<th>修改</th>				
				<th data-hide="phone">最後修改時間</th>
			</tr>
		</thead>
	<tbody>
	<?php 
	foreach($sociallink as $k => $v){
		echo '<tr id="'.$v['name'].'">
			<td class="social_id">'.$v['id'].'</td>';
			echo ($v['status'] == 'open') ? '<td><input type="checkbox" class="social_status" checked="true"></td>' : '<td><input class="social_status" type="checkbox" ></td>';
		echo'<td class="social_name">'.$v['name'].'</td>
			<td><input type="input"  type="url" class="social_url" value="'.urldecode($v['url']).'"></td>
			<td><input type="input" maxlength="2" style="width:30px;" class="social_sort" value="'.$v['sort'].'"></td>
			<td><input type="button" class="btn btn-primary" onclick="edit(\''.$v['name'].'\')" value="Update"></td>';

		echo '<td>'.$v['modifytime'].'</td>
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
  </div>
</div>
<script>
function edit(name) {
	var target = $('#'+name);
	var id = target.find('.social_id').text();
	var status = target.find('.social_status').prop("checked");
	var url = target.find('.social_url').val();
	var sort = target.find('.social_sort').val();
	
	if(status == true) {
		status = 'open';
	}else{
		status = 'close';
	}
	

	$.post('<?php echo URL_ROOT.'ajax/social.php'?>', {
		id : id,
		name : name,
		status : status,
		url : url,
		sort : sort,
	}, function(r) {
		if(r == 1){
			jbox_success('修改完成', '<?php echo URL_ADMIN_ROOT.'sociallink' ?>');
		}else{
			jbox_success('修改失敗，請重新輸入。', '<?php echo URL_ADMIN_ROOT.'sociallink' ?>');
		}
	});

};

$(document).ready(function(){
	
});
</script>






















