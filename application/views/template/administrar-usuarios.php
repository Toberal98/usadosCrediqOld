




<?php $moneda = $this->session->userdata('moneda'); ?>



<div class="content">
    <div class="container12">
        <div class="row">
            <div class="column12">            	
                <h3>Listado de usuarios<span></span></h3>
                <p><a  href="<?php echo base_url(); ?>index.php/user/crear" class="nuevo">Nuevo Usuario</a></p>
                <div class="tabla">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>


                            <th >Nombres</th>
                            <th >Apellidos</th>
                            <th >Email</th>
                            <th >Tipo</th>
                            <th >Estado</th>
                            <th>acciones</th>                            
                        </tr>
                        <?php
                        if (isset($usuarios)) {
                            $v = 1;
                            foreach ($usuarios as $usuario) :
                                if ($v > 2) {
                                    $v = 1;
                                }

                                if ($usuario['estado'] != 'activo' and $usuario['estado'] != 'inactivo') {
                                    $usuario['estado'] = 'inactivo';
                                }
                                ?>

                                <tr>
                                    <td ><?php echo $usuario['nombres']; ?></td>
                                    <td ><?php echo $usuario['apellidos']; ?></td>
                                    <td ><?php echo $usuario['email']; ?></td>
                                    <td ><?php if($usuario['tipo_usuario']==1) echo "Administrador"; else echo "Cliente"; ?></td>
                                    <td ><?php echo $usuario['estado']; ?></td>
                                    <td ><a href="<?php echo base_url() ?>index.php/user/modificar/<?php echo $usuario['id_usuario'] ?>">Modificar</a>
                                         <!--a href="<?php echo base_url() ?>index.php/user/eliminar/<?php echo $usuario['id_usuario'] ?>">Eliminar</a-->
                                    </td>
                                </tr>
        <?php
        $v++;
    endforeach;
}
?>  



                    </table> 
                </div>                
            </div>
        </div>
    </div>
</div>
<?php
if (isset($pagination)) {
    echo '<div class="limiter"></div>';
    echo $pagination;
    echo '<div class="limiter"></div>';
}
?>