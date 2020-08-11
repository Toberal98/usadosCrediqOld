<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-P8DVVV4');</script>
		<!-- End Google Tag Manager -->

        <!--METATAGS-->
        <meta name="google-site-verification" content="cQoCHa6DnbFpei0xEN5V-nVaox1LEYpmW832MlvMtcA" />
        <meta http-equiv="Content-Type" content="text/html;" />
        <meta charset="utf-8" />

        <meta name="keywords" content="<?php
if (isset($equipamiento)) {
    echo $car['marca'] . "," . $car['modelo'];
    foreach ($equipamiento as $equipo) {
        echo "," . $equipo['nombre'];
    }
} else {
    echo "comprar veh&iacute;culo usado";
}
?>">
        <meta name="description" content="<?php
              if (isset($equipamiento)) {
                  echo "Marca: " . $car['marca'] . "- Modelo: " . $car['modelo'] . "- Cilindraje: " . $car['capacidad_de_motor'] . "- Estilo: " . $car['estilo'] . "- Año: " . $car['year'];
              } else {
                  echo "En Usados CrediQ® Te Financiamos Para Que Compres El Que Carro Usados Que Tu Quieras. Vis&iacute;tanos Ahora.";
              }
?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="<?php echo base_url(); ?>public/img/favicon.png" rel="shortcut icon"/>

        <title> <?php echo (isset($car['modelo'])) ? (utf8_encode($car['marca'] . "-" . $car['modelo'])) : "Usados CrediQ® | Todo Lo Que Necesitas Para Comprar Un Vehiculo Usado" ?></title>



        <!--Look2-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/look2/1140.css?v=1.2">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/look2/style.css?v=1.4">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/js/look2/ui/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/datepicker/datepicker.min.css">


        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/look2/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/look2/ui/jquery-ui.js"></script>


        <!--nivo-slider-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/js/look2/nivo/nivo-slider.css">
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/look2/nivo/jquery.nivo.slider.js"></script>


        <!--fancybox-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/js/look2/source/jquery.fancybox.css">
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/look2/source/jquery.fancybox.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>


        <script async src="<?php echo base_url(); ?>public/js/look2/diseno.js"></script>
        <!--Fin Look2-->

        <link href="<?php echo base_url(); ?>public/css/uploadify.css" rel="stylesheet" type="text/css"  />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notie/3.9.4/notie.min.css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.uploadify-3.1.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/filters.js?v=1.2"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/filtro.js?v=1.4"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/scriptLib.js"></script>
        <!--script type="text/javascript" src="<?php echo base_url(); ?>public/js/add-producto.js"></script-->

        <link href="<?php echo base_url(); ?>public/css/bvalidator.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.bvalidator.js"></script>

        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/actions.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.form.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/datepicker/datepicker.min.js"></script>


        <!-- Editor WYSIWYG -->
        <!--link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/stylesheet_editor.css"-->
        <!--script type="text/javascript" src="<?php echo base_url(); ?>public/js/parser_rules/advanced.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/dist/wysihtml5-0.3.0.min.js"></script-->
        <!-- Fin editor -->
        <style media="screen">
          .detalle .links a.accepted {
            background-color: #43ae14;
            border: 1px solid #43ae14;
          }
          .detalle .links a.accepted:hover {
            background-color: #fff;
            border: 1px solid #43ae14;
            color: #43ae14;
          }
          .detalle .links a.disabled {
            background-color: #e7757a;
            border: 1px solid #e7757a;
          }
          .detalle .links a.disabled:hover {
            background-color: #e7757a;
            border: 1px solid #e7757a;
            color: #fff;
          }
          .countries-links a {
            display: block;
            margin: 15px 0;
            font-size: 18px;
            color: #333;
          }
          .countries-links a:hover {
            text-decoration: none;
          }
          .countries-links a img {
            vertical-align: middle;
            width: 30px;
            margin-right: 10px;
            height: auto;
          }
          .country-selector img {
            vertical-align: middle;
          }
          .country-selector a {
            line-height: 1.5;
          }
          .country-selector a small {
            color: #f0f0f0;
          }
          .sell-icon {
            display: block;
            text-decoration: none;
          }
          .sell-icon .label {
            display: block;
            text-align: center;
            color: #016CA6;
            font-size: 18px;
            font-weight: bold;
            margin-top: 15px;
          }
          .sell-icon .icon {
            line-height: 150px;
            width: 150px;
            display: block;
            height: 150px;
            vertical-align: middle;
            text-align: center;
            margin: auto;
          }
          .sell-icon .icon img {
            max-width: 100%;
            max-height: 100%;
            height: auto;
            width: auto;
            vertical-align: middle;
            display: inline-block;
          }
        </style>

        <script>
            function fillSpreadSheet() {

                var lTipoVenta = document.getElementById("venta").value;

                var lVendedor = document.getElementById("vendedorCopy").value;
                var lName = document.getElementById("nameCopy").value;
                var lDui = document.getElementById("duiCopy").value;
                var lEmail = document.getElementById("emailCopy").value;
                var lPhone = document.getElementById("phoneCopy").value;
                var lAuto = document.getElementById("autoCopy").value;
                var lButtom = document.getElementById("button-input").value;
                var bandera = document.getElementById("bandera").value;

                console.log('CAAR: tipo de venta= '+lTipoVenta);

                if(lTipoVenta == 1){

                    // url: "https://script.google.com/macros/s/AKfycbyC-NQ7N4kT58YGS219ZbyLrKr907u9zLwJpMiDdG_odAKBvIMg/exec",

					console.log('CAAR: credito ');
                    $.ajax({
						url: "https://script.google.com/macros/s/AKfycbx_DX-hzN5BMzmVk_3WbjRHJHBeUpTBGje_r4UM0Wm-KuGBow/exec",
                        data: { "vendedor": lVendedor, "boton" : lButtom,
                        "name": lName,"dui": lDui, "email": lEmail,
                        "phone" : lPhone,"bandera":bandera, "automovil": lAuto, "channel" : "web" },
                        type: "POST",
                        dataType: "json",
                        success: function (msg) {
                            console.log(JSON.stringify(msg));


                        },
                        error: function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            console.log(err.Message);
                            console.log("xhr "+xhr);
                            console.log(error);

                        }
                    });
                    console.log('usados');
                    /*
                    form=document.getElementById('solicitud-form');
                    console.log(form);
                    form.target='myIframe';
                    form.method='post';
                    form.action='https://script.google.com/macros/s/AKfycbyC-NQ7N4kT58YGS219ZbyLrKr907u9zLwJpMiDdG_odAKBvIMg/exec';
                    form.submit();
                    */
                }else{
                    // url: "https://script.google.com/macros/s/AKfycbyV2JZY3YmMEQqYfcamlZyPQwB3EnwF6JBn8pwC_NxzZSPQul0/exec",

					console.log('CAAR: contado');
                    $.ajax({
						url: "https://script.google.com/macros/s/AKfycbwUSTEzrWgETNB6umcMeyvlyuSsIUoWTg2VJgtGKydPPqKX0gmk/exec",
                        data: { "vendedor": lVendedor, "boton" : "web",
                        "name": lName,"dui": lDui,"bandera":bandera, "email": lEmail,
                        "phone" : lPhone, "automovil": lAuto, "channel" : "web" },
                        type: "POST",
                        dataType: "json",
                        success: function (msg) {
                            console.log(msg);
                        },
                        error: function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            console.log(err.Message);
                            console.log("xhr "+xhr);
                            console.log(error);

                        }
                    });
                    /*
                    form=document.getElementById('solicitud-form');
                    form.target='myIframe';
                    form.action='https://script.google.com/macros/s/AKfycbyV2JZY3YmMEQqYfcamlZyPQwB3EnwF6JBn8pwC_NxzZSPQul0/exec';
                    form.submit();
                    */
                }


            }
            $(document).ready(function() {
                var lCookie = $.cookie('visited');;
                if(document.referrer === 'http://usadoscrediq.com'){//http://usadoscrediq.com/contado/
                    lPopUp();
                    console.log(lCookie);
                }

              <?php if($_SESSION['data'] != NULL|| $_SESSION['data']=''): ?>
                console.log('<?php echo $_SESSION['data']; ?>');
                console.log('<?php echo $_SESSION['res']; ?>');
        				<?php
        				  endif;

        				  $_SESSION['data'] = NULL;
        				  $_SESSION['res'] = NULL;
        				?>
                function lPopUp(){
                    if (lCookie == 'yes') {
                        console.log('no muestra popup');
                        return false; // second page load, cookie is active so do nothing

                    }else{
                        console.log('muestra popup');
                        if(document.referrer === 'http://usadoscrediq.com')////http://usadoscrediq.com/contado/
                        {
                            //alert(document.referrer);
                            $.fancybox.open(
                                [
                                    {
                                        //href : 'http://usadoscrediq.com/public/img/ODT-CrediQ-Feria-01.png',
                                        href : 'http://usadoscrediq.com/public/img/popup2017.jpg',
                                    }
                                ]
                            );
                            $.cookie('visited', 'yes'); // create the cookie
                        }

                    };
                }


                $('#solicitud-form').on('submit', function (e) {
                  e.preventDefault();
                  $.fancybox.showLoading();
                  $('#solicitud-form').ajaxSubmit(function (response) {
                    console.log('Response '+response);

                    notie.alert(1, 'Hemos enviado tu información. Muchas gracias', 1.5);


                    $.fancybox.close();
                    $('#solicitud-form').get(0).reset();
                    $.fancybox.hideLoading();
                  });
                });

                $().datepicker({
                  language: 'es-ES'
                });

                $('[data-country]').on('click', function (e) {
                  e.preventDefault();
                  var form = $(this).closest('form');
                  $('[name="pais"]', form).val($(this).data('country'));
                  form.get(0).submit();
                });

                $('[data-is-datepicker]').datepicker({
                  format:'yyyy-mm-dd'
                })

                $(".link_off").click(function(evento) {
                    evento.preventDefault();
                });


                $(".pwdname").click(function() {
                    var pwd = $(this).next().html();
                    $(".input").fadeIn(300);
                    $("#overlay").fadeIn(300);
                });

                $(".close").click(function() {
                    $(".input").fadeOut(300);
                    $("#overlay").fadeOut(300);
                });

                $("#rec").click(function() {
                    mimasterpwd = $("#masterpwd").attr("value");
                    $("#masterpwd").attr("value", "");
                    $(".input").fadeOut(300);
                    $("#overlay").fadeOut(300);
                    setTimeout(olvidar, 10 * 60 * 1000);
                });

                $.each($("a"), function() {
                    $(this).attr('target', '_top');
                });
            });

        </script>
        <?php
        $n_comparar = $this->session->userdata('n_comparar');
        if ($n_comparar == "") {
            $n_comparar = 0;
        }
        ?>
        <script>
            /*Define el dominio*/
            var site_root = '<?php echo base_url(); ?>';
            var n_comparar =<?php echo $n_comparar ?>;
        </script>


    <script src='https://www.google.com/recaptcha/api.js'></script>

    </head>



    <body>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P8DVVV4"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->

        <div class="wrapped">
            <div class="top">
                <div class="container12">
                    <div class="row">
                        <div class="column6">
                            <em>Todo lo que necesitas para comprar un auto usado.</em>
                        </div>
                        <div class="column6">
                            <?php
                            /* MODIFICADO POR GGONZALEZ 21/05/2015 -  INI */

                            /* Valida si IP es de Costa Rica, Honduras o El Salvador, si es asi siempre va entrar al pais de la ip sin tener que escoger el pais en el index. */

                            $pais_sel = $this->session->userdata('pais');?>

                            <div class="clearfix country-selector">
                              <a href="#country-select" class="fancybox" style="color:white">
                                <?php if ($pais_sel == '1'): ?>
                                  <img src="<?php echo base_url(); ?>public/img/sv.png" alt="" width="20">
                                  El Salvador <small>(cambiar)</small>
                                <?php endif; ?>
                                <?php if ($pais_sel == '2'): ?>
                                  <img src="<?php echo base_url(); ?>public/img/cr.png" alt="" width="20">
                                  Costa Rica <small>(cambiar)</small>
                                <?php endif; ?>
                                <?php if ($pais_sel == '3'): ?>
                                  <img src="<?php echo base_url(); ?>public/img/hn.png" alt="" width="20">
                                  Honduras <small>(cambiar)</small>
                                <?php endif; ?>
                              </a>
                            </div>

                                        <?php $url_actual = current_url(); ?>
                            <input type="hidden" name="template" value="<?php echo $template; ?>" />

                                        <?php
                                        $pais = $this->session->userdata('pais');

                                        if ($pais == 1) {
                                            ?>

                                <span class="phone">(+503) 2248-6400 opción 2</span>

                                <?php
                            } elseif ($pais == 2) {
                                ?>
                                <span class="phone">(+506) 2522-7878</span>

                                <?php
                            } elseif ($pais == 3) {
                                ?>
                                <span class="phone">(+504) 2269-1400</span>

                                <?php
                            }
                            ?>
                            <!--MODIFICADO POR GGONZALEZ 21/05/2015 - FIN-->
                            |
                            <?php if (!$this->session->userdata('user_id')): ?>
                                <a href="#registro" class="fancybox"><strong>Vende tu auto</strong></a> | <a href="#login" class="fancybox">Iniciar Sesi&oacute;n</a>

                            <?php else: ?>
                                <strong><?php echo $this->session->userdata('user_name'); ?> </strong> |
                                <a href="#" class="myAcc"><strong>Mi Cuenta</strong></a> |
                                <a href="<?php echo base_url() . 'site/logout'; ?>">Cerrar Sesi&oacute;n</a>

                                <div class="sub-menu">
                                    <ul >
                                        <li><a href="<?php echo base_url(); ?>site/modificarDatos">Modificar mis datos</a></li>


                                <?php if ($this->session->userdata('user_perfil') == 1){ //user_perfil =1 ==> Admin    ?>
											<li><a href="<?php echo base_url(); ?>car/estado/userPendiente">Mis veh&iacute;culos</a></li>
                                            <li><a  href="<?php echo base_url(); ?>user/lista">Lista Usuarios</a></li>
                                            <!--<li><a href="<?php echo base_url(); ?>car/estado/pendiente">Autorizar Vehiculos</a></li>-->
                                            <li><a href="<?php echo base_url(); ?>car/estado/aprobado-admin">Lista Vehiculos</a></li>
                                            <li><a href="<?php echo base_url(); ?>autolote/usuarios">Autolotes premium</a></li>
                                            <!--li><a href="<?php echo base_url(); ?>site/adverts">Campa&ntilde;as</a></li-->
                                            <!--li><a href="<?php echo base_url(); ?>site/reportes">Reporte</a></li-->
                                            <!--li><a href="<?php echo base_url(); ?>site/reportes_detalle">Reporte detallado</a></li-->
                                            <!--li><a href="<?php echo base_url(); ?>car/estado/aprobado-hits_2">Estadisticas</a></li-->
								<?php }else{ ?>
										<li><a href="<?php echo base_url(); ?>user/acount">Mis veh&iacute;culos</a></li>
								<?php } ?>

                                    </ul>

                                    <?php endif ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $this->db->where('tipo_venta =', '3');
            $query = $this->db->get('cq_automovil', 1);
            $cards_with_bids = $query->num_rows() > 0;
            ?>
            <!--Menu principal-->
            <header>
                <div class="container12">
                    <div class="row">
                        <div class="column3 logo"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>public/img/logo.png" alt=""/></a> <a  href="<?php echo base_url(); ?>" class="menu-mobile"></a></div>
                        <div class="column9">
                            <nav>
                                <ul>
                                    <li> <a href="<?php echo base_url(); ?>vehiculosusados">INICIO</a></li>
                                    <?php if ($cards_with_bids): ?>
                                      <!--<li> <a href="<?php echo base_url(); ?>subastas">SUBASTAS</a></li>-->
                                    <?php endif; ?>
									<!-- 20190713 -->
                                    <!-- <li> <a href="<?php echo base_url(); ?>contado">VEHÍCULOS DE CONTADO</a></li> -->
                                    <li> <a href="<?php echo base_url(); ?>contado">VEHÍCULOS EN SUBASTA</a></li>

                                    <li class="w71"><a href="<?php echo base_url(); ?>Financiamiento/SolicitudVehiculo">SOLICITAR VEHÍCULO</a></li>
                                    <!--li><a href="Destacados.html">DESTACADOS</a></li-->
