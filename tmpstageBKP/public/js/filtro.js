var numbers = '0123456789';
var numericKeys = '0123456789.';
var numericInteger='0123456789-';
var numericFloat='0123456789-.';
var smallDate='0123456789/';
var hourKeys='0123456789:';
var dateKeys = '0123456789./-';
var phoneKeys = '0123456789.+-(), ';
var emailKeys = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ._-@';
var serieKeys = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-._ ';
var er_email = /^(.+\@.+\..+)$/

/*funcion que valida que el caracter digitado se encuentre en una cadena determinada, si lo encuentra 
  se podra digitar dicho caracter, si no pues no se podra digitar.*/
  function validateKey(evt, validKeys){
	var charCode;
	if(evt.charCode){
		charCode=evt.charCode;
		if(!(validKeys.indexOf(String.fromCharCode(charCode)) >= 0)){
		    evt.preventDefault();
	    }
	}else{
		charCode=event.keyCode;
		evt.returnValue=validKeys.indexOf(String.fromCharCode(charCode)) >= 0;
	}
	//var charCode = (evt.charCode ) ? evt.charCode : event.keyCode
  }



function filter_charact(lapso_actual, pagina_actual,vista_actual,orden, pais){
	var marca="";
	var cargando='<div id="loading"><img src="../public/images/enviando.gif" width="32" height="32" alt="enviando formulario" class="flotar" /><div id="enviando">Buscando...</div></div>';
	$("#box").prepend(cargando);
        $('#loading').show();

        if(pais == 1){
			$("#amount").val($("#amount1").val()+' - '+$("#amount2").val());
			var amount = $("#amount").val().split("-");
		}
		if(pais == 3){
			$("#amounthn").val($("#amounthn1").val()+' - '+$("#amounthn2").val());
			var amount = $("#amounthn").val().split("-");
		}
		 
		if(pais == 2){
			$("#amountcr").val($("#amountcr1").val()+' - '+$("#amountcr").val());
			var amount = $("#amountcr").val().split("-");
		}

        $("#year").val($("#year1").val()+' - '+$("#year2").val());
        var year = $("#year").val().split("-");

	$(".marcaDummy" ).each(function( index ) {
		if($(this).is(':checked')){
			if(marca==""){
				marca=$(this).val();
			}else{
				marca=marca+","+$(this).val();
			}
		}
	});
		
	var form_data = ({
		//year   :$('#year').val(),
		//year_hasta   :$('#year_hasta').val(),
                year   :year[0].trim(),
		year_hasta   :year[1].trim(),
		marca  :marca,   //$('#marca').val(),
		tipo_venta  :$('[name=tipo_venta]').val(),
		modelo :$('#modelo').val(),
		//desde  :$("#amount").val(),
		//hasta  :$('#hasta').val(),
        desde  :amount[0].trim().replace("$", "").replace(",", ""),
		hasta  :amount[1].trim().replace("$", "").replace(",", ""),
		tipo_v :$('#tipo_vehiculo').val(),
		combustible :$('#combustible').val(),
		financiamiento :$('#financiamiento').val(),
		transmision :$('#transmision').val(),
                tipo_ingreso :$('#tipo_ingreso').val(),
                recomendados :$('#recomendados').val(),  /*FIN - Modificado por: GGONZALEZ - 25/01/2015 */
		pagina_actual: pagina_actual,
		lapso_actual: lapso_actual,
		vista_actual: vista_actual,
		orden:orden
	});

	


	$.ajax({
		url: site_root + 'index.php/ajax/filter',
		type: 'POST',
		data: form_data,
		success: function(data){
			$('#box').html(data);
			$('#loading').hide();
			//$('.filter_tile').html("RESULTADO DE BUSQUEDA DE ACUERDO A LOS SIGUIENTES FILTROS");
			$('#boton_buscar').removeClass("boton");
			//$('#boton_buscar').addClass("large_boton2");
			$('#boton_buscar').html("Nueva Busqueda");
		},

		error:function(){ alert('Ocurrio un error Intente de nuevo mas tarde'); }
	});
        //document.forms[0].submit();
		
		

}
function filter_charact_re(lapso_actual, pagina_actual,vista_actual,orden, pais){

	var cargando='<div id="loading"><img src="../public/images/enviando.gif" width="32" height="32" alt="enviando formulario" class="flotar" /><div id="enviando">Buscando...</div></div>';
	$("#box").prepend(cargando);
        $('#loading').show();

        if(pais == 1){
			$("#amount").val($("#amount1").val()+' - '+$("#amount2").val());
			var amount = $("#amount").val().split("-");
		}
		if(pais == 3){
			$("#amounthn").val($("#amounthn1").val()+' - '+$("#amounthn2").val());
			var amount = $("#amounthn").val().split("-");
		}
		 
		if(pais == 2){
			$("#amountcr").val($("#amountcr1").val()+' - '+$("#amountcr").val());
			var amount = $("#amountcr").val().split("-");
		}

        $("#year").val($("#year1").val()+' - '+$("#year2").val());
        var year = $("#year").val().split("-");

	var form_data = ({
		//year   :$('#year').val(),
		//year_hasta   :$('#year_hasta').val(),
                year   :year[0].trim(),
		year_hasta   :year[1].trim(),
		marca  :$('#marca').val(),
		tipo_venta  :$('[name=tipo_venta]').val(),
		modelo :$('#modelo').val(),
		//desde  :$("#amount").val(),
		//hasta  :$('#hasta').val(),
        desde  :amount[0].trim().replace("$", "").replace(",", ""),
		hasta  :amount[1].trim().replace("$", "").replace(",", ""),
		tipo_v :$('#tipo_vehiculo').val(),
		combustible :$('#combustible').val(),
		financiamiento :$('#financiamiento').val(),
		transmision :$('#transmision').val(),
                tipo_ingreso :$('#tipo_ingreso').val(),
                recomendados :$('#recomendados').val(),  /*FIN - Modificado por: GGONZALEZ - 25/01/2015 */
		pagina_actual: pagina_actual,
		lapso_actual: lapso_actual,
		vista_actual: vista_actual,
		orden:orden
	});


	$.ajax({
		url: site_root + 'index.php/ajax/filterre',
		type: 'POST',
		data: form_data,
		success: function(data){
			$('#box').html(data);
			$('#loading').hide();
			//$('.filter_tile').html("RESULTADO DE BUSQUEDA DE ACUERDO A LOS SIGUIENTES FILTROS");
			$('#boton_buscar').removeClass("boton");
			//$('#boton_buscar').addClass("large_boton2");
			$('#boton_buscar').html("Nueva Busqueda");
		},

		error:function(){ alert('Ocurrio un error Intente de nuevo mas tarde'); }
	});
        //document.forms[0].submit();

}

