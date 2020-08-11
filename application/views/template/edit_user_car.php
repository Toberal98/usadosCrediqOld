<?php 
date_default_timezone_set('America/El_Salvador');
$row_default = $renting->row_array(); 
$rowr = $data_renting->row_array();
?>
<!-- Editor WYSIWYG -->
<!--link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/stylesheet_editor.css"-->
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/parser_rules/advanced.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/dist/wysihtml5-0.3.0.min.js"></script>
<!-- Fin editor -->
<?php

$this->load->view('template/inc/header_stripe.php');

?>



<?php
if ($this->session->userdata('pais') == '2') {//si el pais es Costa Rica
    $texto_dep = 'Provincia'; //Cambiamos el texto por provincia
} else {
    $texto_dep = 'Departamento';
}

if ($this->session->userdata('pais') == '1' or $this->session->userdata('pais') == '3') {
    $tex = 'trailers';
} else {
    $tex = 'mulas';
}

?>
<style>
.image-upload > input
{
    display: none;
}

.image-upload img
{
    width: 80px;
    cursor: pointer;
}

</style>
<form id="form_addCar" name="form_addCar" accept-charset="utf-8" action="<?php echo base_url(); ?>index.php/savedata/savecar/update" enctype="multipart/form-data" method="post" >
		<input type="hidden" name="tipo_venta" value="<?php echo $tipo_venta ?>">


    <div class="content">
        <div class="container12">
            <div class="row agregarNuevo">
                <h3>Modificar Veh&iacute;culo - <?php echo $car['id_automovil']; ?> <span></span></h3>

                <p class="title-sec">Caracter&iacute;sticas</p>
                <div class="column6">

              <!--  /* MODIFICADO POR GGONZALEZ 13/05/2015 INI */-->
                    <label><span>Marca:</span>
                        <select class="cabin_grey" name="marca" id="marca" onchange="getModels(this.value);" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <?php foreach ($marks as $mark): ?>
                                <option <?php if ($mark['id_marca'] == $car['id_marca']) {
                                echo 'selected="selected"';
                            } ?> value="<?php echo $mark['id_marca']; ?>"><?php echo $mark['nombre']; ?></option>
<?php endforeach ?>
                        </select>
                    </label>
                    <label><span>Modelo:</span> <select class="cabin_grey" name="modelo" id="modelo" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <?php foreach ($models as $modelo): ?>
                                <option <?php if ($modelo['id_modelo'] == $car['id_modelo']) {
                                echo 'selected="selected"';
                            } ?> value="<?php echo $modelo['id_modelo']; ?>"><?php echo $modelo['nombre']; ?></option>
<?php endforeach ?>
                        </select>
                    </label>

                     <!--  /* MODIFICADO POR GGONZALEZ 13/05/2015 FIN*/-->
                    <label><span>Año:</span>
                        <select class="cabin_grey" name="year" id="year" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
<?php for ($i = date('Y'); $i > (date('Y') - 15); $i--): ?>
                                <option <?php if ($i == $car['year']) {
        echo 'selected="selected"';
    } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor ?>
                        </select>
                    </label>
                    <label><span>Tipo Combustible:</span>
                        <select class="cabin_grey" name="tipo_combus" id="tipo_combus" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
<?php foreach ($combustibles as $combustible): ?>
                                <option <?php if ($combustible['id_tipo_combustible'] == $car['tipo_combustible']) {
        echo 'selected="selected"';
    } ?> value="<?php echo $combustible['id_tipo_combustible']; ?>"><?php echo $combustible['nombre']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </label>
                    <label><span>Tipo Veh&iacute;culo:</span>
                        <select class="cabin_grey" name="tipo_vehiculo" id="tipo_vehiculo" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
<?php foreach ($categories as $category): ?>
                                <option <?php if ($category['id_tipo_vehiculo'] == $car['tipo_vehiculo']) {
        echo 'selected="selected"';
    } ?> value="<?php echo $category['id_tipo_vehiculo']; ?>"><?php echo $category['nombre']; ?></option>
