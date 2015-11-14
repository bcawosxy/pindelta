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


