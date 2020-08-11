


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
                    <label><span>Nombres:</span><input type="text" name="nombres" id="nombres" data-bvalidator="required"     value="<?php echo $usuario['nombres']; ?>" ></label>
                    <label><span>Apellidos:</span> <input type="text" name="apellidos" id="apellidos" data-bvalidator="required" value="<?php echo $usuario['apellidos']; ?>" ></label>
                    <label><span>Email:</span> <input type="text" name="email" id="email" data-bvalidator="email, required"  value="<?php echo $usuario['email']; ?>" ></label>                
                    <label><span>Confirmar Email:</span> <input type="text" name="remail" id="remail" data-bvalidator="equalto[email],required" value="<?php echo $usuario['email']; ?>" ></label>                
                    <label><span>Telefonos:</span> <?php
                        $i = 1;
                        foreach ($telefonos as $telefono) {
                            if ($i == 1) {
                                echo '<input type="text" class="i_medium" name="telefono' . $i . '" id="telefono' . $i . '" value="' . $telefono['telefono'] . '" data-bvalidator="required" >';
                                echo '<input type="hidden"  name="id_' . $i . '" id="id_' . $i . '" value="' . $telefono['id_telefono'] . '">';
                            } else {
                                echo '<input type="text" class="i_medium" name="telefono' . $i . '" id="telefono' . $i . '" value="' . $telefono['telefono'] . '">';
                                echo '<input type="hidden" name="id_' . $i . '" id="id_' . $i . '" value="' . $telefono['id_telefono'] . '">';
                            }
                            $i++;
                        }

                        for ($t = 3; $t >= $i; $t--) {
                            $i++;
                            echo '<input type="text" class="i_medium" name="telefono' . $i . '" id="telefono' . $i . '" value="">';
                        }
                        ?></label>
                    <label><span>Profeci&oacute;n:</span> 
                        <select class="cabin_grey" name="profesion" id="profesion" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <?php foreach ($profesions as $profesion): ?>
                                <option  value="<?php echo $profesion['id_profesion']; ?>"  <?php if ($usuario['profesion'] == $profesion['id_profesion']) {
                                echo 'selected="selected"';
                            } ?>><?php echo $profesion['nombre']; ?></option>
<?php endforeach ?>
                        </select>
                    </label>
                    <label><span>Marca Favorita:</span>
                        <select class="cabin_grey" name="marca_favorita" id="marca_favorita" onchange="getModels(this.value);" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
<?php foreach ($marks as $mark): ?>
                                <option value="<?php echo $mark['id_marca']; ?>" <?php if ($usuario['marca_favorita'] == $mark['id_marca']) {
        echo 'selected="selected"';
    } ?>><?php echo $mark['nombre']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </label>
                    <label><span>Modelo Favorito:</span>
                        <select class="cabin_grey" name="modelo_favorito" id="modelo_favorito">
                            <option value="">-Seleccione-</option>
<?php foreach ($modelos as $modelo): ?>
                                <option <?php if ($usuario['modelo_favorito'] == $modelo['id_modelo']) {
        echo 'selected="selected"';
    } ?> value="<?php echo $modelo['id_modelo']; ?>"><?php echo $modelo['nombre']; ?></option>
                                <?php endforeach ?>
                        </select>
                    </label>
                    <label><span>Pa&iacute;s:</span> <select class="cabin_grey" name="pais" id="pais" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
<?php foreach ($paises as $pais): ?>
                                <option value="<?php echo $pais['id_pais']; ?>" <?php echo ($pais['id_pais'] == $this->session->userdata('pais')) ? 'selected="selected"' : ''; ?>>
                                <?php echo $pais['nombre']; ?>
                                </option>
                                <?php endforeach ?>
                        </select>
                    </label>
                    <label><span>Tipo Usuario:</span> 
                        <select class="cabin_grey" name="tipo_usuario" id="tipo_usuario" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
<?php foreach ($tipo_user as $tipo_us): ?>
                                <option value="<?php echo $tipo_us['id_tipo_usuario']; ?>" <?php if ($tipo_us['id_tipo_usuario'] == $usuario['tipo_usuario']) {
        echo 'selected="selected"';
    } ?>>
                                <?php echo $tipo_us['nombre']; ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </label>
                    <label><span>Estado:</span> 
                        <select class="cabin_grey" name="estado" id="estado" data-bvalidator="required">
                            <option value="">-Seleccione-</option>

                            <?php
                            if ($usuario['estado'] != 'activo' and $usuario['estado'] != 'inactivo' and $usuario['estado'] != 'bloqueado') {
                                $usuario['estado'] = 'inactivo';
                            }

                            $estado[1] = 'activo';
                            $estado[2] = 'inactivo';
                            $estado[3] = 'bloqueado';

                            for ($i = 1; $i <= 3; $i++):
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
                    <button type="submit">Guardar Datos</button>

                </form>
                <hr/>


                <form id="form_cam_pass" name="form_cam_pass" accept-charset="utf-8" action="<?php echo base_url(); ?>index.php/savedata/updatePass" method="post" >

                    <p class="title-sec">Cambiar Clave</p>
                    <label><span>Nueva Contraseña:</span> <input type="password" name="pass1" id="pass1" data-bvalidator="required"></label>
                    <label><span>Confirmar Contraseña:</span> <input type="password" name="pass2" id="pass2" data-bvalidator="equalto[pass1],required"></label>                 
                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">

                    <button type="submit">Guardar Clave</button>

                </form>


            </div>



        </div>
    </div>
</div>


<script type="text/javascript">
    $('#form_reg_user').bValidator();
</script>

<script type="text/javascript">
    $('#form_cam_pass').bValidator();
</script>
