<?php
$this->load->view('template/inc/header_stripe.php');
?>

<form id="form_detalle_corto" name="form_detalle_corto" accept-charset="utf-8" method="post" >
    
<div class="content">
	<div class="container12">
    	<div class="row">
			
            
<?php if(!isset($aviso)){ ?>
        <h3>Veh&iacute;culos Usados - <?php echo $car['id_automovil'] ?></h3>
<?php } ?>
<?php if(isset($aviso)){ 
    echo $aviso;
 } ?> 
            	
            <div class="row detalle">
                <div class="column6">
                    
                    <?php
                    if ($tumbnails == 0) {
                        ?>

                        <div class="figure"><img src="<?php echo base_url(); ?>public/images/no_disponible.jpg" alt=""/></div>

                        <?php
                    } else {
                        $i = 1;
                        ?> 
                        <div class="figure">
                            <a href="<?php echo base_url(); ?>index.php/ajax/doimage/<?php echo $car['id_automovil']; ?>-800-580-<?php echo (int) $tumbnails[0]['tipo']; ?>" class="fancybox fancybox.iframe" ><img src="<?php echo base_url(); ?>index.php/ajax/doimage/<?php echo $car['id_automovil']; ?>-800-600-<?php echo (int) $tumbnails[0]['tipo']; ?>" alt=""/></a>
                        </div>

                        <ul class="thumbs">
                            <?php
                            foreach ($tumbnails as $thumb):
                                if ($first_thum == '') {
                                    $first_thum = $thumb['tipo'];
                                }
                                echo "<li data-mostrar='t0" . $i . "'>";
                                ?>
                                <img  src="<?php echo base_url(); ?>index.php/ajax/doimage/<?php echo $car['id_automovil']; ?>-800-600-<?php echo (int) $thumb['tipo']; ?>" alt=""/>
                                </li>

                                <?php
                                $i++;
                            endforeach;
                        }
                        ?>   

                    </ul>
                </div>
                
                
            	<div class="column6">
                    <p class="title-sec">Datos Generales</p>
                    <div class="tabla">
                    <table width="100%" cellpadding="0" cellspacing="0">
                    	  <tr>
                                <th>Precio</th>
                                <td><?php echo $car['moneda'] . ' ' . number_format($car['precio'], 2, ".", ","); ?><td>
                            </tr>
                            <tr>
                                <th>Marca</th>
                                <td><?php echo $car['marca']; ?></td>
                            </tr>
                            <tr>
                                <th>Modelo</th>
                                <td><?php echo $car['modelo']; ?></td>
                            </tr>
                            <tr>
                                <th>A&ntilde;o</th>
                                <td><?php echo $car['year']; ?></td>
                            </tr>
                            
                            <tr>
                                <th>Cilindraje</th>
                                <td><?php echo number_format($car['capacidad_de_motor']); ?></td>
                            </tr>
                            <tr>
                                <th>Estilo</th>
                                <td><?php echo $car['estilo']; ?></td>
                            </tr>                            
                            <tr>
                                <th>Combustible</th>
                                <td><?php echo $car['tipo_comb']; ?></td>
                            </tr>
                            <tr>
                                <th>Transmisi&oacute;n</th>
                                <td><?php echo $car['tipo_transmision']; ?></td>
                            </tr>
                            <?php if ($car['kilometraje'] != "" AND $car['kilometraje'] != "0") { ?>
                                <tr>
                                    <th>kilometraje</th>
                                    <td><?php echo $car['kilometraje']; ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th>Nº puertas</th>
                                <td><?php echo $car['numero_puertas']; ?></td>
                            </tr>
                            <tr>
                                <th>Ciudad</th>
                                <td><?php echo $car['ciudad']; ?></td>
                            </tr>
                            <tr>
                                <th>Ingreso</th>
                                <td><?php echo $ingreso; ?></td>
                            </tr>
                            <tr>
                                <th>Tracci&oacute;n</th>
                                <td><?php echo $car['traccion']; ?></td>
                            </tr>
                            <?php if ($color_interior != NULL AND $color_exterior != NULL) { ?>
                                <tr>
                                    <th>Color Exterior</th>
                                    <td><?php echo $color_exterior['nombre']; ?></td>
                                </tr>
                                <tr>
                                    <th>Color Interior</th>
                                    <td><?php echo $color_interior['nombre']; ?></td>
                                </tr>
                            <?php } ?>
                    </table>
                    </div>                    
                </div>
             
                
            </div>
            
        </div>
    </div>
</div>

</form>

