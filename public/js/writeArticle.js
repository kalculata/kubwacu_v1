$(document).ready(function(){
	//charge the croppie work station
	$image_crop = $('#image_demo').croppie({
		enableExif:true,
		viewport:{
			width :650,
			height:450,
			type:'square'
		},
		boundary:{
			width:700,
			height:500
		},
	});
	//listen on button 'next'
	$('#article_cover_cover').on('change', function(){
		var reader = new FileReader();
		reader.onload = function(event){
			$image_crop.croppie('bind',{
				url:event.target.result
			}).then(function(){
				console.log('Jquery bind complete');
			});
		}
		reader.readAsDataURL(this.files[0]);
		$('#coverWorkStation').css('display','block');
	});

	$('.coverWorkStation-h .quit').on('click', function(){
		$('#coverWorkStation').css('display','none');
	})
	
	$('#addTempCover').on('click', function(){
		$image_crop.croppie('result', {
			type:'canvas',
			size:'viewport'
		}).then(function(data){
			$('#coverWorkStation').css('display','none');
			$('#uploadbt-message').css('display','none');
			$('#publish-bt').css('display','none');
			$('#preview').attr('src',data);
			$('#uploaded_image').css('display','block');
			uploadbt.css('display','none');
			uploadbt.nextAll().css('display','block');
			$('#publish-bt-withCover').css('display','block')
		})
	});

	$('#quitUpload_image').on('click', function(){
		$('#uploaded_image').css('display','none');
		$('#coverWorkStationBt').css('display','block');
		$('#publish-bt').css('display','block');
		$('#uploadbt-message').css('display','block');
		uploadbt.css('display','block');
		uploadbt.nextAll().css('display','none');
		$('#publish-bt-withCover').css('display','none');
	})
	$('#editUpload_image').on('click', function(){
		$('#uploaded_image').css('display','none');
		$('#coverWorkStation').css('display','block');
		$('#publish-bt-withCover').css('display','none');
		uploadbt.css('display','block');
		$('#uploadbt-message').css('display','block');
		uploadbt.slice(1, 3).css('display','none');
	})
});