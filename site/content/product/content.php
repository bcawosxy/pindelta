<?php 
//項目的方塊
if($nav['show_type']=='category'){ ?>
	<div id="product_content">
	<?php 
		if(is_array($category)){
			foreach($category as $k => $v){
				echo '<a class="product_show" href="./?goods='.base64_encode($nav['categoryarea_id']).'&category='.base64_encode($v['id']).'">
					<div class="product_area">
						<div class="product_show_img">
							<img width="170px" height="220px" src="'.$v['category_cover'].'">
						</div>
						<hr>
						<div class="product_show_title">
							'.$v['name'].'
						</div>
						<div class="product_show_intro">
							'.$v['category_description'].'
						</div>
					
					</div>
				</a>';
			}
		}
	++$g_pages;
	?>
	
	<div id="next"><a href="<?php echo '?goods='.base64_encode($nav['categoryarea_id']).'&pages='.$g_pages ;?>"></a></div>			
	</div>
<?php }?>


<?php 
	//產品的方塊
	if($nav['show_type'] == 'items'){ ?>
	<div id="product_content">
		<?php 
		if($product == null || !empty($product) || $product != ''){
			foreach($product as $k => $v){
				if($v['id'] === null) {
					echo '<a class="product_show" href="javascript:void(0)">';
				}else{
					echo '<a class="product_show" href="./?goods='.base64_encode($nav['categoryarea_id']).'&category='.base64_encode($nav['category_id']).'&items='.base64_encode($v['id']).'">';
				}
					echo '<div class="product_area">
						<div class="product_show_img">
							<img width="170px" height="220px" src="'.$v['cover'].'">
						</div>
						<hr>
						<div class="product_show_title">
							'.$v['name'].'
						</div>
						<div class="product_show_intro">
							'.$v['description'].'
						</div>
					
					</div>
				</a>';
			}
		}
		++$g_pages;
		?>

	<div id="next"><a href="<?php echo '?goods='.base64_encode($nav['categoryarea_id']).'&category='.base64_encode($nav['category_id']).'&ajax=true&pages='.$g_pages; ?>"></a></div>	
	</div>
	<?php } ?>
	
<?php if($nav['show_type'] == 'items_content'){ ?>
	
	<div id="items">
		<div class="items_title">
			<div class="title_name"><?php echo $product['product_name'] ?></div><br>
			<div <?php echo $social_class ;?> >
				<div class="social-likes" data-url="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" data-title="<?php echo $_this_name; ?>" >
					<div class="facebook" title="Share link on Facebook">Facebook</div>
					<div class="twitter" title="Share link on Twitter">Twitter</div>
					<div class="plusone" title="Share link on Google+">Google+</div>
					<div class="pinterest" title="Share image on Pinterest" data-media="">Pinterest</div>
				</div>
			</div>
		</div>
		<div class="items_head">
			<div class="items_img"> 
				<a href="<?php echo ADMIN_IMG_UPLOAD.'product/'.$product['product_cover']; ?>" title="<?php echo $product['product_name'] ?>" data-jbox-image="gallery2">
					<img width="250px" height="300px" src="<?php echo ADMIN_IMG_UPLOAD.'product/'.$product['product_cover']; ?>"> 
				</a>
			</div>
			
			<div class="itmes_info">
				<div style="font-family:Arial, 微軟正黑體;"> 
					<?php echo $product['product_description'] ?>
				</div>
				<hr style="margin:8px 0px">
				<ul>
					<li><span class="info">Item Number：</span><span class="text"><?php echo $product['product_model'] ?> </span></li>
					<?php 
						if(!empty($product['product_standard'])|| $product['product_standard'] != ''){
							echo '<li><span class="info">Size：</span><span class="text">'.$product['product_standard'].'</span></li>';
						}
					?>					
					<li><span class="info">Material：</span><span class="text"><?php echo $product['product_material'] ?> </span></li>
					<li><span class="info">Production Time：</span><span class="text"><?php echo $product['product_produce_time'] ?> </span></li>
					<li><span class="info">MOQ：</span><span class="text"><?php echo $product['product_lowest'] ?> </span><img id="tip" width="14" height="14" src="<?php echo URL_IMG_ROOT.'question_mark2.png'; ?>"></li>
					<li><span class="info">Memo：</span><br><textarea rows="10" cols="50" style="resize:none; font-size:13px; font-weight: 500;   font-family: Microsoft YaHei;" readonly><?php echo $product['product_memo'] ?></textarea></li>
				</ul><br><br><br><br><br>
				<input id="items_return_btn" type="button" value="Request Quote" style="width:100%;" class="btn btn-warning">
			</div>
			<div class="items_return">
				<table class="table table-bordered">
					<caption>Request Info (<span style="color:red">*</span>Required field)</caption>
					<tbody class="inquiry_table">
						<tr>
							<td colspan="">
								<span style="color:red">＊</span>First Name：<br>
								<input type="text" name="first_name" class="form-control" id="name">
							</td>
							<td colspan="">
								<span style="color:red">＊</span>Last Name：<br>
								<input type="text" name="last_name" class="form-control" id="name">
							</td>
							<td colspan="">
								<span style="color:red">＊</span>E-mail：<br>
								<input type="text" name="email" class="form-control" id="name"> 
							</td>
						</tr>
						<tr>
							<td colspan="">
								<span style="color:red">＊</span>Quantity：<br>
								<input type="text" name="quantity" class="form-control" id="name">
							</td>
							<td colspan="">
								<span style="color:red">＊</span>Country：<br>
								<input type="text" name="country" class="form-control" id="name">
							</td>
							<td colspan="">
								<span style="color:red"></span>Company：<br>
								<input type="text" name="company" class="form-control" id="name"> 
							</td>
						</tr>
						<tr>
							<td colspan="2">Website：<input type="text" name="website" class="form-control" id="name"> </td>
							<td>
								Logo Request：							
							   <label>
								  <input type="radio" name="logo" id="optionsRadios1" value="false" checked> No
							   </label>
								　
							   <label>
								  <input type="radio" name="logo" id="optionsRadios2" value="true"> Yes
							   </label>		
							</td>
						</tr>
						<tr>
						</tr>
						<tr>
							<td colspan="3">
								Message：<br>
								<textarea style="resize:none;" name="memo" rows="5" cols="80"> </textarea>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								Please enter the Verification Code: <input maxlength="5" style="width:60px;" name="captcha_code" type="text" >
									<?php echo '<img width="80" height="40" src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code">';?>
							</td>
							<td align="right" colspan="0"> 
								<input style="right:0;" type="button" id="send_btn" onclick="send_contact()" value="Submit" class="btn btn-primary">
								<div style="display:none;" class="loading_bar"><img src="<?php echo URL_IMG_ROOT.'loader.gif' ?>" ></div>
							</td>
						</tr>
						<tr style="display:none;"><td><div style="display:none;" id="inquiry_form"></td></tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="items_body">
			<?php echo htmlspecialchars_decode($product['product_content']); ?>
		</div>
		
		<div class="items_tag">
			<ul>
				<li><img width="24px" height="24px" src="<?php echo URL_IMG_ROOT.'tag2.png' ?>"></li>
				<li class="tags_title">
					<?php 
						if(!empty($product['product_tags'])){
							foreach(json_decode($product['product_tags']) as $k => $v){
								echo '<a href="javascript:void(0)">'.$v.'</a>&nbsp;';
							}
						}
					?>
				</li>
				
			</ul>
		</div>
	</div>
	
	
<?php } ?>


