<div class="buscar-cont">
    <?php $moneda = $this->session->userdata('moneda'); ?>
    <div class="resultado">
    <p> <?php
    if($informe!=null || $informe!=''){
        echo "Mostrando";
        if (isset($total_resultados)) {
            echo $total_resultados;
        }
        
        echo " con los siguiente filtros: ";
        if (isset($informe)) {
            echo $informe;
        }
    }
        ?>

    </p>
    
    <table >
        <thead>
        <th>Comparar</th>
        <th>Previa</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Año</th>
        <th>Precio</th>
        <!--th>Cuota</th-->
        <th>Kilometraje</th>
        <th>Combustible</th>
        </thead>
        <?php
    $ids = $this->session->userdata('comparar');
    $i = 1;
    $chequed = "";
    $v = 1;
    foreach ($products as $car):
        if ($v > 2) {
            $v = 1;
        }


        if ($ids != '') {
            if (in_array($car['id_automovil'], $ids)) {
                $chequed = 'checked="checked"';
            } else {
                $chequed = "";
            }
        }
        ?>
        <!--div class="list_item item_gray<?php //echo $v; ?>"-->
        <tr>
            <td>
                <input name="comparar_<?php echo $car['id_automovil']; ?>" type="checkbox" id="comparar_<?php echo $car['id_automovil']; ?>"  <?php echo $chequed; ?> onclick="if (this.checked)
                            doComparar('agregar', <?php echo $car['id_automovil']; ?>);
                        else
                            doComparar('quitar', <?php echo $car['id_automovil']; ?>)"  />
            </td>
                <td>
                      <a  href="<?php echo base_url() ?>index.php/car/ver/<?php echo $car['id_automovil']; ?>" onmousedown="doClick(<?php echo $car['id_automovil']; ?>)">
                        <img width="60px" height="40px" src="<?php echo base_url(); ?>index.php/ajax/dothums/<?php echo $car['id_automovil']; ?>-2" alt="Automovil">
    <?php if ($car['certificado'] == 1): ?>
                            <img class="certificado-v-2" src="<?php echo base_url(); ?>public/images/vehiculo-certificado.png" alt="">
    <?php endif ?>
                    </a>
            </td>
                <td><?php echo $car['nombre_marca'] ?></td>
                <td><?php echo $car['modelo'] ?></td>
                <td><?php echo $car['year'] ?></td>
                <td><?php echo $moneda . number_format($car['precio'] , 2, ".", ",")?></td>
                <td><?php echo $moneda . $car['cuotaMin'] ?></td>
                <td><?php
                if ($car['kilometraje'] != "" and $car['kilometraje'] != "0") {
                    echo  number_format($car['kilometraje']);
                } else {
                    echo '&nbsp';
                }
                ?></td>
                <td><?php echo $car['tipo_comb'] ?></td>
                
        </tr>
         <?php
        $v++;
        $i++;
    endforeach;
    ?>
        
        
    </table>

    
       
    <?php
    //echo $i;
    if ($i <= 1) {
        echo '<div style="width: 550px;"><span><h3 class="cabin_blue_18">No se han encontrado vehículos con estas características!</h3></span></div>';
    }
    ?>
    
    
<?php
if (isset($paginacion)) {
    echo $paginacion;
}
?>
    
    <a class="comparar" href="<?php echo base_url(); ?>index.php/car/comparar">Comparar</a><br />
    <div style="width: 550px;"><span class="nota">Para efectuar comparaciones entre vehículos debe buscar en formato listado y marque el recuadro que se encuentra a la izquierda de
            cada vehículo que desea incluir, posteriormente oprima el botón de comparar.  Puede realizar hasta 4 comparaciones de vehículos</span>
    </div>
</div>
</div>