<?php ?>
                                    <!--<li> <a href="<?php echo base_url(); ?>Recomendados">RECOMENDADOS</a></li>-->
                                    <!--INI - Modificado por: GGONZALEZ - 25/01/2015 -->
                                    <!-- <li> <a href="<?php echo base_url(); ?>VehiculosVendidos">VENDIDOS</a></li> -->
                                    <!--FIN - Modificado por: GGONZALEZ - 25/01/2015 -->
                                    <li><a  href="<?php echo base_url(); ?>Contactenos">CONTÁCTENOS</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </header>




            <!--Paginas a Mostrar-->
                                    <?php
                                    if (isset($template)) {
                                        $this->load->view($template);
                                    }
                                    ?>




            <!--footer-->
            <section class="blueContent">
                <div class="container12">
                    <div class="man"></div>
                    <div class="row">
                        <div class="column3">&nbsp;</div>
                        <div class="column9">
                            <h2>S&oacute;lo en CrediQ</h2>
                            <h3>Te recibimos tu carro usado como prima de tu veh&iacute;culo nuevo.</h3>
                           <ul>
                                <li>
                                <figure class="agencia"></figure>
                                <p><strong>Financiamos</strong> tu carro usado de <strong>agencia</strong> de cualquier marca*</p>
                                </li>
                                <li>
                                <figure class="traido"></figure>
                                <p><strong>Financiamos</strong> tu carro de <strong>agencia</strong> de cualquier marca*</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
