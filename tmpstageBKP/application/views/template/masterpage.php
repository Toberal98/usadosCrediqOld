<?php   
$pais = $this->session->userdata('pais'); 
$moneda = $this->session->userdata('moneda');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--METATAGS-->
        <meta http-equiv="Content-Type" content="text/html;" />
        <meta charset="utf-8" />
        
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="<?php echo base_url(); ?>public/img/favicon.png" rel="shortcut icon"/>

        <title>Nuevos CrediQ® | Todo Lo Que Necesitas Para Comprar Un Vehículo Nuevo</title>

        <!--Look2-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/look2/1140.css?v=1.2">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/look2/style.css?v=1.4">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/look2/bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/look2/animate.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/js/look2/ui/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/datepicker/datepicker.min.css">

        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/slick.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/slick-theme.css">

    <script type="text/javascript" src="<?php echo base_url(); ?>public/js/look2/jquery-1.11.1.min.js"></script>

    <script src="<?php echo base_url(); ?>public/js/sweetalert.min.js"></script>
    <script src="<?php echo base_url(); ?>public/js/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>public/js/additional-methods.min.js"></script>

    <script src="<?php echo base_url(); ?>public/js/jqueryvalidateconfig.js"></script>

        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/look2/ui/jquery-ui.js"></script>


        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/jquery.fancybox.css">
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.fancybox.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.cookie.min.js"></script>

        <script async src="<?php echo base_url(); ?>public/js/look2/diseno.js"></script>
        <link href="<?php echo base_url(); ?>public/fontawesome/css/all.min.css" rel="stylesheet" >
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/actions.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/datepicker/datepicker.min.js"></script>

        <script src="<?php echo base_url(); ?>public/js/slick.js"></script>
<style type="text/css">
    .menu-lateral{
        top: 0;
        left: 0;
        position: fixed;
        background: #016CA6;
        width: 250px;
        height: 100%;
        box-shadow: 1px 2px 3px rgba(0,0,0,0.5);
        display: none;
        z-index: 999;
    }
    .menu-lateral a{
        display: block;
        padding-left: 16px;
        padding-right: 16px;
        padding-top: 12px;
        padding-bottom: 12px;
        text-decoration: none;
        color: #fff;
        
    }
    /* boton cerrado para menu lateral*/
    .menu-lateral .close {
            font-size: 15px;
            background: #CE2028;
            text-align: right;
    }
    .menu-lateral .close:hover {
        background: #b71c1c;
    }
    .menu-lateral li:hover{
        background: rgba(0, 20, 22, 0.2);
    }

    .menu-lateral li:hover a{
        color: #fff;
    }
    .menu-lateral:target{
        display: block;
    }
    
    .menu-lateral i{
        padding-right: 10px;
    }
</style>
    </head>
    <body>

    <div id="loading" class="loading" style="display:none">Loading&#8230;</div>
        <div class="wrapped">
            <div class="top" style="border-bottom:1px solid red;">
                <div class="containerb-fluid">
                    <div class="row">
                        <div class="column6" style="float:right">
                        <?php $url_actual = current_url(); ?>
                            <input type="hidden" name="template" value="<?php echo $template; ?>" />
                            <?php
                            if ($pais == 1 && !$admin) {
                            ?>
                                <span class="phone">(+503) 2248-6400</span>
                            <?php
                            } elseif ($pais == 3 && !$admin) {
                            ?>
                                <span class="phone">(+504) 2269-1400</span>

                            <?php
                            }
                            ?>
                        </div>
                        <div class="column1">
                            <div class="clearfix">
                            <?php if ($this->session->userdata('user_id') && $admin) : ?>
                                <a href="#mimenu" style="text-transform: uppercase">
                                    <i class="fas fa-bars"></i> <?php echo $this->session->userdata('user_name');?></i></a>
                            <?php endif; ?>

                            </div>
                        </div>
                        <div class="column3" style="float:right">
                            <?php if(!$admin): ?>
                            <div class="clearfix country-selector">
                              <!--<a href="#country-select" class="fancybox" style="color:white">-->
                                <?php if ($pais == '1'): ?>
                                  <img src="<?php echo base_url(); ?>public/img/sv.png" alt="" width="20">
                                  El Salvador <small><!--(cambiar)--></small>
                                <?php endif; ?>
                                <?php if ($pais == '3'): ?>
                                  <img src="<?php echo base_url(); ?>public/img/hn.png" alt="" width="20">
                                  Honduras <small>(cambiar)</small>
                                <?php endif; ?>
                              <!--</a>-->
                            </div>
                            <?php endif;?>
                        </div>
                        </div>
                    </div>
                </div>
            </div>


