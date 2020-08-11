

<?php
$this->load->view('template/inc/header_stripe.php');
?>





<form id="form_sol_info2" name="form_sol_info2" accept-charset="utf-8" action="<?php echo base_url() ?>index.php/car/proccessInfo_2/" method="post" >

    <div class="content">
        <div class="container12">
            <div class="row">
                <div class="column4"><img src="<?php echo base_url(); ?>public/img/woman.jpg" alt=""/></div>
                <div class="column8">
                    <h3>Solicitar informaci&oacute;n <br/><?php echo $car['id_automovil']; ?> - <?php echo $car['marca']; ?> <?php echo $car['modelo']; ?><span></span></h3>

                    <div class="formDatos">
                        <label><span>Nombre *:</span> <input type="text" name="nombre" id="nombre" data-bvalidator="required"></label>
                        <label><span>Apellidos *:</span> <input type="text" name="apellido" id="apellido" data-bvalidator="required"></label>
                        <label><span>Telefono Principal *:</span> <input type="text" name="telefono" id="telefono" data-bvalidator="required"></label>
                        <label><span>Telefono Secundario :</span> <input type="text" name="telefono2" id="telefono2" ></label>
                        <label><span>Otro Telefono :</span> <input type="text" name="telefono3" id="telefono3" ></label>
                        <label><span>Email :</span> <input type="text" name="email" id="email" data-bvalidator="email" ></label>
                        <label><span>Mensaje :</span> <textarea name="consulta" id="consulta" cols="20" rows="4"></textarea></label>


                        <input type="hidden"  name="marca" id="marca" value="<?php echo $car['marca']; ?>"/>
                        <input type="hidden"  name="modelo" id="modelo" value="<?php echo $car['modelo']; ?>"/>
                        <input type="hidden"  name="3m41l" id="3m41l" value="<?php echo str_replace('@', '#', $user['email']); ?>"/>
                        <input type="hidden"  name="id" id="id" value="<?php echo $car['id_automovil']; ?>"/>

                        <div class="inline">
                            <button type="submit">Enviar</button>
                        </div>
                        <div class="inline">
                            <span class="nota">Importante
                                "No realice ningún pago por transferencia u otro medio a ninguna persona con la cual no tenga la suficiente confianza para hacerlo. Además,
                                sugerimos actuar siempre con precaución a la hora de compra cualquier vehículo y de verificar la identidad de los vendedores antes de llevar
                                a cabo cualquier negocio ó hacer un pago como anticipo"
                            </span>
                        </div>
                    </div>

                </div>             
            </div>
        </div>
    </div>

</form>


<script type="text/javascript">
    $('#form_sol_info2').bValidator();
</script>
