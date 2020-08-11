<?php
$this->load->view('template/inc/header_stripe.php');
if (isset($error)) {
    $usuario_existe = 1;
}
?>



<div class="content">
    <div class="container12">

        <div class="row">
            <div class="column4"><img src="<?php echo base_url(); ?>public/img/man.jpg" alt=""/></div>
            <div class="column8">
                <h3>Mis Datos<span></span></h3>  

                <div class="formDatos">
                    <p class="title-sec">Datos de Usuario</p>
                    <form id="form_reg_user" name="form_reg_user" accept-charset="utf-8" action="<?php echo base_url(); ?>index.php/savedata/updateUser" method="post" >                
                        <label><span>Nombres:</span> <input type="text" name="nombres" id="nombres" data-bvalidator="required"     value="<?php echo $this->session->userdata('user_nombres') ?>" ></label>
                        <label><span>Apellidos:</span><input type="text" name="apellidos" id="apellidos" data-bvalidator="required" value="<?php echo $this->session->userdata('user_apellidos') ?>" ></label>
                        <label><span>Email:</span> <input type="text" name="email" id="email" data-bvalidator="email, required"  value="<?php echo $this->session->userdata('user_email') ?>" ></label>
                        <label><span>Confirmar Email:</span> <input type="text" name="remail" id="remail" data-bvalidator="equalto[email],required" value="<?php echo $this->session->userdata('user_email') ?>" ></label>
                        <label><span>Telefonos:</span> <?php
                            $i = 1;
                            foreach ($telefonos as $telefono) {
                                if ($i == 1) {
                                    echo '<input type="text"  name="telefono' . $i . '" id="telefono' . $i . '" value="' . $telefono['telefono'] . '" data-bvalidator="required" >';
                                    echo '<input type="hidden"  name="id_' . $i . '" id="id_' . $i . '" value="' . $telefono['id_telefono'] . '">';
                                } else {
                                    echo '<input type="text" name="telefono' . $i . '" id="telefono' . $i . '" value="' . $telefono['telefono'] . '">';
                                    echo '<input type="hidden" name="id_' . $i . '" id="id_' . $i . '" value="' . $telefono['id_telefono'] . '">';
                                }
                                $i++;
                            }

                            for ($t = 3; $t >= $i; $t--) {
                                $i++;
                                echo '<input type="text" name="telefono' . $i . '" id="telefono' . $i . '" value="">';
                            }
                            ?></label>

                        <button type="submit">Guardar Datos</button>
                    </form>

                    <hr/>
                    <form id="form_cam_pass" name="form_cam_pass" accept-charset="utf-8" action="<?php echo base_url(); ?>index.php/savedata/updatePass" method="post" >
                        <p class="title-sec">Cambiar Clave</p>

                        <label><span>Contraseña Actual:</span> <input type="password"  name="oldpass" id="oldpass" data-bvalidator="required"></label>
                        <label><span>Nueva Contraseña:</span> <input type="password" name="pass1" id="pass1" data-bvalidator="required"></label>                
                        <label><span> &nbsp;</span> &nbsp;</label>
                        <label><span>Confirmar Contraseña:</span> <input type="password" name="pass2" id="pass2" data-bvalidator="equalto[pass1],required"></label>

                        <button type="submit">Guardar Clave</button>
                    </form>

                    <div class="note">
                        <p>Nota: Los anuncios gratuitos serán confirmados telefónicamente al número de teléfono que proporcione en su anuncio, antes de ser publicado.</p>
                        <p>Importante: Cualquier anuncio que sea publicado de accesorios ó artículos que no sean vehículos COMPLETOS (no para repuestos), o que no sea para VENDER un vehículo, será borrado. Además, se permite anunciar únicamente un vehículo por anuncio, y no se permite anunciar vehículos que no sean de los estilos o marcas disponibles, tales como cuadraciclos, go-carts, mulas, juguetes, etc. usadoscrediq.com se reserva el derecho de eliminar cualquier anuncio que no contenga toda la información requerida y "real", incluyendo: nombre del vendedor, números de teléfono, precio, modelo, cilindrada, etc. Cualquier vehículo que sea vendido debe ser eliminado del sitio. Si el vendedor no lo elimina, usadoscrediq.com se reserva el derecho de hacerlo.</p>
                        <p>Si tiene cualquier duda en cuanto a la publicación de su anuncio o de las opciones ofrecidas, favor contactarnos al 2248-6400 antes de ingresar su anuncio. </p>
                        <p>Sólo se permite anunciar vehículos que ya se encuentren en el país que eligió .Cualquier anuncio que no cumpla con los requisitos aquí descritos podráser eliminado por usadoscrediq.com</p>
                    </div>
                </div>



            </div>
        </div>
    </div></div>


<script type="text/javascript">
    $('#form_reg_user').bValidator();
</script>




<script type="text/javascript">
    $('#form_cam_pass').bValidator();
</script>

