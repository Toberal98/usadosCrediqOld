<?php $moneda = $this->session->userdata('moneda'); ?>

<div class="content">
    <div class="container12">
        <div class="row">
            <div class="column12">            	
                <h3>Veh&iacute;culos<span></span></h3>
                <p class="title-sec">Modelos de Autos</p>
                <br>
                <form method="post" action="<?php echo base_url().'index.php/savedata/saveModelo'?>"
                    id="formularioAdd" style="display: none;"">
                    <h3>Agregar nuevo modelo:</h3>
                    <label class="form-label">Nombre de Modelo:</label>
                        <input type="text" id="nombreAdd" name="nombre" autocomplete="off" required>
                    
                    <br><br>
                    <label class="form-label">Marca:</label>
                        <select id="marcaAdd" name="marca" required>
                            <option value="">..Seleccione</option>
                            <?php
                            foreach ($marcas as $marca):
                            ?>
                                <option value="<?php echo $marca['id_marca']; ?>"><?php echo $marca['nombre']; ?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    
                    <br>
                    <button type="submit" style="width: 200px;"> Guardar</button>
                    <button type="button" onclick="cancelar();" style="width: 200px; background-color:#90A4AE">Cancelar</button> 
                </form>
                      
                <form method="post" action="<?php echo base_url().'index.php/savedata/updateModelo'?>"
                    id="formularioMod" style="display: none;">
                    <h3>Modificar Modelo</h3>
                    <input type="text" id="idMod" name="id" class="hidden" required>
                    <label class="form-label">Nombre de Modelo:</label>
                        <input type="text" id="nombreMod" name="nombre" required>
                    
                    <br><br>
                    <label class="form-label">Marca:</label>
                        <select id="marcaMod" name="marca" required>
                            <option value="">..Seleccione</option>
                            <?php
                            foreach ($marcas as $marca):
                            ?>
                                <option value="<?php echo $marca['id_marca']; ?>"><?php echo $marca['nombre']; ?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    <br>
                    <button type="submit" style="width: 200px;"> Modificar</button>
                    <button type="button" onclick="cancelar();" style="width: 200px; background-color:#90A4AE"> Cancelar</button>
                </form>
                <div id="listado">
                    <p><a href="#" class="nuevo" onclick="openformAdd();" target="_top">Nuevo Modelo</a></p>
                    <div class="tabla">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <th>Id</th>  
                                <th >Modelo</th>
                                <th >Marca</th>   
                                <th>Opciones</th>
                            </tr>


                            <?php
                            if (isset($modelos)) {
                                foreach ($modelos as $model) :
                            ?>
                                    <tr class="t_gris<?php echo $v; ?>">
                                        <td ><?php echo $model['id_modelo']; ?></td>
                                        <td ><?php echo $model['nombre']; ?></td>
                                        <td ><?php echo $model['marca']; ?></td>
                                        <td >
                                            <a href="#" onclick="openformMod(
                                                                '<?php echo $model['id_modelo']; ?>',
                                                                '<?php echo $model['nombre']; ?>',
                                                                '<?php echo $model['id_marca']; ?>');">Editar</a>
                                        </td>
                                    </tr>
                                    <?php
                                endforeach;
                            }
                            ?>

                        </table> 

                    </div>
                    <?php if($pagination){
                        echo $pagination;
                    }  
                    ?> 
                </div>                
            </div>
        </div>
    
    </div>
</div>

<script type="text/javascript">
    function openformAdd(){
        $('#listado').hide();
        $('#formularioAdd').show();
        $('#nombre').val('');
        $('#marca').val('');
    }
    function openformMod($id, $nom, $vis){
        $('#listado').hide();
        $('#formularioAdd').hide();
        $('#formularioMod').show();
        $('#idMod').val($id);
        $('#nombreMod').val($nom);
        $('#marcaMod').val($vis);
    }
    function cancelar(){
        $('#formularioAdd').hide();
        $('#formularioMod').hide();
        $('#listado').show();
    }
</script>







