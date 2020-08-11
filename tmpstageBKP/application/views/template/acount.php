
<?php $moneda = $this->session->userdata('moneda'); ?>

<?php
$this->load->view('template/inc/header_stripe.php');
?>

<div class="content">
    <div class="container12">
        <div class="row">
            <div class="column12">            	
                <h3>Mis Vehículos<span></span></h3>
                <p><a href="<?php echo base_url(); ?>index.php/car/add"  class="nuevo">Añadir Nuevo Vehículo</a></p>
                <div class="tabla">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Año</th>
                            <th>Combustible</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>

                        <?php
                        $v = 1;
                        foreach ($activeCars as $Car) :
                            if ($v > 2) {
                                $v = 1;
                            }
                            ?>
                            <tr class="t_gris<?php echo $v; ?>">
                                <td ><?php echo $Car['marca']; ?></td>
                                <td ><?php echo $Car['modelo']; ?></td>
                                <td ><?php echo $Car['year']; ?></td>
                                <td ><?php echo $Car['combustible']; ?></td>
                                <td ><?php echo $moneda . $Car['precio']; ?></td>
                                <td ><?php echo $Car['estado']; ?></td>
                                <td >
                                    <a href="Detalle/<?php echo $Car['id_automovil'] ?>">Detalle</a> 
                                    <!-- <a href="<?php echo base_url() ?>index.php/car/dar_baja/<?php echo $Car['id_automovil'] ?>/preguntar">Dar baja</a> -->
                                    <a href="<?php echo base_url() ?>index.php/car/datos/modificar/<?php echo $Car['id_automovil'] ?>" >Editar</a> 
                                    <a href="<?php echo base_url() ?>index.php/car/borrar_mi_vehiculo/preguntar/<?php echo $Car['id_automovil'] ?>" >Borrar</a>
                                    <!-- <a href="<?php echo base_url() ?>index.php/car/estadisticas/<?php echo $Car['id_automovil'] ?>">Estadisticas</a> -->
                                </td>
                            </tr>
                            <?php
                            $v++;
                        endforeach;
                        ?>
                    </table> 
                </div>                
            </div>
        </div>
    </div>
</div>
