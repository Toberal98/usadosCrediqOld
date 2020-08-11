<script type="text/javascript">

    function Seleccionar() {
        var nombre = document.formulario.justi_solicitud.value;

        if (nombre.length == 0 || nombre == "") {
            alert("Debe Ingresar un respuesta de la solicitud.");
            return null;
        }

        var url = "<?php echo base_url() . 'car/rechazar/' . $car['id_automovil'] . '/' ?>" + nombre;
        window.location = url;
    }


    function SeleccionarAprobar() {
        var nombre = document.formulario.justi_solicitud.value;

        if (nombre.length == 0 || nombre == "") {
            alert("Debe Ingresar un respuesta de la solicitud.");
            return null;
        }

        var url = "<?php echo base_url() . 'car/aprobar/' . $car['id_automovil'] . '/' ?>" + nombre;
        window.location = url;
    }

</script>



<?php
$this->load->view('template/inc/header_stripe.php');


$first_thum = '';

if ($car['tipo_transmision'] == 'M') {
    $car['tipo_transmision'] = 'Manual';
}
if ($car['tipo_transmision'] == 'A') {
    $car['tipo_transmision'] = 'Automatica';
}

if ($car['tipo_ingreso'] == 'I') {
    $ingreso = 'Importado';
}
if ($car['tipo_ingreso'] == 'G') {
    $ingreso = 'Agencia';
}
?>


