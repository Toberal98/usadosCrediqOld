function getModels(marca){
	$.ajax({
		url: site_root + 'index.php/ajax/getmodels',
		type: 'POST',
		data: ({marca:marca}),
		success: function(data){
			$('#modelo').html(data);
		},
		error:function(){ alert('Ocurrio un error Intente de nuevo mas tarde'); }
	});
}

function inColor(object){
	$('#color_in').val($(object).attr('id'));
	$('.color1').removeClass('color-selected');
	$(object).addClass('color-selected');
}

function outColor(object){
	$('#color_out').val($(object).attr('id'));
	$('.color2').removeClass('color-selected');
	$(object).addClass('color-selected');
}

