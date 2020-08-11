<!-- Inicio add-producto *********************************************************************************************************************** -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/add-producto.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.bvalidator.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/filters.js"></script>


<?php if(isset($error)){ $usuario_existe=1; } ?>
<form id="form_reg_user" name="form_reg_user" accept-charset="utf-8" enctype="multipart/form-data" action="<?php echo base_url(); ?>index.php/savedata/updateAdvert/<?php echo $banner['id_banner']; ?>" method="post" >
<div id="head-vehiculo">
	Modificar campa&ntilde;a
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
	<input type="text" class="i_medium" name="nombre" id="nombre" value="<?php echo $banner['nombre']; ?>" data-bvalidator="required" >

	<select class="cabin_grey" name="seccion" id="seccion" data-bvalidator="required">
	  <option value="">-Seleccione-</option>
		<option <?php if($banner['seccion']=='home'){ ?>            selected="selected"<?php } ?> value="home">Home</option>
		<option <?php if($banner['seccion']=='vehiculos-usados'){ ?>selected="selected"<?php } ?> value="vehiculos-usados">Vehiculos usados</option>
		<option <?php if($banner['seccion']=='contactenos'){ ?>     selected="selected"<?php } ?> value="contactenos">Cont&aacute;ctenos</option>
	</select>

	<select class="cabin_grey" name="tipo" id="tipo" data-bvalidator="required">
	    <option value="">-Seleccione-</option> 
		<option <?php if($banner['tipo']=='estatico'){ ?>selected="selected"<?php } ?> value="estatico">Est&aacute;tico</option>
		<option <?php if($banner['tipo']=='rotador'){ ?>selected="selected"<?php } ?> value="rotador">Rotador</option>
		<option <?php if($banner['tipo']=='dinamico'){ ?>selected="selected"<?php } ?> value="dinamico">Rotador Din&aacute;mico</option>
	</select>

	<select class="cabin_grey" name="posicion" id="posicion" data-bvalidator="required">
	  	<option value="">-Seleccione-</option>
		<option <?php if($banner['posicion']=='1'){ ?>selected="selected"<?php } ?> value="1">Baner-top</option>
		<option <?php if($banner['posicion']=='2'){ ?>selected="selected"<?php } ?> value="2">Side</option>
	</select>

	<select class="cabin_grey" name="estado" id="estado" data-bvalidator="required">
	  	<option value="">-Seleccione-</option>
		<option <?php if($banner['estado']=='activo'){ ?>selected="selected"<?php } ?> value="activo">Activo</option>
		<option <?php if($banner['estado']=='oculto'){ ?>selected="selected"<?php } ?> value="oculto">Oculto</option>
	</select>

  <input type="text" class="i_medium" name="inicio" id="inicio" data-bvalidator="required" value="<?php echo $banner['fecha_publicacion'] ?>" >
  <input type="text" class="i_medium" name="fin" id="fin" data-bvalidator="required"  value="<?php echo $banner['fecha_expiracion'] ?>" >

  <input type="text" class="i_medium" name="link" id="link" data-bvalidator="required"  value="<?php echo $banner['link'] ?>">

  <div id="checkUser"></div>
	<input style="width:auto; height:auto;" type="image" src="<?php echo base_url() ?>public/images/guardar.png" alt="Guardar">
</div>

<div class="inputs left" style="margin-left:30px;">
<?php 
	$i=1;
	foreach($banner_imgs as $banner_image){
?>
		<img src="<?php echo base_url().'public/banners/'.$banner_image['imagen'];  ?>" alt="" width="200" height="70" id="img<?php echo $i;  ?>">
		<input type="file"  name="archivo<?php echo $i; ?>" id="archivo<?php echo $i; ?>" >
		<input type="text" placeholder="Texto Alternativo" value="<?php echo $banner_image['alt_text']; ?>" name="nombre_img[]" id="nombre_img<?php echo $i; ?>"><br />	
<?php
	$i++; 	
	}
	for($v=$i;$v<=4;$v++){
?>
		<input type="file"  name="archivo<?php echo $v; ?>" id="archivo<?php echo $v; ?>" >
		<input type="text" placeholder="Texto Alternativo" name="nombre_img[]" id="nombre_img<?php echo $v; ?>"><br />	
<?php 
	}
?>

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
        $("#img1").fadeIn("medium");
        $("#img2").fadeOut("medium");
        $("#img3").fadeOut("medium");
        $("#img4").fadeOut("medium");    
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
        $("#img1").fadeIn("medium");
        $("#img2").fadeIn("medium");
        $("#img3").fadeIn("medium");
        $("#img4").fadeIn("medium");       
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
        $("#img1").fadeIn("medium");
        $("#img2").fadeIn("medium");
        $("#img3").fadeIn("medium");
        $("#img4").fadeIn("medium");       
    }
    
});


	<?php if($banner['tipo']=='estatico'){ ?>
		
		$("#archivo1").fadeIn("medium");
        $("#archivo2").fadeOut("medium");
        $("#archivo3").fadeOut("medium");
        $("#archivo4").fadeOut("medium");
        $("#nombre_img1").fadeIn("medium");
        $("#nombre_img2").fadeOut("medium");
        $("#nombre_img3").fadeOut("medium");
        $("#nombre_img4").fadeOut("medium");  
        $("#img1").fadeIn("medium");
        $("#img2").fadeOut("medium");
        $("#img3").fadeOut("medium");
        $("#img4").fadeOut("medium");   
		
	<?php }else{ ?>
		
	 	$("#archivo1").fadeIn("medium");
        $("#archivo2").fadeIn("medium");
        $("#archivo3").fadeIn("medium");
        $("#archivo4").fadeIn("medium");
        $("#nombre_img1").fadeIn("medium");
        $("#nombre_img2").fadeIn("medium");
        $("#nombre_img3").fadeIn("medium");
        $("#nombre_img4").fadeIn("medium");
        $("#img1").fadeIn("medium");
        $("#img2").fadeIn("medium");
        $("#img3").fadeIn("medium");
        $("#img4").fadeIn("medium");      
		
	<?php } ?>


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