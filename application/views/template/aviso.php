<?php
$this->load->view('template/inc/header_stripe.php');
?>

<div class="content">
    <div class="container12">
        <div class="row">
            <div class="column4"><img src="<?php echo base_url(); ?>public/img/warning.png" alt=""/></div>
            <div class="column8">






                <?php
                if (!$tipo) {
                    $tipo = null;
                }

                $redirect = "";
                $direcc = "";

                if ($tipo == 1) {

                    echo '<h3 class="cabin_blue_18">Registro exitoso!</h3>
          <p class="cabin_parrafo">Gracias por tu registro, se te ha enviado un e-mail con la clave y un enlace para activar tu cuenta!</p>
          ';
                }
                if ($tipo == 2) {
                    echo '<span class="cabin_naranjas">Registro Fallido!</span>
          <span class="cabin_parrafo">El correo que intenta registrar ya esta en uso!</span>';
                    //$this->load->view('template/add-usuario');
                }
                if ($tipo == 3) {

                    echo '<h3 class="cabin_blue_18">Operacion Fallida!</h3>
          <p class="cabin_parrafo">Ocurrio un error al intentar enviar datos!';
                    //$this->load->view('template/add-usuario');
                }
                if ($tipo == 4) {
                    echo '<span class="cabin_blue">Datos modificados exitosamente!</span>';
                    $this->load->view('template/mod-usuario');
                }
                if ($tipo == 5) {
                    echo '<h3 class="cabin_blue_18">Datos enviados exitosamente!</h3>
          <p class="cabin_parrafo">Gracias por usar el formulario de contactos, responderemos a la brevedad posible! </p>';
                }
                if ($tipo == 6) {
                    echo '<h3 class="cabin_blue_18">Datos modificados exitosamente!</h3>
          <p class="cabin_parrafo">Hemos enviado los datos de acceso a su cuenta de correo!</p>';
                }
                if ($tipo == 7) {
                    echo '<span class="cabin_naranjas">Recuperacion Fallida!</span>
          <span class="cabin_parrafo">El correo que intenta ingresar no existe!</span>';
                    $this->load->view('template/recuperar_clave');
                }
                if ($tipo == 8) {
                    echo '<h3 class="cabin_blue_18">Cuenta activada exitosamente!</h3>
          <p class="cabin_parrafo">Hemos activado su cuenta ahora puede iniciar sesion!</p>';
                }
                if ($tipo == 9) {
                    echo '<h3 class="cabin_blue_18">Error de activacion!</h3>
          <p class="cabin_parrafo">Ha ocurrido un error al activar la cuenta! pueda ser que su cuenta ya este activada o se registro en un pais diferente su ubicacion actual</p>';
                }
                if ($tipo == 10) {
                    echo $aviso;
                }
                if ($tipo == 11) {
                    echo $aviso;
                    $this->load->view('template/detalle-corto'); //
                }
                if ($tipo == 12) {
                    echo '<h3 class="cabin_blue_18">Error!</h3>
          <p class="cabin_parrafo">La contraseña actual que ingreso es incorrecta!</p>';
                    $this->load->view('template/mod-usuario'); //
                }
                if ($tipo == 13) {
                    echo '<h3 class="cabin_blue_18">Contraseña cambiada!</h3>
          <p class="cabin_parrafo">La contraseña se ha cambiado exitosamente!</p>';
                    $this->load->view('template/mod-usuario'); //
                }
                if ($tipo == 14) {
                    echo '<h3 class="cabin_blue_18">Error!</h3>
          <p class="cabin_parrafo">El e-mail que ingreso ya existe!</p>';
                    $this->load->view('template/update-user'); //
                }
                if ($tipo == 15) {
                    echo '<h3 class="cabin_blue_18">Datos Guardados!</h3>
          <p class="cabin_parrafo">Los datos se han guardado exitosamente!</p>';
                    $this->load->view('template/update-user'); //
                }
                if ($tipo == 16) {
                    echo '<h3 class="cabin_blue_18">Datos Guardados!</h3>
            <p class="cabin_parrafo">Los datos se han guardado exitosamente!</p>';
                    $this->load->view('template/user-crear'); //
                }
                if ($tipo == 17) {
                    echo '<h3 class="cabin_blue_18">Banner Guardado!</h3>
          <p class="cabin_parrafo">Los datos se han Guardado exitosamente!</p>';
                    $redirect = 'ok';
                    if (isset($id)) {
                        $direcc = '/site/advert_update/"' . $id;
                    } else {
                        $direcc = '/site/adverts';
                    }
                }
                if ($tipo == 18) {
                    echo $aviso;
                    echo '<br /><br /><img src="' . base_url() . 'public/banners/' . $imagen[0]['imagen'] . '" width="300" height="100"><br />';
                }
                if ($tipo == 19) {
                    echo '<h3 class="cabin_blue_18">Banner Borrado!</h3>
          <p class="cabin_parrafo">Los datos se han borrado exitosamente!</p>';
                    $redirect = 'ok';
                    $direcc = '/site/adverts';
                }
                if ($tipo == 20) {
                    echo '<h3 class="cabin_blue_18">Vehiculo Desactivado!</h3>
          <p class="cabin_parrafo">El vehiculo ha sido desactivado exitosamente!</p>';
                    $redirect = 'ok';
                    $direcc = '/car/estado/aprobado-admin';
                }
                if ($tipo == 21) {
                    echo '<h3 class="cabin_blue_18">Datos guardados!</h3>
          <p class="cabin_parrafo">los datos de la solicitud se han guardado exitosamente!</p>';
                    $redirect = 'ok';
                    $direcc = '/solicitud/credito_natural/1';
                }
                if ($tipo == 22) {
                    echo '<h3 class="cabin_blue_18">Desea Rechazar la solicitud?</h3>
          <p class="cabin_blue_18"><a href="' . base_url() . 'index.php/solicitud/rechazar/' . $id . '/borrar">si</a> | <a href="' . base_url() . 'index.php/solicitud/lista">no</a></p>';
                }
                if ($tipo == 23) {
                    echo '<h3 class="cabin_blue_18">La solicitud fue rechazada</h3>
          <p class="cabin_parrafo">La solicitud se marco como rechazada a continuacion sera direccionado a la lista de solicitudes</p>';
                    $redirect = 'ok';
                    $direcc = '/solicitud/lista';
                }
                if ($tipo == 24) {
                    echo '<h3 class="cabin_blue_18">Datos guardados!</h3>
          <p class="cabin_parrafo">los datos de la solicitud se han guardado exitosamente!</p>';
                    $redirect = 'ok';
                    $direcc = '/solicitud/credito_juridica/1';
                }

                if ($tipo == 25) {
                    echo '<h3 class="cabin_blue_18">Datos Enviados!</h3>
          <p class="cabin_parrafo">El vendedor se comunicara a la brevedad posible</p>';
                    $redirect = 'ok';
                    $direcc = '/car/ver/' . $id;
                }
                if ($tipo == 26) {
                    echo '<h3 class="cabin_blue_18">No hay vehiculos!</h3>
          <p class="cabin_parrafo">No hay vehiculos en la lista de comparacion</p>
		  <div class="clear_0"></div>
		  <a class="agregar_v" style="float:none"  href="' . base_url() . 'index.php/site/change_vista/2">Agregar Vehículos</a>
		  <div class="clear_0"></div>';
                    $redirect = '';
                    $direcc = '';
                }

                if ($tipo == 27) {
                    echo '<h3 class="cabin_blue_18">Datos enviados!</h3>
          <p class="cabin_parrafo">Los datos se han enviado</p>';
                    $redirect = 'ok';
                    $direcc = '/site/recomendar';
                }
                if ($tipo == 28) {
                    echo '<h3 class="cabin_blue_18">Datos enviados!</h3>
          <p class="cabin_parrafo">Los datos se han enviado</p>
		  <span class="cabin_parrafo">Direccionando...<span>
		
		  <script language="JavaScript">
			
			function redirecciona(){  
				window.top.location.href="' . base_url() . '/index.php/site/recomendar";
			}
			setTimeout("redirecciona()", 5000);
			
			</script>
		  
		  ';
                    $redirect = '';
                    $direcc = '';
                }
                if ($tipo == 29) {
                    echo '<h3 class="cabin_blue_18">Gracias por elegirnos!!</h3>
          <p class="cabin_parrafo">Su solicitud esta siendo procesada</p>
		  <p class="cabin_parrafo">El número de su solicitud es: ' . $this->session->userdata('this_id') . '<br />
		  Puede ingresar al Chat en línea por cualquier consulta sobre su solicitud.
		  Con CrediQ  <strong>"Pon en Marcha tus Sueños"</strong>
		  </p>';
                    $redirect = 'ok';
                    $direcc = '/solicitud/credito';
                }

                if ($tipo == 30) {
                    echo '<h3 class="cabin_blue_18">Datos incorrectos!</h3>
          <p class="cabin_parrafo">Usuario o contraseña incorrectos!</p>';
                    $redirect = '';
                    $direcc = '';
                }
                if ($tipo == 31) {
                    echo '<h3 class="cabin_blue_18">Vehiculo aprobado!</h3>
          <p class="cabin_parrafo">El vehiculo ha sido aprobado! , sera direccionado al panel de vehiculos</p>';
                    $redirect = 'ok';
                    //$direcc = '/car/estado/pendiente';
                    $direcc = '/car/estado/userPendiente';
                }
                if ($tipo == 32) {
                    echo '<h3 class="cabin_blue_18">Datos incorrectos!</h3>
          <p class="cabin_parrafo">ocurrio un error al aprobar intente mas tarde! , sera direccionado al panel de vehiculos</p>';
                    $redirect = 'ok';
                   // $direcc = '/car/estado/pendiente';
					 $direcc = '/car/estado/userPendiente';
                }
                if ($tipo == 33) {
                    echo '<h3 class="cabin_blue_18">Vehiculo rechazado!</h3>
          <p class="cabin_parrafo">El vehiculo ha sido rechazado, sera direccionado al panel de vehiculos!</p>';
                    $redirect = 'ok';
                   // $direcc = '/car/estado/pendiente';
					 $direcc = '/car/estado/userPendiente';
                }
                if ($tipo == 34) {
                    echo $aviso;
                    $redirect = '';
                    $direcc = '';
                }
                if ($tipo == 35) {
                    echo '<h3 class="cabin_blue_18">Marcado como primium</h3>
          <p class="cabin_parrafo">El usuario ha sido marcado como primium, sera direccionado al panel de usuarios primium</p>';
                    $redirect = 'ok';
                    $direcc = 'autolote/usuarios';
                }
                if ($tipo == 36) {
                    echo '<h3 class="cabin_blue_18">Quitado como primium</h3>
          <p class="cabin_parrafo">El usuario ha sido quitado como primium, sera direccionado al panel de usuarios primium</p>';
                    $redirect = 'ok';
                    $direcc = '/autolote/usuarios';
                }

                if ($tipo == 37) {
                    echo '<h3 class="cabin_blue_18">Gracias por elegirnos!!</h3>
          <p class="cabin_parrafo">Su solicitud esta siendo procesada</p>
		  <p class="cabin_parrafo">El número de su solicitud es: ' . $this->session->userdata('this_id') . '<br />
		  Puede ingresar al Chat en línea por cualquier consulta sobre su solicitud.
		  Con CrediQ  <strong>"Pon en Marcha tus Sueños"</strong>
		  </p>';
                    $redirect = 'ok';
                    $direcc = '/solicitud/vehiculo';
                }
                if ($redirect == 'ok') {
                    echo '
		<span class="cabin_parrafo">Direccionando...<span>
		
		  <script language="JavaScript">
		  
		  function redirecciona(){  
				window.top.location.href="' . base_url() . 'index.php' . $direcc . '";
			}
			setTimeout("redirecciona()", 6000);
			
			</script>
	';
                }
                ?>


                <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

            </div>             
        </div>
    </div>
</div>