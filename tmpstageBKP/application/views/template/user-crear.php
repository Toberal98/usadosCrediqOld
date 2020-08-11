<?php
if (isset($error)) {
    $usuario_existe = 1;
}
?>

<form id="form_reg_user" name="form_reg_user" accept-charset="utf-8" action="<?php echo base_url(); ?>index.php/savedata/crearUser" method="post" >
    <div class="content">
        <div class="container12">
            <div class="row agregarNuevo">
                <h3>Datos de Usuario<span></span></h3>  

                <div class="column12">
                    <p class="title-sec">Datos de Usuario</p>
                    <label><span>Nombres: </span><input type="text" name="nombres" id="nombres">
                    </label>
                    <label><span>Apellidos:</span><input type="text" name="apellidos" id="apellidos">
                    </label>
                    <label><span>Email: </span><input type="text" name="email" id="email">
                    </label>
                    <label><span>Pais: </span> 
                        <select class="cabin_grey" name="pais" id="pais">
                            <option value="">-Seleccione-</option>
                            <?php foreach ($paises as $pais): ?>
                            <option value="<?php echo $pais['id_pais']; ?>" <?php echo ($pais['id_pais'] == $this->session->userdata('pais')) ? 'selected="selected"' : ''; ?>>
                            <?php echo $pais['nombre']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label><span>Tipo: </span> 
                        <select class="cabin_grey" name="tipo_usuario" id="tipo_usuario">
                            <option value="">-Seleccione-</option>
                            <?php foreach ($tipo_user as $tipo_us): ?>
                            <option value="<?php echo $tipo_us['id_tipo_usuario']; ?>">
                            <?php echo $tipo_us['nombre']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label><span>Estado: </span>
                        <select class="cabin_grey" name="estado" id="estado">
                            <option value="">-Seleccione-</option>
                            <option value="activo">activo</option>
                            <option value="inactivo">inactivo</option>
                            <option value="bloqueado">bloqueado</option>
                        </select>
                        <input type="hidden" name="id_usuario" id="id_usuario">
                    </label>
                    <label><span>Telefonos: </span>
                        <input type="text" name="telefono1" id="telefono1" placeholder="Telefono 1">
                        <label for="telefono1" generated="true" class="error" style="display:inline"></label>
                        <input type="text" name="telefono2" id="telefono2" placeholder="Telefono 2">
                    </label>         
                    <hr/>
                    <label><span>Contraseña:</span> <input type="password" name="pass1" id="pass1"></label>                
                    <label><span>Confirmar Contraseña:</span> <input type="password" name="pass2" id="pass2"></label>                 



                </div>
                <div style="text-align: center; width: 200px;">
                    <button type="submit">Guardar Datos</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
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
        url: "<?php echo base_url().'index.php/ajax/comprobarEmail'?>",
        type: "post",
        data: {
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