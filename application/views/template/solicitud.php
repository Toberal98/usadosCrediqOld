<?php if (!isset($tipo_solicitud)) {
    $tipo_solicitud = 'natural';
    $controlador = 'solicitud_save';
} ?>
<form id="form1" name="form1" method="post" action="<?php echo base_url() ?>index.php/<?php echo $controlador; ?>/credito_<?php echo $tipo_solicitud ?>/1" >
    <input type="hidden" name="tipo_solicitud" id="tipo_solicitud" value="<?php echo $tipo_solicitud ?>">

    <div id="head-vehiculo">Solicitud de credito Persona <?php echo $tipo_solicitud ?></div>

    <div class="separator_fields"></div>

    <span class="cabin_blue">Servicio/Producto que solicita  </span>
    <div class="clear_0"></div>
    <?php
    $c = 'checked="checked"';
    if ($this->session->userdata('datos_generales')) {
        $d = $this->session->userdata('datos_generales');
    } else {
        $d = array('id' => '',
            'fecha' => '',
            'id_usuario' => '',
            'producto' => '',
            'valor_de_compra' => '',
            'valor_de_prima' => '',
            'canje' => '',
            'valor_a_financiar' => '',
            'plazo' => '',
            'prima' => '',
            'tasa' => '',
            'garantia' => '',
            'nueva' => '',
            'usada' => '',
            'marca' => '',
            'modelo' => '',
            'asesor_de_ventas' => '',
            'fecha_sugerida_de_pago' => '',
            'tipo_solicitud' => 'credito_natural'
        );
    }
    ?>
    <p style="float:left; display:block;">
        <input name="producto" type="radio" id="producto" value="Credito decreciente" <?php if ($d['producto'] == 'Credito decreciente') {
        echo $c;
    } ?> />
        <label>Credito decreciente</label>
        <br/>
        <input type="radio" name="producto" id="producto" value="Linea de credito rotativa" <?php if ($d['producto'] == 'Linea de credito rotativa') {
        echo $c;
    } ?> />
        <label>Linea de credito rotativa</label>
        <br/>
        <input type="radio" name="producto" id="producto" value="Leasing" <?php if ($d['producto'] == 'Leasing') {
        echo $c;
    } ?> />
        <label>Leasing</label>
        <br/>
        <input type="radio" name="producto" id="producto" value="ServiQ Contacto" <?php if ($d['producto'] == 'ServiQ Contacto') {
        echo $c;
    } ?> />
        <label>ServiQ Contrato</label>
        <br/>

    </p>


    <p style="float:left; display:block; margin-left:50px;">

        <input type="radio" name="producto" id="producto" value="Taller" <?php if ($d['producto'] == 'Taller') {
        echo $c;
    } ?> />
        <label>Taller</label>
        <br />
        <input type="radio" name="producto" id="producto" value="Repuestos" <?php if ($d['producto'] == 'Repuestos') {
        echo $c;
    } ?> />
        <label for="producto">Repuestos</label>
        <br/>
        <input type="radio" name="producto" id="producto" value="Mayoreo" <?php if ($d['producto'] == 'Mayoreo') {
        echo $c;
    } ?> />
        <label for="producto">Mayoreo</label>
        <br/>
        <input type="radio" name="producto" id="producto" value="Seguro" <?php if ($d['producto'] == 'Seguro') {
        echo $c;
    } ?> />
        <label for="producto">Seguro</label>
        <br/>

    </p>

    <div class="separator_fields"></div>
    <span class="cabin_blue">Informacion del credito  </span>


    <div class="info_credito">

        <label for="producto">Valor de compra: </label>
        <input type="text" name="valor_de_compra" id="valor_de_compra"  value="<?php echo $d['valor_de_compra']; ?>" />

        <br/>
        <label for="producto">Valor de la prima: </label>
        <input type="text" name="valor_de_prima" id="valor de prima"  value="<?php echo $d['valor_de_prima']; ?>"/>

        <br/>
        <label for="producto">Canje: </label>
        <input type="text" name="canje" id="canje" value="<?php echo $d['canje']; ?>" />

        <br/>
        <label for="producto">Valor a financiar: </label>
        <input type="text" name="valor_a_financiar" id="valor_a_financiar" value="<?php echo $d['valor_a_financiar']; ?>" />

        <br/>
        <label for="producto">Plazo: </label>		
        <input type="text" name="plazo" id="plazo"  value="<?php echo $d['plazo']; ?>" />

        <div style="width:620px; margin:30px 0 30px 0; ">

            <div style="float:left; width:310px;">
                <label for="producto">Prima: </label><!-- ancho 150 -->		
                <input type="text" name="prima" id="prima"  value="<?php echo $d['prima']; ?>" /><!-- ancho 150 -->
            </div>

            <div style="float:left; width:310px;">
                <label for="producto">Taza: </label>
                <input type="text" name="tasa" id="tasa" value="<?php echo $d['tasa']; ?>" />
            </div> 

        </div>

        <br />
        <div style="width:620px; margin:30px 0 30px 0;">
            <div style="float:left; width:310px;">
                <label for="producto">Garantia: </label>		
                <input type="text" name="garantia" id="garantia" value="<?php echo $d['garantia']; ?>" />

            </div>
            <div style="float:left; width:310px;">
                <label for="producto">Nueva: </label>
                <input type="text" name="nueva" id="nueva" value="<?php echo $d['nueva']; ?>"  />

            </div> 
            <div style="float:left; width:310px;">
                <label for="producto">Usada: </label>
                <input type="text" name="usada" id="usada"  value="<?php echo $d['usada']; ?>" />

            </div> 
            <div style="float:left; width:310px;">
                <label for="producto">Marca: </label>
                <input type="text" name="marca" id="marca" value="<?php echo $d['marca']; ?>"  />

            </div> 
            <div style="float:left; width:310px;">
                <label for="producto">Modelo: </label>
                <input type="text" name="modelo" id="modelo" value="<?php echo $d['modelo']; ?>" />

            </div>     
        </div><!-- fin multi inputs or group of fields -->
        <div class="clear_0"></div> 
        <br />
        <label for="producto">Asesor de ventas: </label>
        <input type="text" name="asesor_de_ventas" id="asesor_de_ventas" value="<?php echo $d['asesor_de_ventas']; ?>" />

        <br/>

        <label for="producto">Fecha sugerida de pago: </label>
        <input type="text" name="fecha_sugerida_de_pago" id="fecha_sugerida_de_pago" value="<?php echo $d['fecha_sugerida_de_pago']; ?>" />

        <br/>

    </div><!-- fin contenedor info_credito -->

    <div class="separator_fields"></div>

<!-- <a href="<?php //base_url()  ?>index.php/solicitud/credito/2" class="cabin_blue">Siguiente</a> -->

    <input type="submit" name="siguiente" id="Siguiente" value="Siguiente" />

</form>