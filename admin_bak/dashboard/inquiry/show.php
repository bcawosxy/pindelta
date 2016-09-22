	<div class="page_title">產品詢價 - 列表[Active]</div><hr>
	<!--<div class="admin_tips">123</div>-->
	<?php 
		$query = 'select * from `inquiry` where status = "open" order by `inserttime` desc;';
		$query = query_despace($query);
		$result = mysql_query($query);
		$inquiry = array();
		$num = 1 ;
		while($row=mysql_fetch_array($result)){
			$inquiry[$num]['id'] = $row['id'];
			$inquiry[$num]['first_name'] = $row['first_name'];
			$inquiry[$num]['last_name'] = $row['last_name'];
			$inquiry[$num]['company'] = $row['company'];
			$inquiry[$num]['status'] = $row['status'];
			$inquiry[$num]['read'] = $row['read'];
			$inquiry[$num]['inserttime'] = $row['inserttime'];
			$num++;
		}

	
	?>
	Search: <input id="filter" type="text"/>&nbsp;&nbsp;&nbsp;<a class="btn btn-link" href="<?php echo URL_ADMIN_ROOT.'inquiry?act=index' ?>">[Issue List]</a>&nbsp;&nbsp;&nbsp;
		<a class="btn btn-link" href="<?php echo URL_ADMIN_ROOT.'inquiry?act=archive' ?>">[Archive box]</a><br><br>
	<table class="footable metro-blue" data-page-size="20" data-filter="#filter" data-filter-text-only="true">
		<thead>
			<tr>
				<th>姓</th>
				<th>名</th>
				<th>公司名稱</th>
				<th>時間</th>
				<th>狀態</th>
				<th>查看</th>
			</tr>
		</thead>
	<tbody>
	<?php 
	foreach($inquiry as $k => $v){
		$class = ($v['read'] == 'read') ? 'class="status-metro status-disabled" title="Disabled"' : 'class="status-metro status-active" title="Active"';
		echo '<tr>';
		echo 	'<td>'.$v['last_name'].'</td>
				<td>'.$v['first_name'].'</td>
				<td>'.$v['company'].'</td>
				<td>'.$v['inserttime'].'</td>
				<td style="width:100%;text-align:center;" '.$class.'>'.strtoupper($v['read']).'</td>
				<td><a href="'.URL_ADMIN_ROOT.'inquiry?act=detail&id='.$v['id'].'">詳細 </a></td>';
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
