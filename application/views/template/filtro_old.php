
<?php $moneda = $this->session->userdata('moneda'); ?>
<aside class="column2 filters">
    <label>Categoría:</label>
    <select name="tipo_vehiculo" id="tipo_vehiculo" class="max-80" onChange="marcasByTipoExistentes(this.value);">
        <option value="todas">Todas</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['id_tipo_vehiculo']; ?>" <?php echo ($category['id_tipo_vehiculo'] == $this->session->userdata('CategoriaActual')) ? 'selected="selected"' : ''; ?>><?php echo $category['nombre']; ?></option>
        <?php endforeach ?>
    </select>
    <label>Marca:</label>
    <select name="marca" id="marca" class="max-80" onChange="getModelsExistentes(this.value);" >
        <option value="">Todas</option>
        <?php foreach ($marks as $mark): ?>
            <option value="<?php echo $mark['id_marca']; ?>"><?php echo $mark['nombre']; ?></option>
        <?php endforeach ?>
    </select>
    <label>Modelo:</label>
    <select name="modelo" id="modelo" class="max-80"><option value="">Todos</option></select>
    <label>Combustible:</label>
    <select name="combustible" id="combustible" class="max-80">
        <option value="">Todos</option>
        <?php foreach ($combustibles as $combustible): ?>
            <option value="<?php echo $combustible['id_tipo_combustible']; ?>" ><?php echo $combustible['nombre']; ?></option>
        <?php endforeach ?>
    </select>
    <label>Financiamiento:</label>
    <select name="financiamiento" id="financiamiento" class="max-80">
        <option value="">Todos</option>
        <option value="1">Con financiamiento</option>
        <option value="0">Sin financiamiento</option>
    </select>
     <!--INI - Modificado por: GGONZALEZ - 25/01/2015 --> 
     </select>
    <label>Recomendados:</label>
    <select name="recomendados" id="recomendados" class="max-80">
        <option value="">Todos</option>
        <option value="1">Recomendaci&oacute;n de CrediQ</option>        
    </select> 
     <!--FIN - Modificado por: GGONZALEZ - 25/01/2015 --> 
    <label>Transmisión:</label>
    <select name="transmision" id="transmision" class="max-80">
        <option value="">Todos</option>
        <option value="A">Automatica</option>
        <option value="M">Standard</option>

    </select>
    <label>Ingreso:</label>
    <select name="tipo_ingreso" id="tipo_ingreso" class="max-80">
        <option value="">Todos</option>
        <option value="G">Agencia</option>
        <option value="I">Importado</option>
    </select>
    <label for="year" class="year">Año: <input type="text" id="year" readonly /> </label>               
    <div id="slider-range-year" class="slider-range"></div>

    <label for="hasta" class="amount">Precio en: <?php echo $moneda ?> <input type="text" id="amount" readonly /> </label>               
   <div id="slider-range-amount" class="slider-range"></div> 

    <button id="boton_buscar" onclick="filter_charact(0, 1, '', '');">BUSCAR</button>


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