<?php endforeach ?>
                        </select>

                    </label>
                    <label><span>Tipo Transmisi&oacute;n:</span>
                        <select class="cabin_grey" name="transmision" id="transmision" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <option <?php if ('A' == $car['tipo_transmision']) {
    echo 'selected="selected"';
} ?> value="A">Automatica</option>
                            <option <?php if ('M' == $car['tipo_transmision']) {
    echo 'selected="selected"';
} ?> value="M">Manual</option>
                        </select>
                    </label>
                    <label><span>No. de Placa:</span> <input type="text" name="num_placa" id="num_placa" value="<?php echo $car['numero_de_placa']; ?>" data-bvalidator="required"><em>Ingresa n&uacute;mero completo.</em></label>
                    <label><span>Kilometraje:</span> <input type="text"  value="<?php echo $car['kilometraje']; ?>" name="kilometraje" id="kilometraje" data-bvalidator="number,required"><em>Kms.</em></label>
                    <!--label><span>Capacidad Motor:</span> <input type="text" value="<?php //echo $car['capacidad_de_motor']; ?>" name="cap_motor" id="cap_motor" data-bvalidator="number,required"></label-->

                    <!--  /* MODIFICADO POR GGONZALEZ 13/05/2015 INI*/-->
                    <label><span>Capacidad Motor:</span><select class="i_medium" name="cap_motor" id="cap_motor" data-bvalidator="required"> >
                                                <option <?php if ('800 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="800 cc">800 cc</option>
                                                <option <?php if ('900 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="900 cc">900 cc</option>
                                                <option <?php if ('1000 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="1000 cc">1000 cc</option>
                                                 <option <?php if ('1100 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="1100 cc">1100 cc</option>
                                                 <option <?php if ('1200 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="1200 cc">1200 cc</option>
                                                 <option <?php if ('1300 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="1300 cc">1300 cc</option>
                                                 <option <?php if ('1400 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="1400 cc">1400 cc</option>
                                                 <option <?php if ('1500 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="1500 cc">1500 cc</option>
                                                 <option <?php if ('1600 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="1600 cc">1600 cc</option>
                                                 <option <?php if ('1700 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="1700 cc">1700 cc</option>
                                                 <option <?php if ('1800 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="1800 cc">1800 cc</option>
                                                 <option <?php if ('1900 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="1900 cc">1900 cc</option>
                                                 <option <?php if ('2000 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="2000 cc">2000 cc</option>
                                                <option <?php if ('2100 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="2100 cc">2100 cc</option>
                                                <option <?php if ('2200 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="2200 cc">2200 cc</option>
                                                <option <?php if ('2300 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="2300 cc">2300 cc</option>
                                                <option <?php if ('2400 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="2400 cc">2400 cc</option>
                                               <option <?php if ('2500 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="2500 cc">2500 cc</option>
                                               <option <?php if ('2600 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="2600 cc">2600 cc</option>
                                                <option <?php if ('2700 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="2700 cc">2700 cc</option>
                                                <option <?php if ('2800 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="2800 cc">2800 cc</option>
                                                <option <?php if ('2900 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="2900 cc">2900 cc</option>
                                                <option <?php if ('3000 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="3000 cc">3000 cc</option>
                                                <option <?php if ('3100 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="3100 cc">3100 cc</option>
                                                 <option <?php if ('3200 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="3200 cc">3200 cc</option>
                                                 <option <?php if ('3300 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="3300 cc">3300 cc</option>
                                                 <option <?php if ('3400 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="3400 cc">3400 cc</option>
                                                 <option <?php if ('3500 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="3500 cc">3500 cc</option>
                                                 <option <?php if ('3600 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="3600 cc">3600 cc</option>
                                                 <option <?php if ('3700 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="3700 cc">3700 cc</option>
                                                 <option <?php if ('3800 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="3800 cc">3800 cc</option>
                                                 <option <?php if ('3900 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="3900 cc">3900 cc</option>
                                                 <option <?php if ('4000 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="4000 cc">4000 cc</option>
                                                 <option <?php if ('4100 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="4100 cc">4100 cc</option>
                                                 <option <?php if ('4200 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="4200 cc">4200 cc</option>
                                                <option <?php if ('4300 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="4300 cc">4300 cc</option>
                                                <option <?php if ('4400 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="4400 cc">4400 cc</option>
                                                 <option <?php if ('4500 cc' == $car['capacidad_de_motor']) {
                                                  echo 'selected="selected"';} ?> value="4500 cc">4500 cc</option>

                    </select></label>

                     <!--  /* MODIFICADO POR GGONZALEZ 13/05/2015 FIN*/-->
                </div>


                <div class="column6">
                      <!-- <label><span>Tracci&oacute;n:</span>
                        <select class="cabin_grey" name="traccion" id="traccion" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <option <?php if ('Delantera' == $car['traccion']) {
									echo 'selected="selected"';
								} ?> value="Delantera">Delantera</option>
									<option <?php if ('Trasera' == $car['traccion']) {
									echo 'selected="selected"';
								} ?> value="Trasera">Trasera</option>
                            <option <?php if ('4x2' == $car['traccion']) {
                                echo 'selected="selected"';
                            } ?> value="Trasera">4x2</option>
                            <option <?php if ('4x4' == $car['traccion']) {
                                echo 'selected="selected"';
                            } ?> value="Trasera">4x4</option>
                        </select>
                    </label> -->
					<input type="hidden" id="traccion" name="traccion" value="<?php echo $car['traccion'] ?>"/>

                    <!--<label><span>Color Interior:</span>              
							<select class="cabin_grey" name="color_in" id="color_in">
                            <option value="">-Seleccione un Color-</option>
							<?php foreach ($colors as $color): ?>
														<option <?php if ($color['id_color'] == $car['color_interno']) {
								echo 'selected="selected"';
							} ?> value="<?php echo $color['id_color']; ?>" ><?php echo $color['nombre']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </label> -->
					<input type="hidden" id="color_in" name="color_in" value="<?php echo $car['color_interno']; ?>"/>
                    
					<label><span>Color:</span>
                        <select class="cabin_grey" name="color_out" id="color_out" data-bvalidator="required">
                            <option value="">-Seleccione un Color-</option>
							<?php foreach ($colors as $color): ?>
															<option <?php if ($color['id_color'] == $car['color_externo']) {
									echo 'selected="selected"';
								} ?> value="<?php echo $color['id_color']; ?>" ><?php echo $color['nombre']; ?></option>
							<?php endforeach ?>
                        </select>
                    </label>

                    <!--<label><span>No. de Puertas:</span>
                        <select class="cabin_grey" name="num_puertas" id="num_puertas" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
							<?php for ($i = 1; $i <= 5; $i++): ?>
															<option <?php if ($i == $car['numero_puertas']) {
									echo 'selected="selected"';
								} ?>value="<?php echo $i; ?>"><?php echo $i; ?></option>
							<?php endfor ?>
                        </select>
                    </label>-->
					<input type="hidden" id="num_puertas" name="num_puertas" value="<?php echo $car['numero_puertas'] ?>"/>
                    
					<!--<label><span>No. de Asientos:</span>
                        <select class="cabin_grey" name="num_asientos" id="num_asientos" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
							<?php for ($i = 2; $i <= 15; $i++): ?>
															<option <?php if ($i == $car['numero_asientos']) {
									echo 'selected="selected"';
								} ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
							<?php endfor ?>
                        </select>
                    </label>-->
					<input type="hidden" id="num_asientos" name="num_asientos" value="<?php echo $car['numero_asientos'] ?>"/>
                    
					<label><span>Procedencia:</span>
                        <select class="cabin_grey" name="tipo_ingreso" id="tipo_ingreso" data-bvalidator="required" onchange="mostrar(this.value);">
                            <option value="">-Seleccione-</option>
                            <option <?php if ('I' == $car['tipo_ingreso']) {
								echo 'selected="selected"';
							} ?> value="I">Importado</option>
														<option <?php if ('G' == $car['tipo_ingreso']) {
								echo 'selected="selected"';
							} ?> value="G">De Agencia</option>
                        </select>
                    </label>

                    <script>
                        $(document).ready(function() {
                            $('#guardar_prod').mouseover(function() {

                                if ($('#precio').val() < 1000) {
                                    $('.mess_3').show();
                                    $('.etiqueta3').html('El precio no puede ser menor de 1000');
                                    $('html, body').animate({scrollTop: 500}, 500);

                                }
                            });
                        });

                    </script>
                     <!--  /* MODIFICADO POR GGONZALEZ 13/05/2015 INI*/-->
                       <label><span><?php echo $tipo_venta == 2 ? 'Precio de contado' : ($tipo_venta == 3 ? 'Precio mínimo' :  'Precio') ?>:</span>
                            <input type="text" class="i_medium" name="precio" id="precio" value="<?php echo $car['precio']; ?>" data-bvalidator="number,required, minlength[3], maxlength[9]">

                               <div class="bVErrMsgContainer mess_3" style="position: absolute; display:none">


                            <div class="bvalidator_errmsg" style="visibility: visible; position: absolute; top: -20px; left: 100px; display: block;">
                                <em></em>
                                <div style="display:table">
                                    <div style="display:table-cell">
                                        <div class="etiqueta3">El precio no deber ser menor de 1000 .</div>
                                    </div>
                                    <div style="display:table-cell">
                                        <div class="bvalidator_close_icon" onclick="$(this).closest('.bvalidator_errmsg').css('visibility', 'hidden');">x</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <!--  /* MODIFICADO POR GGONZALEZ 13/05/2015 FIN*/-->
                    </label>
                    <?php if ($tipo_venta == 3): ?>
                      <label><span>Fecha de finalización de subasta:</span>
                              <input type="text" value="<?php echo date('Y-m-d', strtotime($car['bid_available_until'])); ?>" data-is-datepicker class="i_medium" name="bid_available_until" id="bid_available_until" data-bvalidator="required">

                      </label>
                    <?php endif; ?>
                    <label><span>Moneda:</span>
                        <select class="precio_list" name="moneda_venta" id="moneda_venta" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <option value="US$" <?php if ($car['moneda'] == 'US$') {
								echo 'selected="selected"';
							} ?> >Dolares(US$)</option>
                            <option value="L" 	<?php if ($car['moneda'] == 'L') {
                            echo 'selected="selected"';
                        } ?> >Lempiras(L)</option>
                            <option value="¢" 	<?php if ($car['moneda'] == '¢') {
                            echo 'selected="selected"';
                        } ?> >Colones(¢)</option>
                        </select>
                    </label>

                     <!--  /* MODIFICADO POR GGONZALEZ 13/05/2015 INI*/-->
                    <p><span>¿Negociable?</span> <label><input <?php if ('1' == $car['negociable']) {
                            echo 'checked';
                        } ?> type="radio" name="negociable" id="negociable" value="1">Si</label> <label> <input <?php if ('0' == $car['negociable']) {
                            echo 'checked';
                        } ?> type="radio" name="negociable" id="negociable" value="0">No</label></p>
					<?php if($this->session->userdata('user_perfil')==1){ ?>
								<p><span>Certificado</span> <label><input <?php if ('1' == $car['certificado']) {
										echo 'checked';
									} ?> type="radio" name="certificado" id="certificado" value="1">Si</label> <label> <input <?php if ('0' == $car['certificado']) {
										echo 'checked';
									} ?> type="radio" name="certificado" id="certificado" value="0">No</label></p>
                                
                                <?php if($tipo_venta == 1): ?>
                                <p><span>Recomendado</span> <label><input <?php if ('1' == $car['recomendado']) {
										echo 'checked';
									} ?> type="radio" name="recomendado" id="recomendado" value="1" onclick="habilitarRenting()">Si</label> <label> <input <?php if ('0' == $car['recomendado']) {
										echo 'checked';
                                    } ?> type="radio" name="recomendado" id="recomendado" value="0" onclick="desabilitarRenting()" >No</label>
                                </p>
                                <?php endif; ?>


					<?php }else{?>
								<input type="hidden" name="certificado" value="0">
								<input type="hidden" name="recomendado" value="0">
                    <?php } ?>
                    

                    <?php if($tipo_venta == 1): ?>
                    <!-- CALCULADORA RENTING -->
                    <table>
                        <tr>
                            <td>
                                <label><span>Tasa (%): </span>
                                <input type="number" min="0.00" step="0.01" id="tasa_r" name="tasa_r" value="<?php echo $rowr['tasa_anual']; ?>">
                                </label>
                                <label><span>Plazo: </span>
                                <input type="number" id="plazo_r" name="plazo_r" value="<?php echo $rowr['plazo']; ?>">
                                </label>
                            </td>
                            <td>
                                <button type="button" id="btnllenarenting" onclick="llenarRenting();">Valores default <i class="fas fa-redo-alt"></i></button>
                            </td>
                        </tr>
                    </table>
            
                    <label><span>Valor residual ($): </span>
                        <input type="text" id="residual" name="residual" value="<?php echo $rowr['valor_residual']; ?>">
                    </label>

                    <label><span>Mantenimiento ($): </span>
                        <input type="text" id="mantenimiento" name="mantenimiento" 
                        value="<?php echo $rowr['cargo_mantenimiento_mensual']; ?>">
                    </label>

                    <label><span>Cargo Administrativo: </span>
                        <select id="tipo_administrativo" name="tipo_administrativo" onchange="cambiarInput();" style="width: 50px">
                        <option value=""></option>
                        <?php 
                            $check = array($rowr['tipo_administrativo'] => "selected");
                        ?>
                        <option value="monetario" <?php echo $check['monetario']?>>$</option>
                        <option value="porcentaje" <?php echo $check['porcentaje']?>>%</option>
                        </select>
                        <input type="text" id="administrativo" name="administrativo" 
                        value="<?php echo $rowr['cargo_administrativo_mensual']; ?>">
                    </label>

                    <label><span>Gps ($): </span>
                        <input type="text" id="gps_r" name="gps_r" value="<?php echo $rowr['cargo_gps']; ?>">
                    </label>
                
                    <label><span>Seguro ($): </span>
                        <input type="text" id="seguro_r" name="seguro_r" value="<?php echo $rowr['cargo_seguro']; ?>">
                    </label>
                        
                    <button type="button" id="btn_calculo_r" style="width: 130px"
                    onclick="getCuotaRenting();">Calcular </button>
                         
                    <hr>
                    <label><span>Renting calculado:</span>
                        <input type="text" style="background:#CFD8DC" id="renting" name="renting"
                        value="<?php echo $rowr['cuota_mensual']; ?>" readonly>
                    </label> 

                    <?php endif; ?>



					<!--	
					<label><span>Estado Veh&iacute;culo:</span>
                        <select class="cabin_grey" name="condiciones" id="condiciones" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <option <?php if ('Excelente' == $car['Condiciones']) {
                            echo 'selected="selected"';
                        } ?> value="Excelente">Excelente</option>
                            <option <?php if ('Muy Bueno' == $car['Condiciones']) {
                            echo 'selected="selected"';
                        } ?> value="Muy Bueno">Muy Bueno</option>
                            <option <?php if ('Bueno' == $car['Condiciones']) {
                            echo 'selected="selected"';
                        } ?> value="Bueno">Bueno</option>
                            <option <?php if ('Regular' == $car['Condiciones']) {
                            echo 'selected="selected"';
                        } ?> value="Regular">Regular</option>
                        </select>
                    </label>-->
					<input type="hidden" id="condiciones" name="condiciones" value="<?php echo $car['Condiciones'] ?>"/>

                     <!--  /* MODIFICADO POR GGONZALEZ 13/05/2015 FIN*/-->
                    <!-- <label><span><?php echo $texto_dep; ?>:</span>
                        <select class="cabin_grey" name="departamento" id="departamento" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
							<?php
							foreach ($departamentos as $departamento):
								?>
															<option <?php if ($car['Departamento'] == $departamento['id_departamento']) {
									echo 'selected="selected"';
								} ?> value="<?php echo $departamento['id_departamento']; ?>"><?php echo $departamento['nombre']; ?></option>
								<?php
							endforeach
							?>
                        </select>
                    </label>-->
					<input type="hidden" id="departamento" name="departamento" value="<?php echo $car['Departamento'] ?>"/>
                </div>
				
				<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <div class="column6">
                    <p class="title-sec">Equipamiento</p>
                    <ul class="equipamiento">
						<?php
						/* EQUIPAMIENTO GGONZALEZ 13/05/2015 INI*/
						$i = 1;

						foreach ($equipamiento_car as $equipo):

						if ($equipo['ind_ck'] == 'CK') {

						$chequed = $equipo['id_eq'].' checked="checked"';

						 ?>
						<li><label><input type="checkbox" <?php echo $chequed  ?> name="<?php echo $equipo['id_eq']; ?>" id="<?php echo $equipo['id_eq']; ?>"
						value="<?php echo $chequed?> "> <?php echo $equipo['nombre']; ?></label></li>
							<?php

						 } else {

						$chequed = $equipo['id_eq'];

						 ?>
						<li><label><input type="checkbox" <?php echo $chequed  ?> name="<?php echo $equipo['id_eq']; ?>" id="<?php echo $equipo['id_eq']; ?>"
						value="<?php echo $chequed?> "><?php echo $equipo['nombre']; ?></label></li>
							<?php

						 }
							$i++;
						endforeach;



						/* MODIFICADO POR GGONZALEZ 13/05/2015 FIN*/

						?>
                    </ul>
                </div>


<script type="text/javascript">

	$(function(){

		var swf='<?php echo base_url() ?>public/uploadify.swf';

		<?php

		$tipo_foto = array();
		$tipo_foto[1]='FRONTAL';
		$tipo_foto[2]='TRASERA';
		$tipo_foto[3]='LATERAL';
		$tipo_foto[4]='INTERIOR';

		for ($i = 1; $i <= 4; $i++) {
    ?>
                            var uploader = '<?php echo base_url() ?>index.php/ajax/doUpload';//se hace adentro para llenar numero de imagen que se envia
                            $('#imagen<?php echo $i ?>').change(function(e) { addImage(e); });
                            $('#imagen<?php echo $i ?>').uploadify({
                                'fileSizeLimit': '2048KB',
                                'swf': swf,
                                'uploader': uploader,
                                'onUploadSuccess': function(file, data, response) {

                                    var nombre = file.name;

                                    $('#previa<?php echo $i ?>').html('<img width="70" height="70" src="<?php echo base_url() . 'public/img_autos_temp/' ?>' + nombre + '">');

                                    //registramos nombre de la imagen en un array PHP
                                    $.ajax({
                                        url: '<?php echo base_url() ?>index.php/ajax/setname_imagen/imagen' +<?php echo $i; ?>,
                                        type: 'POST',
                                        data: ({archivo: nombre}),
                                        success: function(data) {
                                            //$('#box2').html(data);
                                        },
                                        error: function() {
                                            alert('Ocurrio un error Intente de nuevo mas tarde');
                                        }
                                    });


                                }
                            });


<?php } ?>
    function addImage(e){
      var file = e.target.files[0],
      imageType = /image.*/;

      var sizeByte = file.size;
      var siezekiloByte = parseInt(sizeByte / 1024);

      if(siezekiloByte > 2048){
        alert('La imagen no puede pesar más de 2MB');
        return;
      }
    
      if (!file.type.match(imageType)){
          return;
      }
	  /*
      var reader = new FileReader();
      if(e.target.id == 'imagen1'){
        reader.onload = fileOnload1;
      }
      if(e.target.id == 'imagen2'){
        reader.onload = fileOnload2;
      }
      if(e.target.id == 'imagen3'){
        reader.onload = fileOnload3;
      }
      if(e.target.id == 'imagen4'){
        reader.onload = fileOnload4;
      }
      reader.readAsDataURL(file);
    }

    function fileOnload1(e) {
      var result=e.target.result;
      $('#prvw1').attr("src",result);
    }

    function fileOnload2(e) {
      var result=e.target.result;
      $('#prvw2').attr("src",result);
    }

    function fileOnload3(e) {
      var result=e.target.result;
      $('#prvw3').attr("src",result);
    }

    function fileOnload4(e) {
      var result=e.target.result;
      $('#prvw4').attr("src",result);
    }*/
	
	 var reader = new FileReader();
      if(e.target.id == 'imagen1'){
        reader.onload = fileOnload1;
      }
      if(e.target.id == 'imagen2'){
        reader.onload = fileOnload2;
      }
      if(e.target.id == 'imagen3'){
        reader.onload = fileOnload3;
      }
      if(e.target.id == 'imagen4'){
        reader.onload = fileOnload4;
      }
      reader.readAsDataURL(file);
    }
  
    function fileOnload1(e) {
      var result=e.target.result;
      $('#previa1').html('<label for="imagen1"><img width="70" height="70" src="' + result + '"></label>');
    }

    function fileOnload2(e) {
      var result=e.target.result;
      $('#previa2').html('<label for="imagen2"><img width="70" height="70" src="' + result + '"></label>');
    }

    function fileOnload3(e) {
      var result=e.target.result;
      $('#previa3').html('<label for="imagen3"><img width="70" height="70" src="' + result + '"></label>');
    }

    function fileOnload4(e) {
      var result=e.target.result;
      $('#previa4').html('<label for="imagen4"><img width="70" height="70" src="' + result + '"></label>');
    }
                    });

                </script>



                <div class="column6">
                    <p class="title-sec">Fotograf&iacute;as</p>
                    <ul class="fotos">


        <?php

	if($tumbnails!=0){
		$i=1;
    	foreach($tumbnails as $thumb){//introducimos los tipos de fotos en un array
    		$tipo_thumb[$i]=$thumb['tipo'];
    		$i++;
    	}
    }else{
    	$tipo_thumb[1]='0';
    }


	   /* MODIFICADO POR GGONZALEZ 13/05/2015 INI*/

        for ($v = 1; $v <= 4; $v++) {
if($v<=2){
				//$requerido='data-bvalidator="required"';
				$boton_borrar="";
			}else{
				$boton_borrar='<div class="boton_borrar"><a href="'.base_url().'index.php/car/borrarimagen/'.$car['id_automovil'].'/preguntar/'.$v.'">X</a></div>';
				$requerido="";
			}






            if(in_array('0000'.$v, $tipo_thumb)){//buscamos este codigo en el array
							//echo   '<img src="'.base_url().'index.php/ajax/doimage/'.$car['id_automovil'].'-58-58-'.$v.'" id="prvw'.$v.'" alt="Subir Foto"></span><input type="file" name="imagen'.$v.'" id="imagen'.$v.'" class="f-hide" >';
                           echo '<li>
										<div id="previa' . $v . '" class="figure image-upload">
											<label for="imagen' . $v . '">
												<img src="'.base_url().'index.php/ajax/doimage/'.$car['id_automovil'].'-58-58-'.$v.'" id="prvw'.$v.'" alt="Subir Foto">
											</label>
										</div>
										<p>' . $tipo_foto[$v] . '</p> <input type="file" name="imagen" id="imagen'.$v.'"  ' . $requerido . ' style="display: none"> 
								</li>';

						}else{

							echo '<li><div class="figure"></div><p>' . $tipo_foto[$v] . '</p> <input type="file" name="imagen" id="imagen'.$v.'"  ' . $requerido . ' style="display: none" ></li>';
						}

        }


         ?>



                <input type="hidden" name="edit_user_car" id="edit_user_car" value="user" />
                <input type="hidden" name="id_auto" id="id_auto" value="<?php echo $car['id_automovil']  ?>" />
                <input type="hidden" name="<?php echo 'tipo_foto' .$v  ?>" id="<?php echo 'tipo_foto' . $v  ?>" value="<?php echo  '0000'.$v  ?>" />
				<input type="hidden" name="<?php echo 'desc_foto' .$v  ?>" id="<?php echo 'desc_foto' .$v  ?>" value="<?php echo  $tipo_foto[$v]  ?>" />

            <!--    // MODIFICADO POR GGONZALEZ 13/05/2015 FIN       -->
                    </ul>
                </div>


<script>

$(document).ready(function(){

	function validar_email(valor)
    {
        // creamos nuestra regla con expresiones regulares.
        var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
        // utilizamos test para comprobar si el parametro valor cumple la regla
        if(filter.test(valor)){
            return true;
		}else{
            return false;
		}
    }

	$('#guardar_prod').mouseover(function() {

		if($('#ext_email').val()!=""){


			if(validar_email($('#ext_email').val())==false){
            	$('.mess_1').show();
				$('.etiqueta1').html('Email invalido');
        	}



/*
			if( $('#ext_email').val()!=$('#ext_email2').val() ){

				$('.mess_2').show();
				$('.etiqueta2').html('Email no son iguales');

				//var offset = $($(this).attr('href')).offset().top;
				$('html, body').animate({scrollTop:900}, 900);
			}
*/

		}

	});


});

</script>


                <div class="column12">
                    <p class="title-sec">Datos del Vendedor</p>
			<?php
				   /* MODIFICADO POR GGONZALEZ 13/05/2015 INI*/
					foreach ($info_clientes as $info): ?>

						<input type="checkbox" name="ext_visible" id="ext_visible" value="Si" <?php echo ($info['ext_visible']=="Si")?"checked":"" ?>>
						Mostrar esta información al cliente

						<label><span>Nombre:</span> <input type="text" name="ext_nombre" id="ext_nombre"  <?php echo 'value= "' . $this->session->userdata('user_name') . '"'; ?> data-bvalidator="required" />	</label>
						<label><span>Email:</span> <input type="text" name="ext_email" id="ext_email" <?php echo 'value= ' . $this->session->userdata('user_email'); ?> data-bvalidator="required"  />
							<div class="bVErrMsgContainer mess_1" style="position: absolute; display:none">
								<div class="bvalidator_errmsg" style="visibility: visible; position: absolute; top: -20px; left: 400px; display: block;">
									<em></em>
									<div style="display:table">
										<div style="display:table-cell">
											<div class="etiqueta1">Email es invalido.</div>
										</div>
										<div style="display:table-cell">
											<div class="bvalidator_close_icon" onclick="$(this).closest('.bvalidator_errmsg').css('visibility', 'hidden');">x</div>
										</div>
									</div>
								</div>
							</div>
							<em>Su direcci&oacute;n de correo no aparecer&aacute; visible en el anuncio.</em></label>
					   

							<!--<label><span>Confirmar Email:</span>-->          
							<input type="hidden" name="ext_email2" id="ext_email2"  <?php echo 'value= ' . $this->session->userdata('user_email'); ?> data-bvalidator="required" />
							<div class="bVErrMsgContainer mess_2" style="position: absolute; display:none">
								<div class="bvalidator_errmsg" style="visibility: visible; position: absolute; top: -20px; left: 400px; display: block;">
									<em></em>
									<div style="display:table">
										<div style="display:table-cell">
											<div class="etiqueta2">Email es invalido.</div>
										</div>
										<div style="display:table-cell">
											<div class="bvalidator_close_icon" onclick="$(this).closest('.bvalidator_errmsg').css('visibility', 'hidden');">x</div>
										</div>
									</div>
								</div>
							</div>
						</label>

						<label><span>Tel&eacute;fono 1:</span> <input type="text" name="ext_tel1" id="ext_tel1"  value="<?php echo $info['ext_tel1'];  ?>"  data-bvalidator="required" /></label>
						<label><span>Tel&eacute;fono 2:</span> <input type="text" name="ext_tel2" id="ext_tel2"  value="<?php echo $info['ext_tel2'];  ?>" /></label>
						<!-- /*INI - Modificado por: GGONZALEZ - 30/08/2016 */ -->
						<label><span>Ubicac&oacute;n:</span> <input type="text" name="ubicacion" id="ubicacion"  value="<?php echo $info['ubicacion'];  ?>" /></label>
						<!-- /*FIN - Modificado por: GGONZALEZ - 30/08/2016 */ -->
                  <?php
                     endforeach

				  /* MODIFICADO POR GGONZALEZ 13/05/2015 FIN*/
				  ?>


                    <label><span>Comentario:</span>
					<textarea name="descripcion" id="descripcion" cols="50" rows="5"><?php echo $car['descripcion'];  ?></textarea>
                    </label>

                    <div class="note">
                        <p>Nota: Por motivos de seguridad para nuestros clientes, el contacto por medio de correo electr&oacute;nico se har&aacute; por medio de la p&aacute;gina usadoscrediq.com en donde su correo elecatr&oacute;nico no ser&aacute; visible para el comprador.</p>
                        <p>Los anuncios gratuitos ser&aacute;n confirmados telef&oacute;nicamente al n&uacute;mero de tel&eacute;fono que proporcione en su anuncio, antes de ser publicado. Si tiene cualquier duda en cuanto a la publicaci&oacute;n de su anuncio o de las opciones ofrecidas, favor cont&aacute;ctenos a trav&eacute;s del chat en l&iacute;nea.</p>
                        <p>Importante:  Cualquier anuncio que sea publicado de accesorios &oacute; art&iacute;culos que no sean veh&iacute;culos COMPLETOS (no para repuestos), o que no sea para VENDER un veh&iacute;culo, ser&aacute; borrado. Adem&aacute;s, se permite anunciar &uacute;nicamente un veh&iacute;culo por anuncio, y no se permite anunciar veh&iacute;culos que no sean de los estilos o marcas disponibles, tales como cuadraciclos, go-carts, trailers, juguetes, etc. usadoscrediq.com se reserva el derecho de eliminar cualquier anuncio que no contenga toda la informaci&oacute;n requerida y "real", incluyendo: nombre del vendedor, n&uacute;meros de tel&eacute;fono, precio, modelo, cilindraje, etc. Cualquier veh&iacute;culo que sea vendido debe ser eliminado del sitio. Si el vendedor no lo elimina, usadoscrediq.com se reserva el derecho de hacerlo.</p>
                        <p>S&oacute;lo se permite anunciar veh&iacute;culos que ya se encuentren en el pa&iacute;s que eligi&oacute; .Cualquier anuncio que no cumpla con los requisitos aqu&iacute; descritos podr&aacute; ser eliminado por usadoscrediq.com </p>
                    </div>
                </div>

                <button type="submit" id="guardar_prod">Guardar Nuevo Veh&iacute;culo</button>

            </div>
        </div>
    </div>
</form>



<script type="text/javascript">
	$('#form_addCar').bValidator();
var editor = new wysihtml5.Editor("descripcion", {
	toolbar:     "wysihtml5-editor-toolbar",
	stylesheets: ["http://yui.yahooapis.com/2.9.0/build/reset/reset-min.css", "css/editor.css"],
	parserRules: wysihtml5ParserRules
});
</script>

<!--script adaptado de renting-->
<script>
$(function() {
     
    var aplica_renting = "<?php echo $car['recomendado'] ?>"
    if(aplica_renting == "1"){
        habilitarRenting();
    }else{
        desabilitarRenting();
    }
});

    function getCuotaRenting(){
        var precio = $('#precio').val();
        var tasa = $('#tasa_r').val();
        var plazo = $('#plazo_r').val();
        var nper = $('#plazo_r').val();
        var valor_res = $('#residual').val();
        var mante = $('#mantenimiento').val();
        var tipo_admi = $('#tipo_administrativo').val();
        var adminis = $('#administrativo').val();
        //nuevos cargos
        var gps = $('#gps_r').val();
        var seguro = $('#seguro_r').val();

        if(precio == ""){alert("Debe rellenar el campo precio!"); return;}
        if(tasa == "" || plazo ==""){alert("Debe seleccionar un plan reting!"); return;}
        if(valor_res == ""){alert("Debe rellenar el campo valor residual!"); return;}
        
        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>index.php/ajax/calcCuotaRenting', 
            data:{residual: valor_res, precio: precio, tasa: tasa, plazo: plazo, mantenimiento: mante, tipo_mante:tipo_admi, administrativo:adminis, gps:gps, seguro:seguro},
            success: function(data){
                $("#renting").val(data);
            }
        });
    }

    function llenarRenting(){
        $('#tasa_r').val("<?php echo $row_default['tasa_anual'] ?>");
        $('#plazo_r').val("<?php echo $row_default['plazo'] ?>");
        $("#renting").val("");
    }

    function desabilitarRenting(){
        document.getElementById('tasa_r').disabled = true;
        document.getElementById('plazo_r').disabled = true;
        document.getElementById('residual').disabled = true;
        document.getElementById('mantenimiento').disabled = true;
        document.getElementById('tipo_administrativo').disabled = true;
        document.getElementById('administrativo').disabled = true;
        document.getElementById('gps_r').disabled = true;
        document.getElementById('seguro_r').disabled = true;
        document.getElementById('btn_calculo_r').disabled = true;
        document.getElementById('btnllenarenting').disabled = true;
    }

    function habilitarRenting(){
        document.getElementById('tasa_r').disabled = false;
        document.getElementById('plazo_r').disabled = false;
        document.getElementById('residual').disabled = false;
        document.getElementById('mantenimiento').disabled = false;
        document.getElementById('tipo_administrativo').disabled = false;
        document.getElementById('administrativo').disabled = false;
        document.getElementById('gps_r').disabled = false;
        document.getElementById('seguro_r').disabled = false;
        document.getElementById('btn_calculo_r').disabled = false;
        document.getElementById('btnllenarenting').disabled = false;
    }

</script>
