$(document).ready(function(){
	$('#writeForm').on('submit', function(e){
		e.preventDefault();
		var image = $('#preview').attr('src');
		$.ajax({
			url : '/admin/article/save-article-cover/' ,
			type:"POST",
	   		data:{"image":image,"name":$('#article_title').val()}
		})

	})
})