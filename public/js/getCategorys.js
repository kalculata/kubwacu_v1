$(document).ready(function(){
	$('.site-nav-i').css('display','none');
		$.ajax({
			url : '/getCategorys',
			dataType : 'json',
		}).done(function(data){
			data.forEach( function(data, key) {
				var category =
					'<li><a href="/category/'+data.name+'" class="site-nav-i"><i class="'+data.logotype+'"></i><span>'+data.name+'</span></a></li>';
				$('#site-nav-l').append(category);
				var footer_category =
					'<li><a href="/category/'+data.name+'" class="link"><span>'+data.name+'</span></a></li>'
				$('#footer-categorys-links-c').append(footer_category);
			});
		$('.site-nav-i').css('display','block');
	});
});