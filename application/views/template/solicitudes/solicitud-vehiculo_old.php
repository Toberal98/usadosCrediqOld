<?php
$c = 'checked="checked"';
$s = 'selected="selected"';

if ($this->session->userdata('solicitante')) {
    $d = $this->session->userdata('solicitante');
}
?>
<?php
$this->load->view('template/inc/header_stripe.php');
?>


<form id="form111" name="form111" method="post" action="<?php echo base_url() ?>index.php/solicitud_save/guardar_sol_vehiculo/" >

<div class="contenth1">
	<div class="container12">
    	<div class="row">
        	<div class="column4"><img src="<?php echo base_url() ?>public/img/man.jpg" alt=""/></div>
        	<div class="column8">
            	<h1>Solicite su Vehículo<span></span></h1>
                
                <div class="formDatos">
                	<label><span>Nombre *:</span> <input type="text" name="cli_nombre" id="cli_nombre" data-bvalidator="alpha,minlength[3],required" /></label> 
                    <label><span>Email *:</span> <input type="text" name="cli_email" id="cli_email" data-bvalidator="email, required" /> </label>
                    <label><span>Teléfono:</span> <input type="text" name="cli_telefono_fijo" id="cli_telefono_fijo" data-bvalidator="number, minlength[8],required" onkeypress="validateKey(event, numericKeys)"/></label>  
                    <label><span>Celular *:</span> <input type="text" name="cli_telefono_celular" id="cli_telefono_celular" data-bvalidator="number, minlength[8],required" onkeypress="validateKey(event, numericKeys)"/></label>
                    <label><span>Teléfono Oficina:</span> <input type="text" name="cli_telefono_oficina" id="cli_telefono_oficina" data-bvalidator="number, minlength[8],required" onkeypress="validateKey(event, numericKeys)"/></label>                    
                    <label><span>Tipo de Vehículo</span>
                    <select class="cabin_grey" name="cli_tipo_vehiculo" id="cli_tipo_vehiculo"  data-bvalidator="required">
                    <option value="">-Seleccione-</option>
                    <?php foreach ($allcategories as $category): ?>
                        <option value="<?php echo $category['id_tipo_vehiculo']; ?>" <?php
                        if ($car['tipo_vehiculo'] == $category['id_tipo_vehiculo']) {
                            echo ' selected="selected" ';
                        }
                        ?>    ><?php echo $category['nombre']; ?></option>
                            <?php endforeach ?>
                </select> 
                    </label>
                    <label><span>Marca *:</span> <select class="cabin_grey" name="cli_marcas" id="cli_marcas" onchange="getModels(this.value);" data-bvalidator="required">
                    <option value="">-Seleccione-</option>
                    <?php foreach ($marks as $mark): ?>
                        <option value="<?php echo $mark['id_marca']; ?>" <?php
                        if (isset($car['id_marca'])) {
                            if ($car['id_marca'] == $mark['id_marca']) {
                                echo ' selected="selected" ';
                            }
                        }
                        ?>><?php echo $mark['nombre']; ?></option>
                            <?php endforeach ?>
                </select>
                    </label>
                    <label class="field-inline"><span>Antig&uuml;edad *:</span> 
                        <select name="cli_anio_desde" id="cli_anio_desde" style="width:70px;"  data-bvalidator="required">
                    <option  selected="selected" >Desde </option>
                    <?php for ($i = date('Y'); $i > (date('Y') - 5); $i--): ?>
                        <option value="<?php echo $i; ?>"  <?php
                        /*if ($car['year'] == $i) {
                            echo ' selected="selected" ';
                        }*/
                        ?>   ><?php echo $i; ?></option>
                            <?php endfor ?>
                </select>
                       <select name="cli_anio_hasta" id="cli_anio_hasta" style="width:70px;" data-bvalidator="required" >
                           <option  selected="selected" >Hasta</option>
                    <?php for ($i = date('Y'); $i > (date('Y') - 5); $i--): ?>
                        <option value="<?php echo $i; ?>"  <?php
                        /*if ($car['year'] == $i) {
                            echo ' selected="selected" ';
                        }*/
                        ?>   ><?php echo $i; ?></option>
                            <?php endfor ?>
                </select>
                    </label>
                    <label class="field-inline"><span>Precio *:</span><input type="text" name="cli_precio_desde" id="cli_precio_desde" data-bvalidator="number, minlength[2],maxlength[8],required" onkeypress="validateKey(event, numericKeys)" placeholder="Desde" /><input type="text" name="cli_precio_hasta" id="cli_precio_hasta" data-bvalidator="number, minlength[2],maxlength[8],required" onkeypress="validateKey(event, numericKeys)" placeholder="Hasta" /></label>
                    <label><input type="checkbox"  name="cli_procedencia_importado" id="cli_procedencia_importado" value="1" checked/> Importado</label> 
                    <label><input type="checkbox"  type="checkbox" name="cli_procedencia_agencia" id="cli_procedencia_agencia"  value="1" checked/> Agencia</label>
                    <div class="inline">
                        <label><span>Comentario:</span> <textarea name="cli_comentarios" id="cli_comentarios" ></textarea></label>
                        
                    <p><input type="checkbox" checked/> Autorizo a usadoscrediq.com a utilizar mi información personal para uso interno, tales como promociones, ofertas, etc., siempre y cuando no comparta información con terceras personas. </p>
                    <p><input type="checkbox" checked/> No autorizo a usadoscrediq.com a utilizar mi información personal para ningún otro propósito más que para ser enviada a CrediQ.</p>
                    <p><input type="checkbox" checked/> Autorizo a GRUPO Q EL SALVADOR, S.A DE S.V., en adelante las "Las Empresas" para que consulten mi comportamiento crediticio para la concesión de este crédito para efectos de análisis con entidades especializadas en la prestación de servicios de información o buros de crédito, incluyendo aquellas que recolecten, registran, procesan, distribuyen datos, referentes al comportamiento crediticio de las personas y ofrecen servicios de información de base de datos. </p>
                    <p><strong>NOTA:</strong> al remitir esta solicitud autorizo a CrediQ para realizar consulta sobre mi referencia crediticia.</p>
                        <button type="submit">Enviar</button>
                    </div>                     
                </div>
                
            </div>             
        </div>
    </div>
</div>

    
         
</form>
<script type="text/javascript">
    $('#form111').bValidator();
</script>	
