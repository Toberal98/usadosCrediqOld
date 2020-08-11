<!-- Inicio add-producto *********************************************************************************************************************** -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/add-producto.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.bvalidator.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/filters.js"></script>


<?php if(isset($error)){ $usuario_existe=1; } ?>
<form id="form_reg_user" name="form_reg_user" accept-charset="utf-8" enctype="multipart/form-data" action="<?php echo base_url(); ?>index.php/savedata/saveAdvert" method="post" >
<div id="head-vehiculo">
	Crear nueva campa&ntilde;a
</div>
<span class="cabin_blue italic mleft-10">Datos de Campa&ntilde;a</span><span style="margin-left:260px;" class="cabin_blue italic mleft-10">Banners  Jpg, Png</span>
<div class="separator">&nbsp;</div>

<div class="labels left text-right">

	<label for="">Nombre: </label>
	<label for="">Seccion: </label>
	<label for="">Tipo de campaña: </label>
	<label for="">Posicion: </label>
	<label for="">Estado: </label>
	<label for="">Fecha inicio: </label>
	<label for="">Fecha fin: </label>
	<label for="">Link: </label>

</div>

<div class="inputs left">
	<input type="text" class="i_medium" name="nombre" id="nombre" data-bvalidator="required" >

	<select class="cabin_grey" name="seccion" id="seccion" data-bvalidator="required">
	  <option value="">-Seleccione-</option>
		<option  value="home">Home</option>
		<option  value="vehiculos-usados">Vehiculos usados</option>
		<option  value="contactenos">Cont&aacute;ctenos</option>
	</select>

	<select class="cabin_grey" name="tipo" id="tipo" data-bvalidator="required">
	    <option value="">-Seleccione-</option>
		<option  value="estatico">Est&aacute;tico</option>
		<option  value="rotador">Rotador</option>
		<option  value="dinamico">Rotador Din&aacute;mico</option>
	</select>

	<select class="cabin_grey" name="posicion" id="posicion" data-bvalidator="required">
	  	<option value="">-Seleccione-</option>
		<option  value="1">Baner-top</option>
		<option  value="2">Side</option>
	</select>

	<select class="cabin_grey" name="estado" id="estado" data-bvalidator="required">
	  	<option value="">-Seleccione-</option>
		<option  value="activo">Activo</option>
		<option  value="oculto">Oculto</option>
	</select>

  <input type="text" class="i_medium" name="inicio" id="inicio" data-bvalidator="required" >
  <input type="text" class="i_medium" name="fin" id="fin" data-bvalidator="required" >

  <input type="text" class="i_medium" name="link" id="link" data-bvalidator="required" >

  <div id="checkUser"></div>
	<input style="width:auto; height:auto;" type="image" src="<?php echo base_url() ?>public/images/guardar.png" alt="Guardar">
</div>

<div class="inputs left" style="margin-left:30px;">

  <input type="file" name="archivo1" id="archivo1" >
  <input type="text" placeholder="Texto Alternativo" name="nombre_img[]" id="nombre_img1">

  <input type="file" name="archivo2" id="archivo2" >
  <input type="text" placeholder="Texto Alternativo" name="nombre_img[]" id="nombre_img2" style="display:none">

  <input type="file" name="archivo3" id="archivo3" >
  <input type="text" placeholder="Texto Alternativo" name="nombre_img[]" id="nombre_img3" style="display:none">

  <input type="file" name="archivo4" id="archivo4" >
  <input type="text" placeholder="Texto Alternativo" name="nombre_img[]" id="nombre_img4" style="display:none">

</div>
</form>
<script type="text/javascript">

	//validacion de form 
	$('#form_reg_user').bValidator();

	//select tipo
	$('#tipo').change(function(){	

	if($(this).val() == "estatico"){

        $("#archivo1").fadeIn("medium");
        $("#archivo2").fadeOut("medium");
        $("#archivo3").fadeOut("medium");
        $("#archivo4").fadeOut("medium");   
        $("#nombre_img1").fadeIn("medium");
        $("#nombre_img2").fadeOut("medium");
        $("#nombre_img3").fadeOut("medium");
        $("#nombre_img4").fadeOut("medium");    
    }

    if($(this).val() == "rotador"){

        $("#archivo1").fadeIn("medium");
        $("#archivo2").fadeIn("medium");
        $("#archivo3").fadeIn("medium");
        $("#archivo4").fadeIn("medium");       
        $("#nombre_img1").fadeIn("medium");
        $("#nombre_img2").fadeIn("medium");
        $("#nombre_img3").fadeIn("medium");
        $("#nombre_img4").fadeIn("medium");       
    }

    if($(this).val() == "dinamico"){

        $("#archivo1").fadeIn("medium");
        $("#archivo2").fadeIn("medium");
        $("#archivo3").fadeIn("medium");
        $("#archivo4").fadeIn("medium");       
        $("#nombre_img1").fadeIn("medium");
        $("#nombre_img2").fadeIn("medium");
        $("#nombre_img3").fadeIn("medium");
        $("#nombre_img4").fadeIn("medium");       
    }
    
});

</script>
<div class="clear_0"></div>

<div class="separator">&nbsp;</div>

<div class="photos mleft-10"></div>
<br />
<br />
<div class="clear_0"></div>
<span class="cabin_gray_11">
<br />
<br />
</span>
<!-- FIN add-USUARIO *********************************************************************************************************************** -->