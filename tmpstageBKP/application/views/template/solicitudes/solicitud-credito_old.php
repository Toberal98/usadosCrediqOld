    

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


<form id="form111" name="form111" method="post" action="<?php echo base_url() ?>index.php/solicitud_save/guardar_sol_credito/" >

    <div class="contenth1">
        <div class="container12">
            <div class="row">
                <div class="column4"><img src="<?php echo base_url() ?>public/img/woman.jpg" alt=""/></div>
                <div class="column8">
                    <h1>Solicite su Crédito<span></span></h1>

                    <div class="formDatos">
                        <label><span>Nombre *:</span> <input type="text" name="cli_nombre" id="cli_nombre" data-bvalidator="alpha,minlength[3],required" /></label>
                        <label><span>Email:</span> <input type="text" name="cli_email" id="cli_email" data-bvalidator="email, required" /></label>
                        <label><span>DUI:</span> <input type="text" name="cli_dui" id="cli_dui" data-bvalidator="minlength[7]" /></label>
                        <label><span>Email *:</span> <input type="text" /></label>
                        <label><span>Monto máximo a financiar:</span> <input type="text" name="cli_monto_max" id="cli_monto_max" style="width: 60px;" data-bvalidator="number" onkeypress="validateKey(event, numericKeys)"/></label>
                        <label><span>Cuota máximo:</span> <input type="text" name="cli_cuota_max" id="cli_cuota_max" style="width: 60px;" data-bvalidator="number" onkeypress="validateKey(event, numericKeys)"/></label>
                        <label><span>Teléfono *:</span> <input type="text" name="cli_telefono_fijo" id="cli_telefono_fijo" data-bvalidator="number, minlength[8],required" onkeypress="validateKey(event, numericKeys)"/></label>
                        <label><span>Celular *:</span> <input type="text" name="cli_telefono_celular" id="cli_telefono_celular" data-bvalidator="number, minlength[8],required" onkeypress="validateKey(event, numericKeys)"/></label>
                        <label><span>Teléfono Oficina:</span> <input type="text" name="cli_telefono_oficina" id="cli_telefono_oficina" data-bvalidator="number, minlength[8]" onkeypress="validateKey(event, numericKeys)"/></label>
                        <label><input type="checkbox" class="referCheckbox" checked/> Datos Referente</label>
                        <div class="hidden">
                            <div class="clearfix"></div>
                            <div class="referente">
                                <label><span>Referido por:</span> <input type="text" name="cli_ref_por" id="cli_ref_por" data-bvalidator="alpha,minlength[3]" /></label>
                                <label><span>DUI:</span> <input type="text" name="cli_dui_ref_por" id="cli_dui_ref_por" data-bvalidator="minlength[7]" /></label>
                                <label><span>Teléfono:</span> <input type="text" name="cli_telefono_fijo_ref_por" id="cli_telefono_fijo_ref_por" data-bvalidator="number, minlength[8]" onkeypress="validateKey(event, numericKeys)"/></label>
                                <label><span>Email:</span> <input type="text" name="cli_email_ref_por" id="cli_email_ref_por"  data-bvalidator="email"  /></label>
                            </div>  
                        </div> 
                        <div class="inline">
                            <label><span>Comentario:</span> <textarea name="cli_comentarios" id="cli_comentarios" style="width: 350px; height: 80px"></textarea></label>
                        <p>*No son tomados en cuenta: bonificaciones, horas extras u otras. (Aplica únicamente personal de venta).</p>
                    <p><input type="checkbox" checked/> Autorizo a usadoscrediq.com a utilizar mi información personal para uso interno, tales como promociones, ofertas, etc., siempre y cuando no comparta información con terceras personas. </p>
                    <p><input type="checkbox" checked/> No autorizo a usadoscrediq.com a utilizar mi información personal para ningún otro propósito más que para ser enviada a CrediQ </p>
                    <p><input type="checkbox" checked/> Autorizo a GRUPO Q EL SALVADOR, S.A DE S.V., en adelante las "Las Empresas" para que consulten mi comportamiento crediticio para la concesión de este crédito para efectos de análisis con entidades especializadas en la prestación de servicios de información o buros de crédito, incluyendo aquellas que recolecten, registran, procesan, distribuyen datos, referentes al comportamiento crediticio de las personas y ofrecen servicios de información de base de datos.</p>
                    <p><strong>NOTA:</strong> Al remitir esta solicitud autorizo a CrediQ para realizar consulta sobre mi referencia crediticia.</p>
                        <button type="submit">Enviar</button>

                    </div>                     
                </div>
                
            </div>             
        </div>
    </div>
</div>

    
</form>