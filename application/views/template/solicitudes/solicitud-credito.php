

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

<form action="<?php echo base_url(); ?>index.php/ajax/enviarMail" method="Post" id="solicitud-form">
   <input type="hidden" name="pais" value="<?php echo $this->session->userdata('pais'); ?>">
   <input type="hidden" name="channel" value="web">
   <input type="hidden" id="button-input" name="button" value="Solicitud Crédito">
   <div class="contenth1">
       <div class="container12">
           <div class="row">
               <div class="column4"><img src="<?php echo base_url() ?>public/img/woman.jpg" alt=""/></div>
               <div class="column8">
                   <h1>Solicite su Crédito<span></span></h1>
                   <p style="margin: 0 5%; text-align:justify">
                     Solicita tu crédito ahora de forma fácil y rápida, llenando
                     este formulario para que puedas recibir toda la asesoría
                     correspondiente por parte de uno de nuestros agentes.
                   </p>
                   <div class="form">
                       <label style="width:90%;"><span>Nombre:</span> <input type="text" name="name" data-bvalidator="required"/></label>
                       <label><span>Email:</span> <input type="text" name="email" data-bvalidator="email, required"/></label>
                       <label><span>Teléfono:</span> <input type="text" name="phone"  data-bvalidator="number, required"/></label>
                       <div class="clearfix"></div>
                       <br>
                       <label style="width:80%"><input type="checkbox" checked/> Autorizo a usadoscrediq.com a utilizar mi información personal para uso interno, tales como promociones, ofertas, etc., siempre y cuando no comparta información con terceras personas. </label>
                       <label style="width:80%"><input type="checkbox" checked/> No autorizo a usadoscrediq.com a utilizar mi información personal para ningún otro propósito más que para ser enviada a CrediQ.</label>
                       <label style="width:80%"><input type="checkbox" checked/> Autorizo a CREDIQ, S.A DE S.V., en adelante las "Las Empresas" para que consulten mi comportamiento crediticio para la concesión de este crédito para efectos de análisis con entidades especializadas en la prestación de servicios de información o buros de crédito, incluyendo aquellas que recolecten, registran, procesan, distribuyen datos, referentes al comportamiento crediticio de las personas y ofrecen servicios de información de base de datos. </label>
                       <label style="width:80%"><strong>NOTA:</strong> al remitir esta solicitud autorizo a CrediQ para realizar consulta sobre mi referencia crediticia.</label>
                       <br>
                       <label style="float:right;"><button type="submit">Enviar</button></label>
                       <div class="clearfix"></div>
                   </div>
               </div>
           </div>
       </div>
   </div>

</form>
