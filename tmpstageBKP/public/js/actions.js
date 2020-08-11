/*Filter by Characteristics*/
function mostrar(campo){
      if(campo=='I'){
 		$(".precio_extranjero").show();
      }else{
      	$(".precio_extranjero").hide();
      }
}

function clearText(field){
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}

function ingresos(tipo){
	
	if(tipo=='Asalariado'){
		$('.asalariado').show();
		$('.profesional').hide();
		$('.jubilado').hide();
		$('.cargo').show();
	}
	
	if(tipo=='Profesional'){
		$('.asalariado').hide();
		$('.profesional').show();
		$('.jubilado').hide();
		$('.cargo').show();
	}
	
	if(tipo=='Jubilado'){
		$('.asalariado').hide();
		$('.profesional').hide();
		$('.jubilado').show();
		$('.cargo').hide();
	}
	
}

function sort_val(valor){
	$('#sort').val(valor);
}

function tipo_val(valor){
	$('#tipo').val(valor);
}

function rangoVal(valor){
	$('#rango').val(valor);
}