function filter_charact_ve(lapso_actual, pagina_actual,vista_actual,orden, pais){

	var cargando='<div id="loading"><img src="../public/images/enviando.gif" width="32" height="32" alt="enviando formulario" class="flotar" /><div id="enviando">Buscando...</div></div>';
	$("#box").prepend(cargando);
        $('#loading').show();

		if(pais == 1){
			$("#amount").val($("#amount1").val()+' - '+$("#amount2").val());
			var amount = $("#amount").val().split("-");
		}
		if(pais == 3){
			$("#amounthn").val($("#amounthn1").val()+' - '+$("#amounthn2").val());
			var amount = $("#amounthn").val().split("-");
		}
		 
		if(pais == 2){
			$("#amountcr").val($("#amountcr1").val()+' - '+$("#amountcr2").val());
			var amount = $("#amountcr").val().split("-");
		}
		$("#year").val($("#year1").val()+' - '+$("#year2").val());
        var year = $("#year").val().split("-");

	var form_data = ({
		//year   :$('#year').val(),
		//year_hasta   :$('#year_hasta').val(),
                year   :year[0].trim(),
		year_hasta   :year[1].trim(),
		marca  :$('#marca').val(),
		modelo :$('#modelo').val(),
		//desde  :$("#amount").val(),
		//hasta  :$('#hasta').val(),
        desde  :amount[0].trim().replace("$", "").replace(",", ""),
		hasta  :amount[1].trim().replace("$", "").replace(",", ""),
		tipo_v :$('#tipo_vehiculo').val(),
		combustible :$('#combustible').val(),
		financiamiento :$('#financiamiento').val(),
		transmision :$('#transmision').val(),
                tipo_ingreso :$('#tipo_ingreso').val(),
                recomendados :$('#recomendados').val(),  /*FIN - Modificado por: GGONZALEZ - 25/01/2015 */
		pagina_actual: pagina_actual,
		lapso_actual: lapso_actual,
		vista_actual: vista_actual,
		orden:orden
	});



	$.ajax({
		url: site_root + 'index.php/ajax/filterve',
		type: 'POST',
		data: form_data,
		success: function(data){
			$('#box').html(data);
			$('#loading').hide();
			//$('.filter_tile').html("RESULTADO DE BUSQUEDA DE ACUERDO A LOS SIGUIENTES FILTROS");
			$('#boton_buscar').removeClass("boton");
			//$('#boton_buscar').addClass("large_boton2");
			$('#boton_buscar').html("Nueva Busqueda");
		},

		error:function(){ alert('Ocurrio un error Intente de nuevo mas tarde'); }
	});
        //document.forms[0].submit();

}

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

