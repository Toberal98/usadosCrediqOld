<?php   
$pais = $this->session->userdata('pais'); 
$moneda = $this->session->userdata('moneda');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html;" />
        <meta charset="utf-8" />
        
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="<?php echo base_url(); ?>public/img/favicon.png" rel="shortcut icon"/>

        <title>Login - Administrador interno CrediQ Nuevos</title>

        <!--Look2-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/look2/1140.css?v=1.2">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/look2/style.css?v=1.4">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/look2/bootstrap.css">
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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" rel="stylesheet" >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notie/3.9.4/notie.min.css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.uploadify-3.1.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/filters.js?v=1.2"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/filtro.js?v=1.3"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/scriptLib.js"></script>
        <!--script type="text/javascript" src="<?php echo base_url(); ?>public/js/add-producto.js"></script-->

        <link href="<?php echo base_url(); ?>public/css/bvalidator.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.bvalidator.js"></script>

        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/actions.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.form.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/datepicker/datepicker.min.js"></script>

    </head>
    <body>
    <div class="containerb">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <form action="<?php echo base_url(); ?>index.php/site/login" method="Post" style="margin-top: 20%">

                    <?php 
                    if(isset($error_login2) && !empty($error_login2)){
                        echo "<div class='alert alert-danger animated pulse'>". $error_login2."</div>";
                    }
                    if(isset($error_login) && !empty($error_login)){
                        echo "<div class='alert alert-danger animated pulse'>". $error_login."</div>";
                    }
                    ?>

                    <img src="<?php echo base_url() ?>public/img/logo.jpg" class="img-responsive" alt="CrediQ">
                    <label><strong>Usuario</strong></label>
                    <input type="text" name="user" style="width: 100%" required><br>
                    <label><strong>Contraseña</strong></label>
                    <input type="password" name="pwd" style="width: 100%" required><br>

                    <button type="submit" class="button">Iniciar Sesión </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </body>
</html>