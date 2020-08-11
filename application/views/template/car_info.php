

<?php
$this->load->view('template/inc/header_stripe.php');
?>





<form id="form_contactenos" name="form_contactenos" accept-charset="utf-8" action="<?php echo base_url() ?>index.php/car/proccessInfo"  method="post" >

    <div class="content">
	<div class="container12">
    	<div class="row">
        	<div class="column4"><img src="img/woman.jpg" alt=""/></div>
        	<div class="column8">
                    <h3>Solicitar informaci&oacute;n - <span>Marca: <?php echo $car['marca']; ?> - Modelo: <?php echo $car['modelo']; ?> </span></h3>
                
                <div class="formDatos">
                    <label><span>Nombre:</span> <input type="text" name="nombre" id="nombre" style="width: 150px" data-bvalidator="required"></label>
                    <label><span>Telefono:</span> <input type="text" name="telefono" id="telefono" ></label>
                    <label><span>Email *:</span> <input type="text" name="email" id="email" data-bvalidator="email,required" ></label>
                    <label><span>Consulta:</span> <textarea name="consulta" id="consulta" cols="20" rows="4"></textarea></label>
                    
                    
                    <input type="hidden"  name="marca" id="marca" value="<?php echo $car['marca']; ?>">
                    <input type="hidden"  name="modelo" id="modelo" value="<?php echo $car['modelo']; ?>">
                    <input type="hidden"  name="3m41l" id="3m41l" value="<?php echo str_replace('@','#',$user['email']); ?>">
                    <input type="hidden"  name="id" id="id" value="<?php echo $car['id_automovil']; ?>">
  
                    <div class="inline">
                        <button type="submit">Enviar</button>
                    </div>                     
                </div>
                
            </div>             
        </div>
    </div>
</div>

    
    <div id="head-vehiculo">Solicitar informacion</div>

<div class="separator">&nbsp;</div>



<div class="inputs left">
  <input type="text" name="nombre" id="nombre" style="width: 150px" data-bvalidator="required">
  <input type="text" name="telefono" id="telefono" >
  <input type="text" name="email" id="email" data-bvalidator="email,required" >
  

  
</div>
<!--Columna 2-->
<div class="labels left text-right"></div>

<div class="inputs left"></div>

<div class="clear_0"></div>

<div class="separator">&nbsp;</div>

<div class="photos mleft-10"></div>

<div class="clear_10"></div>
<span class="cabin_blue italic mleft-10">
	<input type="image" src="<?php echo base_url() ?>public/images/enviar.jpg" class="left mleft-10" alt="Guardar">
</span>












</form>
<script type="text/javascript">
	$('#form_contactenos').bValidator();
</script>

