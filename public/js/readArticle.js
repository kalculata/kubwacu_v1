$(document).ready(function(){
	$('#article-container .loader').css('display','block');
	$.ajax({
		url : 'https://www.kubwacu.com/getArticle/'+article_id,
		dataType :'json'
	}).done(function(article){
			article = 
			'<div class="article-h">'+	
				'<div class="article-title">'+
					'<h1>'+article.title+'</h1>'+
				'</div>'+
				'<div class="article-infos">'+
					'<div class="category-infos">'+
						'<a href="/category/'+article.category+'"><span class="category"><i class="'+article.category_logo+'"></i>'+article.category+'</span></a>'+
						'<a href="/category/'+article.category+'/'+article.sub_category+'"><span class="sub-category">'+article.sub_category+'</span></a>'+
					'</div>'+
					'<div class="supp-infos">'+
						'<span class="author">Par <a href="">'+article.author+'</a></span>'+
						'<div class="article-publishAt">'+
							'<span class="date postAt">Publié '+article.postAt+' </span>'+
							//'<span class="date modifyAt">Mise à jour le 2 juin 2020 à 11h30</span>'+
						'</div>'+	
					'</div>'+
				'</div>'+
			'</div>'+
			'<div class="article-introduction">'+article.introduction+'</div>'+
			'<div class="article-content">'+
				'<div class="article-cover">'+
					'<div id="article-cover">'+
						'<img src="https://www.kubwacu.com/public/data/cover/'+article.cover_name+'" alt="'+article.cover_description+'">'+
					'</div>'+
					'<span class="cover-source">Source : '+article.cover_copyright+'</span>'+
				'</div>'+
				'<div class="article-stat"'+
					'<span><i class="fas fa-eye"></i>'+(article.views)+'</span>'+
				'</div>'+
				'<div class="article">'+
					'<div class="inner-article">'+article.article+'<div>'+
					'<span class="author"><a href="">'+article.author+'</a></span>'+
				'</div>'+
			'</div>';
		$('#article-container .loader').css('display','none');
		$('#article-container').append(article);
	});
})
