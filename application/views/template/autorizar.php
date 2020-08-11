<?php $moneda = $this->session->userdata('moneda'); ?>



<div class="content">
    <div class="container12">
        <div class="row">
            <div class="column12">            	
                <h3>Autorizaci&oacute;n de veh&iacute;culos<span></span></h3>
                <p class="title-sec">Veh&iacute;culos pendientes de autorizaci&oacute;n</p>
                <div class="tabla">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Año</th>
                            <th>Combustible</th>
                            <th>Precio</th>

                            <th></th>
                        </tr>
                       
                        <?php
                        $v = 1;
                        if (isset($cars)) {
                            foreach ($cars as $car) :
                                if ($v > 2) {
                                    $v = 1;
                                }
                                ?>
                                <tr class="t_gris<?php echo $v; ?>">
                                    <td ><?php echo $car['marca']; ?></td>
                                    <td ><?php echo $car['modelo']; ?></td>
                                    <td ><?php echo $car['year']; ?></td>
                                    <td ><?php echo $car['tipo_comb']; ?></td>

                                    <td ><?php echo $moneda . $car['precio']; ?></td>
                                    <td ><a href="<?php echo base_url() ?>index.php/car/detalle/<?php echo $car['id_auto'] ?>">Autorizar</a></td>
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

