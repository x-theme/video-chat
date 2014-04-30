$(function(){
	$(".link.log.not_logged_in").click(function(){
		$(".login_triangle").toggle();
		$(".drop_down_login").toggle();
	});
	
	var log_timeout;
	
	$(".link.log.logged_in").mouseenter(function(){
		clearTimeout( log_timeout );
		$(".login_triangle.logged_in").show();
		$(".drop_down_login.logged_in").show();
	});
		
	$(".link.log.logged_in").mouseleave(function(){
		log_timeout = setTimeout(function(){
				$(".login_triangle.logged_in").hide();
				$(".drop_down_login.logged_in").hide();				
			}, 300);
	});
	
	$(".drop_down_login.logged_in").mouseenter(function(){
		clearTimeout( log_timeout );
	});
	
	$(".drop_down_login.logged_in").mouseleave(function(){
		log_timeout = setTimeout(function(){
				$(".login_triangle.logged_in").hide();
				$(".drop_down_login.logged_in").hide();				
			}, 300);		
	});
});