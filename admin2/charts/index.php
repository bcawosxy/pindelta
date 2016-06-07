<!DOCTYPE html>
<html>
<?php include('../head.php'); ?>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
	<?php include('../header.php'); ?>
	<?php include('../navbar.php'); ?>
	<?php 
		/**
		 * 圖表一 : 逐周的量表
		 */
		//本周最後一天(星期日)
		$this_week = date('Y-m-d', strtotime('+7 day', time()-86400*date('w')));
		$series_line = []; $rate = 7;
		for($i=1; $i<13; $i = $i+1) {$tmp[] = date('Y-m-d 23:59:59', strtotime('-'.($i*$rate).' day', strtotime($this_week)));}
		array_unshift($tmp,$this_week);
		$week = array_reverse($tmp);
		
		foreach ($week as $k0 => $v0) {
			/*Categoryarea*/
			$query = 'select COUNT(*) as `count` from `categoryarea` where (`categoryarea_status` != "delete" and `categoryarea_insert_time` < "'.$v0.'") or (`categoryarea_status` = "delete" and `categoryarea_modify_time` > "'.$v0.'");';
			$result = mysql_query($query);
			while($row = mysql_fetch_assoc($result)){	$data_categoryarea[] = $row['count'];	}

			/*Category*/
			$query = 'select COUNT(*) as `count` from `category` where (`category_status` != "delete" and `category_insertime` < "'.$v0.'") or (`category_status` = "delete" and `category_modify_time` > "'.$v0.'");';
			$result = mysql_query($query);
			while($row = mysql_fetch_assoc($result)){	$data_category[] = $row['count'];	}

			/*Product*/
			$query = 'select COUNT(*) as `count` from `product` where (`product_status` != "delete" and `product_inserttime` < "'.$v0.'") or (`product_status` = "delete" and `product_modify_time` > "'.$v0.'");';
			$result = mysql_query($query);
			while($row = mysql_fetch_assoc($result)){	$data_product[] = $row['count'];	}

			$chart_categories[] = '\'~'.date('m/d', strtotime($v0)).'\'';
		}

		$series_line = [
			['name'=>'Categoryarea', 'data'=>implode(',', $data_categoryarea)],
			['name'=>'Category', 'data'=>implode(',' ,$data_category)],
			['name'=>'Product', 'data'=>implode(',' ,$data_product)],
		];


		/**
		 * 圖表二 : 各類別下項目及產品數量
		 */
		$a_categoryarea_id = []; $series_pie = []; 
		$query_1 = 'SELECT `categoryarea`.`categoryarea_id`, `categoryarea`.`categoryarea_name`, `category`.`category_id` FROM `categoryarea` LEFT JOIN `category` USING ( `categoryarea_id` ) WHERE `category_id` != ""  AND `categoryarea`.`categoryarea_status` != "delete" AND `category`.`category_status` != "delete" GROUP BY `categoryarea_id`';
		$result = mysql_query($query_1);
		while($row = mysql_fetch_assoc($result)){ $categoryarea_id[] = $row; }
		//所有的categoryarea_id
		foreach ($categoryarea_id as $k0 => $v0) {
			$pie_data = [];$category_num=0;$prodcut_num=0;
			$query_2 = 'SELECT `category_name` as name , COUNT(`category_id`) as y FROM `category` LEFT JOIN `product` ON `product`.`product_category_id` = `category`.category_id WHERE `category`.`category_status` != "delete" AND `product`.`product_status` != "delete" AND `category`.categoryarea_id = "'.$v0['categoryarea_id'].'" AND `product_id` != "" GROUP BY `category_id`';
			$result = mysql_query($query_2);
			while($row = mysql_fetch_assoc($result)){
				$pie_data[] = '{name:"'.$row['name'].'", y:'.$row['y'].'},';
				$prodcut_num += $row['y'];
			};

			if(count($pie_data) == 0) continue;
			$series_pie[] = [
				'categoryarea_id' => $v0['categoryarea_id'],
				'categoryarea_name' => $v0['categoryarea_name'],
				'category_num' => count($pie_data),
				'product_num' => $prodcut_num,
				'data' => implode('', $pie_data),
			];
		}
	?>
	
	<div class="content-wrapper" style="height: auto;">
		<section class="content col-lg-11">
			<div class="box">
				<div class="box-header with-border">
					<h3>
						類別 / 項目 / 產品 逐周統計數量
					</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div id="container" style="height: auto; margin: 0 auto;width:95%;"></div>
					</div>
				</div>
				<hr>
				<div class="box-header with-border">
					<h3>
						各類別下的項目 / 產品數量
					</h3>
				</div>
				<div class="box-body">
					<div class="row">
					<?php 
						foreach ($series_pie as $k0 => $v0) {
							echo '<div class="col-md-2" style="margin:10px 0;" >
									<div id="container_'.$v0['categoryarea_id'].'" style="height: 300px; margin: 0 auto"></div>
								</div>';
						}
					?>
					</div>

				</div>
			</div>
		</section>
	</div>
	<?php include('../footer.php'); ?>
</div>
<script>
$(function () {
	 // Build the Line chart
    $('#container').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Product / Category / Categoryarea Info.'
        },
        subtitle: {
            text: 'Count Of Weekly'
        },
        xAxis: {
            categories: [<?php echo implode(',', $chart_categories)?>]
        },
        yAxis: {
            title: {
                text: 'Num.'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        series:[
        	<?php foreach ($series_line as $k0 => $v0) {
        		echo '{name:"'.$v0['name'].'", data : ['.$v0['data'].']},' ;
        	} ?>
        ]
    });

    // Build the Pie chart
	<?php 
		foreach ($series_pie as $k0 => $v0) {
			echo '$(\'#container_'.$v0['categoryarea_id'].'\').highcharts({
		        chart: {
		            plotBackgroundColor: null,
		            plotBorderWidth: null,
		            plotShadow: false,
		            type: \'pie\'
		        },
		        title: {
		            text: \''.$v0['categoryarea_name'].'\'
		        },
		        subtitle: {
		            text: \'Category : '.$v0['category_num'].' <br /> Product : '.$v0['product_num'].'\',
		        },
		        tooltip: {
		           formatter: function() {
		                return \'<b>\' + this.point.name + \'</b><br />Total: \' +Highcharts.numberFormat(this.y, 0) + \'<br />\'  + Highcharts.numberFormat(this.percentage, 1) + \'%\';
		            }

		        },
		        plotOptions: {
		            pie: {
		                allowPointSelect: true,
		                cursor: \'pointer\',
		                dataLabels: {
		                    enabled: false
		                },
		                showInLegend: true
		            },
		        },
		        series: [{
		            name: \'Brands\',
		            colorByPoint: true,
		            data: ['.$v0['data'].']
		        }]
		    });';
		};
	?>

	$('.content-wrapper').css('min-height', <?php echo  600 + floor(count($series_pie)/6)*600 ?>);
});


</script>
</body>
</html>
<?php include('../foot.php') ?>