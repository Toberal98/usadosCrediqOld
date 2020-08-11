<?php $moneda = $this->session->userdata('moneda'); ?>
<div class="content">
    <div class="container12">
       
        <div class="row">
            <div class="column12">            	
                <h3>Marcas<span></span></h3>

                <form method="post" action="<?php echo base_url().'index.php/savedata/saveMarca'?>"
                    id="formularioAdd" style="display: none;">
                    <h3>Agregar nueva marca</h3>
                    <label class="form-label">Nombre de marca:</label>
                        <input type="text" id="nombreAdd" name="nombre" required>
                    
                    <br><br>
                    <label class="form-label">Estado:</label>
                        <select id="visible" name="visible" required>
                            <option value="">Seleccione</option>
                            <option value="Si">Visible</option>
                            <option value="No">No visible</option>
                        </select>
                    <br>
                    <button type="submit" style="width: 200px;"> Guardar</button>
                    <button onclick="cancelar();" style="width: 200px; background-color:#90A4AE">Cancelar</button> 
                </form>
                      
                <form method="post" action="<?php echo base_url().'index.php/savedata/updateMarca'?>"
                    id="formularioMod" style="display: none;">
                    <h3>Modificar Marca</h3>
                    <input type="text" id="idMod" name="id" class="hidden" required>
                    <label class="form-label">Nombre de marca: </label>
                        <input type="text" id="nombreMod" name="nombre" required>
                    
                    <br><br>
                    <label class="form-label">Estado: </label>
                        <select id="visibleMod" name="visible" required="">
                            <option value="">..Seleccione</option>
                            <option value="Si">Visible</option>
                            <option value="No">No visible</option>
                        </select>
                    <br>
                    <button type="submit" style="width: 200px;"> Modificar</button>
                    <button type="button" onclick="cancelar();" style="width: 200px; background-color:#90A4AE"> Cancelar</button>
                </form>

                <div id="listado">
                    <p class="title-sec">Listado de Marcas <?php echo $estado; ?></p>
                    <br>
                    <p><a href="#" class="nuevo" target="_top" onclick="openformAdd()">Nueva Marca</a></p>
                    <div class="tabla">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <th>Id</th>  
                                <th >Marca</th>
                                <th >Visible</th>   
                                <th>Opciones</th>
                            </tr>


                            <?php
                            if (isset($marcas)) {
                                foreach ($marcas as $marca) :
                            ?>
                                    <tr class="t_gris<?php echo $v; ?>">
                                        <td ><?php echo $marca['id_marca']; ?></td>
                                        <td ><?php echo $marca['nombre']; ?></td>
                                        <td ><?php echo $marca['visible']; ?></td>
                                        <td >
                                            <a href="#" onclick="openformMod(
                                                                '<?php echo $marca['id_marca']; ?>',
                                                                '<?php echo $marca['nombre']; ?>',
                                                                '<?php echo $marca['visible']; ?>');">Editar</a>

                                            <!--<a href="#" onclick="openformDel('<?php echo $marca['id_marca']; ?>');">Baja</a>-->
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
    function cancelar(){
        $('#formularioAdd').hide();
        $('#formularioMod').hide();
        $('#listado').show();
    }
    function openformAdd(){
        $('#listado').hide();
        $('#formularioAdd').show();
        $('#id').val('');
        $('#nombre').val('');
        $('#visible').val('');
    }
    function openformMod($id, $nom, $vis){
        $('#listado').hide();
        $('#formularioAdd').hide();
        $('#formularioMod').show();
        $('#idMod').val($id);
        $('#nombreMod').val($nom);
        $('#visibleMod').val($vis);
    }

    function openformDel($id){
        swal({
          title: "Esta seguro?",
          text: "Desea eliminar este registro?",
          icon: "warning",
          buttons: true,
          dangerMode: true
        })
        .then((willDelete) => {
          if (willDelete) {
            swal("Registro eliminado!", {
              icon: "success",
            });
            window.location.replace("<?php echo base_url().'index.php/savedata/deleteMarca/'?>"+$id+"");
          } else {
            
          }
        });
    }
</script>






