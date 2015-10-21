$(window).ready(function(){

$(".header_menu_nav_fixed").hide();
$(".back_top").hide();

//header menu hover時
$('.header_menu_box>ul>li>a>p').hover(
	function(){
		$(this).addClass('header_menu_select');
	},
	function(){
		$(this).removeClass('header_menu_select');
	}
);

//header menu hover時(fixed bar)
$('.header_menu_nav_fixed>ul>li>a>p').hover(
	function(){
		$(this).addClass('header_menu_select');
	},
	function(){
		$(this).removeClass('header_menu_select');
	}
);

//偵測scorll位置 使fixed bar show
$(window).scroll(function () {
	var scrollVal = $(this).scrollTop();
	
	if(scrollVal > 150){
		$(".header_menu_nav_fixed").show();
		$(".back_top").show();
	}else{
		$(".header_menu_nav_fixed").hide();
		$(".back_top").hide();
	} 
});

//點擊回最上層
$('.back_top').click(
	function(){
		var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
		$body.animate({
			scrollTop: 0
		}, 600);
		return false;
	}
);

$('.header_back_top').click(
	function(){
		var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
		$body.animate({
			scrollTop: 0
		}, 600);
		return false;
	}
);

//header icon
$('.header_banner_right').find('li a img').hover(function(){
	$(this).css('width', '35px');
},function(){
	$(this).css('width', '32px');

});
	
});


function check_login(){  //驗證登入帳號密碼
  if(document.admin_login.login_account.value.length == 0 ){
    document.getElementById("login_account_msg").innerHTML = "請輸入帳號";
    return false;
  }

  if(document.admin_login.login_passwd.value.length == 0 ){
    document.getElementById("login_passwd_msg").innerHTML = "請輸入密碼";
    return false;
  }

  return true;
}

//JS轉址 搭配Jbox OR 直接呼叫
function js_location(url) {
	location.href = url;
}

function check_form(v){
	var reg = /^([a-zA-Z0-9_-{.}])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/; 
	var reg2 =/^[0123456789]+$/;
	var reg3 =/^[a-zA-Z0-9_-]+$/; 
	var reg4 =/^([0])+([9])+([0123456789])+$/ ;
	var reg5 =/^([0123456789])+$/ ;
	var reg6 =/^([0])+([0123456789])+$/ ;
	var reg7 =/^([a-zA-Z])+([a-zA-Z0-9_])+$/ ;
	var reg8 =/\\/ ;
	
	
	if(v == 'categoryarea_form'){
		var name = $('input[name=categoryarea_name]').val();
		var priority = $('input[name=categoryarea_priority]').val();	
		var cover = $('input[name=categoryarea_cover]').val();
		var description = $('input[name=categoryarea_description]').val();
		
		if(name.length<=0 || priority.length<=0 ||  cover.length<=0 || reg8.test(name)==true || reg5.test(priority)==false){
			jbox_error("請輸入正確的資料!");
			return false;
		}
		
		return true;
		
	}	
	
	if(v == 'category_form'){
		var name = $('input[name=category_name]').val();
		var priority = $('input[name=category_priority]').val();
		var categoryarea_id = $('#category_belong_categoryarea :selected').val();
		var cover = $('input[name=category_cover]').val();
		var description = $('input[name=category_description]').val();
		
		if(name.length<=0 || priority.length<=0 || categoryarea_id == "0" || cover.length<=0 ||  reg8.test(name)==true || reg5.test(priority)==false){
			jbox_error("請輸入正確的資料!");
			return false;
		}
		
		return true;
		
	}
	
	if(v == 'product_form'){
		var name = $('input[name=product_name]').val();
		var priority = $('input[name=product_priority]').val();
		var model = $('input[name=product_model]').val();
		var standard = $('input[name=product_standard]').val();
		var material = $('input[name=product_material]').val();
		var produce_time = $('input[name=product_produce_time]').val();
		var lowest = $('input[name=product_lowest]').val();
		var category_id = $('#product_belong_category :selected').val();
		var cover = $('input[name=product_cover]').val();
		var description = $('input[name=product_description]').val();
		
		
		if(name.length<=0 || priority.length<=0 || model.length<=0 || material.length<=0 || produce_time.length<=0 || lowest.length<=0 || category_id == "0" || cover.length<=0 || reg8.test(name)==true || reg5.test(priority)==false){
			jbox_error("請輸入正確的資料!");
			return false;
		}
		
		return true;
	}
}