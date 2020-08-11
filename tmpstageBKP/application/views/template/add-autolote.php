
<?php
$this->load->view('template/inc/header_stripe.php');
?>
<script type="text/javascript">
    var RecaptchaOptions = {
        theme: 'white',
        custom_theme_widget: 'recaptcha_widget'
    };
</script>

<form id="form1" accept-charset="utf-8" action="<?php echo base_url() ?>index.php/autolote/leer" enctype="multipart/form-data" method="post" >

    <div class="content">
        <div class="container12">
            <div class="row agregarNuevo">
                <h3>Añadir Autolote<span></span></h3>  

                <div class="column12">
                    <p class="title-sec">Datos Autolote</p>

                    <label><span>Nombre corto:</span> <input type="text"  name="nombre" id="nombre" data-bvalidator="required" ></label>
                    <label><span>Archivo de texto:</span> <input type="file"  name="archivo" id="archivo" data-bvalidator="required"></label>

                </div>

                <button type="submit">Guardar Datos</button>

            </div>
        </div>
    </div>

</form>
<script type="text/javascript">
    $('#form1').bValidator();


</script>