<!--Menu principal-->
    <header>
        <div class="containerb-fluid">
            <div class="row">
                <div class="column3 logo">
                    <?php if($admin): ?>
                        <a href="<?php echo base_url().'index.php/car'; ?>">
                    <?php else:?>
                        <a href="<?php echo base_url(); ?>">
                    <?php endif; ?>
                        <img src="<?php echo base_url(); ?>public/img/logo.jpg" alt=""/></a> <a  href="<?php echo base_url(); ?>" class="menu-mobile"></a></div>
                <div class="column9" style="float:right">
                    <nav>
                        <ul>
                            <li>
                                <?php if(!$admin): ?>
                                <a  href="<?php echo base_url(); ?>index.php/site/contacto">CONTÁCTENOS</a>
                            <?php endif; ?>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <div class="menu-lateral animated slideInLeft faster" id="mimenu" >
        <div class="close">
            <a href="#"><i class="fas fa-times" aria-hidden="true"></i> Cerrar</a>
        </div>
        <ul>
            <li><a href="<?php echo base_url().'index.php/user/modificar/'.
            $this->session->userdata('user_id');?>">
                <i class="fas fa-edit"></i>Modificar mis datos</a></li>

            <!--<li><a href="#">Mis autos</a></li>-->
            <li><a href="<?php echo base_url().'index.php/user/lista';?>">
                <i class="fas fa-users"></i> Lista de usuarios</a></li>
            <hr>
            <li><a href="<?php echo base_url().'index.php/car/precios';?>">
                <i class="fas fa-money-check-alt"></i>Parametros Renting y Compra</a></li>
            <hr>
            <li><a href="<?php echo base_url().'index.php/car/add';?>">
                <i class="fas fa-car"></i><i class="fas fa-plus"></i> Nuevo vehiculo</a></li>
            <li><a href="<?php echo base_url().'index.php/car/estado/completado';?>">
                <i class="fas fa-car"></i><i class="fas fa-list"></i>Listado de Vehiculos</a></li>
            <!--<li><a href="<?php echo base_url().'index.php/car/estado/pendiente';?>">
                <i class="fas fa-car"></i><i class="fas fa-clock"></i> Vehiculos Pendientes</a></li>-->
            <li><a href="<?php echo base_url().'index.php/car/marcas';?>">
                <i class="fas fa-tags"></i> Marcas</a></li>
            <li><a href="<?php echo base_url().'index.php/car/modelos';?>">
                <i class="fas fa-dolly-flatbed"></i> Modelos</a></li>
            <hr>
            <li><a href="<?php echo base_url().'index.php/login/logout';?>">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
        </ul>
    </div>

    <?php
    if (isset($template))
    {
        $this->load->view($template);
    }
    ?>
</div>
<?php if(!$admin): ?>
<div class="condition-msg">
    <p>* Los montos son únicamente de referencia, las condiciones de tasas, plazos, prima o renting pueden variar de acuerdo al perfil del cliente y política de créditos aplicable.</p>
</div>
<?php endif; ?>
<footer class="container">
    <div class="row">
        <div class="col-md-3 center">
            <img src="<?php echo base_url(); ?>public/img/logoTransparent.png" style="max-width:200px" alt=""/>
        </div>
        
        <div class="col-md-9">
            *Restricciones aplican. No realice ning&uacute;n pago por transferencia u otro medio a ninguna persona con la cual no tenga la suficiente confianza para hacerlo. Adem&aacute;s sugerimos actuar siempre con precauci&oacute;n a la hora de comprar cualquier veh&iacute;culo y de verificar la identidad de los vendedores antes de llevar acabo cualquier negocio o hacer un pago en señal de trato. *Cuota estimada sujeta a an&aacute;lisis crediticio. Puede variar seg&uacute;n segmento del cual provengan los ingresos del solicitante y sus condiciones crediticias. Es presentada para efectos ilustrativos y no implica ning&uacute;n compromiso para la empresa.
        </div>
    </div>
    <div class="center">
    <p class="copy">&copy; <?php echo date("Y"); ?> CrediQ Nuevos. Todos los derechos reservados.</p>
    </div>
    <div class="center" <?php if($admin){ echo "style='opacity: 0'"; } ?> > 
        <a href="<?php echo base_url() ?>index.php/login/" class="interno">Sitio Interno </a>
    </div>
   
</footer>

<div id="country-select" class="pp">
    <div class="padding">
        <input type="hidden" name="pais" value="">
        <h2>Selecciona tu país</h2>
        <div class="countries-links">
            <a href="<?php echo base_url(); ?>index.php/site/changePais/1" data-country="1">
            <img src="<?php echo base_url() ?>public/img/sv.png" alt="El Salvador">
            El Salvador
            </a>
            <a href="<?php echo base_url(); ?>index.php/site/changePais/3" data-country="3">
            <img src="<?php echo base_url() ?>public/img/hn.png" alt="Honduras">
            Honduras
            </a>
        </div>
    </div>
</div>