<!-- /*INI - Modificado por: GGONZALEZ - 30/08/2016 */ -->
    <footer class="container12">
        <div class="row">
            <div class="column2"><img src="<?php echo base_url(); ?>public/img/logo.png" alt=""/></div>
            <div class="column10">
                *Restricciones aplican. No realice ning&uacute;n pago por transferencia u otro medio a ninguna persona con la cual no tenga la suficiente confianza para hacerlo. Adem&aacute;s sugerimos actuar siempre con precauci&oacute;n a la hora de comprar cualquier veh&iacute;culo y de verificar la identidad de los vendedores antes de llevar acabo cualquier negocio o hacer un pago en señal de trato. *Cuota estimada sujeta a an&aacute;lisis crediticio. Puede variar seg&uacute;n segmento del cual provengan los ingresos del solicitante y sus condiciones crediticias. Es presentada para efectos ilustrativos y no implica ning&uacute;n compromiso para la empresa.
                <p class="copy">&copy; <?php echo date("Y"); ?> CrediQ Usados. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

<!-- /*FIN - Modificado por: GGONZALEZ - 30/08/2016 */ -->



    <!--Formulario login-->
    <div id="login" class="pp">
        <div class="padding">
            <form action="<?php echo base_url(); ?>site/login" method="Post">
                <h2>Iniciar Sesi&oacute;n</h2>
                <div class="form">
                    <label><span>Email:</span> <input type="text" name="user" size="25" data-bvalidator="email, required"/></label>
                    <label><span>Contraseña:</span> <input type="password" name="pwd"  size="25" data-bvalidator="required"/></label>
                    <div class="clearfix"></div>
                    <label class="condiciones"><a href="<?php echo base_url(); ?>site/recuperarClave"  class="fancybox">Olvid&eacute; mi contraseña</a></label>
                    <label><button type="submit">Enviar</button></label>
                </div>
            </form>
        </div>
    </div>

    <div id="country-select" class="pp">
        <div class="padding">
            <form action="<?php echo base_url(); ?>site/changePais" method="Post">
                <input type="hidden" name="pais" value="">
                <h2>Selecciona tu país</h2>
                <div class="countries-links">
                  <a href="#" data-country="1">
                    <img src="<?php echo base_url() ?>public/img/sv.png" alt="El Salvador">
                    El Salvador
                  </a>
                  <a href="#" data-country="2">
                    <img src="<?php echo base_url() ?>public/img/cr.png" alt="Costa Rica">
                    Costa Rica
                  </a>
                  <a href="#" data-country="3">
                    <img src="<?php echo base_url() ?>public/img/hn.png" alt="Honduras">
                    Honduras
                  </a>
                </div>
            </form>
        </div>
    </div>



    <!--Formulario registrar usuario-->
    <div id="registro" class="pp">
        <div class="padding">
            <!-- Inicio add-producto *********************************************************************************************************************** -->


            <script type="text/javascript">
        var RecaptchaOptions = {
            theme: 'white',
            custom_theme_widget: 'recaptcha_widget'
        };
            </script>
            <form id="form_reg_user" name="form_reg_user" accept-charset="utf-8" action="<?php echo base_url(); ?>index.php/savedata/saveUser" method="post">


                <h2>Registro</h2>
                <div class="form">
                    <label><span>Nombre:</span> <input type="text" name="nombres" id="nombres" data-bvalidator="required" ></label>
                    <label><span>Apellido:</span> <input type="text" name="apellidos" id="apellidos" data-bvalidator="required" ></label>
                    <label><span>Email:</span> <input type="text" name="email" id="email" data-bvalidator="email, required" onBlur="CheckUser();" ></label>
                    <label><span>Tel&eacute;fono:</span> <input type="text" name="telefono" id="telefono" data-bvalidator="maxlength[8], minlength[8], number, required"></label>


                    <!--<label><span>Marca Favorita:</span>
                        <select class="" name="marca_favorita" id="marca_favorita" onchange="getModelsRegistro(this.value);" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
						<?php foreach ($marks_registro as $mark): ?>
                                <option value="<?php echo $mark['id_marca']; ?>"><?php echo $mark['nombre']; ?></option>
						<?php endforeach ?>
                        </select></label>-->

                   <!--
						<label><span>Modelo Favorito:</span><select class="cabin_grey" name="modelo" id="modelo_registro" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                        </select></label>

                    <label><span>Profesi&oacute;n:</span> <select class="cabin_grey" name="profesion" id="profesion" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
						<?php foreach ($profesions_registro as $profesion): ?>
                                <option value="<?php echo $profesion['id_profesion']; ?>"><?php echo $profesion['nombre']; ?></option>
						<?php endforeach ?>
                        </select></label>
					-->
                    <label><span>Pa&iacute;s:</span> <select class="cabin_grey" name="pais" id="pais" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
							<?php foreach ($paises as $pais): ?>
                                <option value="<?php echo $pais['id_pais']; ?>" <?php echo ($pais['id_pais'] == $this->session->userdata('pais')) ? 'selected="selected"' : ''; ?>>
                                <?php echo $pais['nombre']; ?>
                                </option>
                            <?php endforeach ?>
                        </select></label>
				<!--
                    <label> <span>Ingresa c&oacute;digo:</span>
                    <div class="g-recaptcha" data-sitekey="6LffiC4UAAAAAIdcOIqQ9R5qgQ0CyGUkXUoGnBye"></div>
                        <div class="photos mleft-10"></div>
                    </label>
				-->
                    <div class="clearfix"></div>
                    <label class="condiciones"><input type="checkbox" checked /> Condiciones de uso</label>
                    <label><button type="submit">Enviar</button></label>
                </div>





            </form>
            <script type="text/javascript">
        $('#form_reg_user').bValidator();
       /*
		$('#form_reg_user').submit(
			function() { return validarCaptcha();}
		);

		l
        function validarCaptcha() {
            challengeField = $("input#recaptcha_challenge_field").val();
            responseField = $("input#recaptcha_response_field").val();

            var htmlC = $.ajax({
                type: "POST",
                url: site_root + '/public/aplications/validate.php',
                data: "recaptcha_challenge_field=" + challengeField + "&recaptcha_response_field=" + responseField,
                async: false
            }).responseText;

            var pattern = /success/i;



            if (pattern.test(htmlC)) {
                $("#captchaStatus").html(htmlC);
                //alert('ttrue');
                return true;
            } else {
                //alert('falsee');
                $("#captchaStatus").html(htmlC);
                Recaptcha.reload();
                return false;
            }

        }
		*/

            </script>


            <!-- FIN add-USUARIO *********************************************************************************************************************** -->


        </div>
    </div>



    <!--Formulario recuperar clave-->
    <!--div id="password" class="pp">
        <div class="padding">
            <h2>Recuperar Contraseña</h2>
            <div class="form">
                <label><span>Email:</span> <input type="text"/></label>
                <button type="submit" >Enviar</button>
            </div>
        </div>
    </div-->




    <!--Formulario de errores-->
    <!--div id="error_login" class="pp">
        <div class="padding">
            <h2>Error</h2>
            <div class="form">
                <label><span><?php //echo $error_login . '  |   ' . $error_login2; ?></span></label>
            </div>
        </div>
    </div-->
<!-- /*INI - Modificado por: GGONZALEZ - 30/08/2016 */ -->
<?php include_once("analyticstracking.php") ?>

<!-- /*FIN - Modificado por: GGONZALEZ - 30/08/2016 */ -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/notie/3.9.4/notie.min.js"></script>

</body>


</html>
