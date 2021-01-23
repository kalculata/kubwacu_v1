$.ajax({
	url : "https://www.kubwacu.com/public/search_query",
	data:'p='+page_active+'&q='+query,
	dataType : 'json',
}).done(function(articles){
	if(articles == null){
		var message = '<p class="search-error-message">Aucun résultat trouvé pour "'+query+'"';
		$('#result-w').html(message);
	}
	if(articles[0] === undefined){
		$('#newsFeed .loader').css('display','none');
	}
	else if(articles[0].length !== undefined){
		articles[0].forEach( function(articlesData, key) {
			var article = 
			'<div class="new-i">'+
				'<div class="new-header">'+
					'<span>Publié '+articlesData.postAt+'</span>'+
					'<span id="new-auth">Par <a href="" class="new-auth">Huzaifa Nimushimirimana</a></span>'+
				'</div>'+
				'<div class="new-i-c">'+
					'<div class="new-main-info">'+
						'<div class="new-cover">'+
							'<img src="https://www.kubwacu.com/public/data/mini_cover/'+articlesData.cover_name+'" alt="" id="new-cover">'+
						'</div>'+
						'<div class="new-title">'+
							'<a href="articles/'+articlesData.title+'?tag='+articlesData.id+'" class="new-title-i">'+articlesData.title+'</a>'+
						'</div>'+
					'</div>'+
					'<div class="new-supp-info-c">'+
						'<div class="new-category">'+
							'<a href="category/'+articlesData.category+'"><span class="category"><i class="'+articlesData.category_logo+'"></i>'+articlesData.category+'</span></a>'+
							'<a href="category/'+articlesData.category+'/'+articlesData.sub_category+'"><span class="sub-category">'+articlesData.sub_category+'</span></a>'+
						'</div>'+
						'<a href="" class="new-supp-info" title="commentaires">'+
							'<span><i class="fas fa-eye"></i>'+(articlesData.views-1)+'</span>'+
							/*'<span><i class="fas fa-comments"></i>0</span>'+*/
						'</a>'+
					'</div>'+
				'</div>'+
			'</div>';	
			$('#articles-result').append(article);
		});
		if(articles[2]<=1){
			$('#result-nombre').text(articles[2]+" résultat trouvé");
		}
		else{
			$('#result-nombre').text(articles[2]+" résultats trouvés");
		}
		$('#result-w .result-content').append('<ul id="newsFeedPagination"></ul>');
		//pagination
		if(articles[1] > 1){
			if(page_active != 1){
				$('#newsFeedPagination').append('<li><a href="/search/'+(page_active-1)+'?q='+query+'" class="pagination-bt mover">Précédent</a></li>');	
			}
			var groupes = (articles[1]%5 == 0 )?Math.floor(articles[1]/5):Math.floor(articles[1]/5)+1,
				tranches = [],
				x = 1,y=5;
			tranches[1]={
				'offset':x,
				'limit':y,
			}	
			for (var i = 2; i<=groupes; i++) {
				tranches[i]={
					'offset':x+5,
					'limit':y+5,	
				};	
				x+=5,y+=5;
			}
			console.log(tranches);
			var w = 0,groupe_initial=1;
			while(page_active>w+5){groupe_initial++;w+=5}
			var limit = tranches[groupe_initial].limit;
			if(groupe_initial == groupes){
				limit = tranches[groupe_initial].offset+(articles[1] - ((groupes-1)*5))-1;		
			}
			for (var i = tranches[groupe_initial].offset; i <= limit; i++ ){
				var active = (page_active == i)?'active':'';
				$('#newsFeedPagination').append('<li><a href="/search/'+i+'?q='+query+'" class="pagination-bt '+active+'">'+i+'</a></li>');
			}
			if(articles[1]!=page_active){
				$('#newsFeedPagination').append('<li><a href="/search/'+(page_active+1)+'?q='+query+'" class="pagination-bt mover">Suivant</a></li>');
			}
		}
	}

	//pagination
	if(articles[1]==undefined){
		$('#result-w .result-main-t').html('Aucun résultat trouvé pour "'+query+'"<span><i class="fas fa-search"></i></span>');
	}
	
	$('#result-w .loader').css('display','none');
	$('#result-w .articles-result-w').css('display','block');
});