$(document).ready(function(){
	var ressource = '',
		subcategoryform = $('#article_sub_category');
	//function de chargement des options
	function chargeOptions(categorySelected){
		subcategoryform.children('option').each(function(){
			$(this).remove();
		});
		ressource = categoryinfo[categorySelected].sub_categorys;
		if(ressource.length==0){
			subcategoryform
				.attr('disabled','disabled')
				.css({
					'background' : '#ccc'
			});
		}
		ressource.forEach( function(notice) {
			subcategoryform.css({
				'background' : '#1565c0'
			});
			subcategoryform.append(new Option(notice, notice));
		});
	}
					
	var categorySelectedInitial = $('#article_category').children('option').val();
	chargeOptions(categorySelectedInitial);
	$('#article_category').on('change', function(){
		var categorySelected = $(this).children("option:selected").val();
        chargeOptions(categorySelected);
	});
});