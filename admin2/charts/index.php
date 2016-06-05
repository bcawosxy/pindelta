<!DOCTYPE html>
<html>
<?php include('../head.php'); ?>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
	<?php include('../header.php'); ?>
	<?php include('../navbar.php'); ?>
	<?php 
		//本周最後一天(星期日)
		$this_week = date('Y-m-d', strtotime('+7 day', time()-86400*date('w')));
		$series = []; $rate = 7;
		for($i=1; $i<13; $i = $i+1) {$tmp[] = date('Y-m-d 23:59:59', strtotime('-'.($i*$rate).' day', strtotime($this_week)));}
		$week = array_reverse($tmp);
		
		foreach ($week as $k0 => $v0) {
			/*Categoryarea*/
			$query = 'select COUNT(*) as `count` from `categoryarea` where (`categoryarea_status` = "open" and `categoryarea_insert_time` < "'.$v0.'") or (`categoryarea_status` = "close" and `categoryarea_modify_time` > "'.$v0.'");';
			$result = mysql_query($query);
			while($row = mysql_fetch_assoc($result)){	$data_categoryarea[] = $row['count'];	}

			/*Category*/
			$query = 'select COUNT(*) as `count` from `category` where (`category_status` = "open" and `category_insertime` < "'.$v0.'") or (`category_status` = "open" and `category_modify_time` > "'.$v0.'");';
			$result = mysql_query($query);
			while($row = mysql_fetch_assoc($result)){	$data_category[] = $row['count'];	}

			/*Product*/
			$query = 'select COUNT(*) as `count` from `product` where (`product_status` = "open" and `product_inserttime` < "'.$v0.'") or (`product_status` = "open" and `product_modify_time` > "'.$v0.'");';
			$result = mysql_query($query);
			while($row = mysql_fetch_assoc($result)){	$data_product[] = $row['count'];	}

			$chart_categories[] = '\'~'.date('m/d', strtotime($v0)).'\'';
		}

		$series = [
			['name'=>'categoryarea', 'data'=>implode(',', $data_categoryarea)],
			['name'=>'category', 'data'=>implode(',' ,$data_category)],
			['name'=>'product', 'data'=>implode(',' ,$data_product)],
		];
	?>
	
	<div class="content-wrapper">
		<section class="content col-lg-11">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">
					<?php 
						/*title here*/
					?>
					</h3>
				</div>
				<div class="box-body">
					<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
				</div>
			</div>
		</section>
	</div>
	<?php include('../footer.php'); ?>
</div>
<script>
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Product / Category / Categoryarea Info.'
        },
        subtitle: {
            text: 'Unit : Weekly'
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
        	<?php foreach ($series as $k0 => $v0) {
        		echo '{name:"'.$v0['name'].'", data : ['.$v0['data'].']},' ;
        	} ?>
        ]
    });

});
</script>
</body>
</html>
<?php include('../foot.php') ?>