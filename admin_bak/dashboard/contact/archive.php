	<div class="page_title">聯繫我們 - 列表[Archive]</div><hr>
	<!--<div class="admin_tips">123</div>-->
	<?php 
		$query = 'select * from contact where status = "archive" order by `inserttime` desc;';
		$query = query_despace($query);
		$result = mysql_query($query);
		$contact = array();
		$num = 1 ;
		while($row=mysql_fetch_array($result)){
			$contact[$num]['id'] = $row['id'];
			$contact[$num]['first_name'] = $row['first_name'];
			$contact[$num]['last_name'] = $row['last_name'];
			$contact[$num]['company'] = $row['company'];
			$contact[$num]['tel'] = $row['tel'];
			$contact[$num]['status'] = $row['status'];
			$contact[$num]['read'] = $row['read'];
			$contact[$num]['inserttime'] = $row['inserttime'];
			$num++;
		}

	
	?>
	Search: <input id="filter" type="text"/>&nbsp;&nbsp;&nbsp;<a class="btn btn-link" href="<?php echo URL_ADMIN_ROOT.'contact?act=index' ?>">[Issue List]</a>&nbsp;&nbsp;&nbsp;
		<a class="btn btn-link" href="<?php echo URL_ADMIN_ROOT.'contact?act=archive' ?>">[Archive box]</a><br><br>
	<table class="footable metro-blue" data-page-size="20" data-filter="#filter" data-filter-text-only="true">
		<thead>
			<tr>
				<th>姓</th>
				<th>名</th>
				<th>電話</th>
				<th>公司名稱</th>
				<th>時間</th>
				<th>查看</th>
			</tr>
		</thead>
	<tbody>
	<?php 
	foreach($contact as $k => $v){
		$class = ($v['status'] != 'read') ? 'class="status-metro status-disabled" title="Disabled"' : 'class="status-metro status-active" title="Active"';
		echo '<tr>';
		echo 	'<td>'.$v['last_name'].'</td>
				<td>'.$v['first_name'].'</td>
				<td>'.$v['tel'].'</td>
				<td>'.$v['company'].'</td>
				<td>'.$v['inserttime'].'</td>
				<td><a href="'.URL_ADMIN_ROOT.'contact?act=detail&id='.$v['id'].'">詳細 </a></td>';
		echo '</tr>';
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
