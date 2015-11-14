<div class="contact_all">
	<table style="padding-left:2%;" class="table">
		<caption>
			Want to say hello? Want to know more about us? To inquire about the products and services found on our website, drop us an email and we will get back to you as soon as we can. We'll gladly assist you.
			(<span style="color:red">*</span>Required field)</caption>
		<tbody class="contact_table">
			<tr align="center">
				<td align="left" style="width:25%;"><span style="color:red">＊</span>First Name<br><input maxlength="10" type="text" name="first_name" class="form-control"></td>
				<td align="left" style="width:25%;"><span style="color:red">＊</span><span>Last Name</span><input type="text" maxlength="10" name="last_name" class="form-control"></td>
				<td align="left">E-Mail<br><input type="url" maxlength="20" type="text" name="email" class="form-control"></td>
			</tr>
			<tr align="center">
				 <td colspan="2" align="left"><span style="color:red">＊</span>Phone<br><input type="text" maxlength="15" name="tel" class="form-control"></td>
				 <td align="left">Fax<br><input type="text" maxlength="15" name="fax" class="form-control"></td>
			</tr>
			<tr align="center">
				 <td colspan="3" align="left">Company name<br><input type="text" maxlength="15" name="company" class="form-control"></td>
				 
			</tr>
			<tr align="center">
				 <td colspan="3" align="left"  colspan="2" style="width:8%;">Address<input type="text" maxlength="20"  name="address" class="form-control"></td>
			</tr>
			<tr align="center">
				<td colspan="3" align="left"  colspan="2" style="width:8%;">Message<textarea name="memo" style="resize: none;" class="form-control" cols="60" rows="4"></textarea></td>
			</tr>
			<tr>
				<td align="left"  colspan="2">Please enter the Verification Code：
					<input maxlength="5" style="width:60px;" type="text" name="captcha_code" >
					<?php echo '<img width="80" height="40" src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code">';?>
					
				</td>
				<td align="right" colspan="2"> 
					<input type="button" id="send_btn" onclick="send_contact()" value="Submit" class="btn btn-primary">
					<div style="display:none;" class="loading_bar"><img src="<?php echo URL_IMG_ROOT.'loader.gif' ?>" ></div>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="contact_info">
		<p>
			<span class="title"> Office Info.</span>
		</p>
		<p>
			<span class="name">Phone： </span>
			<span class="text">
				<?php 
					$tmp = array('office_info_phone');
					$t1 = get_settings($tmp); 
					echo $t1['office_info_phone'];
				?> 
			</span>
		</p>
		<p>
			<span class="name">E-mail： </span>
			<span class="text">
				<?php 
					$tmp = array('office_info_email');
					$t1 = get_settings($tmp); 
					echo $t1['office_info_email'];
				?>
			</span>
		</p>
	</div>
</div>
<div style="display:none;" id="contact_form">
</div>
<script>


function send_contact(){
	var obj = $('.contact_table');
	$('.loading_bar').css('display', 'block');
	$('#send_btn').css('display', 'none');
	
	$.post('<?php echo URL_ROOT.'ajax/contact.php?act=add'?>', {
		first_name : obj.find('input[name=first_name]').val(),
		last_name : obj.find('input[name=last_name]').val(),
		tel : obj.find('input[name=tel]').val(),
		fax : obj.find('input[name=fax]').val(),
		company : obj.find('input[name=company]').val(),
		email : obj.find('input[name=email]').val(),
		address : obj.find('input[name=address]').val(),
		memo : obj.find('[name=memo]').val(),
		code : obj.find('input[name=captcha_code]').val(),

	}, function(r) {
		r = JSON.parse(r);
		if(r.result == 1){			
			var modal = new jBox('Modal', {
					delayOpen : 300,
					content : '<img width="30" height="30" src="<?php echo $URL_IMG_ROOT.'success.png' ?>"><span style="color:#108199; font-size:18px; font-family:微軟正黑體; font-weight:bold;">Success . Thank you!</span>',
					onCloseComplete : function(){
						$('#contact_form').append(r.data);
						$('#contact_btn').click();
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