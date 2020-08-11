<?php
if (isset($error)) {
    $usuario_existe = 1;
}
?>

<form id="form_reg_user" name="form_reg_user" accept-charset="utf-8" action="<?php echo base_url(); ?>index.php/savedata/crearUser" method="post" >
    <div class="content">
        <div class="container12">
            <div class="row agregarNuevo">
                <h3>Mis Datos<span></span></h3>  

                <div class="column12">
                    <p class="title-sec">Datos de Usuario</p>
                    <label><span>Nombres: </span>   <input type="text" name="nombres" id="nombres" data-bvalidator="required" ></label>
                    <label><span>Apellidos:</span> <input type="text" name="apellidos" id="apellidos" data-bvalidator="required" ></label>
                    <label><span>Email: </span> <input type="text" name="email" id="email" data-bvalidator="email, required" ></label>
                    <label><span>Repetir Email: </span> <input type="text" name="remail" id="remail" data-bvalidator="equalto[email],required" ></label>
                    <label><span>Profesion:</span> <select class="cabin_grey" name="profesion" id="profesion" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <?php foreach ($profesions as $profesion): ?>
                                <option  value="<?php echo $profesion['id_profesion']; ?>"><?php echo $profesion['nombre']; ?></option>
<?php endforeach ?>
                        </select>
                    </label>
                    <label><span>Marca Favorita:</span> <select class="cabin_grey" name="marca_favorita" id="marca_favorita" onchange="getModels(this.value);" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                            <?php foreach ($marks as $mark): ?>
                                <option value="<?php echo $mark['id_marca']; ?>"><?php echo $mark['nombre']; ?></option>
<?php endforeach ?>
                        </select>
                    </label>
                    <label><span>Modelo favorito: </span> <select class="cabin_grey" name="modelo" id="modelo">
                            <option value="">-Seleccione-</option>
                        </select>
                    </label>
                    <label><span>Pais: </span> <select class="cabin_grey" name="pais" id="pais" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                                <?php foreach ($paises as $pais): ?>
                                <option value="<?php echo $pais['id_pais']; ?>" <?php echo ($pais['id_pais'] == $this->session->userdata('pais')) ? 'selected="selected"' : ''; ?>>
                                <?php echo $pais['nombre']; ?>
                                </option>
<?php endforeach ?>
                        </select>
                    </label>
                    <label><span>Tipo: </span> <select class="cabin_grey" name="tipo_usuario" id="tipo_usuario" data-bvalidator="required">
                            <option value="">-Seleccione-</option>
                                <?php foreach ($tipo_user as $tipo_us): ?>
                                <option value="<?php echo $tipo_us['id_tipo_usuario']; ?>">
                                <?php echo $tipo_us['nombre']; ?>
                                </option>
<?php endforeach ?>
                        </select>
                    </label>
                    <label><span>Estado: </span> <select class="cabin_grey" name="estado" id="estado" data-bvalidator="required">
                            <option value="">-Seleccione-</option>

                            <?php
                            $estado[1] = 'activo';
                            $estado[2] = 'inactivo';
                            $estado[3] = 'bloqueado';
                            //

                            for ($i = 1; $i <= 3; $i++):
                                ?>
                                <option value="<?php echo $estado[$i]; ?>">
                                <?php echo $estado[$i]; ?>
                                </option>
<?php endfor ?>
                        </select>
                        <input type="hidden" name="id_usuario" id="id_usuario"></label>

                    <?php
                    for ($t = 1; $t <= 3; $t++) {
                        echo '<label><span>Telefonos: </span><input type="text" name="telefono' . $t . '" id="telefono' . $t . '" value=""></label>';
                    }
                    ?>
                    <hr/>

                    <label><span>Contraseña Actual:</span> <input type="password" name="pass1" id="passActual" data-bvalidator="required"></label>                
                    <label><span>Nueva Contraseña:</span> <input type="password" name="pass1" id="pass1" data-bvalidator="required"></label>
                    <label><span>Confirmar Contraseña:</span> <input type="password" name="pass2" id="pass2" data-bvalidator="equalto[pass1],required"></label>                 



                </div>

                <button type="submit">Guardar Datos</button>

            </div>
        </div>
    </div>

</form>



<script type="text/javascript">
    $('#form_reg_user').bValidator();
</script>