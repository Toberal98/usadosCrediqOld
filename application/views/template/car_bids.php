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



                    <p><strong>Descripción:</strong></p>
                    <p><?php echo $car['descripcion']; ?></p>


                    <?php if (!isset($autorizing)) { ?>
                      <p class="note">Nota: NO realice ningún pago por transferencia u otro medio a ninguna persona con la cual no tenga la suficiente confianza para hacerlo. Además, sugerimos actuar siempre con precaución a la hora de comprar cualquier vehículo y de verificar la identidad de los vendedores antes de llevar a cabo cualquier negocio ó hacer un pago como anticipo.
                        Consultar con el vendedor si el precio incluye los gastos de traspaso, ya que normalmente éstos los asume el comprador del vehículo. Además, todos los anuncios que se publiquen en este sitio podrán aparecer en una guía impresa.</p>
                        <?php } ?>



                        <!--INFORMACION DEL VENDEDOR-->
                        <?php
                        if ($this->session->userdata('user_id') and in_array($this->session->userdata('user_perfil'), array(1))) {
                            ?>
                            <div class="">
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
                                            <th>Ubicaci&oacute;n</th>
                                            <td><?php echo $car['ubicacion']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Comentario</th>
                                            <td><?php echo $car['justi_solicitud']; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>


                </div>




                <div class="column6">
                    <h1><?php echo $car['marca'] . '-' . $car['modelo']; ?></h1>
                    <?php if (!isset($autorizing)) { ?>
                      <p>Este vehiculo ha sido visto:<?php
                      if (isset($visto)) {
                        echo $visto['total'];
                      } else {
                        echo '0';
                      }
                      ?>&nbsp; veces</p>
                      <?php } ?>

                    <?php if ((int) $car['tipo_venta'] == 3): ?>
                      <p class="cuota">Oferta Mínima: <span><?php echo $car['moneda'] . $car['precio'] ?></span></p>
                    <?php elseif ((int) $car['tipo_venta'] == 2): ?>
                      <p class="cuota">Precio de contado: <span><?php echo $car['moneda'] . $car['precio'] ?></span></p>
                    <?php else: ?>
                      <p class="cuota">Cuota: <span><?php echo $car['moneda'] . $car['cuotaMin'] ?></span></p>
                    <?php endif; ?>

                    <?php if (!isset($autorizing)) { ?>

                        <?php if ($car['tipo_venta'] == '3'): ?>
                          <p class="links">
                              <a id="link9" href="#bid-info" class="<?php echo strtotime($car['bid_available_until']) < time() ? 'disabled' : 'fancybox' ?>">Hacer una oferta</a>
                              <!--a href="<?php echo base_url(); ?>Contactenos">Solicitar Información</a-->
                          </p>
                        <?php endif; ?>
                    <?php } ?>

                    <?php foreach ($bids as $bid): ?>
                      <hr>
                      <?php if ($mine): ?>
                        <div class="pull-right links">
                          <a href="#" data-accept data-id="<?php echo $bid->id ?>" class="<?php echo $bid->status == '1' ? 'accepted' : '' ?>"><?php echo $bid->status == '1' ? 'Oferta aceptada' : 'Aceptar oferta' ?></a>
                        </div>
                      <?php endif; ?>
                      <h4><?php echo $bid->nombres ?> <?php echo substr($bid->apellidos, 0, 1) ?> el <?php echo date('Y-m-d', strtotime($bid->created_at)) ?></h4>
                      <p class="cuota"><span>$<?php echo number_format($bid->amount, 2, '.', ',') ?></span></p>
                      <div class="clearfix"></div>
                    <?php endforeach; ?>
                    <br>
                    <?php if (!count($bids)): ?>
                      <h3>No se han ingresado ofertas</h3>
                    <?php endif; ?>

                </div>
            </div>





              <?php if (!empty($equipamiento)) { ?>
                <p class="title-sec">Equipamiento</p>
                <?php
                $i = 1;
                $car_eq = array();
                foreach ($equipamiento as $equ) {
                    $car_eq[$i] = $equ['nombre'];
                    $i++;
                }
                $equipamiento2 = array_splice($equipamiento, floor(count($equipamiento) / 2));
                ?>
                <div class="row">
                  <div class="column6">
                    <div class="tabla">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <?php
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
                            } unset($equipo);
                            ?>
                        </table>
                    </div>
                  </div>
                  <div class="column6">
                    <div class="tabla">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <?php
                            foreach ($equipamiento2 as $equipo) {
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
                            } unset($equipo);
                            ?>
                        </table>
                    </div>
                  </div>
                </div>

              <?php } ?>


              <div class="row">



                <?php
                if (!isset($autorizing)) {

                    if (!empty($similares)) {
                        ?>
                        <div class="column12">
                            <p class="title-sec">Ver m&aacute;s veh&iacute;culos en venta</p>
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

                    <div class="column12">
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

<!--Formulario login-->
<div id="solicitud-info" class="pp">
    <div class="padding">
        <form action="<?php echo base_url(); ?>index.php/ajax/enviarMail" method="Post" id="solicitud-form">
            <input type="hidden" name="auto" value="<?php echo $car["id_automovil"]; ?>">
            <input type="hidden" name="channel" value="web">
            <input type="hidden" name="pais" value="<?php echo $this->session->userdata('pais'); ?>">
            <input type="hidden" id="button-input" name="button" value="Solicitar Crédito">
            <h2>Solicitud de Información</h2>
            <div class="form">
              <p style="margin: 0 5%; text-align:justify">
                Solicita tu crédito ahora de forma fácil y rápida, llenando
                este formulario para que puedas recibir toda la asesoría
                correspondiente por parte de uno de nuestros agentes.
              </p>
              <p>
                &nbsp;
              </p>

                <label style="width:90%;"><span>Nombre:</span> <input onchange="this.form.nameCopy.value=this.value;" required type="text" id="name" name="name" data-bvalidator="required"/></label>
                <label><span>Email:</span> <input onchange="this.form.emailCopy.value=this.value;" type="text" required id="email" name="email" data-bvalidator="email, required"/></label>
                <label><span>Teléfono:</span> <input onchange="this.form.phoneCopy.value=this.value;" type="text" required maxlength="8" id="phone" name="phone"  data-bvalidator="number, required"/></label>

                <input type="hidden" id="nameCopy" name="nameCopy" /> 
                <input type="hidden" id="emailCopy" name="emailCopy"/>
                <input type="hidden" id="phoneCopy" name="phoneCopy"/>                            
                <input type="hidden" name="automovil" value="<?php echo $car['marca']." ".$car['modelo']." ".$car[year]." (".$car["id_automovil"].")" ?>" >
                <input type="hidden" name="vendedor" value="ventasusados@crediq.com">
                <input type="hidden" name="boton" value="Solicitar Información">
                <input type="hidden" id="venta" name="venta" value="<?php echo $car['tipo_venta']  ?>">       

                <div class="clearfix"></div>

                <p style="margin:0">
                  <br>
                  <label style="width:80%"><input type="checkbox" checked/> Autorizo a usadoscrediq.com a utilizar mi información personal para uso interno, tales como promociones, ofertas, etc., siempre y cuando no comparta información con terceras personas. </label>
                  <label style="width:80%"><input type="checkbox" checked/> No autorizo a usadoscrediq.com a utilizar mi información personal para ningún otro propósito más que para ser enviada a CrediQ.</label>
                  <label style="width:80%"><input type="checkbox" checked/> Autorizo a CREDIQ, S.A DE S.V., en adelante las "Las Empresas" para que consulten mi comportamiento crediticio para la concesión de este crédito para efectos de análisis con entidades especializadas en la prestación de servicios de información o buros de crédito, incluyendo aquellas que recolecten, registran, procesan, distribuyen datos, referentes al comportamiento crediticio de las personas y ofrecen servicios de información de base de datos. </label>
                  <label style="width:80%"><strong>NOTA:</strong> al remitir esta solicitud autorizo a CrediQ para realizar consulta sobre mi referencia crediticia.</label>
                  <br>
                </p>
                <label style="float:right;"><button type="submit">Enviar</button></label>
                <div class="clearfix"></div>
            </div>
        </form>
        <iframe  style="display: none;" src="" name="myIframe" id="myIframe"></iframe>
    </div>
</div>

<!--Formulario login-->
<div id="bid-info" class="pp">
    <div class="padding">
        <form action="<?php echo base_url(); ?>index.php/bid/create/<?php echo $car['id_automovil'] ?>" method="post" id="bid-form">
            <input type="hidden" name="auto" value="<?php echo $car["id_automovil"]; ?>">
            <input type="hidden" name="pais" value="<?php echo $this->session->userdata('pais'); ?>">
            <h2>Ingresa tu oferta</h2>
            <div class="form">
                <label style="width:90%;"><span>&nbsp;</span> <input required type="text" name="amount" placeholder="Ingresa el monto" data-bvalidator="required"/></label>
                <label style="float:right;"><button type="submit">Enviar</button></label>
                <div class="clearfix"></div>
            </div>
        </form>
    </div>
</div>



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
    $('#link5').on('click', function(e) {
        e.preventDefault();
        $("#solicitud-info h2").text('Solicitar Crédito');
        $("#solicitud-info p").show();
        $("#button-input").val('Solicitar Crédito');
    });
    $('#link6').on('click', function(e) {
        e.preventDefault();
        $("#solicitud-info h2").text('Hacer Cita');
        $("#solicitud-info p").hide();
        $("#button-input").val('Hacer Cita');
    });
    $('#link7').on('click', function(e) {
        e.preventDefault();
        $("#solicitud-info h2").text('Contactar Vendedor');
        $("#solicitud-info p").hide();
        $("#button-input").val('Contactar Vendedor');
    });
    $('#link8').on('click', function(e) {
        e.preventDefault();
        $("#solicitud-info h2").text('Solicitar Información');
        $("#solicitud-info p").show();
        $("#button-input").val('Solicitar Información');
    });

    $('#link9, [data-accept]').on('click', function(e) {
        e.preventDefault();
    });

    var loading = false;

    $('[data-accept]').on('click.bid', function(e) {
        e.preventDefault();
        if (loading) {
          return;
        }
        loading = true;
        var id = $(this).data('id'),
          that = this;
        notie.confirm(
          '¿Estás seguro que deseas aceptar esta oferta?',
          'Sí',
          'Cancelar',
          function(){
            $.fancybox.showLoading();

            $.ajax({
              method: 'post',
              url: '<?php echo base_url(); ?>index.php/bid/winner/' + id,
              dataType: 'json',
              complete: function () {
                $.fancybox.hideLoading();
                loading = false;
              },
              success: function (response) {
                if (response.error) {
                  notie.alert(3, response.error, 1.5);
                } else {
                  notie.alert(1, 'Oferta aceptada', 1.5);
                  $('[data-accept]').off('click.bid').addClass('disabled');
                  $(that).removeClass('disabled').addClass('accepted').text('Oferta aceptada');
                }
              },
              error: function () {
                notie.alert(1, 'Oferta aceptada', 1.5);
              }
            });
          },
          function(){
            loading = false;
            notie.alert(3, 'Oferta no aceptada', 1.5);
          }
        );
    });

    $('#bid-form').bValidator();

    if ($('[data-accept].accepted').length) {
      $('[data-accept]').off('click.bid').not('.accepted').addClass('disabled');
    }

    $('#bid-form').on('submit', function (e) {
      e.preventDefault();
      $.fancybox.showLoading();
      $('#bid-form').ajaxSubmit(function (response) {
        if (response.error) {
          notie.alert(3, response.error, 1.5);
        } else {
          $.fancybox.close();
          notie.alert(1, 'Hemos enviado tu información. Muchas gracias', 1.5);
          $('#bid-form').get(0).reset();
        }
        $.fancybox.hideLoading();
      });
    });
</script>
