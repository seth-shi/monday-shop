(function() {

jQuery(function($){
	
	//鼠标悬停信息

	$("#wrap .item").mouseenter(function(){
		$(this).children(".mp_tooltip").animate({left:-92,queue:true});
		$(this).children(".mp_tooltip").css("visibility","visible");
		$(this).children(".ibar_login_box").css("display","block");
	});
	$("#wrap .item").mouseleave(function(){
		$(this).children(".mp_tooltip").css("visibility","hidden");
		$(this).children(".mp_tooltip").animate({left:-121,queue:true});
		$(this).children(".ibar_login_box").css("display","none");
	});
	$(".quick_toggle li").mouseover(function(){
		$(this).children(".mp_qrcode").show();
		$(this).children(".mp_tooltip").animate({left:-92,queue:true});
		$(this).children(".mp_tooltip").css("visibility","visible");
	});
	$(".quick_toggle li").mouseleave(function(){
		$(this).children(".mp_qrcode").hide();
		$(this).children(".mp_tooltip").css("visibility","hidden");
		$(this).children(".mp_tooltip").animate({left:-121,queue:true});		
	});

})
		$(".return_top").click(function(){
			ds.scrollTo(0, 0);
			hideReturnTop();})
})();