<div class="content">
    <div class="container12">
        <div class="row">

            <h3>Vehículos Usados - <?php echo $car['id_automovil'] ?><span></span></h3>

            <div class="row detalle">
                <div class="column6">



                    <?php
                    if ($tumbnails == 0) {
                        ?>

                        <div class="figure"><img src="<?php echo base_url(); ?>public/images/no_disponible.jpg" alt=""/></div>

                        <?php
                    } else {
                        $i = 1;
                        ?> 
                        <div class="figure">
                            <a href="<?php echo base_url(); ?>index.php/ajax/doimage/<?php echo $car['id_automovil']; ?>-800-580-<?php echo (int) $tumbnails[0]['tipo']; ?>" class="fancybox fancybox.iframe" ><img src="<?php echo base_url(); ?>index.php/ajax/doimage/<?php echo $car['id_automovil']; ?>-800-600-<?php echo (int) $tumbnails[0]['tipo']; ?>" alt=""/></a>
                        </div>

                        <ul class="thumbs">
                            <?php
                            foreach ($tumbnails as $thumb):
                                if ($first_thum == '') {
                                    $first_thum = $thumb['tipo'];
                                }
                                echo "<li data-mostrar='t0" . $i . "'>";
                                ?>
                                <img  src="<?php echo base_url(); ?>index.php/ajax/doimage/<?php echo $car['id_automovil']; ?>-800-600-<?php echo (int) $thumb['tipo']; ?>" alt=""/>
                                </li>

                                <?php
                                $i++;
                            endforeach;
                        }
                        ?>   

                    </ul>
                </div>   




                <div class="column6">
                    <h1><?php echo $car['marca'] . '-' . $car['modelo']; ?></h1>
                    <p class="cuota">Cuota: <span><?php echo $car['moneda'] . $car['cuotaMin'] ?></span></p>

                    <?php if (!isset($autorizing)) { ?>
                        <p class="links">
                            <a class="env_mail" href="<?php echo base_url() ?>car/solicitar_info_2/<?php echo $car['id_automovil']; ?>">Contactar Vendedor</a>
                            <a class="comparar" id="link4" href="<?php echo base_url() ?>vehiculosusados/Comparar/">Mis comparaciones</a>
                        </p>
                        <p class="links solicitar">
                            <a href="<?php echo base_url(); ?>Financiamiento/SolicitudCredito">Solicitar Crédito</a> 
                            <!--a href="<?php echo base_url(); ?>Contactenos">Solicitar Información</a-->
                        </p>
                    <?php } ?>  


                    <?php if (!isset($autorizing)) { ?>            
                        <p>Este vehiculo ha sido visto:<?php
                            if (isset($visto)) {
                                echo $visto['total'];
                            } else {
                                echo '0';
                            }
                            ?>&nbsp; veces</p> 
                    <?php } ?> 



                    <p><strong>Descripción:</strong></p> 
                    <p><?php echo $car['descripcion']; ?></p>


                    <?php if (!isset($autorizing)) { ?>
                        <p class="note">Nota: NO realice ningún pago por transferencia u otro medio a ninguna persona con la cual no tenga la suficiente confianza para hacerlo. Además, sugerimos actuar siempre con precaución a la hora de comprar cualquier vehículo y de verificar la identidad de los vendedores antes de llevar a cabo cualquier negocio ó hacer un pago como anticipo.
                            Consultar con el vendedor si el precio incluye los gastos de traspaso, ya que normalmente éstos los asume el comprador del vehículo. Además, todos los anuncios que se publiquen en este sitio podrán aparecer en una guía impresa.</p>
                    <?php } ?>
                </div>
            </div>  
            <div class="row">

                <!--DATOS GENERALES-->
                <div class="column6">
                    <p class="title-sec">Datos Generales</p>
                    <div class="tabla">
                        <table width="100%" cellpadding="0" cellspacing="0">
                             <tr>
                                <th>Precio</th>
                                <td><?php echo $car['moneda'] . ' ' . number_format($car['precio'], 2, ".", ","); ?><td>
                            </tr>
                            <tr>
                                <th>Marca</th>
                                <td><?php echo $car['marca']; ?></td>
                            </tr>
                            <tr>
                                <th>Modelo</th>
                                <td><?php echo $car['modelo']; ?></td>
                            </tr>
                            <tr>
                                <th>A&ntilde;o</th>
                                <td><?php echo $car['year']; ?></td>
                            </tr>
                            
                            <tr>
                                <th>Cilindraje</th>
                                <td><?php echo number_format($car['capacidad_de_motor']); ?></td>
                            </tr>
                            <tr>
                                <th>Estilo</th>
                                <td><?php echo $car['estilo']; ?></td>
                            </tr>                            
                            <tr>
                                <th>Combustible</th>
                                <td><?php echo $car['tipo_comb']; ?></td>
                            </tr>
                            <tr>
                                <th>Transmisi&oacute;n</th>
                                <td><?php echo $car['tipo_transmision']; ?></td>
                            </tr>
                            <?php if ($car['kilometraje'] != "" AND $car['kilometraje'] != "0") { ?>
                                <tr>
                                    <th>kilometraje</th>
                                    <td><?php echo $car['kilometraje']; ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th>Nº puertas</th>
                                <td><?php echo $car['numero_puertas']; ?></td>
                            </tr>
                            <tr>
                                <th>Ciudad</th>
                                <td><?php echo $car['ciudad']; ?></td>
                            </tr>
                            <tr>
                                <th>Ingreso</th>
                                <td><?php echo $ingreso; ?></td>
                            </tr>
                            <tr>
                                <th>Tracci&oacute;n</th>
                                <td><?php echo $car['traccion']; ?></td>
                            </tr>                           
                            <?php if ($color_interior != NULL AND $color_exterior != NULL) { ?>
                                <tr>
                                    <th>Color Exterior</th>
                                    <td><?php echo $color_exterior['nombre']; ?></td>
                                </tr>
                                <tr>
                                    <th>Color Interior</th>
                                    <td><?php echo $color_interior['nombre']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>




                <!--INFORMACION DEL VENDEDOR-->
                <?php
                if ($this->session->userdata('user_id') and in_array($this->session->userdata('user_perfil'), array(1))) {
                    ?>
                    <div class="column6">
                        <p class="title-sec">Datos Vendedor</p>
                        <div class="tabla">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th>Fecha Ingreso</th>
                                    <td><?php echo $car['fecha']; ?></td>
                                </tr>
                                <tr>
                                    <th>Nombre</th>
                                    <td><?php echo $car['ext_nombre']; ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo $car['ext_email']; ?></td>
                                </tr>
                                <tr>
                                    <th>Telefono 1</th>
                                    <td><?php echo $car['ext_tel1']; ?></td>
                                </tr>
                                <tr>
                                    <th>Telefono 2</th>
                                    <td><?php echo $car['ext_tel2']; ?></td>
                                </tr>
                                <tr>
                                    <th>Comentario</th>
                                    <td><?php echo $car['justi_solicitud']; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                <?php } ?>

                <?php if (!empty($equipamiento)) { ?>
                    <div class="column6">
                        <p class="title-sec">Equipamiento</p>
                        <div class="tabla">


                            <table width="100%" cellpadding="0" cellspacing="0">
                                <?php
                                $i = 1;
                                $car_eq = array();
                                foreach ($equipamiento as $equ) {
                                    $car_eq[$i] = $equ['nombre'];
                                    $i++;
                                }
                                $i = 1;
                                foreach ($equipamiento as $equipo) {
                                    if (in_array($equipo['nombre'], $car_eq)) {
                                        $check = "check";
                                    } else {
                                        $check = "check_vacio";
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="<?php echo $check; ?>"></div>
                                            <?php echo $equipo['nombre']; ?> 
                                        </td>
                                    </tr>        
                                    <?php
                                    if ($i > 10) {
                                        $i = 1;
                                    }
                                    $i++;
                                }
                                ?>
                            </table>
                        </div>
                    </div>

                <?php } ?>






                <?php
                if (!isset($autorizing)) {

                    if (!empty($similares)) {
                        ?>
                        <div class="column6">
                            <p class="title-sec">Otros veh&iacute;culos de este vendedor</p>
                            <div class="tabla">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>     
        <?php foreach ($similares as $similar) { ?>
                                            <td><a href="" onclick="event.preventDefault()" onmousedown="doClick(<?php echo $similar['id_automovil']; ?>)">
                                                    <img width="99" height="77" src="<?php echo base_url(); ?>ajax/dothums/<?php echo $similar['id_automovil']; ?>-3" alt=""><br/>
            <?php echo '<span class="cabin_white">' . $similar['nombre_marca'] . ' ' . $similar['modelo'] . ' ' . $similar['year'] . '</span>'; ?>
                                                </a>
                                            </td>
        <?php } ?>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    <?php }
                } else {
                    ?>

                    <div class="column6">
                        <p class="title-sec"><?php echo $car['estado']; ?></p>
                        <div class="tabla">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>                            
                                    <td> 

                                        <?php
                                        switch ($car['estado']) {
                                            case 'pendiente':
                                                ?>	
                                                <form name="formulario" >
                                                    <div class="detalle-tag">: </div>

                                                    <th>Justificaci&oacute;n</th>
                                                    <td><input type="text" name="justi_solicitud" id="nombreTexbox" data-bvalidator="required"  /> </td>
                                                </form>
                                                <a href="#" onClick="SeleccionarAprobar();">Aprobar</a><!--	Forma con javascript	-->
                                                <a href="#" onClick="Seleccionar();">Rechazar</a><!--	Forma con javascript	-->

                                                <?php
                                                break;
                                            case 'Aprobado':
                                                echo '<span class="cabin_red">El vehículo ha sido autorizado.</span>';
                                                break;
                                            case 'Rechazado':
                                                echo '<span class="cabin_red">La solicitud ha sido rechazada.</span>';
                                                break;
                                        }
                                        ?>	


                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

<?php } ?>


            </div>

        </div>
    </div>
</div>



<form id="solicitarcredito" action="<?php echo base_url() ?>vehiculosusados/solicitarcredito/index.php" method="POST">
    <input type="hidden" name="auto" value="<?php echo $car["id_automovil"]; ?>">
</form>

<form id="solicitarcredito2" action="<?php echo base_url() ?>vehiculosusados/CalcularCuota/index.php" method="POST">
    <input type="hidden" name="auto" value="<?php echo $car["id_automovil"]; ?>">
</form>

<form id="solicitarcredito3" action="<?php echo base_url() ?>vehiculosusados/SolicitarInformacion/index.php" method="POST">
    <input type="hidden" name="auto" value="<?php echo $car["id_automovil"]; ?>">
</form>
<form id="solicitarcredito4" action="<?php echo base_url() ?>vehiculosusados/Comparar/index.php" method="POST">
    <input type="hidden" name="auto" value="<?php echo $car["id_automovil"]; ?>">
</form>



<script>
    $('#link1').on('click', function(e) {
        e.preventDefault();
        $("#solicitarcredito").submit();
    });
    $('#link2').on('click', function(e) {
        e.preventDefault();
        $("#solicitarcredito2").submit();
    });
    $('#link3').on('click', function(e) {
        e.preventDefault();
        $("#solicitarcredito3").submit();
    });
    $('#link4').on('click', function(e) {
        e.preventDefault();
        $("#solicitarcredito4").submit();
    });
</script>