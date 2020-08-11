<?php $moneda = $this->session->userdata('moneda'); ?>



<div class="content">
    <div class="container12">
        <div class="row">
            <div class="column12">            	
                <h3>Mis Vehículos<span></span></h3>
                <span><a href="<?php echo base_url(); ?>index.php/car/add"  class="nuevo">Añadir Nuevo Vehículo</a></span>
				<span style="float:right">
					<select class="cabin_grey" name="verVehiculos" id="verVehiculos" onchange="verVeh();">
                          <option value="MIO">Ver Mis Vehículos</option>
						  <option value="TODOS">Ver Todos los Vehículos</option>
					</select>
					&nbsp;&nbsp;
					<input type="text" name="placa" id="placa" placeholder="Placa">
					<a href="#" onclick="document.location.href='<?php echo base_url(); ?>index.php/car/estado/userPendiente/0/'+$('#placa').val()" class="nuevo">Buscar</a>
				</span>
                <div class="tabla">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Año</th>
							<th>Placa</th>
                            <th>Combustible</th>
                            <th>Precio</th>
							<th>Estado</th>
                            <th></th>
  
                        </tr>
                       
                        <?php
                        $v = 1;
						//print_r($cars);
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
									<td ><?php echo $car['numero_de_placa']; ?></td>
                                    <td ><?php echo $car['tipo_comb']; ?></td>
                                    <td ><?php echo $car['moneda']. $car['precio']; ?></td>
									<td ><?php echo $car['estado']; ?></td>
                                    <td >
										<?php if($car['estado']=='pendiente'){ ?>
												<a href="<?php echo base_url() ?>index.php/car/detalle/<?php echo $car['id_auto'] ?>">Autorizar</a>
										<?php }else{ ?>
												<a href="<?php echo base_url() ?>index.php/car/Detalle/<?php echo $car['id_auto'] ?>">Detalle</a> 
												<a href="<?php echo base_url() ?>index.php/car/datos/modificar/<?php echo $car['id_auto'] ?>" >Editar</a> 
												<a href="<?php echo base_url() ?>index.php/car/borrar_mi_vehiculo/preguntar/<?php echo $car['id_auto'] ?>" >Borrar</a>
										<?php } ?>
									</td>
                                </tr>
                                <?php
                                $v++;
                            endforeach;
                        }
                        ?>
                    </table> 
					<?php
						if (isset($pagination)) {
							echo $pagination;
						}
					?>
                </div>                
            </div>
        </div>
    </div>
</div>

<script>
	function verVeh(){
		if($('#verVehiculos').val()=="MIO"){
			document.location.href="<?php echo base_url(); ?>car/estado/userPendiente";
		}
		
		if($('#verVehiculos').val()=="TODOS"){
			document.location.href="<?php echo base_url(); ?>car/estado/aprobado-admin";
		}
	}
	
</script>

