
<?php $moneda = $this->session->userdata('moneda'); ?>
<aside class="column2 filters">
    <input type="hidden" name="tipo_venta" value="<?php echo $tipo_venta; ?>">
	
   <?php
    if ($this->session->userdata('pais') == 1) {

		$pais_amount= 1;
        ?>

    Precio en: <?php echo $moneda ?>
<div align="right">
		Min:&nbsp;&nbsp;<input type="text" id="amount1" style="text-align:right; height:25px;padding-right:5px; width:60px;-webkit-border-radius:3px;border:1px solid #ddd"  value="" onkeypress="validateKey(event,numbers)" onclick="this.value='';" /><br><br>
		Máx:&nbsp;&nbsp;<input type="text" id="amount2" style="text-align:right; height:25px;padding-right:5px; width:60px;-webkit-border-radius:3px;border:1px solid #ddd" value="" onkeypress="validateKey(event,numbers)" onclick="this.value='';" /> 
		<input type="hidden" id="amount" readonly /> 
</div>	
    <?php  }
    elseif ($this->session->userdata('pais') == 2) {
		$pais_amount= 2;
     ?>
		Precio en: <?php echo $moneda ?> <br>
	<div align="right">
		Min:&nbsp;&nbsp;<input type="text" id="amountcr1" style="text-align:right; height:25px;padding-right:5px; width:60px;-webkit-border-radius:3px;border:1px solid #ddd"  value="" onkeypress="validateKey(event,numbers)" onclick="this.value='';" /><br><br>
		Máx:&nbsp;&nbsp;<input type="text" id="amountcr2" style="text-align:right; height:25px;padding-right:5px; width:60px;-webkit-border-radius:3px;border:1px solid #ddd" value="" onkeypress="validateKey(event,numbers)" onclick="this.value='';" /> 
		<input type="hidden" id="amountcr" readonly /> 
	</div>	
    
    <?php  }
    elseif ($this->session->userdata('pais') == 3) {
		$pais_amount= 3;
     ?>

		Precio en: <?php echo $moneda ?> 	<div align="right">
		Min:&nbsp;&nbsp;<input type="text" id="amounthn1" style="text-align:right; height:25px;padding-right:5px; width:60px;-webkit-border-radius:3px;border:1px solid #ddd"  value="" onkeypress="validateKey(event,numbers)" onclick="this.value='';" /><br><br>
		Máx:&nbsp;&nbsp;<input type="text" id="amounthn2" style="text-align:right; height:25px;padding-right:5px; width:60px;-webkit-border-radius:3px;border:1px solid #ddd" value="" onkeypress="validateKey(event,numbers)" onclick="this.value='';" /> 
		<input type="hidden" id="amounthn" readonly /> 
	</div>	

   <?php } ?>
	 
	 Año: 	
	<div align="right">
		Desde:&nbsp;&nbsp;<input type="text" id="year1" style="text-align:right; height:25px;padding-right:5px; width:60px;-webkit-border-radius:3px;border:1px solid #ddd" maxlength="4" value="" onkeypress="validateKey(event,numbers)" onclick="this.value='';" /><br><br>
		Hasta:&nbsp;&nbsp;<input type="text" id="year2" style="text-align:right; height:25px;padding-right:5px; width:60px;-webkit-border-radius:3px;border:1px solid #ddd" maxlength="4" value="" onkeypress="validateKey(event,numbers)" onclick="this.value='';" /> 
		<input type="hidden" id="year" readonly /> 
	</div>	
	
	<label>Ingreso:</label>
    <select name="tipo_ingreso" id="tipo_ingreso" class="max-80">
        <option value="">Todos</option>
        <option value="G">Agencia</option>
        <option value="I">Importado</option>
    </select>
	<label>Categoría:</label>
    <select name="tipo_vehiculo" id="tipo_vehiculo" class="max-80" onChange="marcasByTipoExistentes(this.value);">
        <option value="todas">Todas</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['id_tipo_vehiculo']; ?>" <?php echo ($category['id_tipo_vehiculo'] == $this->session->userdata('CategoriaActual')) ? 'selected="selected"' : ''; ?>><?php echo $category['nombre']; ?></option>
        <?php endforeach ?>
    </select>
	<label>Marca:</label><br>
    <?php /*
	<select name="marca" id="marca" class="max-80"  > <!-- onChange="getModelsExistentes(this.value);" -->
        <option value="">Todas</option>
        <?php foreach ($marks as $mark): ?>
            <option value="<?php echo $mark['id_marca']; ?>"><?php echo $mark['nombre']; ?></option>
        <?php endforeach ?>
    </select>
	*/ ?>
	
  <?php $otrasMarcas="";
		foreach ($marks as $mark): 
			if($mark['visible']=="Si"){ ?>
				<div style="height:5px;" >
					<input type="checkbox" class="marcaDummy" name="marca1" style="-webkit-border-radius:3px;border:1px solid #ddd" value="<?php echo $mark['id_marca']; ?>"/>&nbsp;&nbsp;<?php echo $mark['nombre']; ?>
				</div><br>
	<?php	}else{
				if($otrasMarcas==""){
					$otrasMarcas=$mark['id_marca'];
				}else{
					$otrasMarcas=$otrasMarcas.','.$mark['id_marca'];
				}
			}
	?>
            
  <?php endforeach ?>
	  <div style="height:5px;">
		<input type="checkbox" class="marcaDummy" name="marca1" style="-webkit-border-radius:3px;border:1px solid #ddd" value="<?php echo $otrasMarcas ?>"/>&nbsp;&nbsp;OTRAS MARCAS
	  </div><br>
	<input type="hidden" id="modelo" name="modelo" value=""/>
	 
	 <!--
    <label>Modelo:</label>
    <select name="modelo" id="modelo" class="max-80"><option value="">Todos</option></select>
    -->
	
	<input type="hidden" id="combustible" name="combustible" value=""/>
	<!--
	<label>Combustible:</label>
	<select name="combustible" id="combustible" class="max-80">
        <option value="">Todos</option>
        <?php /* foreach ($combustibles as $combustible): ?>
            <option value="<?php echo $combustible['id_tipo_combustible']; ?>" ><?php echo $combustible['nombre']; ?></option>
        <?php endforeach */ ?>
    </select>
	-->
	<!--
    <label>Financiamiento:</label>
    <select name="financiamiento" id="financiamiento" class="max-80">
        <option value="">Todos</option>
        <option value="1">Con financiamiento</option>
        <option value="0">Sin financiamiento</option>
    </select>
	-->
	 <input type="hidden" id="financiamiento" name="financiamiento" value=""/>
	 <br>
    <label>Recomendados:</label>
    <select name="recomendados" id="recomendados" class="max-80">
        <option value="">Todos</option>
        <!--<option value="1">Recomendaci&oacute;n de CrediQ</option>-->
        <option value="1">Renting de CrediQ</option>
		<option value="2">Certificados de CrediQ</option>
    </select>
     <!--FIN - Modificado por: GGONZALEZ - 25/01/2015 -->
    <input type="hidden" id="transmision" name="transmision" value=""/>
	<!--
	<label>Transmisión:</label>
    <select name="transmision" id="transmision" class="max-80">
        <option value="">Todos</option>
        <option value="A">Automatica</option>
        <option value="M">Standard</option>
    </select>
	-->
	 


    <button id="boton_buscar" onclick="filter_charact(0, 1, '', '','<?php echo $pais_amount?>');">BUSCAR</button>


    <div id="loading">
        <img src="<?php echo base_url(); ?>public/images/enviando.gif" width="32" height="32" alt="enviando formulario" class="flotar" />
        <div id="enviando">Buscando...</div>
    </div>

</aside>

<form id="principal" action="<?php echo base_url(); ?>" method="Post">

</form>

<script>

    $('#loading').hide();
</script>
