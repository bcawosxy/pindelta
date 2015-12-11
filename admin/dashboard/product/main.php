<div class="model_all">
  <div class="model_navbar">
    <div class="model_navbar_title">
	  <img src="<?php echo URL_IMG_ROOT.'small_logo.png' ;?>" width="40" height="40">
	  <span><b><a class="nav_headlink" href="<?php echo URL_ADMIN_ROOT ?>">管理後台</a></b></span>
	  <hr>
	</div>
	
	<div class="model_navbar_list">
      <?php include('./../navlist.php'); ?>
	</div>
  </div>
  
  <div class="model_content">
    <?php  include('./data.php'); ?>
  </div>
</div>
<?php $id = (!empty($_GET['id'])) ? $_GET['id'] : null; ?>
<?php $type = (!empty($_GET['type'])) ? $_GET['type'] : null; ?>
<script type="text/javascript">

function delete_item(type, id) {
	switch(type)
	{
		case 'categoryarea':
		  content = '<div style="color:purple; font-size:22px; font-family:微軟正黑體; font-weight:bold;">※刪除資料※</div><div>刪除類別將會連所屬"項目"以及"產品"一併刪除，建議您將狀態調為"關閉"即可將此類別下的所有產品隱藏。</div><div>您確定要刪除此筆資料?</div>';
		  break;
		  
		case 'category':
		  content = '<div style="color:purple; font-size:22px; font-family:微軟正黑體; font-weight:bold;">※刪除資料※</div><div>刪除項目將會連所屬"產品"一併刪除，建議您將狀態調為"關閉"即可將此項目下的所有產品隱藏。</div><div>您確定要刪除此筆資料?</div>';
		  break;
		  
		default:
		  content = '<div style="color:purple; font-size:22px; font-family:微軟正黑體; font-weight:bold;">※刪除資料※</div><div>您確定要刪除此筆產品?</div>';
	};
	
	var modal = new jBox('Confirm', {
			content : content,			
			confirm : function(){
				var new_form = '<form method="POST" action="./action.php?act=delete&type='+type+'&id='+id+'"> <input type="submit" name="key_btn"></form>';
				$('#del_form').append(new_form);
				$('input[name=key_btn]').trigger('click');
			}
		});
	modal.open();	
}

/*新增標籤欄位*/
function add_tags(){
	var target = $('#tag_area>ul');
	var new_tags = '<li><input type="input" name="tag" maxlength="20"> <input type="button" onclick="del()" class="btn btn-default" value="刪除"></li>';
	target.append(new_tags);
}

/*修改標籤欄位*/
function edit_tags() {
	var tag_data = [];
	if($('#tag_area').find('input[name=tag]').length == 0){
		var tag_data = null;
	}else{
		$('#tag_area').find('input[name=tag]').each(function(){
			if($(this).val() != ""){
				tag_data.push($(this).val());
			}
		});
	}

	if(tag_data == ''){
		jbox_error('未填入資料', 'javascript:void(0)');
	}else{
		$.post('<?php echo URL_ROOT.'ajax/tags.php'?>', {
			product_id : '<?php echo $id; ?>',
			tags : tag_data,
			name : $('.product_name').text(),
		}, function(r) {
			if(r == 1){
				jbox_success('修改完成', '<?php echo URL_ADMIN_ROOT.'/product?type=product' ;?>');
			}else{
				jbox_success('修改失敗，請重新輸入。', '<?php echo URL_ADMIN_ROOT.'/product?type=product' ;?>');
			}
		});
	}
}
/*刪除標籤欄位*/
function del() {
	var obj = event.target;
	$(obj).parent('li').remove();
}

/*修改SEO描述*/
function edit_description() {
	var obj = event.target;
	var id = $(obj).attr('tag');
	var text = $(obj).parent('td').prev('td').find('textarea').val();

	$.post('<?php echo URL_ROOT.'ajax/product_description.php'?>', {
		proudct_id : id,
		text : text,
	}, function(r) {
		if(r == 1){
			jbox_success('修改完成', '<?php echo URL_ADMIN_ROOT.'product?act=description' ?>');
		}else{
			jbox_success('修改失敗，請重新輸入。');
		}
	});
	
}

$(document).ready(function(){
	var url = '<?php echo URL_ROOT.'ajax/upload.php?type='.$type; ?>' ;
	$('#fileupload').fileupload({
		url: url,		//上傳處理的PHP
		dataType: 'json',
		//將要上傳的資料顯示
		add: function (e, data) {
			$('#loadbar').css('display', 'inline');
			$('input[name=key_btn]').css('display', 'none');
			// $('div.img_area .img_info').text(data.files[0].name);
			var jqXHR = data.submit();
		},
		//上傳失敗
		fail:function(e, data){
			alert("上傳失敗");
		},
		//單一檔案上傳完成
		done: function (e, data) {
			// $('.img_info').text(data.result.status);
			var img_src = '<?php echo URL_ROOT.'upload/admin/images/'.$type.'/' ; ?>';
			$('.img_show>img').attr('src',img_src + data.result.status);
			$('#cover').attr('value', data.result.status);
		},
		stop: function (e) {
			$('#loadbar').css('display', 'none');
			$('input[name=key_btn]').css('display', 'inline');
		},
	});
	
	// $( "#select1" ).selectmenu();
});

	$('#add_categoryarea').click(function(){
		location.href = './?act=add&type=categoryarea';
	});

	$('#add_category').click(function(){
		location.href = './?act=add&type=category';
	});

	$('#add_product').click(function(){
		location.href = './?act=add&type=product';
	});

    $(function () {
		$('table').footable().bind('footable_filtering', function (e) {
		  var selected = $('.filter-status').find(':selected').text();
		  if (selected && selected.length > 0) {
			e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
			e.clear = !e.filter;
		  }
		});
	
		$('table').trigger('footable_filter', {filter: $('#filter').val()});
    	
		$('.filter-status').change(function (e) {
			e.preventDefault();
			$('table').trigger('footable_filter', {filter: $('#filter').val()});
		});

	});
	

</script>