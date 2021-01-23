$('.most-r-news-footer').css('display','none');
$('#loader').css('display','block');
function getMostRead(){
	$.ajax({
		url:'/getMostRead',
		dataType:'json'
	}).done(function(articles){
		var article_s1=[],article_s2=[];
		var nt1 = 0;
		if(articles.length <=5 ){
			for (var i = 0; i < articles.length; i++){
				article_s1.push( 
					'<div class="most-r-news-i">'+
						'<div class="most-r-new">'+
							'<div class="most-r-new-cover">'+
								'<img src="https://www.kubwacu.com/public/data/mini_cover/'+articles[i]['cover_name']+'">'+
								'<div class="most-r-new-supp-info">'+
									'<span class="place">'+(i+1)+'</span>'+
									'<span class="views"><i class="fas fa-eye"></i>'+(articles[i]['views']-1)+'</span>'+
								'</div>'+
							'</div>'+
							'<div class="most-r-new-info">'+
								'<span class="most-r-new-date"></span>'+
								'<a href="https://www.kubwacu.com/articles/'+articles[i]['title_link']+'?tag='+articles[i]['id']+'" class="most-r-new-title">'+
									'<span>'+articles[i]['title']+'</span>'+
								'</a>'+
							'</div>'+
						'</div>'+
						'<div class="new-category">'+
							'<a href="https://www.kubwacu.com/category/'+articles[i]['category']+'"><span class="category"><i class="'+articles[i]['category_logo']+'"></i>'+articles[i]['category']+'</span></a>'+
							'<a href="https://www.kubwacu.com/category/'+articles[i]['category']+'/'+articles[i]['sub_category']+'"><span class="sub-category">'+articles[i]['sub_category']+'</span></a>'+
						'</div>'+
					'</div>');
			}
			$('#most-r-news-c').append(article_s1.join(''));
			$('#loader').css('display','none');
		}
		else{
			for (var i = 0; i < 5; i++){
				article_s1.push( 
					'<div class="most-r-news-i">'+
						'<div class="most-r-new">'+
							'<div class="most-r-new-cover">'+
								'<img src="https://www.kubwacu.com/public/data/mini_cover/'+articles[i]['cover_name']+'">'+
								'<div class="most-r-new-supp-info">'+
									'<span class="place">'+(i+1)+'</span>'+
									'<span class="views"><i class="fas fa-eye"></i>'+(articles[i]['views']-1)+'</span>'+
								'</div>'+
							'</div>'+
							'<div class="most-r-new-info">'+
								'<span class="most-r-new-date"></span>'+
								'<a href="https://www.kubwacu.com/articles/'+articles[i]['title_link']+'?tag='+articles[i]['id']+'" class="most-r-new-title">'+
									'<span>'+articles[i]['title']+'</span>'+
								'</a>'+
							'</div>'+
						'</div>'+
						'<div class="new-category">'+
							'<a href="https://www.kubwacu.com/category/'+articles[i]['category']+'"><span class="category"><i class="'+articles[i]['category_logo']+'"></i>'+articles[i]['category']+'</span></a>'+
							'<a href="https://www.kubwacu.com/category/'+articles[i]['category']+'/'+articles[i]['sub_category']+'"><span class="sub-category">'+articles[i]['sub_category']+'</span></a>'+
						'</div>'+
					'</div>');
			}
			for (var i = 5; i < (5+(articles.length-5)); i++){
				article_s2.push( 
					'<div class="most-r-news-i">'+
						'<div class="most-r-new">'+
							'<div class="most-r-new-cover">'+
								'<img src="https://www.kubwacu.com/public/data/mini_cover/'+articles[i]['cover_name']+'">'+
								'<div class="most-r-new-supp-info">'+
									'<span class="place">'+(i+1)+'</span>'+
									'<span class="views"><i class="fas fa-eye"></i>'+(articles[i]['views']-1)+'</span>'+
								'</div>'+
							'</div>'+
							'<div class="most-r-new-info">'+
								'<span class="most-r-new-date"></span>'+
								'<a href="https://www.kubwacu.com/articles/'+articles[i]['title_link']+'?tag='+articles[i]['id']+'" class="most-r-new-title">'+
									'<span>'+articles[i]['title']+'</span>'+
								'</a>'+
							'</div>'+
						'</div>'+
						'<div class="new-category">'+
							'<a href="https://www.kubwacu.com/category/'+articles[i]['category']+'"><span class="category"><i class="'+articles[i]['category_logo']+'"></i>'+articles[i]['category']+'</span></a>'+
							'<a href="https://www.kubwacu.com/category/'+articles[i]['category']+'/'+articles[i]['sub_category']+'"><span class="sub-category">'+articles[i]['sub_category']+'</span></a>'+
						'</div>'+
					'</div>');
			}
			$('#most-r-news-c').append(article_s1.join(''));
			$('.most-r-news-footer').css('display','block');
			$('#loader').css('display','none');
			$('#most-r-news-bt-nxt').on('click', function(){
				$('#most-r-news-c').html(article_s2);
			})
			$('#most-r-news-bt-prev').on('click', function(){
				$('#most-r-news-c').html(article_s1);
			})
		}
	})
}
$(document).ready(function(){
	getMostRead();
})