function getModelsRegistro(marca){
	$.ajax({
		url: site_root + 'index.php/ajax/getmodels',
		type: 'POST',
		data: ({marca:marca}),
		success: function(data){
			$('#modelo_registro').html(data);
		},
		error:function(){ alert('Ocurrio un error Intente de nuevo mas tarde'); }
	});
}

function getModelsExistentes(marca){
	$.ajax({
		url: site_root + 'index.php/ajax/getmodelsExistentes',
		type: 'POST',
		data: ({marca:marca}),
		success: function(data){
			$('#modelo').html(data);
		},
		error:function(){ alert('Ocurrio un error Intente de nuevo mas tarde'); }
	});
}

function marcasByTipo(tipo){
	if(tipo!=""){//si viene lleno ejecutamos ajax

		$.ajax({
			url: site_root + 'index.php/ajax/marcasByTipo',
			type: 'POST',
			data: ({tipo:tipo}),
			success: function(data){
				$('#marca').html(data);
			},
			error:function(){ alert('Ocurrio un error Intente de nuevo mas tarde'); }
		});
	}else if(tipo=="todas"){
		$('#marca').html('<select name="marca" id="marca" class="max-80" onChange="getModels(this.value);"><option value="">Todas</option></select>');
		//$('#marca').html('asddf');
	}
}

function marcasByTipoExistentes(tipo){
	if(tipo!=""){//si viene lleno ejecutamos ajax

		$.ajax({
			url: site_root + 'index.php/ajax/marcasByTipoExistentes',
			type: 'POST',
			data: ({tipo:tipo}),
			success: function(data){
				$('#marca').html(data);
			},
			error:function(){ alert('Ocurrio un error Intente de nuevo mas tarde'); }
		});
	}else if(tipo=="todas"){
		$('#marca').html('<select name="marca" id="marca" class="max-80" onChange="getModels(this.value);"><option value="">Todas</option></select>');
		//$('#marca').html('asddf');
	}
}
function CheckUser(){
		$.ajax({
			url: site_root + 'index.php/ajax/checkEmail',
			type: 'POST',
			data: ({email:$("#email").val()}),
			success: function(data){
				$('#checkUser').html(data);


			},
			error:function(){ alert('Ocurrio un error al intentar revisar existencia del usuario'); }
		});
}
function doClick(idCar){

		$.ajax({
			url: site_root + 'index.php/ajax/inyectarClick',
			type: 'POST',
			data: ({id:idCar}),

			success: function(data){

				window.top.location.href= site_root + "index.php/car/ver/" + idCar;
			}
		});
		return false;
}
function doComparar(accion,idCar){

		if(accion=="agregar"){//si esta chequeado se va a quitar

			n_comparar=n_comparar+1;

			if(n_comparar<=4){
				$.ajax({
				url: site_root + 'index.php/ajax/addComparar',
				type: 'POST',
				data: ({id:idCar}),

				success: function(data){
					return true
				}
				});
				alert('Agregado a la lista de comparacion');
			}else{
				n_comparar=4;
				alert('solo puede comparar: '+n_comparar+' vehiculos');
				 $('#comparar_'+idCar).attr('checked', false);

			}

		} else if(accion=="quitar") {//si no esta chequeado se va a agregar

			$.ajax({
			url: site_root + 'index.php/ajax/removeComparar',
			type: 'POST',
			data: ({id:idCar}),

			success: function(data){
				return true
			}
			});

			n_comparar=n_comparar-1;

			if(n_comparar<0){
				n_comparar=0;
			}

			alert('Se quito de la lista de comparacion');

		}




}
