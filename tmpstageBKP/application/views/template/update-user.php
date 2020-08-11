


<?php if (isset($error)) {
    $usuario_existe = 1;
} ?>


<div class="content">
    <div class="container12">
        <div class="row agregarNuevo">
            <h3>Modificar datos<span></span></h3>  

            <div class="column12">
                <p class="title-sec">Datos de Usuario</p>
                <form id="form_reg_user" name="form_reg_user" accept-charset="utf-8" action="<?php echo base_url(); ?>index.php/savedata/updateUser" method="post" >

                    <label><span>Nombres:</span><input type="text" name="nombres" id="nombres" value="<?php echo $usuario['nombres']; ?>"></label>

                    <label><span>Apellidos:</span> <input type="text" name="apellidos" id="apellidos" value="<?php echo $usuario['apellidos']; ?>" ></label>

                    <label><span>Email:</span> <input type="text" name="email" id="email" 
                    value="<?php echo $usuario['email']; ?>"></label>        

                    <label><span>Telefonos:</span>
                    <?php
                    $i = 1;
                    foreach ($telefonos as $telefono):
                        echo '<input type="text" name="telefono' . $i . '" id="telefono' . $i . '" value="' . $telefono['telefono'] . '" >';
                        $i++;
                    endforeach;

                        for ($t = $i; $t <= 2; $t++){
                            echo '<input type="text" name="telefono' . $i . '" id="telefono' . $i . '" value="">';
                            $i++;
                        }
                        ?></label>

                    <label><span>Pa&iacute;s:</span> <select class="cabin_grey" name="pais" id="pais">
                            <option value="">-Seleccione-</option>
                                <?php foreach ($paises as $pais): ?>
                                <option value="<?php echo $pais['id_pais']; ?>" <?php echo ($pais['id_pais'] == $this->session->userdata('pais')) ? 'selected="selected"' : ''; ?>>
                                    <?php echo $pais['nombre']; ?>
                                </option>
                                <?php endforeach ?>
                        </select>
                    </label>
                    <label><span>Tipo Usuario:</span> 
                        <select class="cabin_grey" name="tipo_usuario" id="tipo_usuario">
                            <option value="">-Seleccione-</option>
                            <?php foreach ($tipo_user as $tipo_us): ?>

                            <option value="<?php echo $tipo_us['id_tipo_usuario']; ?>" 
                                <?php if ($tipo_us['id_tipo_usuario'] == $usuario['tipo_usuario']){
                                    echo 'selected="selected"'; } ?>
                            ><!-- End option -->
                                <?php echo $tipo_us['nombre']; ?>
                            </option>

                            <?php endforeach ?>
                        </select>
                    </label>
                    <label><span>Estado:</span> 
                        <select class="cabin_grey" name="estado" id="estado">
                            <option value="">-Seleccione-</option>
                            <?php
                            if ($usuario['estado'] != 'activo' and $usuario['estado'] != 'inactivo' and $usuario['estado'] != 'bloqueado') {
                                $usuario['estado'] = 'inactivo';
                            }

                            $estado[1] = 'activo';
                            $estado[2] = 'inactivo';
                            $estado[3] = 'bloqueado';

                            for($i = 1; $i <= 3; $i++):
                                ?>
                                <option value="<?php echo $estado[$i]; ?>" <?php if ($estado[$i] == $usuario['estado']) {
                                    echo 'selected="selected"';
                                } ?>>
                                <?php echo $estado[$i]; ?>
                                </option>
                            <?php endfor ?>
                        </select>
                    </label> 



                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
                    <input type="hidden" name="email_actual" id="email_actual" value="<?php echo $usuario['email']; ?>">
                    <div style="width: 200px;">
                        <button type="submit">Guardar Datos</button>
                    </div>
                </form>
                <hr/>


                <form id="form_cam_pass" name="form_cam_pass" accept-charset="utf-8" action="<?php echo base_url(); ?>index.php/savedata/updatePass" method="post" >

                    <p class="title-sec">Cambiar Clave</p>
                    <label><span>Nueva Contraseña:</span> <input type="password" name="pass1" id="pass1"></label>
                    <label><span>Confirmar Contraseña:</span> <input type="password" name="pass2" id="pass2" data-bvalidator="equalto[pass1],required"></label>                 
                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
                    <div style="width: 200px;">
                        <button type="submit">Guardar Clave</button>
                    </div>
                </form>


            </div>



        </div>
    </div>
</div>


<script type="text/javascript">
jQuery.validator.setDefaults({
  success: "valid"
});
$("#form_reg_user").validate({
  rules: {
    nombres: {
      required: true
    },
    apellidos: {
      required: true
    },
    email: {
      required: true,
      email: true,
      remote: {
        url: "<?php echo base_url().'index.php/ajax/comprobarEmailNuevoActual'?>",
        type: "post",
        data: {
            actual: '<?php echo $usuario['email']; ?>',
            correo: function() {
                return $("#email").val();
            }
        }           
        }
    },
    tipo_usuario: {
        required: true
    },
    pais: {
        required: true
    },
    estado: {
        required: true
    },
    telefono1: {
        required: true
    },
    pass1:{
        required: true
    },
    pass2:{
        required: true,
        equalTo: "#pass1"
    }
  },
  messages: {
    email: {
      remote: "Email ya esta en uso."
    }
  },
  success: function (label) { $(label).closest('.form-group').removeClass('has-error'); label.remove(); }
});
</script>
