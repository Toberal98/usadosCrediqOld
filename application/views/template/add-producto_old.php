<?php date_default_timezone_set('America/El_Salvador'); ?>
<!-- Editor WYSIWYG -->
<!--link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/stylesheet_editor.css"-->
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/add-producto.js"></script>
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

<form id="form_addCar" name="form_addCar" accept-charset="utf-8" action="<?php echo base_url(); ?>index.php/savedata/savecar/guardar" enctype="multipart/form-data" method="post" >



    <div class="content">
        <div class="container12">
            <div class="row agregarNuevo">
                <h3>Añadir Nuevo Veh&iacute;culo<span></span></h3> 

                <p class="title-sec">Caracter&iacute;sticas</p> <?php echo $this->session->userdata('pais');?>
                <div class="column6">	            
                    <label><span>Marca:</span> <select class="cabin_grey" name="marca" id="marca" onchange="getModels(this.value);" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <?php foreach ($marks as $mark): ?>
                                <option value="<?php echo $mark['id_marca']; ?>"><?php echo $mark['nombre']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </label>
                    <label><span>Modelo:</span> 
                        <select class="cabin_grey" name="modelo" id="modelo" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                        </select>
                    </label>
                    <label><span>Año:</span> <select class="cabin_grey" name="year" id="year" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <?php for ($i = date('Y'); $i > (date('Y') - 15); $i--): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor ?>
                        </select>
                    </label>
                    <label><span>Tipo Combustible:</span> <select class="cabin_grey" name="tipo_combus" id="tipo_combus" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <?php foreach ($combustibles as $combustible): ?>
                                <option value="<?php echo $combustible['id_tipo_combustible']; ?>"><?php echo $combustible['nombre']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </label>
                    <label><span>Tipo Veh&iacute;culo:</span> <select class="cabin_grey" name="tipo_vehiculo" id="tipo_vehiculo" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <?php foreach ($allcategories as $category): ?>
                                <option value="<?php echo $category['id_tipo_vehiculo']; ?>"><?php echo $category['nombre']; ?></option>
                            <?php endforeach ?>
                        </select>

                    </label>
                    <label><span>Tipo Transmisi&oacute;n:</span> <select class="cabin_grey" name="transmision" id="transmision" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <option value="A">Automatica</option>
                            <option value="M">Manual</option>
                        </select>
                    </label>
                    <label><span>No. de Placa:</span> <input type="text" class="i_medium" name="num_placa" id="num_placa" data-bvalidator="required"> <em>Ingresa n&uacute;mero completo.</em></label>
                    <label><span>Kilometraje:</span> <input type="text" class="i_medium" name="kilometraje" id="kilometraje" data-bvalidator="number,required"><em>Kms.</em></label>
                    <!--label><span>Capacidad Motor:</span> <input type="text" class="i_medium" name="cap_motor" id="cap_motor" data-bvalidator="number,required"></label-->
                    
                   <label><span>Capacidad Motor:</span><select name="capacidadMotor" class="i_medium" name="cap_motor" id="cap_motor" data-bvalidator="required">
                                                <option value="800">800 cc</option>
                                                <option value="900">900 cc</option>
                                                <option value="1000">1000 cc</option>
                                                <option value="1100">1100 cc</option>
                                                <option value="1200">1200 cc</option>
                                                <option value="1300">1300 cc</option>
                                                <option value="1400">1400 cc</option>
                                                <option value="1500">1500 cc</option>
                                                <option value="1600">1600 cc</option>
                                                <option value="1700">1700 cc</option>
                                                <option value="1800">1800 cc</option>
                                                <option value="1900">1900 cc</option>
                                                <option value="2000">2000 cc</option>
                                                <option value="2100">2100 cc</option>
                                                <option value="2200">2200 cc</option>
                                                <option value="2300">2300 cc</option>
                                                <option value="2400">2400 cc</option>
                                                <option value="2500">2500 cc</option>
                                                <option value="2600">2600 cc</option>
                                                <option value="2700">2700 cc</option>
                                                <option value="2800">2800 cc</option>
                                                <option value="2900">2900 cc</option>
                                                <option value="3000">3000 cc</option>
                                                <option value="3100">3100 cc</option>
                                                <option value="3200">3200 cc</option>
                                                <option value="3300">3300 cc</option>
                                                <option value="3400">3400 cc</option>
                                                <option value="3500">3500 cc</option>
                                                <option value="3600">3600 cc</option>
                                                <option value="3700">3700 cc</option>
                                                <option value="3800">3800 cc</option>
                                                <option value="3900">3900 cc</option>
                                                <option value="4000">4000 cc</option>
                                                <option value="4100">4100 cc</option>
                                                <option value="4200">4200 cc</option>
                                                <option value="4300">4300 cc</option>
                                                <option value="4400">4400 cc</option>
                                                <option value="4500">4500 cc</option>
                                            </select></label>
                    
                </div>


                <div class="column6"> 
                    <label><span>Tracci&oacute;n:</span> <select class="cabin_grey" name="traccion" id="traccion" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <option value="Delantera">Delantera</option>
                            <option value="Trasera">Trasera</option>
                            <option value="4x2">4x2</option>
                            <option value="4x4">4x4</option>
                        </select>
                    </label>
                    <label><span>Color Interior:</span> <select class="cabin_grey" name="color_in" id="color_in">
                            <option value="">-Seleccione un Color-</option>
                            <?php foreach ($colors as $color): ?>
                                <option value="<?php echo $color['id_color']; ?>" ><?php echo $color['nombre']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </label>
                    <label><span>Color Exterior:</span> <select class="cabin_grey" name="color_out" id="color_out" data-bvalidator="required">
                            <option value="">-Seleccione un Color-</option>
                            <?php foreach ($colors as $color): ?>
                                <option value="<?php echo $color['id_color']; ?>" ><?php echo $color['nombre']; ?></option>
                            <?php endforeach ?>
                        </select></label>
                    <label><span>No. de Puertas:</span> <select class="cabin_grey" name="num_puertas" id="num_puertas" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>

                    </label>
                    <label><span>No. de Asientos:</span> <select class="cabin_grey" name="num_asientos" id="num_asientos" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <option value="2">2</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                        </select>
                    </label>
                    <label><span>Procedencia:</span> <select class="cabin_grey" name="tipo_ingreso" id="tipo_ingreso" data-bvalidator="required" onchange="mostrar(this.value);">
                            <option value="">-Seleccione-</option>
                            <option value="I">Importado</option>
                            <option value="G">De Agencia</option>
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
                    <label><span>Precio:</span>  
                            <input type="text" class="i_medium" name="precio" id="precio" data-bvalidator="number,required, minlength[3], maxlength[9]">                           
                        
                    </label>
                    <label><span>Moneda:</span> <select class="precio_list" name="moneda_venta" id="moneda_venta" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <option value="US$">Dolares(US$)</option>
                            <option value="L">Lempiras(L)</option>
                            <option value="¢">Colones(¢)</option>
                        </select>
                    </label>
                    <p><span>¿Negociable?</span> <label><input type="radio" name="negociable" id="negociable" value="1">Si</label> <label> <input type="radio" name="negociable" id="negociable" value="0">No</label></p>
                    <label><span>Estado Veh&iacute;culo:</span>  <select class="cabin_grey" name="condiciones" id="condiciones" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <option value="Excelente">Excelente</option>
                            <option value="Muy Bueno">Muy Bueno</option>
                            <option value="Bueno">Bueno</option>
                            <option value="Regular">Regular</option>
                        </select></label>
                    <label><span><?php echo $texto_dep; ?>:</span>
                        <select class="cabin_grey" name="departamento" id="departamento" data-bvalidator="required"><!-- departamento *************************-->
                            <option value="">-Seleccione-</option>
                            <?php
                            foreach ($departamentos as $departamento):
                                echo '<option value="' . $departamento['id_departamento'] . '">' . $departamento['nombre'] . '</option>';
                            endforeach
                            ?>

                        </select>
                    </label>
                </div>

                <div class="column6">
                    <p class="title-sec">Equipamiento</p>
                    <ul class="equipamiento">                    
                        <?php
                        $i = 1;
                        foreach ($equipamiento_list as $equipo):
                            echo ' <li><label><input type="checkbox" name="' . $equipo['id_eq'] . '" id="' . $equipo['id_eq'] . '" value="' . $equipo['id_eq'] . '"/>' . $equipo['nombre'] . '</label></li>';
                            $i++;
                        endforeach
                        ?>
                    </ul>
                </div>            


                <script type="text/javascript">

                    $(function() {

                        var swf = '<?php echo base_url() ?>public/uploadify.swf';

<?php
$tipo_foto = array();
$tipo_foto[1] = 'FRONTAL';
$tipo_foto[2] = 'TRASERA';
$tipo_foto[3] = 'LATERAL';
$tipo_foto[4] = 'INTERIOR';

for ($i = 1; $i <= 4; $i++) {
    ?>
                            var uploader = '<?php echo base_url() ?>index.php/ajax/doUpload';//se hace adentro para llenar numero de imagen que se envia
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
                    });

                </script>


                <div class="column6">
                    <p class="title-sec">Fotograf&iacute;as</p>
                      <div class="photos">

        <?php
        for ($v = 1; $v <= 4; $v++) {

            if ($v <= 2) {
                $requerido = 'data-bvalidator="required"';
            } else {
                $requerido = "";
            }

            echo '
				<div >
					<div><span class="cabin_white">' . $tipo_foto[$v] . '</span></div>
					<span id="previa' . $v . '">
						<img src="' . base_url() . 'public/img/thumb.png" id="prvw1" alt="Subir Foto">
					</span>
					<input type="file" name="imagen' . $v . '" id="imagen' . $v . '" class="f-hide" ' . $requerido . ' >
				</div>
				<input type="hidden" name="tipo_foto' . $v . '" id="tipo_foto' . $v . '" value="0000' . $v . '" />
				<input type="hidden" name="desc_foto' . $v . '" id="desc_foto' . $v . '" value="' . $tipo_foto[$v] . '" />';
        }
        ?>

                          
   
                          
    </div><!-- fin photos -->

                </div> 


              

                <div class="column12">
                    <p class="title-sec">Datos Adicionales</p>

                    <label><span>Nombre:</span> <input type="text" name="ext_nombre" id="ext_nombre"  <?php echo 'value= "' . $this->session->userdata('user_name') . '"'; ?> data-bvalidator="required" />	</label>
                    <label><span>Email:</span> <input type="text" name="ext_email" id="ext_email" <?php echo 'value= ' . $this->session->userdata('user_email'); ?> data-bvalidator="email, required"  />
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
                    <label><span>Confirmar Email:</span>             <input type="text" name="ext_email2" id="ext_email2"  <?php echo 'value= ' . $this->session->userdata('user_email'); ?> data-bvalidator="required" />
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
                    <label><span>Tel&eacute;fono 1:</span> <input type="text" name="ext_tel1" id="ext_tel1"  data-bvalidator="required" /></label>
                    <label><span>Tel&eacute;fono 2:</span> <input type="text" name="ext_tel2" id="ext_tel2"  /></label>
                    <label><span>Comentario:</span> 
                        <textarea name="descripcion" id="descripcion" cols="50" rows="5"></textarea>
                    </label>

                    <div class="note">
                        <p>Nota: Por motivos de seguridad para nuestros clientes, el contacto por medio de correo electr&oacute;nico se har&aacute; por medio de la p&aacute;gina usadoscrediq.com en donde su correo elecatr&oacute;nico no ser&aacute; visible para el comprador.</p>
                        <p>Los anuncios gratuitos ser&aacute;n confirmados telef&oacute;nicamente al n&uacute;mero de tel&eacute;fono que proporcione en su anuncio, antes de ser publicado. Si tiene cualquier duda en cuanto a la publicaci&oacute;n de su anuncio o de las opciones ofrecidas, favor cont&aacute;ctenos a trav&eacute;s del chat en l&iacute;nea.</p>
                        <p>Importante:  Cualquier anuncio que sea publicado de accesorios &oacute; art&iacute;culos que no sean veh&iacute;culos COMPLETOS (no para repuestos), o que no sea para VENDER un veh&iacute;culo, ser&aacute; borrado. Adem&aacute;s, se permite anunciar &uacute;nicamente un veh&iacute;culo por anuncio, y no se permite anunciar veh&iacute;culos que no sean de los estilos o marcas disponibles, tales como cuadraciclos, go-carts, trailers, juguetes, etc. usadoscrediq.com se reserva el derecho de eliminar cualquier anuncio que no contenga toda la informaci&oacute;n requerida y "real", incluyendo: nombre del vendedor, n&uacute;meros de tel&eacute;fono, precio, modelo, cilindraje, etc. Cualquier veh&iacute;culo que sea vendido debe ser eliminado del sitio. Si el vendedor no lo elimina, usadoscrediq.com se reserva el derecho de hacerlo.</p>
                        <p>S&oacute;lo se permite anunciar veh&iacute;culos que ya se encuentren en el pa&iacute;s que eligi&oacute; .Cualquier anuncio que no cumpla con los requisitos aqu&iacute; descritos podr&aacute; ser eliminado por usadoscrediq.com </p>
                    </div>
                </div>

                <button type="submit">Guardar Nuevo Veh&iacute;culo</button>

            </div>
        </div>
    </div>
</form>






<!--span class="precio_extranjero">


    <input type="text" class="precio" value="Moneda"   name="moneda"   id="moneda" data-bvalidator="required"  onfocus="clearText(this)" onblur="clearText(this)">
</span-->


  <script>

                    $(document).ready(function() {
                        $('#guardar_prod').mouseover(function() {
                            if ($('#ext_email').val() != "") {
                                if (validar_email($('#ext_email').val()) == false) {
                                    $('.mess_1').show();
                                    $('.etiqueta1').html('Email invalido');
                                }

                                if ($('#ext_email').val() != $('#ext_email2').val()) {
                                    $('.mess_2').show();
                                    $('.etiqueta2').html('Email no son iguales');
                                    $('html, body').animate({scrollTop: 900}, 900);

                                }
                            }

                        });


                    });

                </script>

<script type="text/javascript">
    $('#form_addCar').bValidator();

    var editor = new wysihtml5.Editor("descripcion", {
        toolbar: "wysihtml5-editor-toolbar",
        stylesheets: ["http://yui.yahooapis.com/2.9.0/build/reset/reset-min.css", "css/editor.css"],
        parserRules: wysihtml5ParserRules
    });


</script>