<!-- Formulario para solicitar informacion del auto -->
<div id="information-car" class="pp" style="width:850px;">
    <div class="padding">
        <div class="rowb">
            <form action="<?php echo base_url() ?>index.php/ajax/enviarMail" method="post"
            onsubmit="fillSpreadSheet()">            
            <div class="col-md-12">
                
                <h2>Solicitar información</h2>
                <p style="text-align:justify;">
                    Solicita tu crédito ahora de forma fácil y rápida, llenando
                    este formulario para que puedas recibir toda la asesoría
                    correspondiente por parte de uno de nuestros agentes.
                </p>
                <br>
            </div>
            <input type="text" id="opcion-info" name="opcion" class="hidden">
            <input type="text" id="cuota-info" name="cuota" class="hidden">
            <input type="text" id="marca-info" name="marca" class="hidden">
            <input type="text" id="modelo-info" name="modelo" class="hidden">
            <input type="text" name="channel" class="hidden" value="WEB">            
            
            <div class="col-md-8">
                <label style="display:block;"><i class="fas fa-user"></i> Nombre:</label>
                <input type="text" style="display:block; width:80%" id="nombre-info" name="name" required="Campo Requerido"/>
            <br>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <label style="display:block;"><i class="fas fa-user"></i> Dui:</label>
                    <input type="text" style="display:block; width:100%" id="dui-info" name="dui" required="Campo Requerido"/>
                </div>
                <div class="col-md-5">    
                    <label  style="display:block;"><i class="fas fa-mobile"></i> Teléfono:</label> 
                    <input type="tel" style="display:block; width:100%"" pattern="^\d{8}$" id="phone-info" name="phone" required="Campo Requerido" />
                </div>
            </div>
            <div class="col-md-8">
                <label style="display:block;"><i class="fas fa-envelope"></i> Email:</label> 
                <input type="email" style="display:block; width:80%" id="email-info" name="email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" required="Campo requerido o no valido" />
            </div>

            <div class="col-md-12">
                <br>
                <label style="width:90%"><input type="checkbox" checked/> Autorizo a CREDIQ S.A. DE C.V. a utilizar mi información personal para uso interno, tales como promociones, ofertas, etc., siempre y cuando no comparta información con terceras personas.</label><br><br>
                <label style="width:90%"><input type="checkbox" checked/> No autorizo CREDIQ S.A. de C.V. a utilizar mi información personal para ningún otro propósito más que para ser enviada a CrediQ.</label><br><br>
                <label style="width:90%"><input type="checkbox" checked/> Autorizo a CREDIQ S.A. DE C.V., en adelante las "Las Empresas" para que consulten mi comportamiento crediticio para la concesión de este crédito para efectos de análisis con entidades especializadas en la prestación de servicios de información o burós de crédito, incluyendo aquellas que recolecten, registran, procesan, distribuyen datos, referentes al comportamiento crediticio de las personas y ofrecen servicios de información de base de datos. </label><br><br>
                <label style="width:90%"><strong>NOTA:</strong> al remitir esta solicitud autorizo a CrediQ para realizar consulta sobre mi referencia crediticia.</label><br><br>
                <br>
                <div class="center">
                    <button type="submit" style="width:60%;">Enviar</button>
                </div>
            </div> 

            </form>    
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        <?php if($this->session->flashdata('msg')): ?>
            swal("Realizado!", "<?php echo $this->session->flashdata('msg'); ?>", "success");        
        <?php endif; ?>
    });
    
    function fillSpreadSheet() {
        var Name = document.getElementById("nombre-info").value;
        var Dui = document.getElementById("dui-info").value;
        var Email = document.getElementById("email-info").value;
        var Phone = document.getElementById("phone-info").value;
        var Marca = document.getElementById("marca-info").value;
        var Modelo = document.getElementById("modelo-info").value;
        var opcion = document.getElementById("opcion-info").value;
        var cuota = document.getElementById("cuota-info").value;
        var canal = "WEB";

        $.ajax({
            url: "https://script.google.com/macros/s/AKfycbz7cpb0mLEcHR87gdIyMoxFvpfZfse3ftlfKJgQjIwhs30eh7o/exec",
            data: { "Marca": Marca, "Modelo" : Modelo, "Opción": opcion,"name": Name, "dui": Dui,
            "email" : Email, "phone": Phone, "Cuota": cuota, "channel": canal },
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
    }

    function llenarInfoCar(renting, compra, marca, modelo){
        var tipoCuota = $("input[name='tipo_cuota']:checked").val();
        if(tipoCuota == "renting"){
            $("#opcion-info").val("renting");
            $("#cuota-info").val(renting);
        }else{
            $("#opcion-info").val("compra");
            $("#cuota-info").val(compra);
        }
        
        $("#marca-info").val(marca);
        $("#modelo-info").val(modelo);
        $.fancybox.open({
            src  : '#information-car',
            type : 'inline',
            opts : {
            afterShow : function( instance, current ) {
                console.info('done!');
            }
            }
        });
    }
</script>
</body>
</html>