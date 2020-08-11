<?php $moneda = $this->session->userdata('moneda'); 
//print_r($this->session->userdata);

?>


<?php
$this->load->view('template/inc/header_stripe.php');
?>


<div class="content">
    <div class="container12">
        <div class="row">
            <div class="column12">            	
                <h3>Veh&iacute;culos<span></span></h3>
                <span class="title-sec">Listado de veh&iacute;culos</span>
				<span style="float:right">
					<select class="cabin_grey" name="verVehiculos" id="verVehiculos" onchange="verVeh();">
                        <option value="TODOS">Ver Todos los Vehículos</option>  
						<option value="MIO">Ver Mis Vehículos</option>
						  
					</select>
					&nbsp;&nbsp;
					<input type="text" name="placa" id="placa" placeholder="Placa">
					<a href="#" onclick="document.location.href='<?php echo base_url(); ?>car/estado/aprobado-admin/0/'+$('#placa').val()" class="nuevo">Buscar</a>
				</span>
                <div class="tabla">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <th>Id</th>  
                            <th>F. Ingreso</th>
                            <th >Marca</th>
                            <th >Modelo</th>
                            <th >Año</th>  
							<!--
							<th >Cert.</th>
                            <th >Rec.</th>
							-->
							<th>Placa</th>
                            <th >Precio</th>
							<th >Estado</th>
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
                                    <td ><?php echo $car['id_automovil']; ?></td>
                                    <td ><?php echo $car['fecha']; ?></td>
                                    <td ><?php echo $car['nombre_marca']; ?></td>
                                    <td ><?php echo $car['modelo']; ?></td>
                                    <td ><?php echo $car['year']; ?></td>
									<td ><?php echo $car['numero_de_placa']; ?></td>
                                    <!--td ><?php echo $car['tipo_comb']; ?></td-->

                                    <td ><?php echo $moneda . $car['precio']; ?></td>
								<!--
								   <td >
                                        <?php if ($car['certificado'] == '0') { ?>
                                            <a href="<?php echo base_url() ?>index.php/savedata/marcar/<?php echo $car['id_automovil']; ?>">S</a>
                                        <?php } else { ?>
                                            <a href="<?php echo base_url() ?>index.php/savedata/desmarcar/<?php echo $car['id_automovil']; ?>">N</a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td >
                                        <?php if ($car['recomendado'] == '0') { ?>
                                            <a href="<?php echo base_url() ?>index.php/savedata/marcar_rec/<?php echo $car['id_automovil']; ?>">S</a>
                                        <?php } else { ?>
                                            <a href="<?php echo base_url() ?>index.php/savedata/desmarcar_rec/<?php echo $car['id_automovil']; ?>">N</a>
                                            <?php
                                        }
                                        ?>
                                    </td>
								-->
									<td ><?php echo $car['estado']; ?></td>
                                     <!--FIN - Modificado por: GGONZALEZ - 25/01/2015 -->   
                                    <td >
										<a href="<?php echo base_url() ?>index.php/car/administrar/modificar/<?php echo $car['id_automovil'] ?>">Editar</a>-
                                         <!--a href="<?php echo base_url() ?>index.php/car/borrar_un_vehiculo/preguntar/<?php echo $car['id_automovil'] ?>">Eliminar</a-->
                                        <a href="<?php echo base_url() ?>index.php/car/dar_baja/<?php echo $car['id_automovil'] ?>/preguntar">Detalle</a>
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
                        echo '<div class="limiter"></div>';
                        echo $pagination;
                        echo '<div class="limiter"></div>';
                    }
                    ?>
                </div>                
            </div>

            
            
            
            



        </div>






        <div class="row">
            <?php
            if (isset($tendencias_marca)) {
                echo '<div class="column6">';
                echo '<p class="title-sec"> Tendencia Marcas</p>';


                echo '<ul>';
                foreach ($tendencias_marca as $marcas) {
                    echo '<li>' . $marcas['marca_nombre'] . '</li>';
                }
                echo '</ul>';
                echo '</div>';
            }

            if (isset($tendencias_modelos)) {
                echo '<div class="column6">';
                echo '<p class="title-sec"> Tendencia Modelos</p>';

                echo '<ul> ';
                foreach ($tendencias_modelos as $modelos) {
                    echo '<li>' . $modelos['modelo_nombre'] . '</li>';
                }
                echo '</ul>';
                echo '</div>';
            }
            ?>

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