<script>

new jBox('Image');
$(document).ready(function() {
	$('#tip').jBox('Tooltip', {
	position: {
		x: 'right',
		y: 'center'
	},
	outside: 'x' ,
	content: '<span style="color:red;font-size:12px;">Min. Order Quantity。</span>'
	});

});

var ias = $.ias({
	container:  ('#product_content'),
	item:       '.product_show',
	pagination: '#next',
	next:       '#next a'
});

ias.extension(new IASSpinnerExtension());
ias.extension(new IASTriggerExtension({
	offset : 1 ,
	text : 'more...',
}));

ias.on('loaded', function(data, items) {
   	$(items).hover(function(){
		$(this).find('div.product_area').css('border-color','#F7931D').find('.product_show_intro').css('color','#303030');
	},function(){
		$(this).find('div.product_area').css('border-color','white').find('.product_show_intro').css('color','#9A9A9A');
	});

});


$('.items_return').hide();
$('.product_area').hover(function(){
	$(this).css('border-color','#F7931D').find('.product_show_intro').css('color','#303030');
},function(){
	$(this).css('border-color','white').find('.product_show_intro').css('color','#9A9A9A');
});

$('#items_return_btn').click(function(){
	$('.items_return').fadeToggle( "slow" );

});
	
function send_contact(){
	var obj = $('.inquiry_table');
	$('.loading_bar').css('display', 'block');
	$('#send_btn').css('display', 'none');
	
	$.post('<?php echo URL_ROOT.'ajax/inquiry.php?act=add'?>', {
	<?php if(!empty($nav['product_id']) && $nav['product_id'] != '') echo '	product_id : '.$nav['product_id'].','; ?>
		first_name : obj.find('input[name=first_name]').val(),
		last_name : obj.find('input[name=last_name]').val(),
		email : obj.find('input[name=email]').val(),
		quantity : obj.find('input[name=quantity]').val(),
		country : obj.find('input[name=country]').val(),
		company : obj.find('input[name=company]').val(),
		website : obj.find('input[name=website]').val(),
		logo : obj.find('input[name=logo]:checked').val(),	
		memo : obj.find('[name=memo]').val(),
		code : obj.find('input[name=captcha_code]').val(),

	}, function(r) {
		r = JSON.parse(r);
		if(r.result == 1){
			// jbox_success('', '<?php echo URL_ROOT.'product/?goods='.base64_encode($nav['categoryarea_id']).'&category='.base64_encode($nav['category_id']).'&items='.base64_encode($nav['product_id']) ?>');
			var modal = new jBox('Modal', {
					delayOpen : 300,
					content : '<img width="30" height="30" src="<?php echo $URL_IMG_ROOT.'success.png' ?>"><span style="color:#108199; font-size:18px; font-family:微軟正黑體; font-weight:bold;">You have sent Request Quote, Thank you!</span>',
					onCloseComplete : function(){
						$('#inquiry_form').append(r.data);
						$('#inquiry_btn').click();
					}
				});
			modal.open();	
		}else if(r.result == 2){
			jbox_error('ValidateCode error。', 'javascript:void(0)');
		}else if(r.result == 3){
			jbox_error('You have sent Request Quote within 10 minutes', 'javascript:void(0)');
		}else if(r.result == 4){
			jbox_error('Sorry! something error...。', 'javascript:void(0)');
		}else{
			jbox_error('Please check Required field again', 'javascript:void(0)');
		}
		$('.loading_bar').css('display', 'none');
		$('#send_btn').css('display', 'block');
	});
	
	return false;

}

</script>