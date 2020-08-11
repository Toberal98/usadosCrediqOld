
<!-- Inicio Contacto *********************************************************************************************************************** -->
<div class="contenth1">
    <div class="container12">
        <div class="row">
            <div class="column4"><img src="<?php echo base_url(); ?>public/img/contact-us.jpg" alt=""/></div>
            <div class="column8">
                <h1>Cont&aacute;ctenos<span></span></h1>
                 <form action="<?php echo base_url(); ?>index.php/ajax/enviarMail" method="Post" id="solicitud-form">
                 <!-- <form action="<?php echo base_url(); ?>index.php/proccessContact" method="Post" id="solicitud-form"> -->
                    <input type="hidden" name="pais" value="<?php echo $this->session->userdata('pais'); ?>">
                    <input type="hidden" name="channel" value="web">
                    <input type="hidden" id="button-input" name="button" value="Contacto">
                    <div class="form">
                        <label style="width:90%;"><span>Nombre:</span> <input type="text" name="name" data-bvalidator="required"/></label>
                        <label><span>Email:</span> <input type="text" name="email" data-bvalidator="email, required"/></label>
                        <label><span>Teléfono:</span> <input type="text" name="phone"  data-bvalidator="number, required"/></label>
                        <div class="clearfix"></div>
                        <label style="float:right;"><button id="enviarContacto" type="submit">Enviar</button></label>
                        <div class="clearfix"></div>
                    </div>
                 </form>

              <?php
              /*MODIFICADO POR GGONZALEZ - 22/05/2015 - INI*/
 $pais= $this->session->userdata('pais');

 if ($pais == 1){

 ?>

                <div class="contacto">
                     <h4>Centro de Negocios y Oficinas Centrales</h4>
                     <p>Boulevard Los Pr&oacute;ceres, Calle Los H&eacute;roes poniente, Edificio CrediQ, San Salvador, El Salvador. [<a href="<?php echo base_url();?>site/agencias/1" class="fancybox fancybox.iframe">ver mapa</a>]</p>

                     <h4>Autolote CrediQ</h4>
                     <p>Boulevard Los Pr&oacute;ceres, contiguo a Dollar City, San Salvador, El Salvador. [<a href="<?php echo base_url();?>site/agencias/2" class="fancybox fancybox.iframe">ver mapa</a>]</p>
<!-- /*INI - Modificado por: GGONZALEZ - 30/08/2016 */ -->
                     <h4>Autolote de Durazno</h4>
                     <p>Avenida Las Amapolas y Calle Los Duraznos,  Frente a talleres de Nissan San Salvador, El Salvador.[<a href="<?php echo base_url();?>site/agencias/5" class="fancybox fancybox.iframe">ver mapa</a>]</p>
<!-- /*FIN - Modificado por: GGONZALEZ - 30/08/2016 */ -->
                     <h4>Centro de Servicio CREDIQ</h4>
                     <p>Agencia CrediQ Centro Comercial Las Cascadas.</p>


                    <h4>Punto de Recepci&oacute;n de Pago</h4>
                    <ul>
                        <li>CrediQ Las Cascadas y Centro de Negocios CrediQ</li>
                        <li>Autoservicio en Autolote CrediQ</li>
                        <li>Tigo Money</li>
                        <li>Medios electr&oacute;nicos de Davivienda.</li>
                        <li>Toda la red de PuntoExpress, aplican pagos en efectivo y menores a $500</li>
                        <li>Citi a trav&eacute;s de su red de sucursales presentando el carnet de colector o v&iacute;a Netbanking.</li>

                    </ul>


                    <h4>Call Center</h4>
                    <p>Nuestro n&uacute;mero telef&oacute;nico de atenci&oacute;n al cliente es el (503) 2248-6400 opción 2 y el horario de servicio es de lunes a viernes de 8:00 a.m. a 6:00 p.m. y s&aacute;bados de 8:00 a.m. a 12:30 p.m.&nbsp;</p>
                </div>

            </div>
        </div>
    </div>
</div>

 <?php
 }

 elseif ($pais == 2){

      ?>

     <div class="contacto">
                    <h4>Centro de Negocios y Oficinas Centrales</h4>
                    <p>Contiguo a la Plaza de La Uruca, San José, Costa Rica. [<a href="<?php echo base_url();?>site/agencias/4" class="fancybox fancybox.iframe">ver mapa</a>]</p>

                    <!--ESTA SECCION SE DEBE EDITAR CON LA INFO DE COSTA RICA, SE HARA CUANDO SE MIGRE EL SITIO A CR, GGONZALEZ 22/05/2015-->

                    <h4>Centro de Servicio CREDIQ</h4>
                    <p>Agencia CrediQ Centro Comercial Las Cascadas.</p>


                    <h4>Punto de Recepci&oacute;n de Pago</h4>
                    <ul>
                        <li>CrediQ Las Cascadas y Centro de Negocios CrediQ</li>
                        <li>Autoservicio en Autolote CrediQ</li>
                        <li>Tigo Money</li>
                        <li>Medios electr&oacute;nicos de Davivienda.</li>
                        <li>Toda la red de PuntoExpress, aplican pagos en efectivo y menores a $500</li>
                        <li>Citi a trav&eacute;s de su red de sucursales presentando el carnet de colector o v&iacute;a Netbanking.</li>

                    </ul>


                    <h4>Call Center</h4>
                    <p>Nuestro n&uacute;mero telef&oacute;nico de atenci&oacute;n al cliente es el (503) 2248-6400 y el horario de servicio es de lunes a viernes de 8:00 a.m. a 6:00 p.m. y s&aacute;bados de 8:00 a.m. a 12:30 p.m.&nbsp;</p>
                </div>

            </div>
        </div>
    </div>
</div>
 <?php
 }
elseif ($pais == 3){

      ?>

     <div class="contacto">
                    <h4>Oficinas Principal CrediQ </h4>
                    <p>Boulevar Centro Am&eacute;rica, Frente a Plaza Miraflores Tegucigalpa M.D.C. [<a href="<?php echo base_url();?>site/agencias/3" class="fancybox fancybox.iframe">ver mapa</a>]</p>

                    <h4>Centro de Servicio CREDIQ</h4>
                    <p>Plaza Record, Centro Comercial Record, Boulevard San Juan Bosco</p>


                    <h4>Punto de Recepci&oacute;n de Pago</h4>
                    <ul>
                        <li>Oficina Principal CrediQ</li>
                        <li>Plaza Record</li>
                        <li>Davivienda</li>
                        <li>Banco Atl&aacute;ntida</li>


                    </ul>


                    <h4>Informaci&oacute;n</h4>
                    <p>Para mayor informaci&oacute;n escribanos a <a href="mailto:info@usadoscrediq.com">info@usadoscrediq.com</a></p>
                </div>

            </div>
        </div>
    </div>
</div>

 <?php
 }

   /*MODIFICADO POR GGONZALEZ - 22/05/2015 - FIN*/
      ?>
