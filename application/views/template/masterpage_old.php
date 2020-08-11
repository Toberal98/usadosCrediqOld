<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <!--METATAGS-->
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
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/look2/1140.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/look2/style.css">               
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/js/look2/ui/jquery-ui.css">
        

        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/look2/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/look2/ui/jquery-ui.js"></script> 
        
        
        <!--nivo-slider-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/js/look2/nivo/nivo-slider.css">
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/look2/nivo/jquery.nivo.slider.js"></script> 
        
        
        <!--fancybox-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/js/look2/source/jquery.fancybox.css">
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/look2/source/jquery.fancybox.js"></script> 

        
        <script async src="<?php echo base_url(); ?>public/js/look2/diseno.js"></script>        
        <!--Fin Look2-->

        <link href="<?php echo base_url(); ?>public/css/uploadify.css" rel="stylesheet" type="text/css"  />
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.uploadify-3.1.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/filters.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/scriptLib.js"></script>
        <!--script type="text/javascript" src="<?php echo base_url(); ?>public/js/add-producto.js"></script-->
        
        <link href="<?php echo base_url(); ?>public/css/bvalidator.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.bvalidator.js"></script>       
        
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/actions.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.form.js"></script>


        <!-- Editor WYSIWYG -->
        <!--link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/stylesheet_editor.css"-->
        <!--script type="text/javascript" src="<?php echo base_url(); ?>public/js/parser_rules/advanced.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/dist/wysihtml5-0.3.0.min.js"></script-->
        <!-- Fin editor -->

        <script>
            $(document).ready(function() {

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
        <script>
            /*Define el dominio*/
            var site_root = '<?php echo base_url(); ?>';

<?php
$n_comparar = $this->session->userdata('n_comparar');
if ($n_comparar == "") {
    $n_comparar = 0;
}
?>

    var n_comparar =<?php echo $n_comparar ?>;
        </script>



    </head>



    <body>


        <!-- Google Tag Manager -->
        <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-PTHBMR"
                          height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-PTHBMR');</script>
        <!-- End Google Tag Manager -->


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


                            /* foreach ($paises as $pais): */

                            $pais_sel = $this->session->userdata('pais');


                            if ($pais_sel == 1) {

                                $pais_arr = array($pais_sel . ' selected="selected"' => "El Salvador", /* 2 => "Costa Rica", */ 3 => "Honduras");
                            } elseif ($pais_sel == 2) {

                                $pais_arr = array($pais_sel . ' selected="selected"' => 'Costa Rica', 1 => "El Salvador", 3 => "Honduras");
                            } elseif ($pais_sel == 3) {

                                $pais_arr = array($pais_sel . ' selected="selected"' => "Honduras", /* 2 => "Costa Rica", */ 1 => "El Salvador");
                            } /* else 

                              {

                              if ($this->session->userdata('pais') == 3){

                              $pais_arr = array(3 .' selected="selected"' => "Honduras", 1=>"El Salvador"); }

                              elseif ($this->session->userdata('pais') == 1) {

                              $pais_arr = array(1 .' selected="selected"' => "El Salvador", 3=>"Honduras");}

                              }

                              endforeach; */
                            ?>

                            <span>

                                <form action="<?php echo base_url(); ?>site/changePais" method="Post">
                                    <select class="cabin_grey" name="pais" onChange="submit();" >
                            <?php foreach ($pais_arr as $id_pais => $nombre_pais): { ?>
                                                <option type="text" value= "<?php echo $id_pais ?>" > <?php echo $nombre_pais ?></option>
                                <?php } ?>
                                            </option>
                            <?php endforeach ?>
                                    </select>

                                </form>
                            </span>



                                        <?php $url_actual = current_url(); ?>
                            <input type="hidden" name="template" value="<?php echo $template; ?>" />

                                        <?php
                                        $pais = $this->session->userdata('pais');

                                        if ($pais == 1) {
                                            ?>

                                <span class="phone">(+503) 2252-0555</span>

                                <?php
                            } elseif ($pais == 2) {
                                ?>
                                <span class="phone">(+506) 2547-7641</span>

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
                                <a href="#registro" class="fancybox"><strong>Registrarse</strong></a> | <a href="#login" class="fancybox">Iniciar Sesi&oacute;n</a>

                            <?php else: ?>
                                <strong><?php echo $this->session->userdata('user_name'); ?> </strong> |
                                <a href="#" class="myAcc"><strong>Mi Cuenta</strong></a> |
                                <a href="<?php echo base_url() . 'site/logout'; ?>">Cerrar Sesi&oacute;n</a>

                                <div class="sub-menu">
                                    <ul >
                                        <li><a href="<?php echo base_url(); ?>site/modificarDatos">Modificar mis datos</a></li>                                                
                                        <li><a href="<?php echo base_url(); ?>user/acount">Mis veh&iacute;culos</a></li>

                                <?php if ($this->session->userdata('user_perfil') == 1): //user_perfil =1 ==> Admin    ?>

                                            <li><a  href="<?php echo base_url(); ?>user/lista">Lista Usuarios</a></li>                                                                                                
                                            <li><a href="<?php echo base_url(); ?>car/estado/pendiente">Autorizar Vehiculos</a></li>
                                            <li><a href="<?php echo base_url(); ?>car/estado/aprobado-admin">Lista Vehiculos</a></li>                                               
                                            <li><a href="<?php echo base_url(); ?>autolote/usuarios">Autolotes premium</a></li>                                                                                                
                                            <!--li><a href="<?php echo base_url(); ?>site/adverts">Campa&ntilde;as</a></li-->                                                
                                            <!--li><a href="<?php echo base_url(); ?>site/reportes">Reporte</a></li-->
                                            <!--li><a href="<?php echo base_url(); ?>site/reportes_detalle">Reporte detallado</a></li--> 
                                            <!--li><a href="<?php echo base_url(); ?>car/estado/aprobado-hits_2">Estadisticas</a></li-->


    <?php endif ?>  

                                    </ul>

                                    <?php endif ?>

                            </div>
                        </div>
                    </div>
                </div>    
            </div>


            <!--Menu principal-->
            <header>
                <div class="container12">
                    <div class="row">
                        <div class="column3 logo"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>public/img/logo.png" alt=""/></a> <a  href="<?php echo base_url(); ?>" class="menu-mobile"></a></div>
                        <div class="column9">
                            <nav>            	
                                <ul>
                                    <li> <a href="<?php echo base_url(); ?>vehiculosusados">USADOS</a></li>
                                    <li> <a href="<?php echo base_url(); ?>Financiamiento/SolicitudCredito">SOLICITAR CRÉDITO</a></li>
                                    <li><a href="<?php echo base_url(); ?>Financiamiento/SolicitudVehiculo">SOLICITAR VEHÍCULO</a></li>
                                    <!--li><a href="Destacados.html">DESTACADOS</a></li-->
<?php ?>
                                    <li> <a href="<?php echo base_url(); ?>Recomendados">RECOMENDADOS</a></li>
                                    <!--INI - Modificado por: GGONZALEZ - 25/01/2015 --> 
                                    <li> <a href="<?php echo base_url(); ?>VehiculosVendidos">VENDIDOS</a></li>
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
                                <p><strong>Financiamos</strong> tu carro <strong>tra&iacute;do</strong> de cualquier marca*</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div> 

    <footer class="container12">
        <div class="row">
            <div class="column2"><img src="<?php echo base_url(); ?>public/img/logo.png" alt=""/></div>
            <div class="column10">
                *Restricciones aplican. No realice ning&uacute;n pago por transferencia u otro medio a ninguna persona con la cual no tenga la suficiente confianza para hacerlo. Adem&aacute;s sugerimos actual siempre con precauci&oacute;n a la hora de comprar cualquier veh&iacute;culo y de verificar la identidad de los vendedores antes de llevar acabo cualquier negocio o hacer un pago en señal de trato. *Cuota estimada sujeta a an&aacute;lisis crediticio. Puede variar seg&uacute;n segmento del cual provengan los ingresos del solicitante y sus condiciones crediticias. Es presentada para efectos ilustrativos y no implica ning&uacute;n compromiso para la empresa.
                <p class="copy">&copy; 2015 CrediQ Usados. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>      





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

                    <label><span>Marca Favorita:</span> 
                        <select class="cabin_grey" name="marca_favorita" id="marca_favorita" onchange="getModelsRegistro(this.value);" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
<?php foreach ($marks_registro as $mark): ?>
                                <option value="<?php echo $mark['id_marca']; ?>"><?php echo $mark['nombre']; ?></option>
<?php endforeach ?>
                        </select></label>
                    <label><span>Modelo Favorito:</span><select class="cabin_grey" name="modelo" id="modelo_registro" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                        </select></label>
                    <label><span>Profesi&oacute;n:</span> <select class="cabin_grey" name="profesion" id="profesion" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
<?php foreach ($profesions_registro as $profesion): ?>
                                <option value="<?php echo $profesion['id_profesion']; ?>"><?php echo $profesion['nombre']; ?></option>
<?php endforeach ?>
                        </select></label>
                    <label><span>Pa&iacute;s:</span> <select class="cabin_grey" name="pais" id="pais" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
<?php foreach ($paises as $pais): ?>
                                <option value="<?php echo $pais['id_pais']; ?>" <?php echo ($pais['id_pais'] == $this->session->userdata('pais')) ? 'selected="selected"' : ''; ?>>
                                <?php echo $pais['nombre']; ?>
                                </option>
                            <?php endforeach ?>
                        </select></label> 
                    <label> <span>Ingresa c&oacute;digo:</span> 
                        <div class="captcha">
<?php
if (isset($capatcha)) {
    echo $capatcha;
}
?>
                            <div class="clear_0"></div>

                            <div id="captchaStatus" class="cabin_naranjas"></div>
                        </div>
                        <div class="photos mleft-10"></div>
                    </label> 

                    <div class="clearfix"></div>
                    <label class="condiciones"><input type="checkbox" checked/> Condiciones de uso</label>
                    <label><button type="submit">Enviar</button></label>
                </div>





            </form>
            <script type="text/javascript">
        $('#form_reg_user').bValidator();
        $('#form_reg_user').submit(function() {
            return validarCaptcha();
        });

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
                <label><span><?php echo $error_login . '  |   ' . $error_login2; ?></span></label>
            </div>
        </div>
    </div-->

</body>


</html>
